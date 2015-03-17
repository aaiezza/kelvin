<?php
require_once '../lib/lib_project1.php';

redirectIfLoggedOut();

// This is a secure area!
if ( !$MEMBER_DB_MANAGER->isAdmin() )
{
    redirectIfLoggedIn();
}
?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead( 'User Management', array ( '../css/managementStyle.css' ), 
        array ( '../js/lib/jquery.tablesorter.js', '../js/lib/underscore-min.js', 
                        '../js/UserManagementWidget.js' ) );
?>

<body>
    <?= templateHeader(true, true)?>
    <div id="content"></div>
</body>

</html>