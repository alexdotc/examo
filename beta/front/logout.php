<?php
	$LOGIN_PATH = '../front/login.php';

	session_start();
	session_destroy();

	unset($_SESSION['teacher']);
	unset($_SESSION['student']);
	unset($_SESSION['logon']);

	header("Location:" . $LOGIN_PATH);
?>
