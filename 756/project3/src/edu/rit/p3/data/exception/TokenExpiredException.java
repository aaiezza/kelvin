package edu.rit.p3.data.exception;

import java.security.cert.CertificateExpiredException;

import edu.rit.p3.data.BeerJdbcManager;

/**
 * Within the {@link BeerJdbcManager} methods (Data Layer), if a user attempts
 * to perform an action that requires authentication, the token string they pass
 * may be expired. In which case, an instance of this exception is thrown.
 *
 * @author Alex Aiezza
 *
 */
public class TokenExpiredException extends CertificateExpiredException
{
    private static final long serialVersionUID = 1L;

    public TokenExpiredException( final String key )
    {
        super( String.format( "Authentication token: '%s' has expired!", key ) );
    }
}
