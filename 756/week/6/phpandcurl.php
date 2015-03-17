<?php
require_once '../5/MyCurl.class.php';

$data = array ( 'firstname' => 'Al', 'email' => 'axa9070@rit.edu', 
                'hobby' => array ( array ( 'hobbyName' => 'frisbee', 'isHobby' => true ), 
                                array ( 'hobbyName' => 'music', 'isHobby' => true ) ) );

// print out the array
function printIt( $data )
{
    echo '<h3>data array</h3>';
    echo '<pre>';
    print_r( $data );
    echo '</pre>';
}

printIt( $data );

// encode the array as JSON
$json_data = json_encode( $data );

printIt( $json_data );

// send the JSON to parser using the curl library
$results = MyCurl::sendPost( 'http://kelvin.ist.rit.edu/~axa9070/756/week/5/parser.php', 
        "json=$json_data" );

printIt( $results );

//decode the JSON
$orig_data = json_decode( $json_data );

printIt( $orig_data );

?>


