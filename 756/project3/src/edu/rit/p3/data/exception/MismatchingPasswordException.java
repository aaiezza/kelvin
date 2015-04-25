package edu.rit.p3.data.exception;

import javax.security.auth.login.AccountNotFoundException;

import edu.rit.p3.web.BeerController;

/**
 * Within the {@link BeerController#getToken(String, String)} method (Business
 * Layer), an attempt at authenticating a user is made. In which case, the given
 * password does not match the password for the given username in the database,
 * this exception is thrown.
 *
 * @author Alex Aiezza
 *
 */
public class MismatchingPasswordException extends AccountNotFoundException
{
    private static final long serialVersionUID = 1L;

    public static final int   USERNAME         = 0, HASHCODE = 1;


    public MismatchingPasswordException()
    {
        super( "The given password does not match the password for that username." );
    }

}
