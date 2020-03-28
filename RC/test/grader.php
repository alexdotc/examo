<?php

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors', 1);

	$URL = 'https://web.njit.edu/~yav3/backEndCS490Betha.php';
	$TEST_FILE = "test.py";

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

	$rdata = array('questionsid' => $questionIDs);

	$params = http_build_query(array('RequestType' => 'retrieve', 'data' => $rdata));

	$result = json_decode(do_curl($params, $URL), true);

	$deductions_tc = array();
	$deductions_name = array();
	//$deductions_no_run = array();

	$scores = array();
	$comments = array();
	$expecteds = array();
	$resulting = array();

	for($i = 0; $i < count($questionIDs); ++$i){

		$topic = $result[$i]['topic'];
		$question = $result[$i]['questText'];
		$testcaseStr = $result[$i]['questTest'];
		$answer = $answers[$i];

		$studentFunctionName = get_student_fname($answer);

		$functionName = substr($testcaseStr, 0, strpos($testcaseStr, $ARGS_START_DELIMITER));
		$testcases = explode($CASE_DELIMITER, $testcaseStr);
		$testInputs = array();
		$expectedReturns = array();

		$NAME_DEDUCTION = 5; // should this be scaled?
		$NO_RUN_DEDUCTION = 0;
		$TC_DEDUCTION = (int)(($maxScores[$i] - $NO_RUN_DEDUCTION - $NAME_DEDUCTION)/count($testcases));

		//adjust for all deductions to add to the max score
		$NO_RUN_DEDUCTION += $maxScores[$i] - $NO_RUN_DEDUCTION - $NAME_DEDUCTION - $TC_DEDUCTION * count($testcases);
		$deducted_each = array();

		foreach($testcases as $testcase){
			$expectedReturns[] = substr($testcase, strpos($testcase, $RETURN_DELIMITER) + 1);
			$testInputs[] = substr($testcase, strpos($testcase, $ARGS_START_DELIMITER), strpos($testcase, $ARGS_END_DELIMITER) - strpos($testcase, $ARGS_START_DELIMITER) + 1);
		}

		file_put_contents($TEST_FILE, $answer);

		foreach($testInputs as $inp)
			file_put_contents($TEST_FILE, "\nprint($studentFunctionName$inp)", FILE_APPEND);

		$python_stdout = array();

		exec("python test.py", $python_stdout, $exec_return_code);

		if (count($python_stdout) == count($expectedReturns)){
			for($j = 0; $j < count($expectedReturns); ++$j)
				$python_stdout[$j] != $expectedReturns[$j] ? $deducted_each[$j] = $TC_DEDUCTION : $deducted_each[$j] = 0;
			$deductions_no_run[$i] = 0;
		}

		else if($exec_return_code){
			for($j = 0; $j < count($expectedReturns); ++$j){
				if(!isset($python_stdout[$j]))
					$python_stdout[$j] = "(Python crashed!)";
				$python_stdout[$j] != $expectedReturns[$j] ? $deducted_each[$j] = $TC_DEDUCTION : $deducted_each[$j] = 0;
			}
			$deductions_no_run[$i] = $NO_RUN_DEDUCTION;
		}

		$deductions_tc[$i] = $deducted_each;
		check_name($functionName, $answer) ? $deductions_name[$i] = 0 : $deductions_name[$i] = $NAME_DEDUCTION;

		$exec_return_code ? $deductions_no_run[$i] = $NO_RUN_DEDUCTION : $deductions_no_run[$i] = 0;
		$scores[$i] = $maxScores[$i] - $deductions_name[$i];
		foreach($deducted_each as $tcd)
			$scores[$i] -= $tcd;

		$comments[$i] = "";
		$expecteds[$i] = $expectedReturns;
		$resulting[$i] = $python_stdout;

	}


	//yuck, why are we using arrays of strings instead of just arrays of arrays when each piece is a discrete value that will need to be modified?

	str_flatten("HACKMAGICK", $expecteds);
	str_flatten("HACKMAGICK", $resulting);
	str_flatten(", ", $deductions_tc);

	$params = http_build_query(array('RequestType' => 'gradingExam', 'data' => array('ucid' => $ucid, 'exaName' => $examName, 'questionsid' => $questionIDs, 'answers' => $answers, 'scores' => $scores, 'maxScores' => $maxScores, 'comments' => $comments, 'expectedAnswers' => $expecteds, 'resultingAnswers' => $resulting, 'deductedPointsPerEachTest' => $deductions_tc, 'deductedPointscorrectName' => $deductions_name)));

	$result = do_curl($params, $URL);
	echo $result;

	function do_curl($params, $url){
		$handle = curl_init();
		
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $params);

		$result = curl_exec($handle);
		curl_close($handle);
		return $result;
	}

	function check_name($fname, $answer){
		$a = strtok($answer, "\n");
		while(ctype_space($a))
			$a = strtok("\n");
		$r = preg_match('/def[ \t]+' . $fname . '[ \t]*\(.+/', $a);
		return $r;
	}

	function get_student_fname($answer){
		$m = array();
		$a = strtok($answer, "\n");
		while(ctype_space($a))
			$a = strtok("\n");
		$r = preg_match('/def[ \t]+([a-zA-z0-9_]+)/', $a, $m);
		return $m[1];
	}
		

        function str_flatten($delim, &$arr){
		foreach($arr as &$a)
			$a = implode($delim, $a);
	}
?>
