<?php
require_once '../lib/lib_project1.php';

redirectIfLoggedOut();

header('Content-Type: application/json');

$result = array();

$username = $_POST['username'];

echo json_encode( $PRODUCT_DB_MANAGER->getCartByUsername( $username ) );

?>