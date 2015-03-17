<?php

include_once 'MemberDetails.class.php';

final class MemberForm extends MemberDetails
{
    private $type;
    private $area_code;
    private $number;

    public function __construct(
        $username,
        $firstname,
        $lastname,
        $type,
        $area_code,
        $number,
        $id = 0 )
    {
        $numbers = array( new PhoneNumber( $id, $type, $area_code, $number ) );

        $this->type = $type;
        $this->area_code = $area_code;
        $this->number = $number;

        parent::__construct( $username, $firstname, $lastname, $numbers );
    }

    /**
     * @param string username
     *            the username to set
     */
    public function setUsername( $username )
    {
        $this->username = $username;
    }

    /**
     * @param string first_name
     *            the first_name to set
     */
    public function setFirstName( $first_name )
    {
        $this->first_name = $first_name;
    }

    /**
     * @param string last_name
     *            the last_name to set
     */
    public function setLastName( $last_name )
    {
        $this->last_name = $last_name;
    }

    public function setNumbers( $numbers )
    {
        $this->numbers = $numbers;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAreaCode()
    {
        return $this->area_code;
    }

    public function getNumber()
    {
        return $this->number;
    }
}
?>