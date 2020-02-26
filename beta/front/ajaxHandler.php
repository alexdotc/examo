<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';

        $URL = 'https://web.njit.edu/~np595/CS490Work/middleAlt.php';

	$reqtype = $_POST['RequestType'];

	$post_params = "RequestType=$reqtype";

	switch($reqtype){
		case 'CreateQuestion':
			$topic = $_POST['topic'];
			$difficulty = $_POST['difficulty'];
			$questiontext = $_POST['questiontext'];
			$testcase1 = $_POST['testcase1'];
			$testcase2 = $_POST['testcase2'];
			$post_params = $post_params . "&data%5Btopic%5D=$topic&data%5Bdifficulty%5D=$difficulty&data%5Bquestiontext%5D=$questiontext&data%5Btestcases%5D=$testcase1$testcase2";
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
