package edu.kelvin.axa9070.web;

import java.sql.SQLException;
import java.util.Collections;
import java.util.List;

import edu.kelvin.axa9070.data.BeerJdbcManager;
import edu.kelvin.axa9070.data.BeerNotFoundException;
import edu.kelvin.axa9070.data.entity.Beer;

public class BeerController
{
    private final BeerJdbcManager BEER_MANAGER;

    private static BeerController singletonish;

    private static String         NO_BEER = "NO_BEER";

    public BeerController()
    {
        this( singletonish.BEER_MANAGER );
    }

    public BeerController( final BeerJdbcManager beerJdbcManager )
    {
        singletonish = this;
        this.BEER_MANAGER = beerJdbcManager;
    }

    /**
     * Takes no arguments and returns a list of the methods contained in the
     * service.
     * 
     * @return a list of the methods contained in the service.
     */
    public String [] getMethods()
    {
        String [] methods = new String [] { "getPrice", "setPrice", "getBeers", "getCheapest",
                "getCostliest" };

        return methods;
    }

    /**
     * Takes a string denoting the beer brand and returns a double representing
     * the beer price.
     * 
     * @param beerName
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
            System.err.println( e.getMessage() );
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
            System.err.println( e.getMessage() );
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
        final List<Beer> beerList = BEER_MANAGER.getBeers();
        final String [] beers = new String [beerList.size()];

        for ( int i = 0; i < beerList.size(); i++ )
        {
            beers[i] = beerList.get( i ).getName();
        }

        return beers;
    }

    /**
     * Get all the beers in the database
     * 
     * @return All of the beer objects in the database
     */
    public Beer [] getRealBeers()
    {
        final List<Beer> beerList = BEER_MANAGER.getBeers();
        final Beer [] beers = new Beer [beerList.size()];
        beerList.toArray( beers );

        return beers;
    }

    /**
     * Takes no arguments and returns the name of the least expensive beer.
     * 
     * @return The name of the least expensive beer
     */
    public String getCheapest()
    {
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
        final List<Beer> beers = getSortedBeers();

        return beers.size() <= 0 ? NO_BEER : beers.get( beers.size() - 1 ).getName();
    }

    private List<Beer> getSortedBeers()
    {
        final List<Beer> beers = BEER_MANAGER.getBeers();
        Collections.sort( beers );
        return beers;
    }
}
