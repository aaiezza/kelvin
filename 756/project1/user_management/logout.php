<?php
require '../lib/lib_project1.php';

if ( isset( $_SESSION[USER] ) )
{
    unset( $_SESSION[USER] );
    
    if ( isset( $_COOKIE[session_name()] ) )
    {
        setcookie( session_name(), "", time() - 86400, "/" );
    }
    
    session_destroy();
}

redirectIfLoggedOut( '?logout' );

?>
