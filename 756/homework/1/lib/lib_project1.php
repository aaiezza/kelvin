<?php
require_once "./oop/Member.class.php";
require_once "./oop/MemberForm.class.php";
require_once "./oop/SignUpFormValidator.class.php";
require_once "./oop/MemberServiceManager.class.php";

session_start();

/*
 * * * * * * * * *
 * Load in properties
 */
$props = parse_ini_file( "resources/project1.properties", true );

/*
 * * * * * * * * *
 * Define Constants
 */
define( "USERNAME", $props["session-values"]["USERNAME"] );
define( "INTENTION", $props["session-values"]["INTENTION"] );
define( "SALT", $props["other"]["SALT"] );
define( "MEMBER_DB", $props["member-database"]["dbname"] );
$MEMBER_DB_MANAGER = MemberServiceManager::getInstance();

/*
 * * * * * * * * *
 * Helper Functions
 */

/**
 * Redirect user if they are logged in.
 *
 * @param string $location
 *            the location to redirect to. By default, this is <code>./</code>
 */
function redirectIfLoggedIn( $location = './profile.php' )
{
    if (isset( $_SESSION[INTENTION] ))
    {
        $location = $_SESSION[INTENTION];
    }

    if (isset( $_SESSION[USERNAME] ))
    {
        header( "Location: $location" );
        die();
    }
}

/**
 * Redirect user to login page if they are not yet logged in.
 */
function redirectIfLoggedOut( $params = '' )
{
    if (!isset( $_SESSION[USERNAME] ))
    {
        $_SESSION[INTENTION] = $_SERVER['HTTP_REFERER'];
        header( 'Location: ./login.php' . $params );
        die();
    }
}

/*
 * * * * * * * * *
 * Page Templates
 */

/**
 * Head Template
 *
 * @param string $title
 *            the title of the page
 * @param array $styles
 *            the paths to any styles to add
 * @param array $scripts
 *            the paths to any javascript scripts to add
 * @return string the template head tag element
 */
function templateHead( $title = "Page", $styles, $scripts )
{
    // head tag beginning
    $head = <<< EOF
        <head>
        <meta charset="UTF-8">
        
        <title>Project 1 | $title</title>
        <meta name="description" content="Project 1 | E-Commerce site">
        <meta name="author" content="Alex Aiezza">

        <link rel="stylesheet" href="css/mainStyle.css">
EOF;
    
    // Extra styles
    foreach ( $styles as $style )
    {
        $head .= "<link rel=\"stylesheet\" href=\"$style\">\n";
    }
    
    $head .= <<< EOF
        <link rel="icon" type="image/ico" href="images/favicon.ico">
        <script src='//code.jquery.com/jquery-2.1.3.min.js'></script>
        <script src='js/HeaderWidget.js'></script>
EOF;
    
    // Extra javascripts
    foreach ( $scripts as $script )
    {
        $head .= "<script src='$script'></script>\n";
    }
    
    $head .= "<h2 id='title'>$title</h2></head>";
    
    return $head;
}

/**
 * Header template
 *
 * @param string $linkProfile
 *            if true, will add the linkProfile class to the header div. Later on, the
 *            HeaderWidget javascript will cause the companyLogo to become
 *            a link back to the user's profile page.
 * @return string template header for the e-commerce site
 */
function templateHeader( $linkProfile = false )
{
    $header = "<div id=\"header\"";
    $header .= $linkProfile ? "class=\"linkProfile\"" : "";
    $header .= "></div>";
    
    return $header;
}

/*
 * * * * * * * * *
 * Validations
 */

/**
 * Generic preparation of form input
 *
 * @param string $data
 *            potentially 'dirty' string.
 * @return string the same string but trimmed, stripped, and html happy
 */
function clean_input( $data )
{
    $data = trim( $data );
    $data = stripslashes( $data );
    $data = htmlspecialchars( $data );
    
    return $data;
}

/*
 * * * * * * * * *
 * Database Functionality
 */

?>
