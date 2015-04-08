<?php
$valid_hobbies = array ( "sport", "soccer", "tennis" );

// decode JSON string to PHP object
$decoded = json_decode( $_POST['json'] );

// Check to see if hobbies are valid
$hobbies = "";
$json['error'] = array ();
foreach ( $decoded->hobby as $hobby )
{
    if ( $hobby->isHobby )
    {
        $hobbies .= $hobbyy->hobbyName . ',';
        
        if ( array_search( $hobby->hobbyName, $valid_hobbies ) === false )
        {
            $json['error'][] = sprintf( 'Wrong hobby! (%s)', $hobby->hobbyName );
        }
    }
}

// trim off the last comma
trim( $hobbies, "," );

//count the errors
$json['errorNum'] = count ( $json['error'] );

$encoded = json_encode( $json );

header('Content-Type: application/json');

die( $encoded );
?>
