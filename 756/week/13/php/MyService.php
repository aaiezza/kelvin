<?php
require_once 'Product.class.php';
require_once 'RestService.class.php';

class MyService extends RestService
{

    private $products;

    public function __construct( $request )
    {
        parent::__construct( $request );
        
        // Dummy data store (normally this would come from a DB)
        for ( $i = 0; $i < 5; $i++ )
        {
            $this->products[] = new Product( "Product $i", $i );
        }
    }

    private function getProduct( $i )
    {
        return $this->products[$id];
    }

    protected function product( $args )
    {
        if ( count( $args ) == 0 && $this->method == 'GET' )
        {
            // path: /product
            $prods = array ();
            foreach ( $this->products as $prod )
            {
                $prods[] = array ( 'name' => $prod->getName(), 'id' => $prod->getId() );
            }
            return $prods;
        }
    }
}

try
{
    $service = new MyService( $_REQUEST['request'] );
    echo $service->processAPI();
} catch ( Exception $e )
{
    echo json_encode( array ( 'error' => $e->getMessage() ) );
}

?>