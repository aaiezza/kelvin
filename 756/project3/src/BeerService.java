import static edu.rit.p3.web.BeerController.TIME_FORMAT;
import static java.lang.Integer.parseInt;
import static java.lang.String.format;
import static java.lang.System.getProperty;

import java.io.IOException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.sql.DataSource;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.jdbc.datasource.DriverManagerDataSource;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.data.entity.Beer;
import edu.rit.p3.data.exception.AuthorizationTokenNotFoundException;
import edu.rit.p3.data.exception.BeerServiceClosedException;
import edu.rit.p3.data.exception.TokenExpiredException;
import edu.rit.p3.data.exception.UserHasInsufficientPrivilegesException;
import edu.rit.p3.data.exception.UserNotFoundException;
import edu.rit.p3.data.exception.UserUnderageException;
import edu.rit.p3.util.PropertiesSetter;
import edu.rit.p3.web.BeerController;

/**
 * <p>
 * The BeerService class acts as the <strong>SERVICE LAYER</strong> and has the
 * {@link WebService} annotation.
 * </p>
 * 
 * @author Alex Aiezza
 *
 */
@WebService
@SOAPBinding
public class BeerService
{
    private final Log            LOG = LogFactory.getLog( getClass() );

    private final BeerController BEER_CONTROLLER;

    {
        try
        {
            new PropertiesSetter();
        } catch ( IOException e )
        {
            LOG.error( e.getMessage() );
        }
    }

    public BeerService() throws ParseException
    {
        final DataSource dataSource = new DriverManagerDataSource( getProperty( "db.url" ) );

        BeerJdbcManager beerMan = new BeerJdbcManager( dataSource,
                parseInt( getProperty( "token.expire" ) ), parseInt( getProperty( "access.age" ) ) );

        try
        {
            final Date closeTime = new SimpleDateFormat( TIME_FORMAT )
                    .parse( getProperty( "time.close" ) );
            final Date openTime = new SimpleDateFormat( TIME_FORMAT )
                    .parse( getProperty( "time.open" ) );
            BEER_CONTROLLER = new BeerController( beerMan, closeTime, openTime );
        } catch ( ParseException e )
        {
            LOG.error( e.getMessage() );
            throw e;
        }
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
     * @throws AuthorizationTokenNotFoundException
     *             Thrown when an given username does not have a token
     */
    @WebMethod
    public String getToken( final String username, final String password )
            throws UserNotFoundException, UserUnderageException,
            AuthorizationTokenNotFoundException
    {
        LOG.info( format( "Calling: getToken( %s, %s )", username, password ) );
        return BEER_CONTROLLER.getToken( username, password );
    }

    /**
     * Takes no arguments and returns a list of the methods contained in the
     * service.
     * 
     * @return a list of the methods contained in the service.
     */
    @WebMethod
    public String [] getMethods()
    {
        LOG.info( "Calling: getMethods()" );

        final String [] methods = new String [] { "Double getPrice(String beerName)",
                "Boolean setPrice(String beerName, Double price)", "String[] getBeers()",
                "String getCheapest()", "String getCostliest()" };

        return methods;
    }

    /**
     * Takes a string denoting the beer brand and a string denoting a token and
     * returns a double representing the beer price if the token is valid.
     * 
     * @param beerName
     *            the name of the beer to get the price of
     * @param token
     *            the authentication token for accessing this method
     * @return The price of the given beer
     */
    @WebMethod
    public double getPrice( final String beerName, final String token )
    {
        LOG.info( format( "Calling: getPrice( %s )", beerName ) );
        try
        {
            return BEER_CONTROLLER.getPrice( beerName, token );
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException
                | BeerServiceClosedException e )
        {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
        return 0;
    }

    /**
     * Takes a string denoting the beer brand, a double denoting the price and a
     * string denoting a token returns <code>true</code> or <code>false</code>
     * depending on success and if the token is valid.
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
     *             <code>token</code> has insufficient privleges for accessing
     *             this method.
     */
    @WebMethod
    public boolean setPrice( final String beerName, final double price, final String token )
            throws UserHasInsufficientPrivilegesException, AuthorizationTokenNotFoundException,
            TokenExpiredException, BeerServiceClosedException
    {
        LOG.info( format( "Calling: setPrice( %s, %.2f )", beerName, price ) );
        return BEER_CONTROLLER.setPrice( beerName, price, token );
    }

    /**
     * Takes a string denoting a token and returns a list of the known beers if
     * the token is valid.
     * 
     * @param token
     *            authentication token for accessing this method
     * @return the names of all the beers in the database
     */
    @WebMethod
    public String [] getBeers( final String token )
    {
        LOG.info( "Calling: getBeers()" );

        List<Beer> beers = new ArrayList<Beer>();
        try
        {
            beers = BEER_CONTROLLER.getBeers( token );
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException
                | BeerServiceClosedException e )
        {
            // TODO SEND SOAP FAULT
            e.printStackTrace();
        }

        final String [] beerNames = new String [beers.size()];
        int b = 0;
        for ( final Beer beer : beers )
        {
            beerNames[b++] = beer.getName();
        }
        return beerNames;
    }

    /**
     * Takes a string denoting a token and returns the name of the least
     * expensive beer if the token is valid.
     * 
     * @param token
     *            authentication token for accessing this method
     * @return The name of the least expensive beer
     */
    @WebMethod
    public String getCheapest( final String token )
    {
        LOG.info( "Calling: getCheapest()" );
        try
        {
            return BEER_CONTROLLER.getCheapest( token ).getName();
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException
                | BeerServiceClosedException e )
        {
            // TODO SEND SOAP FAULT
            e.printStackTrace();
        }
        return null;
    }

    /**
     * Takes a string denoting a token and returns the name of the most
     * expensive beer if the token is valid.
     * 
     * @param token
     *            authentication token for accessing this method
     * @return The name of the most expensive beer.
     */
    @WebMethod
    public String getCostliest( final String token )
    {
        LOG.info( "Calling: getCostliest()" );
        try
        {
            return BEER_CONTROLLER.getCostliest( token ).getName();
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException
                | BeerServiceClosedException e )
        {
            // TODO SEND SOAP FAULT
            e.printStackTrace();
        }
        return null;
    }

}
