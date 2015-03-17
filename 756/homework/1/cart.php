<?php
include 'lib/lib_project1.php';
?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead ( "Cart", array ( "css/lib/perfect-scrollbar.min.css" ), 
        array ( "js/home/CatalogWidget.js", "js/home/SalesWidget.js" ) );
?>

<body>

    <?= templateHeader( true )?>
    <div id="content"></div>
</body>

</html>