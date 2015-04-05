<?php
include_once './lib/xmlrpc.inc';
include_once './lib/xmlrpcs.inc';
include_once './lib/xmlrpc_wrappers.inc';

function helloWorld( xmlrpcmsg $params )
{
    return new xmlrpcresp( new xmlrpcval( 'Hello Math Fans!', $GLOBALS['xmlrpcString'] ) );
}

function calcCircle( xmlrpcmsg $params )
{
    // parse our params
    $radius = $params->getParam( 0 )->scalarval();
    
    return ( $radius > 0 ) ? new xmlrpcresp( new xmlrpcval( pi() * $radius * $radius, $GLOBALS['xmlrpcDouble'] ) ) : new xmlrpcresp( 
            new xmlrpcval( 'Error: radius is required' ) );
}

function calcRectangle( xmlrpcmsg $params )
{
    // parse our params
    $width = $params->getParam( 0 )->scalarval();
    $height = $params->getParam( 1 )->scalarval();
    
    return ( $width + $height > 0 ) ? new xmlrpcresp( new xmlrpcval( $width * $height, $GLOBALS['xmlrpcDouble'] ) ) : new xmlrpcresp( 
            new xmlrpcval( 'Error: width and height are required' ) );
}

/*
 * Declare out signature and provide some information
 *     in a "dispath map".
 * The PHP server supports "remote introspection". (Ask about my API)
 * Signature: array or signatures, where each is an array
 *     that includes the return type and one or more param types
 */
$helloWorld_sig = array ( array ( $GLOBALS['xmlrpcString'] ) );
$calcCircle_sig = array ( array ( $GLOBALS['xmlrpcDouble'], $GLOBALS['xmlrpcDouble'] ) );
$calcRectangle_sig = array ( array ( $GLOBALS['xmlrpcDouble'], $GLOBALS['xmlrpcDouble'], $GLOBALS['xmlrpcDouble'] ) );

$helloWorld_doc = 'Say hi';
$calcCircle_doc = 'Calculate the area of a circle';
$calcRectangle_doc = 'Calculate the area of a rectangle';

new xmlrpc_server( 
    array (
        'area.helloWorld' => array ( 'function' => 'helloWorld', 
                        'signature' => $helloWorld_sig, 
                        'docstring' => $helloWorld_doc ),
        'area.calcCircle' => array( 'function' => 'calcCircle',
                        'signature' => $calcCircle_sig,
                        'docstring' => $calcCircle_doc ),
        'area.calcRectangle' => array( 'function' => 'calcRectangle',
                        'signature' => $calcRectangle_sig,
                        'docstring' => $calcRectangle_doc )
     )
);

?>
