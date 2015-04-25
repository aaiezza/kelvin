<?php

$port = intval( shell_exec( 'tail -n 1 ./resources/MyService-pid' ) );

$running = ( $port > 0 )? "RUNNING on Port: <code>$port</code>" : 'NOT AVAILABLE';

$clientURL =
    'http://kelvin.ist.rit.edu/~axa9070/756/homework/4/?server=http://' .
    (( $port > 0 )? "localhost:$port":"alvin.ist.rit.edu:8100");

?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
  <meta charset="UTF-8">

  <title>Beer Project!</title>
  <meta name="description" content="basic">
  <meta name="author" content="Alex Aiezza">
  <link type="image/x-icon" rel="icon" href="favicon.ico">

  <link type="text/css" rel="stylesheet" href="css/style.css">

</head>

<body>
    <div id="content">
        <p>
            This is where the server <i>is</i>, however you probably want to use
            a client to access the Beer Service.
        </p>
        <hr>
        <p>
            The server is written in Java and all of the source is available in
            this directory. The javadocs can be accessed <a href="./doc/">here</a>.
            Instead of running the main class file
            though there is an executable jar file called <code>BeerService.jar</code>.
        </p>
        <p>
            An even easier alternative I have devised for starting the server is
            through the use of <code>beer-service</code>. This page will let you
            know if the server is running here locally via the beer-service command.
        </p>
        <hr>
        <h2 class="<?= ( $port > 0 )? 'good':'nogood' ?>">
            The Server is <?= $running ?>
        </h2>
        <hr>
        <p>
            If the server is not available. You can log into kelvin and run the
            following command (provided you have the privledges):
        </p>
        <p>
            <tt>/home/axa9070/Sites/756/project2/beer-service [-port|-p {port number}] start</tt>
        </p>
        <p class="teensy">
            Notice that there is an optional parameter for a port. The Default is <code>7177</code>.
        </p>
        <hr>
        <p>
            If the server is running, going to the following URL should
            successfully access the Beer Service:
        </p>
        <p>
            <tt><a href="<?= $clientURL ?>" target="_blank"><?= $clientURL ?></a></tt>
        </p>
        <p>
            Notice that the URL above is to a client front-end
            for Homework 4 (Week 8). Here though we can see the <code>server</code>
            parameter is given in this <code>GET</code> request specifying where
            to find the service.
            <p class="teensy">If <code>server</code> is not provided in
                the <code>GET</code>, the default is: <code>http://alvin.ist.rit.edu:8100</code></p>
        </p>
        <hr>
        <p>
            To stop the server, you can use the same command as earlier, only
            this time specifying <code>stop</code> as the only argument.
        </p>
        <p>
            <tt>/home/axa9070/Sites/756/project2/beer-service stop</tt>
        </p>
        <hr>
        <p>
            I also realize this project was supposed to be completed in PHP. So to use the PHP version with my client, this link is available:
        </p>
        <p>
            <tt><a href="http://kelvin.ist.rit.edu/~axa9070/756/homework/4/?server=http://localhost/~axa9070/756/project2/ophp/xmlrpc.php">http://kelvin.ist.rit.edu/~axa9070/756/homework/4/?server=http://localhost/~axa9070/756/project2/ophp/xmlrpc.php</a></tt>
        </p>
        <hr>
        <p>
            Enjoy!
        </p>
    </div>
</body>

</html>
