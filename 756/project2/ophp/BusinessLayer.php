<?php
/**
 * Created by PhpStorm.
 * User: Sagar Barbhaya
 * Date: 4/4/2015
 * Time: 8:36 PM
 */
require_once './DataLayer.php';

class BusinessLayer {

    private $dl;

    public function __construct( DataLayer $dl )
    {
        $this->dl = $dl;
    }

    function getMethods() {
        $methodsList = array(
                'Double getPrice(String beerName)',
                'Boolean setPrice(String beerName, Double beerPrice)',
                'String getCheapest()',
                'String getCostliest()',
                'String[] getBeers()',
        );
        return $methodsList;
    }

    function getBeers() {
        $beersList = $this->dl->getBeersList();
        return array_keys( $beersList );
    }

    function getPrice( $beerName ) {
        $beersList = $this->dl->getBeersList();
        return $beersList[$beerName];
    }

     function getCostliest() {
        $beersList = $this->dl->getBeersList();
        $cost_beer = array_keys( $beersList, max( $beersList ) );
        return $cost_beer[0];
    }

    function getCheapest() {
        $beersList = $this->dl->getBeersList();
        $cheap_beer = array_keys( $beersList, min( $beersList ) );
        return $cheap_beer[0];
    }

    function setPrice( $beerName, $beerPrice ) {
        $beersList = $this->dl->getBeersList();

        // Check if beer exists
        if ( !array_key_exists( $beerName, $beersList ) )
            return false;

        $beersList[$beerName] = $beerPrice;

        return $this->dl->storeBeers( $beersList );
    }
}
