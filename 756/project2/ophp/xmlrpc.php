<?php
/**
 * Created by PhpStorm.
 * User: Sagar Barbhaya
 * Date: 4/1/2015
 * Time: 12:09 PM
 */

include_once './lib/xmlrpc.inc';
include_once './lib/xmlrpcs.inc';
include_once './lib/xmlrpc_wrappers.inc';

require_once './DataLayer.php';
require_once './BusinessLayer.php';


// Create data layer
$dl = new DataLayer();

// Create businees layer
$bl = new BusinessLayer( $dl );

function getMethods( $params ) {
    global $bl;

    $methodsLists = array();
    foreach( $bl->getMethods() as $method)
    {
        $methodsLists[] = new xmlrpcval( $method );
    }
    return new xmlrpcresp( new xmlrpcval( $methodsLists, 'array' ) );
}

function getBeers( $params ) {
    global $bl;

    $beerNamesList = array();
    foreach( $bl->getBeers() as $beer )
    {
        $beerNamesList[] = new xmlrpcval( $beer );
    }
    return new xmlrpcresp( new xmlrpcval( $beerNamesList, 'array' ) );
}

function getPrice( $params ) {
    global $bl;

    $beerName = $params->getParam( 0 )->scalarval();
    $beerPrice = $bl->getPrice( $beerName );
    return new xmlrpcresp( new xmlrpcval( $beerPrice, 'double' ) );
}

function getCheapest( $params ){
    global $bl;

    $cheap_beer = $bl->getCheapest();
    return new xmlrpcresp( new xmlrpcval( $cheap_beer, 'string' ) );
}

function getCostliest( $params ) {
    global $bl;

    $cost_beer = $bl->getCostliest();
    return new xmlrpcresp(new xmlrpcval( $cost_beer, 'string' ));
}


function setPrice( $params ) {
    global $bl;

    $beerName  = $params->getParam( 0 )->scalarval();
    $beerPrice = $params->getParam( 1 )->scalarval();

    return new xmlrpcresp( new xmlrpcval(
        $bl->setPrice( $beerName, $beerPrice ), 'boolean') );
}


$getMethods_sig = array( array( $GLOBALS['xmlrpcArray'] ) );
$getBeers_sig = array( array( $GLOBALS['xmlrpcArray'] ) );
$getPrice_sig = array( array( $GLOBALS['xmlrpcDouble'], $GLOBALS['xmlrpcString'] ) );
$setPrice_sig = array( array( $GLOBALS['xmlrpcBoolean'], $GLOBALS['xmlrpcString'], $GLOBALS['xmlrpcDouble'] ) );
$getCheapest_sig = array( array( $GLOBALS['xmlrpcString'] ) );
$getCostliest_sig = array( array( $GLOBALS['xmlrpcString'] ) );

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
        array("function" => "getBeers",
            "signature"=> $getBeers_sig,
            "docstring"=>$getBeers_doc),
    "beer.getPrice"=>
        array("function" => "getPrice",
            "signature"=> $getPrice_sig,
            "docstring"=>$getPrice_doc),
    "beer.setPrice"=>
        array("function" => "setPrice",
            "signature"=> $setPrice_sig,
            "docstring"=>$setPrice_doc),
    'beer.getCheapest'=>
        array('function' => 'getCheapest',
            'signature'=> $getCheapest_sig,
            'docstring'=> $getCheapest_doc),
    "beer.getCostliest"=>
        array("function" => 'getCostliest',
            "signature"=> $getCostliest_sig,
            "docstring"=> $getCostliest_doc),
));
?>