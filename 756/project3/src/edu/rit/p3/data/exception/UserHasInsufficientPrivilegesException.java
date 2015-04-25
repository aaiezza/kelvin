package edu.rit.p3.data.exception;

import edu.rit.p3.data.entity.User;
import edu.rit.p3.web.BeerController;

/**
 * Within the {@link BeerController#setPrice(String, double, String)} method
 * (Business Layer), an attempt to change a beer price is made. In order to do
 * this however, the user associated with the given tokenHash must have access
 * permissions.
 *
 * @author Alex Aiezza
 *
 */
public class UserHasInsufficientPrivilegesException extends Exception
{
    private static final long serialVersionUID = 1L;

    public UserHasInsufficientPrivilegesException( final User user, final String beerName )
    {
        super( String.format(
            "User: '%s' has insufficient privleges for changing the price of the '%s' beer.",
            user.getUsername(), beerName ) );
    }

}
