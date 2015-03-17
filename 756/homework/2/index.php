<?php
require_once 'lib/lib_homework2.php';
?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead( 'Peeps', array ( 'css/userManagementStyle.css' ), 
        array ( 'js/lib/jquery.tablesorter.js', 'js/lib/underscore-min.js', 
                        'js/UserManagementWidget.js' ) );
?>

<body>
    <?= templateHeader()?>
    <div id="content"></div>
</body>

</html>