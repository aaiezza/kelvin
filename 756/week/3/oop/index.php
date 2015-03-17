<?php
  // require_once "Validator.class.php";
  
  function __autoload( $class_name )
  {
    require_once "$class_name.class.php";
  }
?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Class Fun!</title>
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
          echo '<h2>Static class methods</h2>';

          // Call the static class methods
          $number1 = 'one';
          $number2 = 23456;
          // :: is the scope resolution operator in PHP
          $yes_no  = Validator::numeric( $number1 ) ? 'is' : 'is NOT';
          echo "<p>$number1 $yes_no a number</p>";
          $yes_no  = Validator::numeric( $number2 ) ? 'is' : 'is NOT';
          echo "<p>$number2 $yes_no a number</p>";
          
          
          // Call instance class methods
          echo '<h2>Instance class methods</h2>';
          $person1 = new Person( 'Smith', 'John' );
          $person2 = new Person();
          $person3 = new Person( 'Jones' );
          
          echo '<p>Person 1: ' . $person1->sayHello() . '</p>';
          echo '<p>Person 2: ' . $person2->sayHello() . '</p>';
          echo '<p>Person 3: ' . $person3->sayHello() . '</p>';
          
          echo '<p>Person 3 last name: ' . $person3->getLastName() . '</p>';
          
        ?>
    </div>
</body>

</html>