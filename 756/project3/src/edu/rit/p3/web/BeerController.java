package edu.rit.p3.web;

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

    public static String          NO_BEER = "NO_BEER";

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
     * @throws UserNotFoundException
     *             Thrown if the given username is not found
     * @throws SQLException
     *             Thrown when an issue with SQLite or the SQL itself occurs
     * @throws UserUnderageException
     *             Thrown when an underage user attempts to become authorized
     * @throws AuthorizationTokenNotFoundException
     *             Thrown when an given username does not have a token
     */
    public String getToken( final String username, final String password )
            throws UserNotFoundException, SQLException, UserUnderageException,
            AuthorizationTokenNotFoundException
    {
        // User is trying to get authenticated
        if ( BEER_MANAGER.updateUserToken( username, password ) )
            return BEER_MANAGER.getTokenByUsername( username ).getTokenHash();
        else return null;
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
     * @return the beers in the database
     */
    public List<Beer> getBeers()
    {
        return BEER_MANAGER.getBeers();
    }

    /**
     * Takes no arguments and returns the least expensive beer.
     * 
     * @return The least expensive beer
     */
    public Beer getCheapest()
    {
        final List<Beer> beers = getSortedBeers();
        return beers.size() <= 0 ? null : beers.get( 0 );
    }

    /**
     * Takes no arguments and returns the the most expensive beer.
     * 
     * @return The most expensive beer. Returns <code>null</code> if no beers
     *         exist.
     */
    public Beer getCostliest()
    {
        final List<Beer> beers = getSortedBeers();
        return beers.size() <= 0 ? null : beers.get( beers.size() - 1 );
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
