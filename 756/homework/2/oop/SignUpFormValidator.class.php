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
        self::validate( $errors, $user->getFirstname(), "First name required." );
        self::validate( $errors, $user->getLastname(), "Last name required." );
        self::validate( $errors, $user->getUsername(), "Username required." );
        self::validate( $errors, $user->getAreaCode(), "Area Code required." );
        self::validate( $errors, $user->getNumber(), "Phone Number required." );
        self::validate( $errors, $user->getType(), "Phone Type required." );

        /* This condition of a username containing a space
         * is covered in the regex match to follow, however
         * explicitely checking for it allows me to be more
         * informative for the user.
         */
        if ( strpos( $user->getUsername(), " " ) > 0 )
        {
            $errors[] .= "Username contains space";
        }

        if ( !preg_match( "/^[\w]{3,16}$/", $user->getUsername() ) )
        {
            $errors[] .= "Username must only be 3 to 16 characters [a-zA-Z0-9_]";
        }

        if ( !preg_match( "/^[0-9]{3}$/", $user->getAreaCode() ) )
        {
            $errors[] .= "Area code must be 3 numbers.";
        }

        if ( !preg_match( "/^[0-9]{7}$/", $user->getNumber() ) )
        {
            $errors[] .= "Telephone Number must be 7 numbers.";
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

    /**
     *
     * @param array $errors            
     * @param string $field            
     * @param string $errorStatement            
     */
    static function validateNumber( &$errors, $field, $errorStatement )
    {
        if ( empty( $field ) )
        {
            $errors[] .= $errorStatement;
        }
    }
}

?>
