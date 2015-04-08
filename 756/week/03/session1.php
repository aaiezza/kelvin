<?php
session_start ();

// redirect
function redirect()
{
    header ( "Location: session2.php" );
    die ();
}

// redirect if already logged in
if (isset ( $_SESSION["name"] ))
{
    redirect ();
}
?>
<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Session 1</title>
<meta name="description" content="basic">
<meta name="author" content="Alex Aiezza">

<link rel="stylesheet" href="css/template.css">

<link rel="icon" type="image/ico" href="images/favicon.ico">

<script src='https://code.jquery.com/jquery-2.1.3.min.js'></script>
<script src="js/template.js"></script>
</head>

<body>
    <div id="content">
        <h2>Here we are!</h2>
        <form method="post" action="session2.php">
            <p>
                <label for="name">Name:</label>
                <input id="name" name="name" />
            </p>
            <p>
                <input type="submit" value="Submit" />
            </p>
        </form>
    </div>
</body>

</html>