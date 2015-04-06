<?php
require_once './lib/xmlrpc.inc';
require_once './lib/xmlrpcs.inc';
require_once './lib/xmlrpc_wrappers.inc';

require_once 'BeerDataSourceManager.class.php';
require_once 'BeerHandler.class.php';

// Create Data Layer
$beerDataSourceManager = new BeerDataSourceManager();

// Create Business Layer
$beerHandler = new BeerHandler( $beerDataSourceManager );

// Create Service Layer
function getMethods   ( xmlrpcmsg $params )
{
    global $beerHandler;
    $methodsList = array();
    foreach ( $beerHandler->getMethods() as $method )
    {
        $methodsList[] = new xmlrpcval( $method, $GLOBALS['xmlrpcString'] );
    }
    return new xmlrpcresp( new xmlrpcval(
        $methodsList, $GLOBALS['xmlrpcArray'] ) );
}

function getBeers     ( xmlrpcmsg $params )
{
    global $beerHandler;
    $beers = array();
    foreach( $beerHandler->getBeers() as $beer )
    {
        $beers[] = new xmlrpcval( $beer, $GLOBALS['xmlrpcString'] );
    }
    return new xmlrpcresp( new xmlrpcval(
        $beers, $GLOBALS['xmlrpcArray'] ) );
}

function getPrice     ( xmlrpcmsg $params )
{
    global $beerHandler;
    return new xmlrpcresp( new xmlrpcval(
        $beerHandler->getPrice(
            $params->getParam( 0 )->scalarval() ), $GLOBALS['xmlrpcDouble'] ) );
}

function getCheapest  ( xmlrpcmsg $params )
{
    global $beerHandler;
    return new xmlrpcresp( new xmlrpcval(
        $beerHandler->getCheapest(), $GLOBALS['xmlrpcString'] ) );
}

function getCostliest ( xmlrpcmsg $params )
{
    global $beerHandler;
    return new xmlrpcresp( new xmlrpcval(
        $beerHandler->getCostliest(), $GLOBALS['xmlrpcString'] ) );
}

function setPrice     ( xmlrpcmsg $params )
{
    global $beerHandler;
    return new xmlrpcresp( new xmlrpcval(
        $beerHandler->setPrice(
            $params->getParam( 0 )->scalarval(),
            $params->getParam( 1 )->scalarval() ), $GLOBALS['xmlrpcBoolean'] ) );
}

$getMethods_sig = array( array( $GLOBALS['xmlrpcArray'] ) );
$getBeers_sig = array( array( $GLOBALS['xmlrpcArray'] ) );
$getPrice_sig = array( array( $GLOBALS['xmlrpcDouble'], $GLOBALS['xmlrpcString'] ) );
$setPrice_sig = array( array( $GLOBALS['xmlrpcBoolean'], $GLOBALS['xmlrpcString'], $GLOBALS['xmlrpcDouble'] ) );
$getCheapest_sig = array( array( $GLOBALS['xmlrpcString'] ) );
$getCostliest_sig = array( array($GLOBALS['xmlrpcString'] ) );

$getMethods_doc = "Get all the methods from server";
$getBeers_doc = "Get all the beers from server";
$getPrice_doc = "Get the price of Beer";
$setPrice_doc = "Set the price of Beer";
$getCheapest_doc= "Get the cheapest price of Beer";
$getCostliest_doc="Get the costliest price of Beer";

new xmlrpc_server( array(
    'beer.getMethods'=>
    array('function' => 'getMethods',
        'signature'=> $getMethods_sig,
        'docstring'=> $getMethods_doc),
    "beer.getBeers"=>
        array("function" => 'getBeers',
            "signature"=> $getBeers_sig,
            "docstring"=>$getBeers_doc),
    "beer.getPrice"=>
        array("function" => 'getPrice',
            "signature"=> $getPrice_sig,
            "docstring"=>$getPrice_doc),
    "beer.setPrice"=>
        array("function" => 'setPrice',
            "signature"=> $setPrice_sig,
            "docstring"=>$setPrice_doc),
    'beer.getCheapest'=>
        array('function' => 'getCheapest',
            'signature'=> $getCheapest_sig,
            'docstring'=> $getCheapest_doc),
    "beer.getCostliest"=>
        array("function" => 'getCostliest',
            "signature"=> $getCostliest_sig,
            "docstring"=>$getCostliest_doc),
));
?>
