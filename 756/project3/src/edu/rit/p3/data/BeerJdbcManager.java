package edu.rit.p3.data;

import static edu.rit.p3.util.HashGenerator.generateHex;
import static java.lang.String.format;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.datasource.DriverManagerDataSource;

import edu.rit.p3.data.entity.Beer;
import edu.rit.p3.data.entity.Token;
import edu.rit.p3.data.entity.User;
import edu.rit.p3.data.entity.mapper.BeerMapper;
import edu.rit.p3.data.entity.mapper.TokenMapper;
import edu.rit.p3.data.entity.mapper.UserMapper;
import edu.rit.p3.data.exception.AuthorizationTokenNotFoundException;
import edu.rit.p3.data.exception.BeerNotFoundException;
import edu.rit.p3.data.exception.UserNotFoundException;
import edu.rit.p3.data.exception.UserUnderageException;
import edu.rit.p3.web.BeerController;

/**
 * <p>
 * The instance of BeerJdbcManager serves as the <strong>DATA LAYER</strong>.
 * This instance is intended to be used by the instance of
 * {@link BeerController} (Business Layer) as a way of efficiently and securely
 * interacting with the Beer Database.
 * </p>
 * 
 * @author Alex Aiezza
 *
 */
public class BeerJdbcManager extends JdbcTemplate
{
    private final Log           LOG                     = LogFactory.getLog( getClass() );

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Uses a given Beer name to query that beer
     */
    private static final String QUERY_BEER_BY_NAME      = "SELECT Name, Price FROM Beer WHERE Name = ?;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Uses a given Username to query that user
     */
    private static final String QUERY_USER_BY_USERNAME  = "SELECT Username, Password FROM User WHERE Username = ?;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Uses a given Username to query that user's authentication token
     */
    private static final String QUERY_TOKEN_BY_USERNAME = "SELECT TokenHash, Username, Expiration FROM Token WHERE Username = ?;";


    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Uses a given token hash to query for a user's authentication token
     */
    private static final String QUERY_TOKEN_BY_HASHCODE = "SELECT TokenHash, Username, Expiration FROM Token WHERE TokenHash = ?;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * With a given Username, this query updates the authorization token
     */
    private static final String UPDATE_TOKEN_FOR_USER   = "UPDATE Token SET TokenHash = ?, Expiration = DATETIME('now', '+? minutes') WHERE Username = ?;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Selects all users from the database
     */
    private static final String SELECT_ALL_USERS        = "SELECT Username, Password FROM User;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Selects all beers from the database
     */
    private static final String SELECT_ALL_BEER         = "SELECT Name, Price FROM Beer;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * With a given Beer name, this query updates a beer with a given Beer price
     */
    private static final String UPDATE_PRICE_OF_BEER    = "UPDATE Beer SET Price = ? WHERE Name = ?;";

    private final BeerMapper    beerMapper;

    private final UserMapper    userMapper;

    private final TokenMapper   tokenMapper;

    private final int           TOKEN_EXPIRATION_MINUTES;

    private final int           ACCESS_AGE;

    @Autowired
    public BeerJdbcManager(
        final DriverManagerDataSource dataSource,
        @Value ( "${token.expire}" ) final int tokenExpire,
        @Value ( "${access.age}" ) final int accessAge )
    {
        super( dataSource );

        beerMapper = new BeerMapper();
        userMapper = new UserMapper();
        tokenMapper = new TokenMapper();
        TOKEN_EXPIRATION_MINUTES = tokenExpire;
        ACCESS_AGE = accessAge;
        LOG.info( "BeerJdbcManager instance initialized" );
    }

    /**
     * Retrieve a user by its username from the database
     * 
     * @param username
     *            the username of the user to retrieve
     * @return the {@link User user} object with the given username
     * @throws SQLException
     *             Thrown when an issue in SQLite or the SQL itself occurs
     * @throws UserNotFoundException
     *             Thrown when a username cannot be found in the database
     */
    public User getUserByUsername( String username ) throws SQLException, UserNotFoundException
    {
        LOG.debug( format( "Retrieving User with name: %s", username ) );

        final PreparedStatement sUserPS = prepare( QUERY_USER_BY_USERNAME );
        sUserPS.setString( 1, username );

        final ResultSet rs = sUserPS.executeQuery();

        final List<User> users = userMapper.extractData( rs );

        if ( users.size() <= 0 )
        {
            LOG.warn( format( "Could not find User with username: %s", username ) );
            throw new UserNotFoundException( username );
        }

        return users.get( 0 );
    }

    /**
     * Get all user in the database
     * 
     * @return A {@link List} of all the users in the database
     */
    public List<User> getUsers()
    {
        LOG.debug( "Retrieving all users" );
        return query( SELECT_ALL_USERS, userMapper );
    }

    /**
     * Update the authorization token of a user
     * 
     * @param username
     *            the username of the user to update the token of
     * @param password
     *            the user's password
     * @return <code>true</code> if the update was successful.
     *         <code>false</code> if the user's password is incorrect.
     * @throws UserNotFoundException
     *             Thrown if the given username is not found
     * @throws SQLException
     *             Thrown when an issue with SQLite or the SQL itself occurs
     * @throws UserUnderageException
     *             Thrown when an underage user attempts to become authorized
     */
    public boolean updateUserToken( final String username, final String password )
            throws UserNotFoundException, SQLException, UserUnderageException
    {
        // This is see if the given username exists first
        final User user = getUserByUsername( username );

        LOG.debug( format(
            "Attempting to update the authorization token for username: %s, to expire %d minutes from now.",
            username, TOKEN_EXPIRATION_MINUTES ) );

        if ( user.getAge() < ACCESS_AGE )
            throw new UserUnderageException( user, ACCESS_AGE );

        if ( !user.getPassword().equals( password ) )
            return false;

        final PreparedStatement uTokenPS = prepare( UPDATE_TOKEN_FOR_USER );

        uTokenPS.setString( 1, generateHex() );
        uTokenPS.setInt( 2, TOKEN_EXPIRATION_MINUTES );
        uTokenPS.setString( 3, username );

        uTokenPS.executeUpdate();

        LOG.info( format( "Token of User with username: %s, will expire %d minutes from now.",
            username, TOKEN_EXPIRATION_MINUTES ) );

        return true;
    }

    /**
     * Retrieve the authorization token for a given username
     * 
     * @param username
     *            username to get the token for
     * @return the token of the given username
     * @throws SQLException
     *             Thrown when an issue with SQLite or the SQL itself occurs
     * @throws AuthorizationTokenNotFoundException
     *             Thrown when an given username does not have a token
     */
    public Token getTokenByUsername( final String username ) throws SQLException,
            AuthorizationTokenNotFoundException
    {
        final PreparedStatement sTokenPS = prepare( QUERY_TOKEN_BY_USERNAME );
        sTokenPS.setString( 1, username );

        final ResultSet rs = sTokenPS.executeQuery();

        final List<Token> tokens = tokenMapper.extractData( rs );

        if ( tokens.size() <= 0 )
            throw new AuthorizationTokenNotFoundException( username,
                    AuthorizationTokenNotFoundException.USERNAME );

        return tokens.get( 0 );
    }

    /**
     * Retrieve the authorization token for a given hash
     * 
     * @param hash
     *            hashcode of the token to look for
     * @return the token with the given hashcode
     * @throws SQLException
     *             Thrown when an issue with SQLite or the SQL itself occurs
     * @throws AuthorizationTokenNotFoundException
     *             Thrown when an given hashcode does not have a token
     */
    public Token getTokenByHash( final String hash ) throws SQLException,
            AuthorizationTokenNotFoundException
    {
        final PreparedStatement sTokenPS = prepare( QUERY_TOKEN_BY_HASHCODE );
        sTokenPS.setString( 1, hash );

        final ResultSet rs = sTokenPS.executeQuery();

        final List<Token> tokens = tokenMapper.extractData( rs );

        if ( tokens.size() <= 0 )
            throw new AuthorizationTokenNotFoundException( hash,
                    AuthorizationTokenNotFoundException.HASHCODE );

        return tokens.get( 0 );
    }

    /**
     * Retrieve a beer by its name from the database
     * 
     * @param beerName
     *            the name of the beer to retrieve
     * @return the {@link Beer beer} object with the given name
     * @throws SQLException
     *             Thrown when an issue with SQLite or the SQL itself occurs
     * @throws BeerNotFoundException
     *             Thrown when a beer name cannot be found in the database
     */
    public Beer getBeerByName( String beerName ) throws SQLException, BeerNotFoundException
    {
        LOG.debug( format( "Retrieving Beer with name: %s", beerName ) );

        final PreparedStatement sBeerPS = prepare( QUERY_BEER_BY_NAME );
        sBeerPS.setString( 1, beerName );

        final ResultSet rs = sBeerPS.executeQuery();

        final List<Beer> beers = beerMapper.extractData( rs );

        if ( beers.size() <= 0 )
        {
            LOG.warn( format( "Could not find Beer with name: %s", beerName ) );
            throw new BeerNotFoundException( beerName );
        }

        return beers.get( 0 );
    }

    /**
     * Get all beers in the database
     * 
     * @return A {@link List} of all the beers in the database
     */
    public List<Beer> getBeers()
    {
        LOG.debug( "Retrieving all beers" );
        return query( SELECT_ALL_BEER, beerMapper );
    }

    /**
     * Update the price of a beer
     * 
     * @param beerName
     *            the name of the beer to change the price of
     * @param price
     *            the new price of the beer
     * @return <code>true</code> if the update was successful. This method in
     *         fact does not return <code>false</code> under any circumstance,
     *         but if something goes wrong, one of a few exceptions will be
     *         thrown.
     * @throws BeerNotFoundException
     *             Thrown if the given beer name is not found
     * @throws SQLException
     *             Thrown when an issue MySQL or the SQL itself occurs
     */
    public boolean updatePriceOfBeer( final String beerName, final double price )
            throws BeerNotFoundException, SQLException
    {
        // This is see if the given beer name exists first
        getBeerByName( beerName );

        LOG.debug( format(
            "Attempting to change the Price of Beer with name: %s, to have a price of: %.2f",
            beerName, price ) );
        
        if ( price < 0 )
            throw new IllegalArgumentException( "Price cannot be less than $0.00" );

        final PreparedStatement uBeerPS = prepare( UPDATE_PRICE_OF_BEER );

        uBeerPS.setDouble( 1, price );
        uBeerPS.setString( 2, beerName );

        uBeerPS.executeUpdate();

        LOG.info( format( "Price of Beer with name: %s, has changed to: %.2f", beerName, price ) );

        return true;
    }

    /**
     * Just a quick little method for preparing SQL statements. This is done in
     * an effort to reduce code duplication.
     * 
     * @param sqlStatement
     *            the statement to prepare on the connection given to
     *            <code>this</code> {@link BeerJdbcManager manager}.
     * @return The prepared statement. The returned statement must still be
     *         processed by setting any <code>?</code> characters in it. Then it
     *         may be executed.
     * @throws SQLException
     *             Thrown when an issue MySQL or the SQL itself occurs
     */
    private PreparedStatement prepare( final String sqlStatement ) throws SQLException
    {
        LOG.debug( format( "Preparing statement: %s", sqlStatement ) );
        final Connection connection = getDataSource().getConnection();
        return connection.prepareStatement( sqlStatement );
    }

}