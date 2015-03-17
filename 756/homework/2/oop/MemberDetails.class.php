<?php

require 'PhoneNumber.class.php';

abstract class MemberDetails
{
    protected $username;
    protected $firstname;
    protected $lastname;
    protected $numbers;

    /**
     * Constructs a new member object
     *
     * @param string $username
     *            the user's unique username.
     * @param string $firstname
     *            the user's firstname.
     * @param string $lastname
     *            the user's lastname.
     * @param string $numbers
     *            the user's phone numbers.
     */
    public function __construct(
        $username,
        $firstname,
        $lastname,
        $numbers = array() )
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->numbers = $numbers;
    }

    /**
     * Get the user's username.
     *
     * @return the user's username.
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Get the user's first name.
     *
     * @return the user's first name.
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * Get the user's last name.
     *
     * @return the user's last name.
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return user numbers
     */
    public function &getNumbers()
    {
        return $this->numbers;
    }

    public function toString()
    {
        return sprintf( "%s (%s %s)", $this->username, $this->firstname, $this->lastname );
    }
}

?>