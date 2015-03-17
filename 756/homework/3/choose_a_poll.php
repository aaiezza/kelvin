<?php
$lines = file( 'poll_data.txt' );

$data = array ();

foreach ( $lines as $line )
{
    list ( $topic, $question ) = explode( '|', $line );
    
    $data[$topic] = $question;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Choose a Poll</title>
</head>
<body>
    <h1>Choose a Poll</h1>
    <ul>
<?php
foreach ( $data as $key => $value )
{
    echo "<li><a href=\"take_a_poll.php?cat=$key\">$key</a> - $value</li>";
}
?>
</ul>

<h3><a href='./add_poll.php'>Add a Poll</a></h3>
</body>
</html>
