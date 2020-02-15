<?php

$url = 'https://myhub.njit.edu/vrs/';
$redirect = 'https://myhub.njit.edu/vrs/Step1handler?UCID=adfasadfadfasdf';
$fronturl = 'https://web.njit.edu/~alc26/front/frontEndCS490.php';
$backurl = 'https://web.njit.edu/~yav3/backEndCS490.php';
$username = '';
$password = '';

$json = file_get_contents($backurl);
if(json_decode($json) != NULL){ //Probably overthinking this part and returns
//when calling the urls for the POST data
        $chfront = curl_init();

        curl_setopt($chfront, CURLOPT_URL, $fronturl);
        curl_setopt($chfront, CURLOPT_POST, 1);
        curl_setopt($chfront, CURLOPT_POSTFIELDS, $json);
        curl_setopt($chfront, CURLOPT_HTTPHEADER,
        array('Content-Type:application/json'));

        $resultF = curl_exec($chfront);
        curl_close($chfront);
        exit;
}

if(isset($_POST['ucid']) && isset($_POST['password'])){
        $ucid1 = $_POST['ucid'];
        $pass1 = $_POST['password'];
        //$username = $_GET[''];
        //$password = $_GET[''];

        $post = "ucid=$ucid1&password=$pass1";

        $chBack = curl_init();
        curl_setopt($chBack, CURLOPT_URL, $backurl);
        curl_setopt($chBack, CURLOPT_HTTPHEADER,
        array('Content-type:application/x-ww-form-urlencoded'));
        curl_setopt($chBack, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chBack, CURLOPT_POST, true);
        curl_setopt($chBack, CURLOPT_POSTFIELDS, $post);
        $resultB = curl_exec($chBack);
        curl_close($chBack);

}

$post = "user_name=$username&passwd=$password";

$fields = urlencode($post);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt ($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

$result = curl_exec($ch);

curl_close($ch);

if($result){
        echo "System has logged in\n";
}
else{
        echo "System has not logged in, bad ucid or password\n";
}
?>
