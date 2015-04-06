<?php
require_once 'Beer.class.php';

class BeerDataSourceManager
{
    const DEFAULT_DATA_SOURCE = './beers.csv';

    private $dataSourcePath;

    public function __construct( $dataSourcePath = self::DEFAULT_DATA_SOURCE )
    {
        $this->dataSourcePath = $dataSourcePath;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function getBeers()
    {
        $dataSource = fopen( $this->dataSourcePath, 'r' );

        $beers = array();

        while ( ( list( $name, $price ) = fgetcsv( $dataSource ) ) !== FALSE )
        {
            $beers[$name] = new Beer( $name, doubleval( $price ) );
        }

        fclose( $dataSource );

        return $beers;
    }

    public function getBeer( $beerName )
    {
        foreach ( $this->getBeers() as $beer )
        {
            if ( $beer->getName() == $beerName )
            {
                return $beer;
            }
        }

        return null;
    }

    public function storeBeers( array $beers )
    {
        $dataSource = fopen( $this->dataSourcePath, 'w' );

        foreach( $beers as $beerName => $beer )
        {
            fputcsv( $dataSource, $beer->toArray() );
        }

        return fclose( $dataSource );
    }
}

// DEBUG
function debugBeerDataSourceManager()
{
    $beerMan = new BeerDataSourceManager();

    echo '<pre>';
    print_r( $beers = $beerMan->getBeers() );
    echo '<hr>';
    $beers['Sam Adams'] = new Beer( 'Sam Adams', 13.98 );
    print_r( $beerMan->storeBeers( $beers ) );
    echo '<hr>';
    print_r( $beerMan->getBeer( 'Sam Adams' ) );
    echo '</pre>';

    // reset db
    $beers['Sam Adams'] = new Beer( 'Sam Adams', 13.99 );
    $beerMan->storeBeers( $beers );
}
// debugBeerDataSourceManager()
?>
