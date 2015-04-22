<?php
?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Beer Client | WSDL</title>
<meta name="description" content="basic">
<meta name="author" content="Alex Aiezza">

<link type="text/css" rel="stylesheet" href="css/style.css">

<link rel="icon" type="image/ico" href="images/favicon.ico">

</head>

<body>
	<div id="content">
		<p>
			The code for the Beer Client which accesses the WSDL Beer WebService
			on
			<code>http://simon.ist.rit.edu</code>
			can be found in this directory on the server.
		</p>
		<p>In order to use the client, there are a few options since it is
			written in Java. (Unforunately, one of those options is not a JApplet
			because with the latest Java updates those are a pain to create.)</p>
		<hr>
		<p>The first option is to run an X11 server locally.
		
		
		<ul>
			<li>Linux - you're good to go</li>
			<li>Mac - <a href="https://xquartz.macosforge.org/trac">XQuartz</a></li>
			<li>Windows - <a href="http://www.straightrunning.com/XmingNotes/">XMing</a></li>
		</ul>
		</p>
		<p>After installing and running an X11 server, from a terminal you can
			run the following command to run the JFrame Beer Client:</p>
		<p>
			<tt>java -cp
				/home/axa9070/Sites/756/homework/05/beer-service.jar:/home/axa9070/Sites/756/homework/05/build/classes
				BeerClient</tt>
		</p>
		<hr>
		<p>
			The second option would be to download the beer-service.jar file
			located here:
			<a href="./beer-service.jar"><code>/home/axa9070/Sites/756/homework/05/beer-service.jar</code></a>
			and then download all of the class files found in here:
			<code>/home/axa9070/Sites/756/homework/05/build/classes</code>
			. Then, on your local machine, open a terminal and run:
		</p>
		<p>
			<tt>java -cp {PATH_TO/beer-service.jar}(:|;){PATH_TO/build/classes}
				BeerClient</tt>
		</p>
		<p>replacing the PATH_TO with the paths to those files you just
			downloaded and separting those paths by selecting either a colon(:)
			for a UNIX based OS or the semi-colon(;) for a Windows OS.
		</p>
		<hr>
		<p>
		    A screenshot of the client:
		    <img src="images/screenshot.png">
		</p>
	</div>
</body>

</html>