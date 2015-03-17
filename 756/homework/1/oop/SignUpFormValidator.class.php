<?php

class SignUpFormValidator
{

    const ACCEPTABLE_USERNAME = "/^[\w]{3,16}$/";
    
    /**
     * Validates a new user
     *
     * @param Member $user            
     * @return array
     */
    public static function validateMember( MemberForm $user )
    {
        $errors = array ();
        SignUpFormValidator::validate( $errors, $user->getFirstname(), "First name required." );
        SignUpFormValidator::validate( $errors, $user->getLastname(), "Last name required." );
        SignUpFormValidator::validate( $errors, $user->getEmail(), "Email required." );
        SignUpFormValidator::validate( $errors, $user->getUsername(), "Username required." );
        
        SignUpFormValidator::validate( $errors, $user->getPassword(), "Password required." );
        
        /* This condition of a username containing a space
         * is covered in the regex match to follow, however
         * explicitely checking for it allows me to be more
         * informative for the user.
         */
        if ( strpos( $user->getUsername(), " " ) > 0 )
        {
            $errors[] .= "Username contains space";
        }

        if ( count( $errors ) != 0 )
            return $errors;
        
        if ( !preg_match( "/^[\w]{3,16}$/", $user->getUsername() ) )
        {
            $errors[] .= "Username must only be 3 to 16 characters [a-zA-Z0-9_]";
        }
        
        if ( $user->getPassword() != $user->getConfirmPassword() )
        {
            $errors[] .= "Passwords Must Match";
        }
        
        return $errors;
    }
    
    /**
     *
     * @param array $errors            
     * @param string $field            
     * @param string $errorStatement            
     */
    static function validate( &$errors, $field, $errorStatement )
    {
        if ( empty( $field ) && !is_numeric( $field ) )
        {
            $errors[] .= $errorStatement;
        }
    }
}

?>
