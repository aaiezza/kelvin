package edu.rit.p3.data.exception;

import edu.rit.p3.data.BeerJdbcManager;
import edu.rit.p3.data.entity.User;

/**
 * Within the {@link BeerJdbcManager#updateUserToken(User)} method (Data Layer),
 * an attempt at creating an authorization token for a User with a certain
 * username may not may not be allowed because a user is under a certain age. In
 * which case, an instance of this exception is thrown.
 *
 * @author Alex Aiezza
 *
 */
public class UserUnderageException extends Exception
{
    private static final long serialVersionUID = 1L;

    public UserUnderageException( final User user, final int age )
    {
        super(
            String.format(
                "User: '%s' is only %d years of age and must be %d years of age to access this service!",
                user.getUsername(), user.getAge(), age ) );
    }

}
