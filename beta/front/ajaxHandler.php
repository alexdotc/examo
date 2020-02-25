<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';

        $URL = 'https://web.njit.edu/~np595/CS490Work/middleAlt.php';

	$reqtype = $_POST['RequestType'];

	$post_params = "RequestType=$reqtype";

	switch($reqtype){
		case 'CreateQuestion':
			$topic = $_POST['Topic'];
			$difficulty = $_POST['Difficulty'];
			$questiontext = $_POST['QuestionText'];
                        $testcases = $_POST['TestCases'];
			$post_params = $post_params . "&Topic=$topic&Difficulty=$difficulty&QuestionText=$questiontext&TestCases=$testcases";
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
