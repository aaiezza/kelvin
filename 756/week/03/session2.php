<?php
  // initiate session
  // session_name( "someone" ); //optional
  // default is PHPSESSID
  session_start();
  
  // check that the form was submitted
  if ( !empty( $_POST["name"] ) )
  {
    session_regenerate_id( true );
    // set session variable
    $_SESSION["name"] = $_POST["name"];

    if ( isset( $_SESSION['HTTP_USER_AGENT'] ) )
    {
      $string = $_SESSION['HTTP_USER_AGENT'];
      $string .= 'SHIFLETT';
      /* Add any other data (salt) that is consistent */
      $fingerprint = md5( $string );
    
      // Set some fingerprint
    }
  }

?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Session 2</title>
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
      // if set, greet by name
      echo "Hi, " . $_SESSION["name"] . ". <a href='session3.php'>Next</a>";
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