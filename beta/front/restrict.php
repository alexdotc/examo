<?php

	$LOGIN_PATH     = '../front/login.php';
	$STUDENT_PATH   = '../front/student.php';
	$TEACHER_PATH   = '../front/teacher.php';

	$STUDENT_PAGES = array('student.php', 'studentExam.php', 'studentTake.php', 'studentReview.php', 'studentView.php', 'studentHome.php');

	$TEACHER_PAGES = array('teacher.php', 'teacherExam.php', 'teacherCompleted.php', 'teacherGrade.php', 'teacherQuestion.php', 'teacherHome.php');

	if (!defined('MAGICNUMBER')){
		header("Location:" . $LOGIN_PATH);
		die("No direct access.");
	}

	session_start();
	
	if (!$_SESSION['logon']){
		header("Location:" . $LOGIN_PATH);
		die("Restricted");
	}
	else if((in_array(basename($_SERVER['SCRIPT_FILENAME']), $TEACHER_PAGES)) && !$_SESSION['teacher']){
		header("Location:" . $STUDENT_PATH);
		die("Restricted");
	}
	else if((in_array(basename($_SERVER['SCRIPT_FILENAME']), $STUDENT_PAGES)) && !$_SESSION['student']){
		header("Location:" . $TEACHER_PATH);
		die("Restricted");
	}
?>
