<?php

// not using WSDL
$options = array ( 'trace' => 1, 'exceptions' => 1 );

// configure our WSDL location
$wsdl = 'http://kelvin.ist.rit.edu/~axa9070/756/week/9/server/phpSoapServer.php?WSDL';

try
{
    if ( !class_exists( 'SoapClient' ) )
    {
        die( 'You haven\'t installed the SOAP module' );
    }
    
    // first param: wsdl URI
    $client = new SoapClient( $wsdl, $options );
    
    $response = $client->helloWorld();
    var_dump( $response );
    echo '<hr>';
    
    // may have to use {$response->return} if stdClass is shown
    // in var_dump, such as from java server and for using
    // wsdl option
    echo $response;
    echo '<hr>';
    
    $response = $client->calcRectangle( 20, 10 );
    echo var_dump( $response );
    echo '<hr>';
    echo $response;
    echo '<hr>';
    
    $response = $client->calcCircle( 5 );
    echo var_dump( $response );
    echo '<hr>';
    echo $response;
    echo '<hr>';
    
    $response = $client->getNameWithAge( 'Santa', 10 );
    echo var_dump( $response );
    echo '<hr>';
    echo $response;
    echo '<hr>';
    
    $response = $client->countTo( 10 );
    echo var_dump( $response );
    echo '<hr>';
    if ( $response )
    {
        foreach ( $response as $value )
        {
            printf( '%s<br>', $value );
        }
    }
    echo '<hr>';
} catch ( SoapFault $e )
{
    printf( 'Soap Fault: %s', $e->getMessage() );
}
?>