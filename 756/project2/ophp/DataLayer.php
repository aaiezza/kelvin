<?php
/**
 * Created by PhpStorm.
 * User: Sagar Barbhaya
 * Date: 4/4/2015
 * Time: 12:15 AM
 */
class DataLayer
{
    function getBeersList()
    {
        $beersList = array();

        if ( ($handle = fopen("BeerData.csv", "r") ) !== FALSE) {
            while ((list($beerName, $beerPrice) = fgetcsv($handle)) !== false) {
                $beersList[$beerName] = $beerPrice;
            }
            fclose($handle);
        }

        return $beersList;
    }

    function storeBeers($beers) {
        $handle = fopen("BeerData.csv","w");
        foreach($beers as $beerName=>$price) {
            fputcsv($handle, array($beerName, $price));
        }
        return fclose( $handle );
    }
}
?>