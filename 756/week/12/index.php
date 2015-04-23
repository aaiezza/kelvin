<?php
require_once './phpLib/MyCurl.class.php';

define( 'BASE_URL', 'http://simon.ist.rit.edu:8080/AreaDemo/resources/AreaCalculator/' );

$responses = array ();

$responses[] = sprintf( '<p>%s</p>', file_get_contents( BASE_URL . 'Hello' ) );

$responses[] = sprintf( '<p>%s</p>', 
        file_get_contents( BASE_URL . 'Rectangle?width=32&length=6543.21' ) );

// CURL!
$responses[] = MyCurl::getRemoteFile( BASE_URL . 'Rectangle?width=32&length=6543.21' );

$responses[] = MyCurl::getRemoteFile( BASE_URL . 'Rectangle?width=32&length=6543.21' );

$data = array ( 'name' => 'stereo', 'id' => '7' );

define( 'PRODUCT_URL', 'http://kelvin.ist.rit.edu/~bdfvks/341/rest/product' );

$responses[] = sprintf( '<pre>%s</pre>', print_r( MyCurl::sendPost( PRODUCT_URL, $data ), true ) );

$responses[] = sprintf( '<pre>%s</pre>', print_r( MyCurl::sendPut( PRODUCT_URL, $data ), true ) );

?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Basic Webapp</title>
<meta name="description" content="basic">
<meta name="author" content="Alex Aiezza">

<link rel="stylesheet" href="css/template.css">

<link rel="icon" type="image/ico" href="images/favicon.ico">

<script src='//code.jquery.com/jquery-2.1.3.min.js'></script>
<script src="js/template.js"></script>
</head>

<body>
    <div id="content">
        <h2>Fun with REST!</h2>
        <p>To run the java REST client execute:</p>
        <p style="padding-left: 25px;">
            <tt>java -cp
                /home/axa9070/Sites/756/week/12/build/classes:/home/axa9070/Sites/756/week/12/lib/commons-codec-1.10.jar:/home/axa9070/Sites/756/week/12/lib/commons-httpclient-3.1.jar:/home/axa9070/Sites/756/week/12/lib/commons-logging-1.2.jar
                RestClient</tt>
        </p>
        <p>
        <?php
        printf( '<pre>%s</pre>', 
                shell_exec( 
                        'java -cp /home/axa9070/Sites/756/week/12/build/classes:/home/axa9070/Sites/756/week/12/lib/commons-codec-1.10.jar:/home/axa9070/Sites/756/week/12/lib/commons-httpclient-3.1.jar:/home/axa9070/Sites/756/week/12/lib/commons-logging-1.2.jar RestClient' ) );
        ?>
        </p>
        <hr>
        <?php foreach( $responses as $resp ) { printf( '<p>%s</p><hr>', $resp ); } ?>
    </div>
</body>

</html>