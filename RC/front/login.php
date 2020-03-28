<?php
	define('MAGICNUMBER', true);
	include 'unlock.php';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="login.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>
</head>
<body>
	<div id="LoginBox">
		<h2 class="LoginHeader">CS490 Beta Login -- Group 4</h2>
		<div id="LoginForm">
		<form id="Login">
			<label for="UCID" class="LoginLabel LoginItems">UCID: </label>
			<input type="text" name="UCID" id="ucid" class="LoginBox LoginItems"/>
			<label for="Password" class="LoginLabel LoginItems">Password: </label>
			<input type="password" name="Password" id="pass" class="LoginBox LoginItems"/>
			<br/>
			<input type="submit" value="LOGIN" class="LoginSubmit LoginItems"/>
		</form>
		</div>
                <h2 id="response" class="LoginResponse"></h2>
	</div>
<script src="login.js"></script>
</body>
</html>
