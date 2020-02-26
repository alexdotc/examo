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
		default:
                        //GetQuestions
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
