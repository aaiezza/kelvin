<?php

require 'MemberDetails.class.php';

final class Member extends MemberDetails
{
    public static function userFromForm( MemberForm $userForm )
    {
        $numbers = array(
            new PhoneNumber( $userForm->getType(),
                $userForm->getAreaCode(), $userForm->getNumber() )
            );

        return new Member( $userForm->getUsername(),
                $userForm->getFirstName(), $userForm->getLastName(), 
                $numbers );
    }
}
?>