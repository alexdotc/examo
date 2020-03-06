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

        $testFile = "test.py";

        $ucid = $data['ucid'];
        $examName = $data['exaName'];
        $questionIDs = $data['questionsid'];
        $answers = $data['answers'];
        $maxScores = $data['maxScore'];

        $tData[] = array('questionsid' => $questionIDs);
        $requesting = 'retrieve';

        $datas = http_build_query(array('RequestType' => $requesting, 'data' => $tData));
        $chr = curl_init();

        curl_setopt($chr, CURLOPT_URL, $backurl);
        curl_setopt($chr, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($chr, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($chr);
        curl_close($chr);

        $topic = $result['topic'];
        $question = $result['questText'];
        $testcases = $result['questTest'];

        $scores[] = array();
        $testCasesAnswered[] = array();
        $correctNames[] = array();
        $deductedPointsPerTest[] = array();

        for($i = 0; $i < $questionIDs; $i++){

                $expectedAnswer = $testcases[$i];
                //$expectedAnswer1 = $testcases[$i][0];
                //$expectedAnswer2 = $testcases[$i][1];
                $deductedPoints[] = array();
                //$deducted1 = 0;
                //$deducted2 = 0;
                $deducted = 0;
                $answer = $answers[$i];
                //One max score for each question for total points compared to
                //total missed
                $maxScore = $maxScores[$i];
                $score = $maxScore/2;
                $correctNameScore = 0;
                //Puts coded answer into the file to be executed
                file_put_contents($testFile, $answer);

                $resultCheck = exec("./$testFile");
                //Executes the code to get an answer, if its not complete or
                //does not match expected answers then it won't work

                //If answers != testcase, no points, if second testcase, then
                //points per testcase by total of testcases
                if($resultCheck != $expectedAnswer){
                        $score = 0;
                        $deducted = $maxScore/2;
                }
                //Adds to number of testcases answered to send to back

                $fh = fopen($testFile, 'r') or die($php_errormsg);
                while(! feof($fh)){
                        if($s = fgets($fh, 1048576)){
                                $words = preg_split('/\s+/',$s,-1,PREG_SPLIT_NO_EMPTY);
                                $fileSize = sizeof($words);
                                for($i = 0; $i < $fileSize; $i++){
                                        if($words[$i] != "def"){
                                                continue;
                                        }
                                        else{
        //If name is there, then give them points for having correct name
                                                $correctNameScore = $maxScore/2;
                                        }
                                }
                        }
                }

                //array_push($deductedPoints, $deducted1, $deducted2);
                array_push($deductedPoints, $deducted);
                array_push($scores, $score);
                array_push($testCasesAnswered, $resultCheck);
                array_push($correctNames, $correctNameScore);
                array_push($deductedPointsPerTest, $deductedPoints);

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
