<?php

	define('MAGICNUMBER', true);
	include 'restrict.php';

        $URL = 'https://web.njit.edu/~np595/CS490Work/middleCS490Beta.php';

	$reqtype = $_POST['RequestType'];

	$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => ''));

	switch($reqtype){
		case 'CreateQuestion':
			$topic = $_POST['topic'];
			$difficulty = $_POST['difficulty'];
			$questiontext = $_POST['questiontext'];
			$testcases = $_POST['testcases'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('topic' => $topic, 'difficulty' => $difficulty, 'questiontext' => $questiontext, 'testcases' => $testcases)));
			break;

		case 'createExam':
			$name = $_POST['examname'];
			$ids = $_POST['ids'];
			$points = $_POST['points'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name, 'questionsid' => explode(",",$ids), 'questPoint' => explode(",",$points))));
			break;

		case 'showExam':
			$name = $_POST['examname'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name)));
			break;

		case 'submitExam':
			$name = $_POST['examname'];
			$ids = $_POST['ids'];
			$points = $_POST['points'];
			$answers = $_POST['answers'];
			$user = $_SESSION['user'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name, 'ucid' => $user, 'questionsid' => explode(",",$ids), 'answers' => explode("HACKMAGICK",$answers), 'points' => explode(",",$points))));
			break;

		case 'showGradedExam':
			$name = $_POST['examname'];
			if ($_SESSION['teacher'])
				$user = $_POST['user'];
			else if ($_SESSION['student'])
				$user = $_SESSION['user'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name, 'ucid' => $user)));
			break;
		
		case 'modifyGradedExam':
			$name = $_POST['examname'];
			$user = $_POST['user'];
			$released = $_POST['released'];
			$ids = $_POST['ids'];
			$scores = $_POST['scores'];
			$comments = $_POST['comments'];
			$nameDs = $_POST['nameDs'];
			$tcDs = $_POST['tcDs'];
			$shittytcDs = explode(",",$tcDs);
			$shittytcDs = str_replace("...", ", ", $shittytcDs);
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name, 'ucid' => $user, 'gradesID' => explode(",",$ids), 'scores' => explode(",",$scores), 'comments' => explode(",",$comments), 'released' => $released, 'deductedPointscorrectName' => explode(",",$nameDs), 'deductedPointsPerEachTest' => $shittytcDs)));
			break;

		case 'listGradedExamsStudent':
			$user = $_SESSION['user'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('ucid' => $user)));
			break;

		case 'listExams':
			$user = $_SESSION['user'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('ucid' => $user)));
			break;

		default:
			//GetQuestions
			//listGradedExams
			break;
	}

	$resp = handoff($post_params, $URL);
	echo $resp;

	function handoff($post_params, $URL){
		$ch = curl_init();
		$options = array(CURLOPT_URL => $URL,
			         CURLOPT_HTTPHEADER =>
				 array('Content-type:application/x-www-form-urlencoded'),
				 CURLOPT_RETURNTRANSFER => TRUE,
				 CURLOPT_POST => TRUE,
				 CURLOPT_POSTFIELDS => $post_params);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
?>
