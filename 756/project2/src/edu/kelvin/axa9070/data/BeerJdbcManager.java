package edu.kelvin.axa9070.data;

import static java.lang.String.format;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.jdbc.core.JdbcTemplate;

import com.mysql.jdbc.jdbc2.optional.MysqlDataSource;

import edu.kelvin.axa9070.data.entity.Beer;
import edu.kelvin.axa9070.data.entity.BeerMapper;
import edu.kelvin.axa9070.web.BeerController;

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
    private final Log           LOG                  = LogFactory.getLog( getClass() );

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Uses a given Beer name to query that beer
     */
    private static final String QUERY_BEER_BY_NAME   = "SELECT BeerId, Name, Price FROM Beer WHERE Name = ?;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * Selects all beers from the database
     */
    private static final String SELECT_ALL_BEER      = "SELECT BeerId, Name, Price FROM Beer;";

    /**
     * <p>
     * <strong>SQL:</strong> {@value}
     * </p>
     * With a given Beer name, this query updates a beer with a given Beer price
     */
    private static final String UPDATE_PRICE_OF_BEER = "UPDATE Beer SET Price = ? WHERE Name = ?;";

    private final BeerMapper    beerMapper;

    @SuppressWarnings ( "serial" )
    public BeerJdbcManager()
    {
        // Prepare the datasource
        super( new MysqlDataSource()
        {
            {
                this.setURL( System.getProperty( "db.mysql.url" ) );
                this.setUser( System.getProperty( "db.mysql.username" ) );
                this.setPassword( System.getProperty( "db.mysql.password" ) );
            }
        } );

        beerMapper = new BeerMapper();

        LOG.info( "BeerJdbcManager instance initialized" );
    }

    /**
     * Retrieve a beer by its name from the database
     * 
     * @param beerName
     *            the name of the beer to retrieve
     * @return the {@link Beer beer} object with the given name
     * @throws SQLException
     *             Thrown when an issue MySQL or the SQL itself occurs
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
