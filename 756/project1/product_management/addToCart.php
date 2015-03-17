<?php
require_once '../lib/lib_project1.php';

header('Content-Type: application/json');

$username = $_POST['username'];
$productId = $_POST['productId'];

echo json_encode( $PRODUCT_DB_MANAGER->insertProductIntoUserCart( $username, $productId ) );
?>
 