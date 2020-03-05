<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';

        $URL = 'https://web.njit.edu/~yav3/backEndCS490Betha.php';

	$reqtype = $_POST['RequestType'];

	$post_params = http_build_query(array('RequestType' => $reqtype, data => ''));

	switch($reqtype){
		case 'CreateQuestion':
			$topic = $_POST['topic'];
			$difficulty = $_POST['difficulty'];
			$questiontext = $_POST['questiontext'];
			$testcases = $_POST['testcase1'] . $_POST['testcase2'];
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
			$answers = $_POST['answers'];
			$user = $_SESSION['user'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name, 'user' => $user, 'questionsid' => explode(",",$ids), 'answers' => explode(",",$answers))));
			break;

		case 'showGradedExam':
			$name = $_POST['examname'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name)));
			break;
		
		case 'modifyGradedExam':
			$name = $_POST['examname'];
			$user = $_POST['user'];
			$released = $_POST['released'];
			$ids = $_POST['ids'];
			$scores = $_POST['scores'];
			$comments = $_POST['comments'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('exaName' => $name, 'ucid' => $user, 'gradesID' => explode(",",$ids), 'scores' => explode(",",$scores), 'comments' => explode(",",$comments), 'released' => $released)));
			break;

		case 'listGradedExamsStudent':
			$user = $_SESSION['user'];
			$post_params = http_build_query(array('RequestType' => $reqtype, 'data' => array('ucid' => $user)));
			break;

		default:
			//listExams
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
