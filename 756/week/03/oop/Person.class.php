<?php
class Person
{
  function __construct( $last = "TBD", $first = "TBD" )
  {
    $this->last = $last;
    $this->first = $first;
  }

  function getFirstName()
  {
    return $this->first;
  }

  function getLastName()
  {
    return $this->last;
  }

  function sayHello()
  {
    return "My first name is " . $this->first .
      " and my last name is " . $this->last;
  }
}
?>
