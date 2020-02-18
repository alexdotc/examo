<?php

$url = 'https://myhub.njit.edu/vrs/';
$redirect = 'https://myhub.njit.edu/vrs/Step1handler?UCID=adfasadfadfasdf';
$fronturl = 'https://web.njit.edu/~alc26/front/frontEndCS490.php';
$backurl = 'https://web.njit.edu/~yav3/backEndCS490.php';
$username = '';
$password = '';

$ucid1 = $_POST['ucid'];
$pass1 = $_POST['password'];
$username = $ucid1;
$password = $pass1;

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

$post = "user_name=$username&passwd=$password";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt ($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

$result = curl_exec($ch);

curl_close($ch);

if($result){
        echo "System has logged in\n";
        $response = "NJITyes";
}
else{
        echo "System has not logged in, bad ucid or password\n";
        $response = "NJITno";
}

        $decoded_json = json_decode($resultB, true);
        $decoded_json['respNJIT'] = $response;
        $finalJSON = json_encode($decoded_json, JSON_PRETTY_PRINT);             
        echo $finalJSON;

?>
