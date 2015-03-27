<?php
require 'xmlrpc_client.php';

if ( isset( $_GET['server'] ) )
    connect( $_GET['server'] );
else 
{
    $_GET['server'] = DEFAULT_SERVER;
    connect();
}

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

    <script type='text/javascript' src='//code.jquery.com/jquery-git2.js'></script>
    <script type='text/javascript' src="js/lib/jquery.formatCurrency-1.4.0.min.js"></script>
    <script type='text/javascript' src="js/lib/jquery.xmlrpc.js"></script>
    <script type='text/javascript' src="js/lib/underscore-min.js"></script>
    <script type='text/javascript' src="js/lib/underscore.string.min.js"></script>
    <script type='text/javascript' src="js/XmlRpcWidget.js"></script>
    <script type='text/javascript' src="js/main.js"></script>
</head>

<body>
    <div id='content'>
        <h2 id='title'>Amazing Beer Service</h2>

        <div id='beerWidget'>
            <p>
                <label for='server_loc'>Server:</label>
                <input id='server_loc' type='url' value='<?= $_GET['server'] ?>'>
                <input id='updateServerLoc' type='button' value='Update Server Location'>
            </p>

            <p>
                <input id='getMethodsButton' class='serviceCall' type='button'
                    value='Get Methods' in='' out='getMethodsField' dest='beer.getMethods'>
                <select id='getMethodsField'></select>
            </p>

            <p>
                <input id='getBeersButton' class='serviceCall' type='button'
                    value='Get Beers' in='' out='getBeersField' dest='beer.getBeers'>
                <select id='getBeersField'></select>

                <input id='getPriceButton' class='serviceCall' type='button'
                    value='Get Price' in='getBeersField' out='getPriceField' dest='beer.getPrice'>
                <input id='getPriceField' class='currency' type='text' readonly>
            </p>

            <p>
                <input id='getCheapestButton' class='serviceCall' type='button'
                    value='Get Cheapest' in='' out='getCheapestName getCheapestPrice' dest='beer.getCheapest'>
                <label for='getCheapestName'>Name:</label>
                <input id='getCheapestName' type='text' readonly>
                <label for='getCheapestPrice'>Price:</label>
                <input id='getCheapestPrice' class='currency' type='text' readonly>
            </p>

            <p>
                <input id='getCostliestButton' class='serviceCall' type='button'
                    value='Get Costliest' in='' out='getCostliestName getCostliestPrice' dest='beer.getCostliest'>
                <label for='getCostliestName'>Name:</label>
                <input id='getCostliestName' type='text' readonly>
                <label for='getCostliestPrice'>Price:</label>
                <input id='getCostliestPrice' class='currency' type='text' readonly>
            </p>

            <p>
                <input id='setPriceButton' class='serviceCall' type='button'
                    value='Set Price' in='setPriceName setPricePrice'
                    out='' dest='beer.setPrice'>
                <label for='setPriceName'>Name:</label>
                <input id='setPriceName' type='text'>
                <label for='setPricePrice'>Price:</label>
                <input id='setPricePrice' class='currency' type='text'>
            </p>

            <!--
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
             -->
        </div>

    </div>
</body>

</html>