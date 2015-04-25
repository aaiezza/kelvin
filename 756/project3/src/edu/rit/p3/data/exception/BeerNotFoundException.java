package edu.rit.p3.data.exception;

import javax.management.InstanceNotFoundException;

import edu.rit.p3.data.BeerJdbcManager;

/**
 * Within some methods of the {@link BeerJdbcManager} (Data Layer), an attempt
 * at finding a Beer with a certain name may not exist. In which case, an
 * instance of this exception is thrown.
 *
 * @author Alex Aiezza
 *
 */
public class BeerNotFoundException extends InstanceNotFoundException
{
    private static final long serialVersionUID = 1L;

    public BeerNotFoundException( final String beerName )
    {
        super( String.format( "Beer: '%s' not found!", beerName ) );
    }

}
