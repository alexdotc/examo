<?php
//Checked with the test and works with sending data from front to back and registers questions and exams, while bringing info of exams
//and questions back to front.
$url = 'https://myhub.njit.edu/vrs/ldapAuthenticateServlet';
$backurl = 'https://web.njit.edu/~yav3/backEndCS490Betha.php';

$requestID = $_POST['RequestType'];
$data = $_POST['data'];
//Due to no connection of post being sent to back, the back would need the data
//To call $data['RequestType'] to get the request type

if ($requestID == 'login'){
        $username = $data['ucid'];
        $password = $data['password'];

        $post = http_build_query(array('RequestType' => $requestID, 'ucid' =>
        $username, 'password' => $password));

        $chBack = curl_init();
        curl_setopt($chBack, CURLOPT_URL, $backurl);
        curl_setopt($chBack, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($chBack, CURLOPT_POSTFIELDS, $post);

        $resultB = curl_exec($chBack);
        curl_close($chBack);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);

        curl_close($ch);

        if(strpos($result, "Invalid UCID")==false){
                $response = "NJITyes";
        }
        else{
                $response = "NJITno";
        }

        $decoded_json = json_decode($resultB, true);
        $decoded_json['respNJIT'] = $response;
        $finalJSON = json_encode($decoded_json, JSON_PRETTY_PRINT);
        echo $finalJSON;

}

if ($requestID == 'CreateQuestion'){
//Creates the question then sends data to back to store in database

        $topic = $data['topic'];
        $difficulty = $data['difficulty'];
        $questiontext = $data['questiontext'];
        $testcases = $data['testcases'];

        $sendData = array('topic' => $topic, 'difficulty' => $difficulty,
        'questiontext' => $questiontext, 'testcases' => $testcases);

        $datas = http_build_query(array('RequestType' => $requestID, data =>
        $sendData));

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
        $sendData = http_build_query(array('RequestType' => $requestID, data =>
        ''));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if ($requestID == 'createExam'){
//Data will be holding the exam created to save in database
        $examName = $data['exaName'];
        $questID = $data['questionsid'];
        $questPoint = $data['questPoint'];

        $sendData = array('exaName' => $examName, 'questionsid' => $questID,
        'questPoint' => $questPoint);

        $datas = http_build_query(array('RequestType' => $requestID, data =>
        $sendData));

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
        $sendData = http_build_query(array('RequestType' => $requestID, data =>
        ''));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

if($requestID == 'showExam'){
//Data will be sending the exam chosen to the front to display
        $examName = $data['exaName'];

        $sendData = array('exaName' => $examName);

        $datas = http_build_query(array('RequestType' => $requestID, data =>
        $sendData));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

}

?>
