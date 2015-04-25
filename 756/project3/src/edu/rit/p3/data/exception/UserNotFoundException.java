package edu.rit.p3.data.exception;

import javax.management.InstanceNotFoundException;

import edu.rit.p3.data.BeerJdbcManager;

/**
 * Within some methods of the {@link BeerJdbcManager} (Data Layer), an attempt
 * at finding a User with a certain username may not exist. In which case, an
 * instance of this exception is thrown.
 *
 * @author Alex Aiezza
 *
 */
public class UserNotFoundException extends InstanceNotFoundException
{
    private static final long serialVersionUID = 1L;

    public UserNotFoundException( final String username )
    {
        super( String.format( "User: '%s' not found!", username ) );
    }

}
