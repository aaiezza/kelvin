package edu.rit.p3.data.exception;

import static java.lang.String.format;

import org.joda.time.Interval;
import org.joda.time.format.DateTimeFormat;

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

    public BeerServiceClosedException( final Interval closed )
    {
        super( format( "The BeerService is inaccessible between the hours of %s and %s", closed
            .getStart().toString( DateTimeFormat.forPattern( "HH:mm:ss" ) ), closed.getEnd()
            .toString( DateTimeFormat.forPattern( "HH:mm:ss" ) ) ) );
    }
}
