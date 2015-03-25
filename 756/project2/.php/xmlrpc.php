<?php
include_once './lib/xmlrpc.inc';
include_once './lib/xmlrpcs.inc';
include_once './lib/xmlrpc_wrappers.inc';

function getMethods()
{
    $response = new xmlrpcval( -1, $xmlrpcArray );
    $methods = array(
        new xmlrpcval( 'getPrice'     , $xmlrpcString),
        new xmlrpcval( 'setPrice'     , $xmlrpcString),
        new xmlrpcval( 'getBeers'     , $xmlrpcString),
        new xmlrpcval( 'getCheapest'  , $xmlrpcString),
        new xmlrpcval( 'getCostliest' , $xmlrpcString) 
    );

    $response->addArray( $methods );

    return new xmlrpcresp( $response );
}

function getPrice( $params )
{
    // parse our params
    $beer = $params->getParam( 0 )->scalarval();
    // $price = $BeerManager->getPriceOfBeer( $beer );
    $price = 3.98;
    
    return new xmlrpcresp( new xmlrpcval( $price, $xmlrpcDouble ) );
}

function setPrice( $params )
{
    // parse our params
    $beer = $params->getParam( 0 )->scalarval();
    $price = $params->getParam( 1 )->scalarval();

    // $priceChanged = $BeerManager->setPriceOfBeer( $beer, $price );
    $priceChanged = false;
    
    return new xmlrpcresp( new xmlrpcval( $priceChanged, $xmlrpcBoolean ) );
}

function getBeers()
{
    $response = new xmlrpcval( -1, $xmlrpcArray );

    // $beers = $BeerManager->getBeers();
    $beers = array(
        new xmlrpcval( 'Bud'       , $xmlrpcString ),
        new xmlrpcval( 'Sam Adams' , $xmlrpcString )
    );

    $response->addArray( $beers );

    return new xmlrpcresp( $response );
}

function getCheapest()
{
    // $beer = $BeerManager->getCheapest();
    $beer = 'Bud';
    
    return new xmlrpcresp( new xmlrpcval( $beer, $xmlrpcString ) );
}

function getCostliest( $params )
{
    // $beer = $BeerManager->getCostliest();
    $beer = 'Sam Adams';
    
    return new xmlrpcresp( new xmlrpcval( $beer, $xmlrpcString ) );
}

/*
 * Declare out signature and provide some information
 *     in a "dispath map".
 * The PHP server supports "remote introspection". (Ask about my API)
 * Signature: array or signatures, where each is an array
 *     that includes the return type and one or more param types
 */
$getMethods_sig = array ( array ( $xmlrpcArray ) );
$getPrice_sig = array ( array ( $xmlrpcString, $xmlrpcString ) );
$setPrice_sig = array ( array ( $xmlrpcString, $xmlrpcDouble, $xmlrpcBoolean ) );
$getBeers_sig = array ( array ( $xmlrpcArray ) );
$getCheapest_sig = array ( array ( $xmlrpcString ) );
$getCostliest_sig = array ( array ( $xmlrpcString ) );

$getMethods_doc = 'Takes no arguments and returns a list of the methods contained in the service.';
$getPrice_doc = 'Takes a string denoting the beer brand and returns a double representing the beer price.';
$setPrice_doc = 'Takes a string denoting the beer brand and a double denoting the price returns true or false depending on success';
$getBeers_doc = 'Takes no arguments and returns a list of the known beers.';
$getCheapest_doc = 'Takes no arguments and returns the name of the least expensive beer.';
$getCostliest_doc = 'Takes no arguments and returns the name of the most expensive beer.';

new xmlrpc_server( 
    array (
        'beer.getMethods' => array( 'function' => 'getMethods', 
                        'signature' => $getMethods_sig, 
                        'docstring' => $getMethods_doc ),
        'beer.getPrice' => array( 'function' => 'getPrice',
                        'signature' => $getPrice_sig,
                        'docstring' => $getPrice_doc ),
        'beer.setPrice' => array( 'function' => 'setPrice',
                        'signature' => $setPrice_sig,
                        'docstring' => $setPrice_doc ),
        'beer.getBeers' => array( 'function' => 'getBeers',
                        'signature' => $getBeers_sig,
                        'docstring' => $getBeers_doc ),
        'beer.getCheapest' => array( 'function' => 'getCheapest',
                        'signature' => $getCheapest_sig,
                        'docstring' => $getCheapest_doc ),
        'beer.getCostliest' => array( 'function' => 'getCostliest',
                        'signature' => $getCostliest_sig,
                        'docstring' => $getCostliest_doc )
     )
);

?>
