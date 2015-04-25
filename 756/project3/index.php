<?php
?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Beer Service | WSDL</title>
<meta name="description" content="basic">
<meta name="author" content="Alex Aiezza">

<link type="text/css" rel="stylesheet" href="css/style.css">

<link rel="icon" type="image/ico" href="images/favicon.ico">

</head>

<body>
	<div id="content">
		<p>The code for the Beer Service can be found in this directory on the
			server.</p>
		<p>
			The Java docs for this project can be found <a href="doc">here</a>.
		</p>
		<p>
			To see the progress made on this project you can visit <a
				href="https://github.com/aaiezza/kelvin/commits/master?path=756/project3">github
				here</a> or for the project files themselves, <a
				href="https://github.com/aaiezza/kelvin/tree/master/756/project3">here</a>.
		</p>
		<hr>
		<div class="optional">
			<p>
				When deploying in GlassFish, use the admin console at port 4848 by
				default. Before uploading the WAR file (which can be downloaded <a
					href="https://github.com/aaiezza/kelvin/raw/master/756/project3/srv/beer-service.war">here</a>),
				it would be in your interest to add an argument necessary for the
				log4j logging to work so you can see helpful server output in
				GlassFish's
				<code>server.log</code>
				file.
			</p>
			<p>
				To do so, visit the left pane through the admin console, and go to <span
					class="bold nowrap">Configurations > server-config > JVM Settings</span>.
				Once there, select the <span class="bold nowrap">JVM Options</span>
				tab. Under Options, click <span class="bold nowrap">Add JVM Option</span>.
				In the new Value slot that becomes available enter the following:
			</p>
			<p>
				<tt>-Dlog4j.configuration=file:${com.sun.aas.instanceRoot}/applications/beer-service/resources/log4j.xml</tt>
			</p>
			<p>Then restart the glassfish server. This step is optional, but does
				provide helpful logging giving someone good insight into the inner
				operation of the server without needing to view source code. This is
				also very helpful for debugging purposes.</p>
		</div>
		<hr>
		<p>
			The following users have been added to the database for easier
			testing. Unfortunately there is not <em>nice</em> way of adding users
			outside of manually accessing the SQLite database file and adding
			them. Of course that wasn't part of the scope of this project.
		</p>
		<p>
		
		
		<table>
			<thead>
				<tr>
					<th>Username</th>
					<th>Password</th>
					<th>Age</th>
					<th>AcessLevel</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>test</td>
					<td>testing</td>
					<td>25</td>
					<td>1</td>
					<td><p>This is the default user for testing. They are above 21 and
							have admin access so setPrice is available to this user.</p></td>
				</tr>
				<tr>
					<td>tom</td>
					<td>pass</td>
					<td>25</td>
					<td>0</td>
					<td><p>tom is above 21 so he can access most of the service but
							does not have admin access so setPrice is not available to this
							user.</p></td>
				</tr>
				<tr>
					<td>sam</td>
					<td>testing</td>
					<td>19</td>
					<td>0</td>
					<td><p>sam is under 21 so he may not even create a token for
							authentication. getMethods will be the only portion of the
							service available to her. sam does not have admin access, so in
							the event she becomes of age, setPrice would still not available
							to this user.</p></td>
				</tr>
			</tbody>
		</table>
		</p>
		<hr>
		<p>
			The client I created for accessing this service can be found <a
				href="client">here</a>. While the
			<code>beer-service.jar</code>
			file that is in this directory will point the client to a working
			WSDL if my server is running at home (Dynamic DNS), running my
			<code>BeerClient</code>
			will not work unless a user <em>re-wsimports</em> the WSDL. I'm
			assuming though that the grader will use his/her own implementation
			of a client.
		</p>
		<hr>
		<p>Enjoy!</p>
	</div>
</body>

</html>