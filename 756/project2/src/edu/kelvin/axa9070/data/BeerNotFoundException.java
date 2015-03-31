package edu.kelvin.axa9070.data;

import javax.management.InstanceNotFoundException;

/**
 * Within some methods of the {@link BeerJdbcManager} (Data Layer), an attempt
 * at find a Beer with a certain name may not exist. In which case, an instance
 * of this exception is thrown.
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
