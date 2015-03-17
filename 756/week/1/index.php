<?php
/*
 * Super Global Variables
 *
 * $_SERVER data about the server environment
 *
 * $_POST data from a post form submission
 * $_GET data from a get submission
 * $_COOKIE data that is stored on client (like session IIS)
 * $_REQUEST data from BOTH POST & GET and cookies
 * ( DON'T USE )
 * $_SESSION data about the session
 *
 * $_GLOBALS array for global variables
 */

// Form Processing

// isset() (DON'T use on whole array!)
// !empty()
// count() -- returns length of the array
if (isset ( $_POST["contact-submit"] ))
{
  // foreach : designed for maps!
  foreach ( $_POST as $key => $value )
  {
    $message .= $key . " : " . $value . "<br/>";
  }
  
  if (mail ( "axa9070@rit.edu", "PHP 101 EMAIL", $message ))
  {
    $feedback = "Form was successfully submitted.";
  } else
  {
    $feedback = "There was an error submitting the form.";
  }
  
  // $message could be an array above!
  // ( $message[] .= ... )
  // but then it won't work in mail above.
  print_r ( $message );
  
  // echo "<pre>";
  // print_r( $_POST );
  // echo "</pre>";
}

/* Print an array! Shouldn't use in prod. */
// echo "<pre>";
// print_r( $_SERVER );
// print_r( $_SERVER[PHP_SELF] );
// echo "</pre>";

// phpinfo();
// phpinfo ( INFO_ALL );

/*
 * include: throws a warning if it can't find file
 * include_once: only includes the file once
 * require: throws a warning if it can't find file AND will NOT continue page execution
 * require_once:
 */
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8' />
<title>PHP 101</title>
</head>
<body>
    <?= $feedback?>
    <!-- Current page is the default action -->
  <form method="post">
    <label for="contact-name">Name:</label> <input id="contact-name"
      name="contact-name" type="text"
    /><br /> <label for="contact-email">Email:</label> <input id="contact-email"
      name="contact-email" type="email"
    /><br /> <label for="contact-comments">Comments:</label>
    <!-- \<\?= \?\> is SHORT TAG! The equals sign is echo -->
    <textarea id="contact-comments" name="contact-comments" cols=40 rows=10><?= $_POST["contact-comments"] ?></textarea>
    <br /> <input type="submit" name="contact-submit" />
  </form>
</body>

</html>
