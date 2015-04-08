<?php

$num1 = $_GET["num1"];
$num2 = $_GET["num2"];
$sum = $num1 + $num2;

/*
Tell the requester the MIME type (Multi-purpose Internet Mail Extension)
Other "Content-type" headers we could have sent are test/html (the default),
image/png, video/quicktime, application/vnd.ms-powerpoint, or many,
many others.
*/
header( "Content-type: text/plain" );
header( "Have: A nice day" );

// Send the result back
echo $sum;

?>