<?php

$backurl = 'https://web.njit.edu/~yav3/backEndCS490Betha.php';

$requestID = $_POST['RequestType'];
$data = $_POST['data'];

if ($requestID == 'login'){

        $post = http_build_query(array('RequestType' => $requestID, 'data' =>
        $data));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);
        echo $result; //Echos login return from back to front
        curl_close($ch);

}

elseif ($requestID == 'CreateQuestion'){
//Creates the question then sends data to back to store in database
        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif ($requestID == 'GetQuestions'){//Send the request data forward for the
//back to retreive the question data from the database to then send to front
//Data will be holding the request type for back to determine which to send
        $datas = http_build_query(array('RequestType' => $requestID, 'data' => $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif ($requestID == 'createExam'){
//Data will be holding the exam created to save in database
        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif ($requestID == 'listExams'){
//Data will be sending the list of exams created to the front
        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif($requestID == 'showExam'){
//Data will be sending the exam chosen to the front to display
        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif($requestID == 'submitExam'){ //Perform auto-grader here!

        $INFINITY = 10;
        $ARGS_START_DELIMITER = "(";
        $ARGS_END_DELIMITER = ")";
        $CASE_DELIMITER = "?";
        $RETURN_DELIMITER = ":";

        $testFile = "test.py";

        $ucid = $data['ucid'];
        $examName = $data['exaName'];
        $questionIDs = $data['questionsid'];
        $answers = $data['answers'];
        $maxScores = $data['points'];

        $tData = array('questionsid' => $questionIDs);
        $requesting = 'retrieve';

        $datas = http_build_query(array('RequestType' => $requesting, 'data' => $tData));
        $chr = curl_init();

        curl_setopt($chr, CURLOPT_URL, $backurl);
        curl_setopt($chr, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($chr, CURLOPT_POSTFIELDS, $datas);

        $resultEn = curl_exec($chr);
        //echo "$result";
        curl_close($chr);

        $result = json_decode($resultEn, true);

        $scores[] = array();
        $testcasesAnswered[] = array();
        $correctNames[] = array();
        $deductedPointsPerTest[] = array();

        for($i = 0; $i < count($questionIDs); ++$i){

                //Deducted for both testcases
                $deductedPoints[] = array();

                $topic = $result[$i]['topic'];
                $question = $result[$i]['questText'];
                $testcases = $result[$i]['questTest'];
                $answer = $answers[$i];
                //One max score for each question for total points compared to
                //total missed
                $fname = substr($testcases, 0, strpos($testcases,
                $ARGS_START_DELIMITER));

                $curTestcase = array();
                $inputs = array();
                $expectedReturns = array();

                $fq = 0;
                $j = 0;

                $maxScore = $maxScores[$i];
                //Two scores for two testcases
                $score1 = 0;
                $score2 = 0;
                $deducted1 = $maxScore/4;
                $deducted2 = $maxScore/4;
                $correctNameScore = 0;
                //Puts coded answer into the file to be executed
                while($j++ < $INFINITY){
                        $nfq = strpos($testcases, $CASE_DELIMITER, $fq);

                        if($nfq === false){
                                $curTestcase[] = substr($testcases, $fq);
                                break;
                        }
                        $curTestcase[] = substr($testcases, $fq, $nfq - $fq);
                        $fq = $nfq + 1;
                }

                foreach($curTestcase as $k){
                        $expectedReturns[] = substr($k, strpos($k,
                        $RETURN_DELIMITER) + 1);
                        $inputs[] = substr($testcase, strpos($testcase,
                        $ARGS_START_DELIMITER), strpos($testcase,
                        $ARGS_END_DELIMITER) - strpos($testcase,
                        $ARGS_START_DELIMITER) + 1);
                }

                file_put_contents($testFile, $answer);

                foreach($inputs as $l)
                        file_put_contents($testFile, "\nprint($functionName$l)", FILE_APPEND);

                $returnSet = array();

                exec("python test.py", $returnSet, $exec_return_code);

                //Executes the code to get an answer, if its not complete or
                //does not match expected answers then it won't work

                //If answers != testcase, no points, if second testcase, then
                //points per testcase by total of testcases
                foreach($returnSet as $returned){
                        if($returned === $curTestcase[0]){
                                $score1 = $maxScore/4;
                                $deducted1 = 0;
                        }
                        elseif($returned === $curTestcase[1]){
                                $score2 = $maxScore/4;
                                $deducted2 = 0;
                        }
                }

                if(strpos($answer, $fname) !== false){
                        $correctNameScore = $maxScore/2;
                }

                $score = array('score1' => $score1, 'score2' => $score2);

                $resultCheck = array('resultCheck1' => $resultCheck1,
                'resultCheck2' => $resultCheck2);

                $deducted = array('test1Deducted' => $deducted1,
                'test2Deducted' => $deducted2);

                //array_push($deductedPoints, $deducted1, $deducted2);
                array_push($scores, $score);
                array_push($testCasesAnswered, $resultCheck);
                array_push($correctNames, $correctNameScore);
                array_push($deductedPointsPerTest, $deducted);

        }

//Comments are nothing since the autograder doesn't input comments nor gets
//when student completes exam, so they are empty
        $tData[] = array('comments' => '', 'ucid' => $ucid, 'exaName' =>
        $examName, 'questionsid' => $questionIDs, 'answers' => $answers,
        'maxScores' => $maxScores, 'expectedAnswers' => $testcases,
        'resultingAnswers' => $testCasesAnswered, 'deductedPointscorrectName'
        => $correctNames, 'deductedPointsPerEachTest' =>
        $deductedPointsPerTest, 'scores' => $scores);

        $request = 'gradingExam';

        $datas = http_build_query(array('RequestType' => $request, 'data' =>
        $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $resulting = curl_exec($ch);
        echo "This completes";
        echo $resulting;
        curl_close($ch);

}

elseif($requestID == 'showGradedExam'){
        $datas = http_build_query(array('RequestType' => $requestID, 'data' => $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif($requestID == 'modifyGradedExam'){
        $datas = http_build_query(array('RequestType' => $requestID, 'data' => $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif($requestID == 'listGradedExams'){

        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

elseif($requestID == 'listGradedExamsStudent'){
        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

?>
