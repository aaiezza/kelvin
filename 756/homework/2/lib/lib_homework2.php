<?php
require_once './oop/Member.class.php';
require_once './oop/MemberForm.class.php';
require_once './oop/SignUpFormValidator.class.php';
require_once './oop/MemberServiceManager.class.php';
require_once '/home/axa9070/etc/db_conn.php';

/*
 * * * * * * * * * * *
 * MySQL database
 * * * * * * * * * * */
$DBMANAGER = MemberServiceManager::getInstance();

/*
 * * * * * * * * * *
 * Helper Functions
 * * * * * * * * * */

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

/**
 * Validate field
 */
function validate( &$errors, $field, $errorStatement )
{
    if ( empty( $field ) && !is_numeric( $field ) )
    {
        $errors[] .= $errorStatement;
    }
}

/*
 * * * * * * * * *
 * Page Templates
 * * * * * * * * */

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
        
        <title>Homework 2 | $title</title>
        <meta name="description" content="Project 1 | E-Commerce site">
        <meta name="author" content="Alex Aiezza">

        <link rel="stylesheet" href="css/mainStyle.css">
        <link rel="stylesheet" href="css/lib/perfect-scrollbar.min.css">
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
        <script src='js/lib/perfect-scrollbar.min.js'></script>
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
function templateHeader( $linkProfile = false, $logoutOption = false )
{
    $header = "<div id=\"header\"";
    $header .= $linkProfile ? "class=\"linkProfile\"" : "";
    $header .= "></div>";

    if ( $logoutOption )
        $header .= LOGOUT_OPTION;
    
    return $header;
}

?>
