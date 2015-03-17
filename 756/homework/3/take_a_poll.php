<?php
$lines = file( 'poll_data.txt' );

$data = array ();

foreach ( $lines as $line )
{
    list ( $topic, $q, $as ) = explode( '|', $line );
    
    $questions[$topic] = $q;
    $answers[$topic] = explode( ';', $as );
}


// make sure cat exists!
if ( empty( $_GET['cat'] ) || !array_key_exists( $_GET['cat'], $answers ) )
{
    header( "Location: choose_a_poll.php" );
    exit();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Take a Poll</title>
<style type="text/css">
ol {
    list-style-type: none;
    margin-left: 0;
    padding-left: 0;
}
</style>
</head>
<body>
    <h1>Take a Poll</h1>

    <h3><?php echo $questions[$_GET['cat']]; ?></h3>
    <form action='poll_results.php' method='GET'>
        <input type='hidden' name='cat' value='<?php echo $_GET['cat'] ?>' />
        <input type='hidden' name='question' value='<?php echo $questions[$_GET['cat']] ?>' />
        <ol>
<?php
foreach ( $answers[$_GET['cat']] as $value )
{
    echo "<li>
			<input type='radio' name = 'choice' value='$value' id='choice_" .
             urlencode( $value ) . "' />
			<label for='choice_" . urlencode( $value ) . "'>$value</label>
		</li>";
}
?>
</ol>
        <input type="reset" value="Reset Form" />
        <input type="submit" name="submit" value="Submit Form" />
    </form>
</body>
</html>