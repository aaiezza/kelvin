<?php
include_once './lib/lib_project1.php';

redirectIfLoggedOut();

$username = getActingUsername( "You cannot access another user's cart!" );
?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead( "Cart", array ( 'css/managementStyle.css', 'css/cartStyle.css' ),
        array ( 'js/lib/jquery.tablesorter.js', 'js/lib/underscore-min.js',
                'js/lib/underscore.string.min.js',
                'js/lib/jquery.formatCurrency-1.4.0.min.js',
                'js/CartWidget.js', 'js/FormWidget.js' ) );
?>

<body>

    <?= templateHeader( true, true, false, false, false, true )?>
    <div id="content"></div>
</body>
<span id="user"><?= $username ?></span>

</html>