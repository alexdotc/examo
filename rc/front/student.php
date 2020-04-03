<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="student.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Page</title>
</head>
<body>
        <div id="nav">
	<ul id="navlist">
            <li class="NavItems"><a class="NavLinks" href='#home'>Home</a></li>
            <li class="NavItems"><a class="NavLinks" href='#exam'>Take Exams</a></li>
	    <li class="NavItems"><a class="NavLinks" href='#review'>Review Exams</a></li>
	    <li class="NavLogout"><a class="NavLinks" href='logout.php'>LOGOUT</a></li>
	</ul>
	</div>
	<div id="main">
        </div>
<script src="student.js"></script>
<div id="subscript">
</div>
</body>
</html>
