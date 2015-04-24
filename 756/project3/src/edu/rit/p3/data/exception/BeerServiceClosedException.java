package edu.rit.p3.data.exception;

import edu.rit.p3.data.BeerJdbcManager;

/**
 * Within the {@link BeerJdbcManager} methods (Data Layer), if a user attempts
 * to perform an action that requires authentication, the token string they pass
 * may be expired. In which case, an instance of this exception is thrown.
 * 
 * @author Alex Aiezza
 *
 */
public class BeerServiceClosedException extends Exception
{
    private static final long serialVersionUID = 1L;

    public BeerServiceClosedException()
    {
        super( "The BeerService is inaccessible between the hours of 00:00 and 10:00" );
    }
}
