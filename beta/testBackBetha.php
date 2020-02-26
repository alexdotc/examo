<?php 
//$dat=array('RequestType' => "login",'data'=> array("ucid"=>"yav3", "password"=>"777"));
//$dat=array('RequestType' => "login",'data'=> array("ucid"=>"alc26", "password"=>"777"));//professor
//$dat=array('RequestType' => "CreateQuestion",'data'=> array('topic' => "roundFunc", "testcases" => 'square(4,2);|16,square(2,3);|8',"difficulty"=>"easy", "questiontext" => "whrer is"));
//$dat=array('RequestType'=>"GetQuestions",'data'=>"");//data does not store anything

//$dat=array('RequestType'=>"createExam",'data'=>array('exaName'=>"exam345",'questionsid'=>array(1,5),'questPoint'=>array(10,40)));


//$dat=array('RequestType'=>"listExams",'data'=>"");//data does not store anything

$dat=array('RequestType'=>"showExam",'data'=>array('exaName'=>"exam345", 'exaRes'=>"20"));

$url="https://web.njit.edu/~yav3/backEndCS490Betha.php";

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
echo http_build_query($dat);
curl_close($ch);

?>
