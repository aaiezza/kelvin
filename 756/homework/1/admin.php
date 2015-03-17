<?php
include 'lib/lib_project1.php';
?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead ( "Admin", array ( "css/lib/perfect-scrollbar.min.css" ), 
        array () );
?>

<body>

    <?= templateHeader( true )?>
    <div id="content"></div>
</body>

</html>