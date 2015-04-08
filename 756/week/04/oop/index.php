<?php
function __autoload( $class_name )
{
    require_once "$class_name.class.php";
}

$person = new ComputerMajor( 'Friday', 'Frank' );
?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Class Fun!</title>
<meta name="description" content="basic">
<meta name="author" content="Alex Aiezza">

<link rel="stylesheet" href="../css/template.css">

<link rel="icon" type="image/ico" href="../images/favicon.ico">

<style>
.fashion {
    color: red;
    font-weight: bold;
}
</style>

<script src='https://code.jquery.com/jquery-2.1.3.min.js'></script>
<script src="../js/template.js"></script>
</head>

<body>
    <div id="content">
        <h2><?= sprintf( 'Welcome, %s %s!', $person->getFirstName(), $person->getLastName() ) ?></h2>
        <p><?= sprintf( 'The hot new fashion is: <span class="fashion">%s</span>.', $person->printFashion() ) ?></p>

    </div>
</body>

</html>