<?php
  session_start();
?>
<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Session 3</title>
<meta name="description" content="basic">
<meta name="author" content="Alex Aiezza">

<link rel="stylesheet" href="css/template.css">

<link rel="icon" type="image/ico" href="images/favicon.ico">

<script src='https://code.jquery.com/jquery-2.1.3.min.js'></script>
<script src="js/template.js"></script>
</head>

<body>
  <div id="content">
  <?php
    //check if session variable's set
    if ( isset( $_SESSION["name"] ) )
    {
      echo "You're here " . $_SESSION["name"] . "!";
      // See? I remembered your name!

      // Tear down the session
      // #1: unset the session variable
      unset( $_SESSION["name"] );
      
      // #2: remove the session cookie
      if ( isset( $_COOKIE[session_name()] ) )
      {
        setcookie( session_name(), "", time() - 86400, "/" );
      }
      
      // #3: destroy the session
      session_destroy();
      echo "<span> <a href='session2.php'>Page 2</a></span>";
    }
    else
    {
    // if not, send back to login
      echo "Who are you? " . "<a href='session1.php'>Login</a>";
    }
  ?>
  </div>
</body>

</html>