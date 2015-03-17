<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>dbPut</title>
</head>
<body>
	<h2>Input to the Database</h2>

	<form method="GET" action="dbput.php">
		<input type="text" name="firstname">First Name<br>
		<input type="text" name="lastname">Last Name<br>
		<input type="text" name="age">How old?<br>
		<input type="text" name="phonenumber">Phone Number<br>
		<input type="text" name="type">type<br>
		<input type="submit" value="Add Record">
	</form>

	<hr>

	<h2>Output from the Database</h2>
	<?php
		include '/home/axa9070/etc/db_conn.php';
		$table = 'phonebook';

		//hook up to my db
		$dbLink=mysql_connect($hostname, $username, $password)
			or die("couldn't connect: ".mysql_error());
		mysql_select_db($database);
		
		//stop sql injection for $_GET
		foreach($_GET as $key => $val){
			$_GET[$key]=mysql_real_escape_string($val);
		}
		
		//stop sql injection for $_POST
		foreach($_POST as $key => $val){
			$_POST[$key]=mysql_real_escape_string($val);
		}
		
		//user entered data... (has been sanitized)
		if(	isset($_GET['firstname']) &&
			isset($_GET['lastname']) && 
			isset($_GET['age']) && 
			isset($_GET['phonenumber']) && 
			isset($_GET['type']) && 

			$_GET['firstname'] != '' && 
			$_GET['lastname'] != '' && 
			$_GET['age'] != '' && 
			$_GET['phonenumber'] != '' && 
			$_GET['type'] != '' && 
			
			is_numeric($_GET['age'])) {

				//build the query and stick it in the db
				$query = "insert into $table values ('',
					'" . $_GET['firstname'] . "',
					'" . $_GET['lastname'] . "',
					"  . $_GET['age'] . ",
					'" . $_GET['phonenumber'] . "',
					'" . $_GET['type'] . "')";
			
				mysql_query($query);

				echo '<p>data entered!</p>';

		} else {

			echo '<p style="color:red">You entered no or bad data</p>';

		}
?>


</body>
</html>