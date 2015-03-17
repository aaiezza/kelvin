<?php
echo '<style>p{margin:0;}</style>';

$dom = new DomDocument();
$dom->load( 'http://www.javascriptworld.com/js6e/chap15/us-states.xml' );

// list all stats using xpath
$xpath = new DomXPath( $dom );
$query = '//choices/item/label';
echo '<h2>List of all states, one by one &hellip;</h2>';

$list = $xpath->query( $query );
foreach ( $list as $label )
{
    
    printf( '<p>%s</p>', $label->nodeValue );
}

// Now get elements by tag name
echo "<hr><h2>list them again!</h2>";
$list = $dom->getElementsByTagName( 'label' );
foreach ( $list as $label )
{
    printf( '<p>%s</p>', $label->nodeValue );
}

?>