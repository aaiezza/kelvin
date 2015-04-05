<?php
include_once './lib/xmlrpc.inc';
include_once './lib/xmlrpcs.inc';
include_once './lib/xmlrpc_wrappers.inc';

$client = new xmlrpc_client( '/~axa9070/756/week/8/xmlrpc.php', 'kelvin.ist.rit.edu', 80 );
// output extra info about what client receives from server
// $client->setDebug( 1 );
// HTTP Basic Authentication
// $client->setCredentials( $username, $password );
function handle_xmlrpc( $client, $msg )
{
    // invoke the method
    $result = $client->send( $msg );
    
    if ( $result )
    {
        if ( $result->value() )
        { // no error has occurred
          // use a shortcut function to lazily decode a scalar
            $val = $result->value()->scalarval();
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

function callIt( $call, $params = array() )
{
    global $client;
    printf( '<hr><h3>%s</h3>', $call );
    $msg = new xmlrpcmsg( $call, $params );
    printf( '<pre>%s</pre>', htmlentities( $msg->serialize() ) );
    handle_xmlrpc( $client, $msg );
}

callIt( 'area.helloWorld' );
callIt( 'area.calcCircle', array ( new xmlrpcval( 5, $GLOBALS['xmlrpcDouble'] ) ) );
callIt( 'area.calcRectangle', 
        array ( new xmlrpcval( 5, $GLOBALS['xmlrpcDouble'] ), new xmlrpcval( 3, $GLOBALS['xmlrpcDouble'] ) ) );

callIt( 'system.listMethods' );
callIt( 'system.methodHelp', array ( new xmlrpcval( 'area.helloWorld', $GLOBALS['xmlrpcString'] ) ) );
callIt( 'system.methodHelp', array ( new xmlrpcval( 'area.calcCircle', $GLOBALS['xmlrpcString'] ) ) );
callIt( 'system.methodHelp', array ( new xmlrpcval( 'area.calcRectangle', $GLOBALS['xmlrpcString'] ) ) );

?>

