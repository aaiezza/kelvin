package edu.kelvin.axa9070.data;

import javax.management.InstanceNotFoundException;

public class BeerNotFoundException extends InstanceNotFoundException
{
    private static final long serialVersionUID = 1L;
    
    public BeerNotFoundException( final String beerName )
    {
        super( String.format( "Beer: '%s' not found!", beerName ) );
    }

}
