<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="teacher.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Page</title>
</head>
<body>
        <div id="nav">
	<ul id="navlist">
            <li class="NavItems"><a class="NavLinks" href='#home'>Home</a></li>
            <li class="NavItems"><a class="NavLinks" href='#question'>Create Question</a></li>
	    <li class="NavItems"><a class="NavLinks" href='#exam'>Create Exam</a></li>
            <li class="NavItems"><a class="NavLinks" href='#completed'>Grade Exams</a></li>
            <li class="NavLogout"><a class="NavLinks" href='logout.php'>LOGOUT</a></li>
	</ul>
	</div>
	<div id="main">
        </div>
<script src="teacher.js"></script>
<div id="subscript">
</div>
</body>
</html>
