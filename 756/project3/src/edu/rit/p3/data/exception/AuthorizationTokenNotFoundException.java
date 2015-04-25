package edu.rit.p3.data.exception;

import javax.security.auth.login.AccountNotFoundException;

import edu.rit.p3.data.BeerJdbcManager;

/**
 * Within the {@link BeerJdbcManager#getTokenByUsername(String)} and the
 * {@link BeerJdbcManager#getTokenByHash(String)} methods (Data Layer), an
 * attempt at finding a User's authentication token with a certain username may
 * not exist. In which case, an instance of this exception is thrown.
 *
 * @author Alex Aiezza
 *
 */
public class AuthorizationTokenNotFoundException extends AccountNotFoundException
{
    private static final long serialVersionUID = 1L;

    public static final int   USERNAME         = 0, HASHCODE = 1;


    public AuthorizationTokenNotFoundException( final String key, final int tokenRetrievalMethod )
    {
        super( String.format( "Authentication token for %s: '%s' not found!",
            tokenRetrievalMethod == USERNAME ? "User"
                                               : tokenRetrievalMethod == HASHCODE ? "Token Hash" : "",
                                                                                  key ) );
    }

}
