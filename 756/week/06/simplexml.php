<?php

function printIt( $title, $description, $link, $pubDate )
{
    printf( '<h3><a href="%s">%s</a></h3><p>%s</p><em>%s</em><hr>', $link, $title, $description, $pubDate );
}

echo '<h2>CNN Top Stories</h2>';

$cnnURL = 'http://rss.cnn.com/rss/cnn_topstories.rss';
$xml = simplexml_load_file( $cnnURL );

for ( $i = 0; $i < 10; $i++ )
{
    $title = $xml->channel->item[$i]->title;
    $link = $xml->channel->item[$i]->link;
    $description = $xml->channel->item[$i]->description;
    $pubDate = $xml->channel->item[$i]->pubDate;
    
    printIt( $title, $description, $link, $pubDate );
}

?>