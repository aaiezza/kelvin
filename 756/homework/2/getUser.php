<?php
require_once 'lib/lib_homework2.php';

$username = $_POST['username'];

$user = $DBMANAGER->loadMemberByUsername( $username );

    $result['username'] = $user->getUsername();
    $result['first_name'] = $user->getFirstName();
    $result['last_name'] = $user->getLastName();
    $result['phone_numbers'] = array();

    foreach ( $user->getNumbers() as $number )
    {
        $result['phone_numbers'][$number->id]['type'] = $number->type;
        $result['phone_numbers'][$number->id]['area_code'] = $number->area_code;
        $result['phone_numbers'][$number->id]['number'] = $number->number;
    }

echo json_encode( $result );

header('Content-Type: application/json');
?>