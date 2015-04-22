import java.sql.SQLException;

import javax.annotation.Resource;
import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import javax.jws.soap.SOAPBinding.Use;
import javax.xml.ws.WebServiceContext;
import javax.xml.ws.handler.MessageContext;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.beans.factory.annotation.Autowired;

import edu.rit.p3.data.exception.AuthorizationTokenNotFoundException;
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
@SOAPBinding ( style = Style.RPC, use = Use.LITERAL )
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
     * @throws UserUnderageException
     * @throws SQLException
     * @throws UserNotFoundException
     * @throws AuthorizationTokenNotFoundException
     */
    @WebMethod
    public String getToken( final String username, final String password )
            throws UserNotFoundException, SQLException, UserUnderageException,
            AuthorizationTokenNotFoundException
    {
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
        return BEER_CONTROLLER.getMethods();
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
    public double getPrice( final String beerName )
    {
        // TODO figure out how to get headers
        Object object = context.getMessageContext().get( MessageContext.HTTP_REQUEST_HEADERS );

        LOG.info( object );
        return BEER_CONTROLLER.getPrice( beerName );
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
    public boolean setPrice( final String beerName, final double price )
    {
        return BEER_CONTROLLER.setPrice( beerName, price );
    }

    /**
     * Takes no arguments and returns a list of the known beers.
     * 
     * @return the names of all the beers in the database
     */
    @WebMethod
    public String [] getBeers()
    {
        return BEER_CONTROLLER.getBeers();
    }

    /**
     * Takes no arguments and returns the name of the least expensive beer.
     * 
     * @return The name of the least expensive beer
     */
    @WebMethod
    public String getCheapest()
    {
        return BEER_CONTROLLER.getCheapest();
    }

    /**
     * Takes no arguments and returns the name of the most expensive beer.
     * 
     * @return The name of the most expensive beer.
     */
    @WebMethod
    public String getCostliest()
    {
        return BEER_CONTROLLER.getCostliest();
    }

}
