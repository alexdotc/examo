<?php 
//$dat=array('RequestType' => "login",'data'=> array("ucid"=>"yav3", "password"=>"777"));
//$dat=array('RequestType' => "login",'data'=> array("ucid"=>"alc26", "password"=>"777"));//professor
//$dat=array('RequestType' => "CreateQuestion",'data'=> array('topic' => "roundFunc", "testcases" => 'square(4,2);|16,square(2,3);|8',"difficulty"=>"easy", "questiontext" => "whrer is"));
//$dat=array('RequestType'=>"GetQuestions",'data'=>"");//data does not store anything

//$dat=array('RequestType'=>"createExam",'data'=>array('exaName'=>"exam345",'questionsid'=>array(1,5),'questPoint'=>array(10,40)));


//$dat=array('RequestType'=>"listExams",'data'=>array('ucid'=>'np595'));//data does not store anything

//$dat=array('RequestType'=>"showExam",'data'=>array('exaName'=>"exam345"));
//$dat=array('RequestType'=>"gradingExam",'data'=>array('ucid'=>'yav3','exaName'=>"exam100",'questionsid'=>array(31,39),
//         'answers'=>array("def square(start, end):
//    while start <= end:
//        start*=start
//    return start","stringNultiply(str1, num)
//	print(str1 * 2)"),'scores'=>array(50,26),'maxScores'=>array(50,50),'comments'=>array("coment1","coment2"),'expectedAnswers'=>array("256,81,16,16","foofoo, barbarbarbar, hihihi, worldworldworldworldworld"),'resultingAnswers'=>array("256,81,16,16","foofoo, barbar, hihi, worldworld"),'deductedPointsPerEachTest'=>array("0, 0, 0, 0","0, 5, 5, 5"),'deductedPointscorrectName'=>array(0,3)));

//$dat=array('RequestType'=>"showGradedExam",'data'=>array('exaName'=>"exam100",'ucid'=>'yav3'));
$dat=array('RequestType'=>"modifyGradedExam",'data'=>array('ucid'=>'np595','exaName'=>"COVID-19 Fun",'gradesID'=>array(64,65,66,67,68),'answers'=>array("ans1","ans2","ans3","ans4","ans5"),'scores'=>array(10,20,30,40,50),'comments'=>array("comentnew1","You\'re","","",""),'released'=>"Y",'deductedPointsPerEachTest'=>array("1, 2","0, 5", "5, 5","10,10","0,0"),'deductedPointscorrectName'=>array(3,2,5,5,5)));

//$dat=array('RequestType'=>"listGradedExams",'data'=>"");//data does not store anything
//$dat=array('RequestType'=>"listGradedExamsStudent",'data'=>array('ucid'=>'yav3'));//data does not store anything

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
echo $unprocessedResult;
curl_close($ch);

?>
