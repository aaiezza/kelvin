<?php

function clean_input( $data )
{
    $data = trim ( $data );
    $data = stripslashes ( $data );
    $data = htmlspecialchars ( $data );
    return $data;
}

// Form Processing

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset ( $_POST['contact-submit'] ) )
{

    $info['Name'] = clean_input ( $_POST['contact-name'] );
    $info['Email'] = clean_input ( $_POST['contact-email'] );
    $info['Telephone'] = clean_input ( $_POST['contact-telephone'] );
    $info['Message'] = clean_input ( $_POST['contact-message'] );

    $info['Firefox User'] = $_POST['check-firefox'] == 'checkFirefox'? true : 0;
    $info['Chrome User'] = $_POST['check-chrome'] == 'checkChrome'? true : 0;
    $info['Safari User'] = $_POST['check-safari'] == 'checkSafari'? true : 0;
    $info['Internet Explorer User'] = $_POST['check-ie'] == 'checkIe'? true : 0;

    switch ( $_POST['radioBrowser'] )
    {
    case 'checkFirefox':
        $info['Favorite Browser'] = 'Firefox';
        break;
    case 'checkChrome':
        $info['Favorite Browser'] = 'Chrome';
        break;
    case 'checkSafari':
        $info['Favorite Browser'] = 'Safari';
        break;
    case 'checkIe':
        $info['Favorite Browser'] = 'Internet Explorer';
        break;
    default:
        $info['Favorite Browser'] = '';
    }

    // foreach : designed for maps!
    foreach ( $info as $key => $value )
    {
        $body .= $key . ' : ' . $value . "\n";

        if ( empty( $value ) && !is_numeric( $value ) )
        {
            $errors[] = "Invalid $key field!";
        }
    }

    if ( count( $errors ) <= 0 )
    {
        // My stuff
        $emailTo = 'axa9070@rit.edu';
        $subject = 'Lab 2 | HTML Forms';

        if ( mail ( $emailTo, $subject, $body, "Cc: {$email}" ) )
        {
            $feedback = "Form was successfully submitted.";
        } else
        {
            $feedback = "There was an error submitting the form.";
        }

        header( 'Location: ./contact-thanks.html' );
    }

    else
    {

        foreach ( $errors as $error )
        {
            echo '<p class="error">' . $error . '</p>';
        }
    }
}

?>

<style>

p.error {
    color: red;
    font-weight: bold;
}

</style>
