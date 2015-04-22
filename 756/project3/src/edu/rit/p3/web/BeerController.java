package edu.rit.p3.web;

import static java.lang.String.format;

import java.sql.SQLException;
import java.util.Collections;
import java.util.List;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.beans.factory.annotation.Autowired;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.data.entity.Beer;
import edu.rit.p3.data.exception.AuthorizationTokenNotFoundException;
import edu.rit.p3.data.exception.BeerNotFoundException;
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
    private final Log             LOG     = LogFactory.getLog( getClass() );

    private final BeerJdbcManager BEER_MANAGER;

    private static String         NO_BEER = "NO_BEER";

    @Autowired
    public BeerController( final BeerJdbcManager beerJdbcManager )
    {
        this.BEER_MANAGER = beerJdbcManager;
        LOG.info( "Beer Controller initialized" );
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
    public String getToken( final String username, final String password )
            throws UserNotFoundException, SQLException, UserUnderageException,
            AuthorizationTokenNotFoundException
    {
        // User is trying to get authenticated! //
        if ( BEER_MANAGER.updateUserToken( username, password ) )
            return BEER_MANAGER.getTokenByUsername( username ).getTokenHash();
        else return null;
    }

    /**
     * Takes no arguments and returns a list of the methods contained in the
     * service.
     * 
     * @return a list of the methods contained in the service.
     */
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
    public double getPrice( final String beerName )
    {
        LOG.info( format( "Calling: getPrice( %s )", beerName ) );
        
        double price = -1;
        try
        {
            final Beer beer = BEER_MANAGER.getBeerByName( beerName );
            price = beer.getPrice();
        } catch ( BeerNotFoundException | SQLException e )
        {
            LOG.error( e.getMessage() );
        }

        return price;
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
    public boolean setPrice( final String beerName, final double price )
    {
        LOG.info( format( "Calling: setPrice( %s, %.2f )", beerName, price ) );

        try
        {
            return BEER_MANAGER.updatePriceOfBeer( beerName, price );
        } catch ( BeerNotFoundException | SQLException e )
        {
            LOG.error( e.getMessage() );
        }

        return false;
    }

    /**
     * Takes no arguments and returns a list of the known beers.
     * 
     * @return the names of all the beers in the database
     */
    public String [] getBeers()
    {
        LOG.info( "Calling: getBeers()" );
        
        

        final List<Beer> beerList = BEER_MANAGER.getBeers();
        final String [] beers = new String [beerList.size()];

        for ( int i = 0; i < beerList.size(); i++ )
        {
            beers[i] = beerList.get( i ).getName();
        }

        return beers;
    }

    /**
     * Takes no arguments and returns the name of the least expensive beer.
     * 
     * @return The name of the least expensive beer
     */
    public String getCheapest()
    {
        LOG.info( "Calling: getCheapest()" );

        final List<Beer> beers = getSortedBeers();

        return beers.size() <= 0 ? NO_BEER : beers.get( 0 ).getName();
    }

    /**
     * Takes no arguments and returns the name of the most expensive beer.
     * 
     * @return The name of the most expensive beer.
     */
    public String getCostliest()
    {
        LOG.info( "Calling: getCostliest()" );

        final List<Beer> beers = getSortedBeers();

        return beers.size() <= 0 ? NO_BEER : beers.get( beers.size() - 1 ).getName();
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
}
