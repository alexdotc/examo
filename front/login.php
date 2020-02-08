<!DOCTYPE html>
<!-- login.php name for future possible php in this -->
<html>
<head>
	<link rel="stylesheet" type="text/css" href="login.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>
</head>
<body>
	<div id="LoginForm">
		<h2 class="LoginHeader">CS490 Alpha Login -- Group 4</h2>
		<form id="Login">
			<label for="UCID" class="LoginLabel LoginItems">UCID: </label>
			<input type="text" name="UCID" id="ucid" class="LoginBox LoginItems"/>
			<label for="Password" class="LoginLabel LoginItems">Password: </label>
			<input type="password" name="Password" id="pass" class="LoginBox LoginItems"/>
			<br/>
			<input type="submit" value="LOGIN" class="LoginSubmit LoginItems"/>
		</form>
	</div>
	<div id="response">
	</div>
<script src="login.js"></script>
</body>
</html>
