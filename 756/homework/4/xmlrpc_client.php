<?php
require_once './lib/xmlrpc.inc';
require_once './lib/xmlrpcs.inc';
require_once './lib/xmlrpc_wrappers.inc';

define( 'DEFAULT_SERVER', 'http://alvin.ist.rit.edu:8100' );

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

            return $result;
        } else
        {
            // deal with XML-RPC error
            echo "We got an error!<br/>";
            echo $result->faultCode() . ": " . $result->faultString() . "<br/>";

            return $result;
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

    return $val->value()->scalarval();
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
        $price = callIt( 'beer.getPrice', array( new xmlrpcval( $beer->scalarval(), $xmlrpcString ) ), false );
        printf( '<p>%s: %f</p>', $beer->scalarval(), $price );
    }

    // $beers = callIt( 'beer.getRealBeers', array(), true );

    callIt( 'beer.getCheapest', array(), true );
    callIt( 'beer.getCostliest', array(), true );
}


// Handle a POST request to this file
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $file = fopen( 'xmlrpc_client.log', 'a' );
    fwrite( $file,
        sprintf( "Request - %s\n  server: %s\n  msg: %s\n",
            date( 'Y-m-t H:i:s', time() ),
            $_POST[server],
            $_POST[xmlrpcMsg] ) );

    connect( $_POST['server'] );
    $val = handle_xmlrpc( $client, $_POST['xmlrpcMsg'], false );

    fwrite( $file,
        sprintf( "Response |\n  %s\n\n", print_r( $val, true ) ) );

    fclose( $file );

    if ( $val->faultCode() > 0 )
    {
        die( $val->faultString() );
    }
    $val = $val->value()->scalarval();

    if ( is_array( $val ) )
    {
        $response = array();
        foreach( $val as $v )
        {
            $response[] = $v->scalarval();
        }
        echo json_encode( $response );
    }
    else
    {
        echo json_encode( $val );
    }
}
?>

