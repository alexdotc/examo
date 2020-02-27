<?php

$url = 'https://myhub.njit.edu/vrs/ldapAuthenticateServlet';
$backurl = 'https://web.njit.edu/~yav3/backEndCS490Betha.php';

$requestID = $_POST['RequestType'];
$data = $_POST['data'];
//Due to no connection of post being sent to back, the back would need the data
//To call $data['RequestType'] to get the request type

if($requestID = 'login'){
        $username = $_POST['ucid'];
        $password = $_POST['password'];

        $post = "user_name=$username&passwd=$password";

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

elseif($requestID == 'CreateQuestion'){
//Creates the question then sends data to back to store in database
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

}

elseif($requestID == 'GetQuestions'){//Send the request data forward for the
//back to retreive the question data from the database to then send to front
//Data will be holding the request type for back to determine which to send
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

}

elseif($requestID == 'createExam'){
//Data will be holding the exam created to save in database
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

}

elseif($requestID == 'listExams'){
//Data will be sending the list of exams created to the front
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

}

elseif($requestID == 'showExam'){
//Data will be sending the exam chosen to the front to display
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $backurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

}

?>
