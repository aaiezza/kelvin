<?php 
	if (!isset($_GET['question']) || !isset($_GET['cat']) || !isset($_GET['choice']) ||
	    strlen($_GET['question']) < 1 || strlen($_GET['cat']) < 1 || strlen($_GET['question']) < 1)
	{
		header("Location: choose_a_poll.php");
		exit;
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Poll Results</title>
</head>
<body>
<h1>Results!</h1>
<h2>You chose the <?php echo $_GET['cat']; ?> category!</h2>
<h2>The question was: <em><?php echo $_GET['question']; ?></em></h2>
<h2>Your answer was: &ldquo;<em><?php echo $_GET['choice']; ?></em>&rdquo;</h2>
<p><a href="choose_a_poll.php">Take another poll?</a></p>

</body>
</html>