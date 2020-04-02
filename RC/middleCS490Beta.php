<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

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

        $ARGS_START_DELIMITER = "(";
        $ARGS_END_DELIMITER = ")";
        $CASE_DELIMITER = "?";
        $RETURN_DELIMITER = ":";//"HACKMAGICK";

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

        $scores = array();
        $comments = array();
        $expecteds = array();
        $resulting = array();

        $deductTest = array();
        $deductName = array();
        $deductDef = array();
        $deductColon = array();
        $deductCons = array();
        //$deductNoRun = array();

        for($i = 0; $i < count($questionIDs); ++$i){

                //Deducted for both testcases
                $topic = $result[$i]['topic'];
                $question = $result[$i]['questText'];
                $testcasesS = $result[$i]['questTest'];
                $answer = $answers[$i];
                $constrain = $result[$i]['constrain'];
                //One max score for each question for total points compared to
                //total missed
                //echo $testcasesS;
                $functionName = substr($testcasesS, 0, strpos($testcasesS,
                $ARGS_START_DELIMITER));
                $fname = substr($answer, 0, strpos($answer, $ARGS_START_DELIMITER));
                $fname = preg_replace("/def /", "", $fname);
                $testcases = explode($CASE_DELIMITER, $testcasesS);
                $inputs = array();
                $expectedReturns = array();
                //echo $testcases[0];
                $S = $maxScores[$i];
                $testFile =
                '/afs/cad.njit.edu/u/n/p/np595/public_html/CS490Work/test.py';
                $NAMED = 5;
                $DEFD = (int)($S * 0.2);
                $COLOND = (int)(($S - $NAMED - $DEFD) * 0.2);
                $CONSD = (int)(($S - $NAMED - $DEFD - $CONSD) * 0.2);
                $TESTD = (int)(($S - $NAMED /*-
                $NORUND*/)/count($testcases));
a
                //$NORUND += $S - $NORUND - $NAMED - $TESTD * count($testcases);
                $totDed = array();
                $p = 0;
                foreach($testcases as $k){
                        $expectedReturns[$p] = substr($k, strpos($k,
                        $RETURN_DELIMITER) + 1);

                        $inputs[$p] = substr($k, strpos($k,
                        $ARGS_START_DELIMITER), strpos($k,
                        $ARGS_END_DELIMITER) - strpos($k,
                        $ARGS_START_DELIMITER) + 1);
                        $p = 1 + $p;
                }

                $tempAnswer = "";

                if(strpos($answer, "):" === false){
                        $deductColon[$i] = $COLOND;
                        //Would be the final input before )
                        $temp = $inputs[$p];
                        $finalChar = substr($temp, -1);
                        //This ensures that it is the parenthesis after the
                        //input that will add the colon
                        $tempAnswer = str_replace("$finalChar)", "$finalChar):", $answer);
                }
                else
                        $deductColon[$i] = 0;

                if(strpos($answer,"def") === false && $tempAnswer == ""){
                        $deductDef[$i] = $DEFD;
                        $tempAnswer = "def $answer";
                }
                elseif(strpos($answer,"def") === false && $tempAnswer != ""){
                        $deductDef[$i] = $DEFD;
                        $tempAnswer = "def $tempAnswer";
                }
                else{
                        $deductDef[$i] = 0;
                }

                clearstatcache();

                //Ensures their answer is the same but the necessary changes
                //are made to get an output.
                if($tempAnswer == "")
                        file_put_contents($testFile, $answer);
                else
                        file_put_contents($testFile, $tempAnswer);

                if($constrain == 'Print'){
                        //I'm checking if print is there, then if return is
                        //there since if it is there, then they will be
                        //breaking the constraint
                        if(strpos($answer, "print(") === true)
                                $deductCons[$i] = 0;
                        if(strpos($answer, "return") === true)
                                $deductCons[$i] = $CONSD;
        //If it doesn't have either, their code won't work and will lose points
        //for this
                        if(strpos($answer, "print(") === false ||
                        strpos($answer, "return") === false)
                                $deductCons[$i] = $CONSD;

                        foreach($inputs as $l)
                                file_put_contents($testFile, "\n$fname$l", FILE_APPEND);
                }
                elseif($constrain == 'For'){
//All this is doing is checking if for is there, if the rest of the code fails
//then they should lose any constrain points since they obviously did it wrong.
//we are unable to fix their code here to try to give them any further points
//on if their code works or not since that would be giving them points
                        if(strpos($answer, "for") === true)
                                $deductCons[$i] = 0;
                        if(strpos($answer, "while") === true)
                                $deductCons[$i] = $CONSD;
                        if(strpos($answer, "for") === false || strpos($answer,
                        "while") === false)
                                $deductCons[$i] = $CONSD;
                }
                elseif($constrain == 'While'){
                        if(strpos($answer, "while") === true)
                                $deductCons[$i] = 0;
                        if(strpos($answer, "for") === true)
                                $deductCons[$i] = $CONSD;
                        if(strpos($answer, "for") === false || strpos($answer,
                        "while") === false)
                                $deductCons[$i] = $CONSD;
                }
                //If no constraint then just print the answer of the function
                elseif($constrain == 'None'){
                        //Since there's no constraint, if the program works
                        // then full points, else they will lose points if
                        // there is an error.
                        $deductCons[$i] = 0;
                        foreach($inputs as $l)
                                file_put_contents($testFile, "\nprint($fname$l)", FILE_APPEND);
                }
                $returnSet = array();

                exec("python test.py", $returnSet, $exec_return_code);

                //If answers != testcase, no points, if second testcase, then
                //points per testcase by total of testcases
                if(count($returnSet) == count($expectedReturns)){
                        for($j = 0; $j < count($expectedReturns); ++$j){
                                $returnSet[$j] != $expectedReturns[$j] ?
                                $totDed[$j] = $TESTD : $totDed[$j] = 0;
                        }
                        //$deductNoRun[$i] = 0;
                }

                else if($exec_return_code){
                        for($j = 0; $j < count($expectedReturns); ++$j){
                                if(!isset($returnSet[$j]))
                                $returnSet[$j] = "(Python crashed!)";

                                $returnSet[$j] != $expectedReturns[$j] ?
                                $totDed[$j] = $TESTD : $totDed[$j] = 0;
                        }
                        //If run fails, then cons deducts.
                        $deductCons[$i] = $CONSD;
                }

                $deductTest[$i] = $totDed;

                $a = strtok($answer, "\n");
                while(ctype_space($a))
                        $a = strtok("\n");
                $r = preg_match('/def[ \t]+' . $functionName . '[ \t]*\(.+/', $a);

                $r ? $deductName[$i] = 0 : $deductName[$i] = $NAMED;

                //$exec_return_code ? $deductNoRun[$i] = $NORUND :
                //$deductNoRun[$i] = 0;
                $scores[$i] = $maxScores[$i] - $deductNoRun[$i] -
                $deductName[$i] - $deductDef[$i] - $deductColon[$i] -
                $deductCons[$i];

                foreach($totDed as $test)
                        $scores[$i] -= $test;
                $comments[$i] = "";
                $expecteds[$i] = $expectedReturns;
                $resulting[$i] = $returnSet;
        }

        str_flatten("HACKMAGICK", $expecteds);
        str_flatten("HACKMAGICK", $resulting);
        str_flatten(", ", $deductTest);

//Comments are nothing since the autograder doesn't input comments nor gets
//when student completes exam, so they are empty

        $tData = array('comments' => $comments, 'ucid' => $ucid, 'exaName' =>
        $examName, 'questionsid' => $questionIDs, 'answers' => $answers,
        'scores' => $scores, 'maxScores' => $maxScores, 'expectedAnswers' =>
        $expecteds, 'resultingAnswers' => $resulting,
        'deductedPointscorrectName' => $deductName, 'deductedPointsPerEachTest'
        => $deductTest, 'deductedPointsHasDef' => $deductDef,
        'deductedPointsMissingColon' => $deductColon, 'deductedPointsConstrain'
        => $deductCons);

        $datas = http_build_query(array('RequestType' => 'gradingExam', 'data' => $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $resulting = curl_exec($ch);
        curl_close($ch);
        echo $resulting;

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

function str_flatten($delim, &$arr){
        foreach($arr as &$a)
                $a = implode($delim, $a);
}
                                

?>
