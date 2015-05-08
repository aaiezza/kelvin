<!doctype html>
<html lang='en'>
<head>
<meta charset='utf-8' />
<title>File Demo</title>
</head>
<body>

<?php
// part 0 - Utilize a simple web service
// load file
$a = 1000;
$b = 2000;
$data = file_get_contents( "http://kelvin.ist.rit.edu/~axa9070/756/week/05/sum.php?num1=$a&num2=$b" );
echo "<p>$a + $b = $data</p>";

// part I - load one string
// load file
$filename = "joke.txt";
var_dump( is_writable( "somefile.txt" ) );
var_dump( is_readable( $filename ) );
var_dump( is_writable( $filename ) );

echo shell_exec( 'whoami' );

if ( is_readable( $filename ) )
{
    $data = file_get_contents( "$filename" );
    printf( '<p>%s</p>', $data );
}

echo "<hr/>";

// part II - load multiple records and put in an indexed array
echo "<h2>Part II</h2>";
$data = file( "jokes.txt" );
foreach ( $data as $joke )
{
    printf( "<p>%s</p>", $joke );
}

echo "<hr/>";

// part II.V - load a text friendly web service and echo out the results
echo "<h2>Part II.V - load a text friendly web service and echo out the results</h2>";
echo "<h3><a href='http://words.bighugelabs.com/api.php'>words.bighugelabs.com</a></h3>";
$url = "http://words.bighugelabs.com/api/2/3991f963b247256461da4b394efcb34f/stupid/";
$data = file( $url );

$words = array ( 'sim', 'syn', 'rel' );

foreach ( $data as $line )
{
    $arr = explode( '|', $line );
    if ( in_array( $arr[1], $words ) )
    {
        printf( '<p>%s = %s</p>', $arr[1], $arr[2] );
    }
}

// part III - load multiple records and put in a nested indexed array
$data = file( "jokes.txt" );
$jokes = array ();

// part IV - load multiple records and put in a nested associative array
$data = file( "jokes.txt" );
$jokes = array ();

foreach ( $data as $line )
{
    list ( $question, $answer ) = explode( '|', $line );
    $jokes[] = array ( 'question' => $question, 'answer' => $answer );
    print_r( $jokes );
    
    printf( '<p>%s<span class="hide">%s</span></p>', $jokes['question'], $jokes['answer'] );
}

echo "<hr/>";


// part V - load Cellular_subscribers_per_100_population.txt

$data = file( "Cellular_subscribers_per_100_population.txt" );
array_shift( $data );

echo '<pre>';
print_r( $data );
echo '</pre>';

?>


</body>
</html>
