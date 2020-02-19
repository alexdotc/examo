<?php

$url = 'https://myhub.njit.edu/vrs/ldapAuthenticateServlet';
$fronturl = 'https://web.njit.edu/~alc26/front/frontEndCS490.php';
$backurl = 'https://web.njit.edu/~yav3/backEndCS490.php';
$username = $_POST['ucid'];
$password = $_POST['password'];

$post = "user_name=$username&passwd=$password";

$chBack = curl_init();
curl_setopt($chBack, CURLOPT_URL, $backurl);
curl_setopt($chBack, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($chBack, CURLOPT_POST, 1);
curl_setopt($chBack, CURLOPT_POSTFIELDS, $post);

$resultB = curl_exec($chBack);
curl_close($chBack);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

$result = curl_exec($ch);

curl_close($ch);

if(strpos($result, "Invalid UCID")==false){ //If true then we want to response back and show the authentication works. Otherwise if the login location also returns then just simply comment out header
        $response = "NJITyes";
        //header("Location: https://myhub.njit.edu/vrs/Step1handler?UCID=adfasadfadfasdf");
}
else{
        $response = "NJITno";
}

$decoded_json = json_decode($resultB, true);
$decoded_json['respNJIT'] = $response;
$finalJSON = json_encode($decoded_json, JSON_PRETTY_PRINT);             
echo $finalJSON;

?>
