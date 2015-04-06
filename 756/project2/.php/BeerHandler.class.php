<?php
require_once 'Beer.class.php';
require_once 'BeerDataSourceManager.class.php';

class BeerHandler
{
    private $beerDataSourceManager;

    public function __construct( BeerDataSourceManager $beerDataSourceManager )
    {
        $this->beerDataSourceManager = $beerDataSourceManager;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function getMethods()
    {
        return array(
            'Double getPrice(String beerName)',
            'Boolean setPrice(String beerName, Double beerPrice)',
            'String getCheapest()',
            'String getCostliest()',
            'String[] getBeers()'
        );
    }

    public function getBeers()
    {
        $beers = $this->beerDataSourceManager->getBeers();

        return array_keys( $beers );
    }

    public function getPrice( $beerName )
    {
        $beers = $this->beerDataSourceManager->getBeers();

        return $beers[$beerName]->getPrice();
    }

    public function getCheapest()
    {
        $beers = $this->sortBeers( $this->beerDataSourceManager->getBeers() );
        return $beers[0]->getName();
    }

    public function getCostliest()
    {
        $beers = $this->sortBeers( $this->beerDataSourceManager->getBeers() );
        return end( $beers )->getName();
    }

    public function setPrice( $beerName, $beerPrice )
    {
        $beers = $this->beerDataSourceManager->getBeers();

        if ( !array_key_exists( $beerName, $beers ) )
            return false;

        $beers[$beerName] = new Beer( $beerName, $beerPrice );

        return $this->beerDataSourceManager->storeBeers( $beers );
    }

    private function &sortBeers( &$beers )
    {
        usort( $beers, function( $beerA, $beerB )
            {
                return $beerA->getPrice() - $beerB->getPrice();
            }
        );
        return $beers;
    }
}

// DEBUG
function debugBeerHandler()
{
    $beerMan = new BeerDataSourceManager();
    $beerHandler = new BeerHandler( $beerMan );

    echo '<pre>';
    print_r( $beerHandler->getMethods() );
    echo '<hr>';
    print_r( $beerHandler->getBeers() );
    echo '<hr>';
    print_r( $beerHandler->getPrice( 'Sam Adams' ) );
    echo '<hr>';
    print_r( $beerHandler->getCheapest() );
    echo '<hr>';
    print_r( $beerHandler->getCostliest() );
    echo '<hr>';
    print_r( $beerHandler->setPrice( 'Guiness', 14.98 ) );
    echo '</pre>';
}

// debugBeerHandler();
?>
