<?php 

// Decode JSON data into PHP associative array format
$dat = array ("ucid"=>"yav3", "password"=>"777");


$url="https://web.njit.edu/~yav3/backEndCS490.php";

$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_REFERER, $url);
curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($dat));
curl_setopt($ch, CURLOPT_POST, true);
$unprocessedResult = curl_exec($ch);
//echo $unprocessedResult;
curl_close($ch);

$result = json_decode($unprocessedResult);


if (strpos($result->resp, "backYes") !== false)
        $backResult = "Our backend knows you.";
else    
        $backResult = "Our backend hates you.";



$finalResult = $backResult . "\n";

echo $finalResult;


?>