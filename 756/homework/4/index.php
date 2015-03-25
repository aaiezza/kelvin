<?php
require 'xmlrpc_client.php';

if ( isset( $_GET['server'] ) )
  connect( $_GET['server'] );
else connect();

?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
  <meta charset="UTF-8">

  <title>Beer!</title>
  <meta name="description" content="basic">
  <meta name="author" content="Alex Aiezza">

  <link rel="icon" type="image/ico" href="favicon.ico">

  <link rel="stylesheet" href="css/beerStyle.css">

  <script type='text/javascript' src='//code.jquery.com/jquery-2.1.3.min.js'></script>
  <script type='text/javascript' src="js/lib/jquery.formatCurrency-1.4.0.min.js"></script>
  <script type='text/javascript' src="js/main.js"></script>
</head>

<body>
    <div id='content'>
        <h2 id='title'>Amazing List of Beers</h2>
        <div id='beerTable'>
            <table>
                <tr><th>Beer</th><th>Price</th></tr>
                <?php
                if ( $client )
                {
                  $beers = callIt( 'beer.getBeers' );

                  foreach ( $beers as $beer )
                  {
                      $price = callIt( 'beer.getPrice',
                          array( new xmlrpcval( $beer->scalarval(), $xmlrpcString ) ) );
                      printf( '<tr><td>%s</td><td class="currency">%f</td></tr>',
                          $beer->scalarval(), $price );
                  }
                }

                ?>
            </table>

            <table id='stats'>
                <tr><td><h4>Cheapest Beer</h4></td><td>
                    <?= $client? callIt( 'beer.getCheapest' ) : ''; ?>
                </td></tr>
                <td><h4>Costliest Beer</h4></td><td>
                    <?= $client? callIt( 'beer.getCostliest' ) : ''; ?>
                </td></tr>
            </table>
        </div>
    </div>
</body>

</html>