<?php
require_once 'lib/lib_homework2.php';

$result = array();

foreach ( $DBMANAGER->getUsers() as $username => $user )
{
    $result[$username]['first_name'] = $user->getFirstName();
    $result[$username]['last_name'] = $user->getLastName();
    $result[$username]['phone_numbers'] = array();

    foreach ( $user->getNumbers() as $number )
    {
        $result[$username]['phone_numbers'][$number->id]['type'] = $number->type;
        $result[$username]['phone_numbers'][$number->id]['area_code'] = $number->area_code;
        $result[$username]['phone_numbers'][$number->id]['number'] = $number->number;
    }

}

// Only for deleting all the users
// foreach ( $result as $username => $key )
// {
//     $user = $DBMANAGER->loadMemberByUsername( $username );
//     $DBMANAGER->deleteUser( $user );
// }

echo json_encode( $result );

header('Content-Type: application/json');
?>