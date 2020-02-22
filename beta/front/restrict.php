<?php

	$LOGIN_PATH     = '../front/login.php';
	$STUDENT_PATH   = '../front/student.php';
	$TEACHER_PATH   = '../front/teacher.php';

	$TEACHER_PAGES = array('teacher.php', 'teacherExam.php', 'teacherQuestion.php',
		               'teacherHome.php');

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
	else if((in_array(basename($_SERVER['SCRIPT_FILENAME']), $TEACHER_PAGES)) && !$_SESSION['teacher']){
		header("Location:" . $STUDENT_PATH);
		die();
	}
	else if((basename($_SERVER['SCRIPT_FILENAME']) == 'student.php') && !$_SESSION['student']){
		header("Location:" . $TEACHER_PATH);
		die();
	}
?>
