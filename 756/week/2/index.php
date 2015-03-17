<?php
// PHP WEIRDNESS

// Non-numeric characters = ignore everything after that!
$weight = "170 lbs 3456";
$diet_weight = $weight * .9;


// interpolation greatness...
echo "my new weight: {$diet_weight}<br />\n";
echo "my new weight: $diet_weight<br />";

// no interpolation in single-quote strings!
echo 'my new weight: {$diet_weight}<br />';
echo 'my new weight: $diet_weight<br />';

// Escapes in double quotes, NOT single quotes
echo "my new weight: \$ \"$diet_weight '<br />";
echo 'my new weight: \$ \"$diet_weight<br />';

// CONSTANTS (no dollar sign!)
define ( "PI", 3.1415927 );
echo "I want a piece of " . PI . "<br />";
printf ( "I want a piece of %f<br />", PI );


// Can't redefine a constant!
define ( "PI", "apple" );

// Arrays
$animals[] = "lion";
$animals[] = "tiger";
$animals[] = "bear";

printf ( "My favorite animal is a %s.<br/>", $animals[2] );

$fruit = array ( 'apple', 'pear', 'peach' );

printf ( "My favorite fruit is a %s.<br/>", $fruit[0] );

// MULTI_DIMENSIONAL
$drPeople = array ( array ( 'first' => 'Juan', 'last' => 'Ortiz' ), 
                array ( 'first' => 'Randy', 'last' => 'Perez' ) );

foreach ( $drPeople as $person )
    printf ( "%s<br />", print_r ( $person, true ) );

foreach ( $drPeople as $person )
    foreach ( $person as $key => $value )
        printf ( "%s: %s<br />", $key, $value );
    

    // List the variables in your array
$info = array ( 'coffee', 'brown', 'caffeine' );

list ( $drink, $color, $power ) = $info;

printf ( 'Drink: %s, Color: %s, Power: %s<br/>', $drink, $color, $power );

// IMPLODE / EXPLODE
$imploded_info = implode ( ", ", $info );
echo $imploded_info;
echo '<br />';

printf ( "%s<br />", print_r ( explode ( ", ", $imploded_info ), true ) );

// PASS by REFERENCE in order to alter object!
foreach ( $drPeople as &$person )
{
    $person['first'] = lcfirst ( $person['first'] );
}

foreach ( $drPeople as $person )
    printf ( "%s<br />", print_r ( $person, true ) );
    

    // FUNCTIONS
function addThem( $num1 = 2, $num2 )
{
    return $num1 + $num2 . $num1 . $num2 . '<br />';
}

echo addThem ( 1 );
echo addThem ( 1, 4 );
echo addThem ( 1, 4, 1 ); // ignores extra parameters
function println( $args )
{
    $format = '%s<br />';
    printf ( $format, $args );
}

// Dates!
// NEED to have date.timezone in php.ini file within server
//   or within .user.ini file (Apache = .htaccess file)
// date_default_timezone_set ( 'America/New_York' );

$date_format = 'l, F jS, Y';
println ( date ( $date_format ) );
println ( date ( $date_format, time () ) );
println ( date ( $date_format, mktime ( 0, 0, 0, 1, 1, 2015 ) ) );

println ( $_SERVER['HTTP_REFERER'] );
println ( $_SERVER['SERVER_NAME'] );

?>

<?php
// COOKIES!!!!!! (C IS FOR COOKIE)

// P is for PEMDAS... but that's not good enough for me!
$expire = time () + ( 7 * 24 * 60 * 60 );
// Cookie expires with the SESSION
// $expire = NULL;
// $expire = 0;
$path = '/~axa9070';
// $domain = 'kelvin.ist.rit.edu';
// Set to NULL, domain is the SERVER_NAME
$domain = NULL;
// $domain = $_SERVER['SERVER_NAME'];
$secure = false; // accessible on HTTP (not just HTTPS)
$http_only = false; // accessible to js

setcookie ( 'test_cookie', 'my First cookie!', null, $path, $domain, $secure, $http_only );

$counter = isset ( $_COOKIE['counter'] ) ? $_COOKIE['counter'] : 0;

printf ( '<h2>counter = %s</h2><br />', $counter );

setcookie ( 'counter', ++$counter );


?>






