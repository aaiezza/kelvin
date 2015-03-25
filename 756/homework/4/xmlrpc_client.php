<?php
require_once './lib/xmlrpc.inc';
require_once './lib/xmlrpcs.inc';
require_once './lib/xmlrpc_wrappers.inc';

$client;

function connect( $server = 'http://alvin.ist.rit.edu:8100' )
{
    global $client;

    $client = new xmlrpc_client( $server );
    // $client = new xmlrpc_client( '', 'alvin.ist.rit.edu', 8100 );
    // output extra info about what client receives from server
    // $client->setDebug( 1 );
    // HTTP Basic Authentication
    // $client->setCredentials( $username, $password );
}


function handle_xmlrpc( $client, $msg, $echo = false )
{
    // invoke the method
    $result = $client->send( $msg );
    
    if ( $result )
    {
        if ( $result->value() )
        { // no error has occurred
          // use a shortcut function to lazily decode a scalar
            $val = $result->value()->scalarval();
            if ( $echo )
                echo "We got this result: $val<br/>";
            
            return $val;
        } else
        {
            // deal with XML-RPC error
            echo "We got an error!<br/>";
            echo $result->faultCode() . ": " . $result->faultString() . "<br/>";
        }
    } else
    { // a low-level I/O error has occurred
        echo "Help! A low-level error has occurred. Error #" . $client->errno . ": " .
                 $client->errstr . "<br/>";
        die();
    }
}


/** This will call a given method from the client declared above
 *
 * @return the response from the server
 */
function callIt( $call, $params = array(), $echo = false )
{
    global $client;
    if ( $echo )
        printf( '<h3>%s</h3>', $call );
    $msg = new xmlrpcmsg( $call, $params );
    if ( $echo )
        printf( '<pre>%s</pre>', htmlentities( $msg->serialize() ) );
    $val = handle_xmlrpc( $client, $msg, $echo );
    if ( $echo )
        echo '<hr>';

    return $val;
}

// $val = callIt( 'system.listMethods' );
// echo '<pre>';
// print_r( $val );
// echo '</pre>';

// callIt( 'system.methodHelp', array ( new xmlrpcval( 'getMethods', $xmlrpcString ) ) );

function test()
{
    connect( $_GET['server'] );
    $methods = callIt( 'beer.getMethods', array(), true );

    foreach ( $methods as $method )
    {
        printf( '<p>%s</p>', $method->scalarval() );
    }

    $beers = callIt( 'beer.getBeers', array(), true );

    foreach ( $beers as $beer )
    {
        $price = callIt( 'beer.getPrice', array( new xmlrpcval( 'Sam Adams', $xmlrpcString ) ), false );
        printf( '<p>%s: %f</p>', $beer->scalarval(), $price );
    }

    // $beers = callIt( 'beer.getRealBeers', array(), true );

    callIt( 'beer.getCheapest', array(), true );
    callIt( 'beer.getCostliest', array(), true );
}

?>

