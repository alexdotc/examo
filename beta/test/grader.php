<?php

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors', 1);

	$URL = 'https://web.njit.edu/~yav3/backEndCS490Betha.php';
	$TEST_FILE = "test.py";

	$INFINITY = 10; // don't allow buffer overflow DoS attack on AFS.....

	$ARGS_START_DELIMITER = "(";
	$ARGS_END_DELIMITER = ")";
	$CASE_DELIMITER = "?";
	$RETURN_DELIMITER = ":";

	$data = $_POST['data'];

	$ucid = $data['ucid'];
	$examName = $data['exaName'];
	$questionIDs = $data['questionsid'];
	$answers = $data['answers'];
	$maxScores = $data['points'];

	$data = array('questionsid' => $questionIDs);
	$request = 'retrieve';

	$params = http_build_query(array('RequestType' => $request, 'data' => $data));

	$result = json_decode(do_curl($params, $URL), true);

	for($i = 0; $i < count($questionIDs); ++$i){

		$topic = $result[$i]['topic'];
		$question = $result[$i]['questText'];
		$testcaseStr = $result[$i]['questTest'];
		$answer = $answers[$i];

		$functionName = substr($testcaseStr, 0, strpos($testcaseStr, $ARGS_START_DELIMITER));
		$testcases = array();
		$testInputs = array();
		$expectedReturns = array();

		$fq = 0;
		$j = 0;

		while($j++ < $INFINITY){
			$nfq = strpos($testcaseStr, $CASE_DELIMITER, $fq);

			if ($nfq === false){ // last test case
				$testcases[] = substr($testcaseStr, $fq);
				break;
			}

			$testcases[] = substr($testcaseStr, $fq, $nfq - $fq);
			$fq = $nfq + 1;
		}

		foreach($testcases as $testcase){
			$expectedReturns[] = substr($testcase, strpos($testcase, $RETURN_DELIMITER) + 1);
			$testInputs[] = substr($testcase, strpos($testcase, $ARGS_START_DELIMITER), strpos($testcase, $ARGS_END_DELIMITER) - strpos($testcase, $ARGS_START_DELIMITER) + 1);
		}

		file_put_contents($TEST_FILE, $answer);

		foreach($testInputs as $inp)
			file_put_contents($TEST_FILE, "\nprint($functionName$inp)", FILE_APPEND);

		$python_stdout = array();

		exec("python test.py", $python_stdout, $exec_return_code);

		foreach($python_stdout as $returned)
			echo $returned . "\n";

	}

	function do_curl($params, $url){
		$handle = curl_init();
		
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $params);

		$result = curl_exec($handle);
		curl_close($handle);
		return $result;
	}

?>
