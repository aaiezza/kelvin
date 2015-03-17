<?php
include 'lib/lib_project1.php';

redirectIfLoggedOut();

?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead ( 'Profile', array ( 'css/lib/perfect-scrollbar.min.css', 'css/profileStyle.css' ), 
        array ( 'js/ProfileWidget.js' ) );
?>

<body>

    <a id="logoutOption" href="./logout.php">Logout</a>
    <?= templateHeader( true )?>
    <div id="content">
        <h3>Well hey there, <?= $_SESSION[USERNAME]?>!</h3>
    </div>
</body>

</html>