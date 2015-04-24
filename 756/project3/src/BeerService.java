import static java.lang.String.format;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import javax.annotation.Resource;
import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.xml.ws.WebServiceContext;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.beans.factory.annotation.Autowired;

import edu.rit.p3.data.entity.Beer;
import edu.rit.p3.data.exception.AuthorizationTokenNotFoundException;
import edu.rit.p3.data.exception.BeerServiceClosedException;
import edu.rit.p3.data.exception.TokenExpiredException;
import edu.rit.p3.data.exception.UserNotFoundException;
import edu.rit.p3.data.exception.UserUnderageException;
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
public class BeerService
{
    private final Log            LOG = LogFactory.getLog( getClass() );

    @Resource
    private WebServiceContext    context;

    private final BeerController BEER_CONTROLLER;

    @Autowired
    public BeerService( BeerController beerController )
    {
        BEER_CONTROLLER = beerController;
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
     * @throws SQLException
     *             Thrown when an issue with SQLite or the SQL itself occurs
     * @throws UserUnderageException
     *             Thrown when an underage user attempts to become authorized
     * @throws AuthorizationTokenNotFoundException
     *             Thrown when an given username does not have a token
     */
    @WebMethod
    public String getToken( final String username, final String password )
            throws UserNotFoundException, SQLException, UserUnderageException,
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
     * Takes a string denoting the beer brand and returns a double representing
     * the beer price.
     * 
     * @param beerName
     *            the name of the beer to get the price of
     * @return The price of the given beer
     */
    @WebMethod
    public double getPrice( final String beerName, final String token )
    {
        LOG.info( format( "Calling: getPrice( %s )", beerName ) );
        try
        {
            return BEER_CONTROLLER.getPrice( beerName, token );
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException | SQLException
                | BeerServiceClosedException e )
        {
            // TODO SEND SOAP FAULT
            e.printStackTrace();
        }
        return 0;
    }

    /**
     * Takes a string denoting the beer brand and a double denoting the price
     * returns <code>true</code> or <code>false</code> depending on success.
     * 
     * @param beerName
     *            the name of the beer to set the price of
     * @param price
     *            the new price of the given beer
     * @return <code>true</code> if the new price was set
     */
    @WebMethod
    public boolean setPrice( final String beerName, final double price, final String token )
    {
        LOG.info( format( "Calling: setPrice( %s, %.2f )", beerName, price ) );
        try
        {
            return BEER_CONTROLLER.setPrice( beerName, price, token );
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException | SQLException
                | BeerServiceClosedException e )
        {
            // TODO SEND SOAP FAULT
            e.printStackTrace();
        }
        return false;
    }

    /**
     * Takes no arguments and returns a list of the known beers.
     * 
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
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException | SQLException
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
     * Takes no arguments and returns the name of the least expensive beer.
     * 
     * @return The name of the least expensive beer
     */
    @WebMethod
    public String getCheapest( final String token )
    {
        LOG.info( "Calling: getCheapest()" );
        try
        {
            return BEER_CONTROLLER.getCheapest( token ).getName();
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException | SQLException
                | BeerServiceClosedException e )
        {
            // TODO SEND SOAP FAULT
            e.printStackTrace();
        }
        return null;
    }

    /**
     * Takes no arguments and returns the name of the most expensive beer.
     * 
     * @return The name of the most expensive beer.
     */
    @WebMethod
    public String getCostliest( final String token )
    {
        LOG.info( "Calling: getCostliest()" );
        try
        {
            return BEER_CONTROLLER.getCostliest( token ).getName();
        } catch ( AuthorizationTokenNotFoundException | TokenExpiredException | SQLException
                | BeerServiceClosedException e )
        {
            // TODO SEND SOAP FAULT
            e.printStackTrace();
        }
        return null;
    }

}
