<?php

// not using WSDL
$options = array ( 
                "location" => "http://kelvin.ist.rit.edu/~dmgics/756/09/phpSoapServerNoWsdl.php", 
                "uri" => "http://kelvin.ist.rit.edu/~dmgics" );

try
{
    // requires php-soap module: check with phpinfo()
    // first param: wsdl URI
    $client = new SoapClient( null, $options );
    
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