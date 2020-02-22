<?php

	$LOGIN_PATH     = '../front/login.php';
	$STUDENT_PATH   = '../front/student.php';
	$TEACHER_PATH   = '../front/teacher.php';

	if (!defined('MAGICNUMBER')){
		header("Location:" . $LOGIN_PATH);
		die("No direct access.");
	}

	if (!session_id())
		session_start();
	
	if (!$_SESSION['logon']){
		header("Location:" . $LOGIN_PATH);
		die();
	}
	else if((basename($_SERVER['SCRIPT_FILENAME']) == 'teacher.php') && !$_SESSION['teacher']){
		header("Location:" . $STUDENT_PATH);
		die();
	}
	else if((basename($_SERVER['SCRIPT_FILENAME']) == 'student.php') && !$_SESSION['student']){
		header("Location:" . $TEACHER_PATH);
		die();
	}
?>
