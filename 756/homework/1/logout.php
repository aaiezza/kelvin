<?php
require 'lib/lib_project1.php';

if (isset( $_SESSION[USERNAME] ))
{
    unset( $_SESSION[USERNAME] );
    
    if (isset( $_COOKIE[session_name()] ))
    {
        setcookie( session_name(), "", time() - 86400, "/" );
    }
    
    session_destroy();
}

redirectIfLoggedOut( '?logout' );

?>
