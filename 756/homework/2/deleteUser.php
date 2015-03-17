<?php
require_once 'lib/lib_homework2.php';

$username = $_POST['username'];

echo $username;

$DBMANAGER->deleteUser( $username );

?>