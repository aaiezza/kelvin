<?php

echo '<style>p{margin: 0 auto;}body{margin: 10px 10%}</style>';

function printIt( $data )
{
    echo '<pre>';
    print_r( $data );
    echo '</pre>';
}

$num_of_jokes = 6;

define( 'JOKES_SERVER', 
        "http://kelvin.ist.rit.edu/~dmgics/756/06/jokes_server.php?num=$num_of_jokes&type=xml" );

$dom = new DomDocument();
$dom->load( JOKES_SERVER );

// grab each joke element
$all_jokes = $dom->getElementsByTagName( 'joke' );
printIt( 'Length = ' . $all_jokes->length );

// echo out all jokes
foreach ( $all_jokes as $joke )
{
    $question = $joke->getElementsByTagName( 'question' )->item( 0 )->nodeValue;
    $answer = $joke->getElementsByTagName( 'answer' )->item( 0 )->nodeValue;
    $rating = $joke->getElementsByTagName( 'rating' )->item( 0 )->nodeValue;
    printf( "<p>%s</p><p>  > <em style='background-color: yellowgreen;'>%s</em></p><p style='padding-bottom: 15px;'>Rating: %s</p>", $question, $answer, $rating );
    
    ;
}

?>