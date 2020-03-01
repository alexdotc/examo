<?php

$backurl = 'https://web.njit.edu/~yav3/backEndCS490Betha.php';

$requestID = $_POST['RequestType'];
$data = $_POST['data'];

if ($requestID == 'login'){
        $username = $data['ucid'];
        $password = $data['password'];

        $tData = array('ucid' => $username, 'password' => $password);

        $post = http_build_query(array('RequestType' => $requestID, 'data' =>
        $tData));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);
        echo $result; //Echos login return from back to front
        curl_close($ch);

}

if ($requestID == 'CreateQuestion'){
//Creates the question then sends data to back to store in database

        $topic = $data['topic'];
        $difficulty = $data['difficulty'];
        $questiontext = $data['questiontext'];
        $testcases = $data['testcases'];

        $tData = array('topic' => $topic, 'difficulty' => $difficulty,
        'questiontext' => $questiontext, 'testcases' => $testcases);

        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if ($requestID == 'GetQuestions'){//Send the request data forward for the
//back to retreive the question data from the database to then send to front
//Data will be holding the request type for back to determine which to send
        $datas = http_build_query(array('RequestType' => $requestID, 'data' => ''));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if ($requestID == 'createExam'){
//Data will be holding the exam created to save in database
        $examName = $data['exaName'];
        $questID = $data['questionsid'];
        $questPoint = $data['questPoint'];

        $tData = array('exaName' => $examName, 'questionsid' => $questID,
        'questPoint' => $questPoint);

        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if ($requestID == 'listExams'){
//Data will be sending the list of exams created to the front
        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        ''));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if($requestID == 'showExam'){
//Data will be sending the exam chosen to the front to display
        $examName = $data['exaName'];

        $tData = array('exaName' => $examName);

        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if($requestID == 'gradingExam'){ //Perform auto-grader here!



}

if($requestID == 'showGradedExam'){

        $examName = $data['exaName'];

        $tData = array('exaName' => $examName);

        $datas = http_build_query(array('RequestType' => $requestID, 'data' => $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if($requestID == 'modifyGradedExam'){

        $ucid = $data['ucid'];
        $examName = $data['exaName'];
        $gradeID = $data['gradesID'];
        $score = $data['scores'];
        $comments = $data['comments'];
        $released = $data['released'];

        $tData = array('ucid' => $ucid, 'exaName' => $examName, 'gradesID' =>
        $gradeID, 'scores' => $score, 'comments' => $comments, 'released' =>
        $released);

        $datas = http_build_query('RequestType' => $requestID, 'data' => $tData);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if($requestID == 'listGradedExams'){

        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        ''));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if($requestID == 'listGradedExamsStudent'){

        $ucid = $data['ucid'];

        $tData = array('ucid' => $ucid);

        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if($requestID == 'retrieve'){

        $id = $data['questionsid'];

        $tData = array('questionsid' => $id);

        $datas = http_build_query(array('RequestType' => $requestID, 'data' =>
        $tData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

?>
