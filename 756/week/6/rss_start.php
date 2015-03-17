<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8' />
<title>Parsing RSS Namespaces</title>
</head>
<body>
    <h1>Parsing RSS Namespaces</h1>
	<?php
$top_ten_url = "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/topsongs/limit=10/rss.xml";
$weather_url = "http://weather.yahooapis.com/forecastrss?p=14623";

echo "<h2><u>Part 1 - Yahoo Weather RSS Feed</u></h2>";
// Instantiate the DOM object
$dom = new DOMDocument();
$dom->load( $weather_url );

// Get first title tag
$title = $dom->getElementsByTagName( 'title' )->item( 0 )->nodeValue;
echo "<h3>$title</h3>";

// Get yweather:astronomy
$yweatherNS = "http://xml.weather.yahoo.com/ns/rss/1.0";
$astronomy = $dom->getElementsByTagNameNS( $yweatherNS, 'astronomy' )->item( 0 );
$sunrise = $astronomy->getAttribute( 'sunrise' );
$sunset = $astronomy->getAttribute( 'sunset' );

date_default_timezone_set( 'America/New_York' );
$sunrise_timestamp = strtotime( $sunrise );
$sunset_timestamp = strtotime( $sunset );

$sunrise = date( 'H:i', $sunrise_timestamp );
$sunset = date( 'H:i', $sunset_timestamp );

echo "<h3>sunrise = $sunrise</h3>";
echo "<h3>sunset = $sunset</h3>";

// Get first item of feed
$item = $dom->getElementsByTagName( 'item' )->item( 0 );

// Get latitude and longitude for the first item

$geoNS = $dom->lookupNamespaceURI( 'geo' ); // manually place the string OR ...
$lat = $item->getElementsByTagNameNS( $geoNS, 'lat' )->item( 0 )->nodeValue;
$long = $item->getElementsByTagNameNS( $geoNS, 'long' )->item( 0 )->nodeValue;
echo "<h3>lat = $lat&deg;</h3>";
echo "<h3>long = $long&deg;</h3>";

// Get the description of the first item
echo "<div style='border:1px solid black; padding:10px; width:400px;'>" .
         $item->getElementsByTagName( 'description' )->item( 0 )->nodeValue . "</div>";


// Part 2 - You do this - Go ahead and parse an Apple Top 10 List
// print out each song <title> and <itms:album> in un-ordered list
echo "<br/><br/><hr />";
echo "<h2><u>Part 2 - Apple Top 10 RSS Feed</u></h2>";

?>
</body>
</html>