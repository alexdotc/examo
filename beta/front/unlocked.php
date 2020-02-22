<?php
	session_start();

	$LOGIN_PATH = '../front/login.php';
	$STUDENT_PATH = '../front/student.php';
	$TEACHER_PATH = '../front/teacher.php';

        if(session_id() and $_SESSION['logon']){
		if($_SESSION['student'])
	                header("Location:" . $STUDENT_PATH);
                else if($_SESSION['teacher'])
			header("Location:" . $TEACHER_PATH);
                die();
        }
?>
