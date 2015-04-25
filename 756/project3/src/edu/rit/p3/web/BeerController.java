package edu.rit.p3.web;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Collections;
import java.util.Date;
import java.util.List;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.joda.time.Interval;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.data.entity.Beer;
import edu.rit.p3.data.entity.Token;
import edu.rit.p3.data.entity.User;
import edu.rit.p3.data.exception.AuthorizationTokenNotFoundException;
import edu.rit.p3.data.exception.BeerNotFoundException;
import edu.rit.p3.data.exception.BeerServiceClosedException;
import edu.rit.p3.data.exception.MismatchingPasswordException;
import edu.rit.p3.data.exception.TokenExpiredException;
import edu.rit.p3.data.exception.UserHasInsufficientPrivilegesException;
import edu.rit.p3.data.exception.UserNotFoundException;
import edu.rit.p3.data.exception.UserUnderageException;

/**
 * <p>
 * The instance of the BeerController class acts as the <strong>BUSINESS
 * LAYER</strong> for the Beer Service. It utilizes a given instance of
 * {@link BeerJdbcManager} (Data Layer) to obtain information from the Beer
 * Database.
 * </p>
 * <p>
 * Here, however there is the ability to hide potentially precious information
 * that we would otherwise not want available to the Service Layer. Workflow is
 * able to be enforced through this layer as well as efficient access of our
 * data as it was intended.
 * </p>
 *
 * @author Alex Aiezza
 *
 */
public class BeerController
{
    public static final SimpleDateFormat TIME_FORMAT = new SimpleDateFormat( "HH:mm:ss" );

    public static String                 NO_BEER     = "NO_BEER";

    public final Calendar                CLOSE_TIME, OPEN_TIME;

    private final Log                    LOG         = LogFactory.getLog( getClass() );

    private final BeerJdbcManager        BEER_MANAGER;

    /**
     * This is retrieved from a <tt>project3.properties</tt>.<br>
     * It is the minimum age necessary for accessing this service's
     * access-protected methods.
     */
    private final int                    ACCESS_AGE;

    public BeerController(
            final BeerJdbcManager beerJdbcManager,
            final Calendar closeTime,
            final Calendar openTime,
            final int accessAge )
    {
        BEER_MANAGER = beerJdbcManager;
        CLOSE_TIME = closeTime;
        OPEN_TIME = openTime;
        ACCESS_AGE = accessAge;
        LOG.info( "Beer Controller initialized" );
    }

    /**
     * Takes no arguments and returns a list of the known beers.
     *
     * @param token
     *            authentication token for accessing this method
     * @return the beers in the database
     * @throws AuthorizationTokenNotFoundException
     *             Thrown if the <code>tokenHash</code> given does not exist.
     * @throws TokenExpiredException
     *             Thrown when the <code>tokenHash</code> given is expired.
     * @throws BeerServiceClosedException
     *             Thrown if the Beer Service is being accessed outside of
     *             working hours.
     */
    public List<Beer> getBeers( final String token ) throws AuthorizationTokenNotFoundException,
    TokenExpiredException, BeerServiceClosedException
    {
        verifyToken( token );
        return BEER_MANAGER.getBeers();
    }

    /**
     * Takes no arguments and returns the least expensive beer.
     *
     * @param token
     *            authentication token for accessing this method
     * @return The least expensive beer
     * @throws AuthorizationTokenNotFoundException
     *             Thrown if the <code>tokenHash</code> given does not exist.
     * @throws TokenExpiredException
     *             Thrown when the <code>tokenHash</code> given is expired.
     * @throws BeerServiceClosedException
     *             Thrown if the Beer Service is being accessed outside of
     *             working hours.
     */
    public Beer getCheapest( final String token ) throws AuthorizationTokenNotFoundException,
    TokenExpiredException, BeerServiceClosedException
    {
        verifyToken( token );
        final List<Beer> beers = getSortedBeers();
        return beers.size() <= 0 ? null : beers.get( 0 );
    }

    /**
     * Takes no arguments and returns the the most expensive beer.
     *
     * @param token
     *            authentication token for accessing this method
     * @return The most expensive beer. Returns <code>null</code> if no beers
     *         exist.
     * @throws AuthorizationTokenNotFoundException
     *             Thrown if the <code>tokenHash</code> given does not exist.
     * @throws TokenExpiredException
     *             Thrown when the <code>tokenHash</code> given is expired.
     * @throws BeerServiceClosedException
     *             Thrown if the Beer Service is being accessed outside of
     *             working hours.
     */
    public Beer getCostliest( final String token ) throws AuthorizationTokenNotFoundException,
    TokenExpiredException, BeerServiceClosedException
    {
        verifyToken( token );
        final List<Beer> beers = getSortedBeers();
        return beers.size() <= 0 ? null : beers.get( beers.size() - 1 );
    }

    /**
     * Takes a string denoting the beer brand and returns a double representing
     * the beer price.
     *
     * @param beerName
     *            the name of the beer to get the price of
     * @param token
     *            authentication token for accessing this method
     * @return The price of the given beer
     * @throws AuthorizationTokenNotFoundException
     *             Thrown if the <code>tokenHash</code> given does not exist.
     * @throws TokenExpiredException
     *             Thrown when the <code>tokenHash</code> given is expired.
     * @throws BeerServiceClosedException
     *             Thrown if the Beer Service is being accessed outside of
     *             working hours.
     */
    public double getPrice( final String beerName, final String token )
            throws AuthorizationTokenNotFoundException, TokenExpiredException,
            BeerServiceClosedException
    {
        verifyToken( token );
        double price = -1;
        try
        {
            final Beer beer = BEER_MANAGER.getBeerByName( beerName );
            price = beer.getPrice();
        } catch ( final BeerNotFoundException e )
        {
            LOG.error( e.getMessage() );
        }

        return price;
    }

    /**
     * Gets all beers and sorts them by price
     *
     * @return Beers sorted by price
     */
    private List<Beer> getSortedBeers()
    {
        LOG.debug( "Calling: getSortedBeers()" );

        final List<Beer> beers = BEER_MANAGER.getBeers();
        Collections.sort( beers );
        return beers;
    }

    /**
     * Takes a string denoting the username, a string denoting a password and
     * returns a "token" string if the username and password match.
     *
     * @param username
     *            the username
     * @param password
     *            the password
     * @return a token that will expire after a certain amount of time. This is
     *         <code>null</code> if user does not exist.
     * @throws UserNotFoundException
     *             Thrown if the given username is not found
     * @throws UserUnderageException
     *             Thrown when an underage user attempts to become authorized
     * @throws MismatchingPasswordException
     *             In which case, the given password does not match the password
     *             for the given username in the database, this exception is
     *             thrown.
     */
    public String getToken( final String username, final String password )
            throws UserNotFoundException, UserUnderageException, MismatchingPasswordException
    {
        // See if user exists
        final User user = BEER_MANAGER.getUserByUsername( username );

        // Check age restriction
        if ( user.getAge() < ACCESS_AGE )
            throw new UserUnderageException( user, ACCESS_AGE );

        // Check if password is correct
        if ( !user.getPassword().equals( password ) )
            throw new MismatchingPasswordException();

        // User is trying to get authenticated
        if ( BEER_MANAGER.updateUserToken( user ) )
            try
        {
                return BEER_MANAGER.getTokenByUsername( username ).getTokenHash();
        } catch ( final AuthorizationTokenNotFoundException e )
        {
            // This would be bad, because this if block
            // is only true if the token has been created!
            LOG.fatal( e.getMessage() );
        }
        return null;
    }

    /**
     * Takes a string denoting the beer brand and a double denoting the price
     * returns <code>true</code> or <code>false</code> depending on success.
     *
     * @param beerName
     *            the name of the beer to set the price of
     * @param price
     *            the new price of the given beer
     * @param token
     *            authentication token for accessing this method
     * @return <code>true</code> if the new price was set
     * @throws AuthorizationTokenNotFoundException
     *             Thrown if the <code>tokenHash</code> given does not exist.
     * @throws TokenExpiredException
     *             Thrown when the <code>tokenHash</code> given is expired.
     * @throws BeerServiceClosedException
     *             Thrown if the Beer Service is being accessed outside of
     *             working hours.
     * @throws UserHasInsufficientPrivilegesException
     *             Thrown if the user associated with the given authentication
     *             <code>token</code> has insufficient privileges for accessing
     *             this method.
     * @throws BeerNotFoundException
     *             Thrown when a beer name cannot be found in the database
     */
    public boolean setPrice( final String beerName, final double price, final String token )
            throws AuthorizationTokenNotFoundException, TokenExpiredException,
            BeerServiceClosedException, UserHasInsufficientPrivilegesException,
            BeerNotFoundException
    {
        verifyToken( token );
        try
        {
            final User user = BEER_MANAGER.getUserByUsername( BEER_MANAGER.getTokenByHash( token )
                .getUsername() );
            if ( !user.isAccessLevel() )
                throw new UserHasInsufficientPrivilegesException( user, beerName );

            return BEER_MANAGER.updatePriceOfBeer( beerName, price );
        } catch ( final UserNotFoundException e )
        {
            LOG.error( e.getMessage() );
        } catch ( final BeerNotFoundException e )
        {
            LOG.error( e.getMessage() );
            throw e;
        }
        return false;
    }


    /**
     * This method is called locally within an instance of the BeerController in
     * methods that perform operations that require authentication.
     *
     * @param tokenHash
     *            the authentication token string
     * @throws AuthorizationTokenNotFoundException
     *             Thrown if the <code>tokenHash</code> given does not exist.
     * @throws TokenExpiredException
     *             Thrown when the <code>tokenHash</code> given is expired.
     * @throws BeerServiceClosedException
     *             Thrown if the Beer Service is being accessed outside of
     *             working hours.
     */
    private void verifyToken( final String tokenHash ) throws AuthorizationTokenNotFoundException,
    TokenExpiredException, BeerServiceClosedException
    {
        // What will make this method fail:
        // The token doesn't exist
        final Token token = BEER_MANAGER.getTokenByHash( tokenHash );

        // The token is expired
        if ( token.isExpired() )
        {
            BEER_MANAGER.deleteTokenByHash( tokenHash );
            throw new TokenExpiredException( tokenHash );
        }

        // The time is between close and open
        final Calendar closing = Calendar.getInstance(), opening = Calendar.getInstance();
        closing.set( Calendar.HOUR_OF_DAY, CLOSE_TIME.get( Calendar.HOUR_OF_DAY ) );
        closing.set( Calendar.MINUTE, CLOSE_TIME.get( Calendar.MINUTE ) );
        closing.set( Calendar.SECOND, CLOSE_TIME.get( Calendar.SECOND ) );
        opening.set( Calendar.HOUR_OF_DAY, OPEN_TIME.get( Calendar.HOUR_OF_DAY ) );
        opening.set( Calendar.MINUTE, OPEN_TIME.get( Calendar.MINUTE ) );
        opening.set( Calendar.SECOND, OPEN_TIME.get( Calendar.SECOND ) );
        final Date now = new Date();

        if ( now.after( closing.getTime() ) && now.before( opening.getTime() ) )
            throw new BeerServiceClosedException( new Interval( closing.getTimeInMillis(),
                opening.getTimeInMillis() ) );

        // Otherwise, update this user's token
        try
        {
            final User user = BEER_MANAGER.getUserByUsername( token.getUsername() );
            // refresh token
            BEER_MANAGER.updateUserToken( user );
        } catch ( final UserNotFoundException e )
        {
            LOG.fatal( e.getMessage() );
        }
    }
}
