<?php
include_once './lib/xmlrpc.inc';
include_once './lib/xmlrpcs.inc';
include_once './lib/xmlrpc_wrappers.inc';

if ( !isset($_GET['server'] ) )
{
    $_GET['server'] = '/~sbb4019/756/Project2/xmlrpc.php';
}

//Creating an object for client
$client = new xmlrpc_client( '/~axa9070/756/project2/ophp/xmlrpc.php', 'kelvin.ist.rit.edu', 80 );
function handle_xmlrpc( $client, $msg )
{
    // invoke the method
    $result = $client->send( $msg );
    if ( $result )
    {
        if ( $result->value() )
        {// no error has occurred
            $val = $result->value()->scalarval();
            return $val;
        } else
        {
            // If there is any XML-RPC error
            echo "We got an error!<br/>";
            echo $result->faultCode() . ": " . $result->faultString() . "<br/>";
        }
    } else
    { // a low-level I/O error has occurred
        echo "Help! A low-level error has occurred. Error #" . $client->errno . ": " .
            $client->errstr . "<br/>";
        die();
    }
}
/*
 * Common function named as callFunctionalities which takes paramters as call and params.
 */
function callFunctionalities($call,$params=array())
{
    global $client;
    $msg = new xmlrpcmsg("beer.$call",$params);
    $value = handle_xmlrpc($client, $msg);
    // printf( '<pre>%s</pre>',  htmlentities( $msg->serialize() ) );
    return $value;
}

/*
 * If button for getMethods is called then we are calling callFunctionalities and passing getMethods as parameter.
 */
if($_POST['GetMethods']) {
    $methods=callFunctionalities("getMethods");
    $optionGetMethods="";
    foreach( $methods as $method ) {
        $optionGetMethods.="<option value='".$method->scalarval()."' >".$method->scalarval()."</option>";
    }
}

/*
 *  * If button for getBeers is called then we are calling callFunctionalities and passing getBeers as parameter.
 */
if($_POST['GetBeers']) {
    $beers=callFunctionalities("getBeers");
    $optionGetBeers="";
    foreach( $beers as $beer )
    {
        $optionGetBeers.="<option value='".$beer->scalarval()."'>".$beer->scalarval()."</option>";
    }
}
/*
 * Taking the value of beer and passing the same to getPrice function and value for that beer is retrived
 */
if($_POST['GetPrice']) {
    $price = callFunctionalities("getPrice", array(new xmlrpcval($_POST['Beers'], "string")));
    echo "The price for " .$_POST['Beers']. " is ". $price;
}
/*
 * If button for getCheapest is called then we are calling callFunctionalities and passing getCheapest as parameter.
 * And in the text box just printing out the result for cheap beer and its cheapest price.
 */
if($_POST['GetCheapest']) {
    $cheapName=callFunctionalities("getCheapest");
    $cheapPrice=callFunctionalities("getPrice",array( new xmlrpcval( $cheapName, "string" ) ));
}
/*
 * If button for getCostliest is called then we are calling callFunctionalities and passing getCostliest as parameter.
 * And in the text box just printing out the result for costliest beer and its costliest price.
 */
if($_POST['GetCostliest']) {
    $costName=callFunctionalities("getCostliest");
    $costPrice=callFunctionalities("getPrice",array( new xmlrpcval( $costName, "string" ) ));
}

if($_POST['SetPrice']) {
    $set = callFunctionalities("setPrice",array(
        new xmlrpcval( $_POST['beerName'], 'string'),
        new xmlrpcval( $_POST['beerPrice'], 'double') )
    );
}

?>
<html>
<head>
    <title>
        Beer Client
    </title>

</head>
<body>
<form method="post" action="xmlrpc_client.php">
    <table style="width: 50%">
        <tr>
            <td><input type="submit" name="GetMethods" value="GetMethods" ></td>
            <td><select>
                    <?php echo $optionGetMethods;?>
                </select></td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="GetBeers" value="GetBeers">
            </td>
            <td>
                <select id="Beers" name="Beers">
                    <?php echo $optionGetBeers;?>
                </select>
            </td>
            <td>
                <input type="submit" name="GetPrice" value="GetPrice">
            </td>
            <td>
                <input type="text" name="price" id="price" value="<?php echo $price;?>">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="GetCheapest" value="GetCheapest" >
            </td>
            <td>
                <label>Name</label>
                <input type="text" name="cheapName" id="cheapName" value="<?= $cheapName ?>">
            </td>
            <td>
                <label>Price</label>
                <input type="text" name="cheapPrice" id="cheapPrice" value="<?= $cheapPrice ?>">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="GetCostliest" value="GetCostliest">
            </td>
            <td>
                <label>Name</label>
                <input type="text" name="costName" id="costName" value="<?= $costName ?>">
            </td>
            <td>
                <label>Price</label>
                <input type="text" name="costPrice" id="costPrice" value="<?= $costPrice ?>">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="SetPrice" value="SetPrice">
            </td>
            <td>
                <label>Beer Name</label>
                <input type="text" name="beerName" id="beerName" value="">
            </td>
            <td>
                <label>Beer Price</label>
                <input type="text" name="beerPrice" id="beerPrice" value="">
            </td>
        </tr>
    </table>
</form>
</body>
</html>