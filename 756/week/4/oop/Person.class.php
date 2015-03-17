<?php
require_once 'ComputerMajor.class.php';

abstract class Person
{

    private $first, $last;

    function __construct( $last = "TBD", $first = "TBD" )
    {
        $this->last = $last;
        $this->first = $first;
    }

    /**
     */
    public function getFirstName()
    {
        return $this->first;
    }

    /**
     * 
     */
    public function getLastName()
    {
        return $this->last;
    }

    /**
     *
     * @return string
     */
    public function sayHello()
    {
        return "My first name is " . $this->first . " and my last name is " . $this->last;
    }

    /**
     * Fun with inheritance! yeaaa!
     */
    public abstract function printFashion();
}
?>
