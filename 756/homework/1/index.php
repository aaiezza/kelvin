<?php
include 'lib/lib_project1.php';

redirectIfLoggedOut();

?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead ( "Home", 
        array ( "css/lib/perfect-scrollbar.min.css", "css/salesStyle.css", "css/catalogStyle.css" ), 
        array ( "js/home/SalesWidget.js", "js/home/CatalogWidget.js" ) );
?>

<body>

    <?= templateHeader( true )?>
    <div id="content">
        <div id="salesBlock"></div>
        <div id="catalogBlock"></div>
    </div>
</body>

</html>