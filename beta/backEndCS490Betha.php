<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  //Detectes run-time errors
ini_set('display_errors' , 1);

//DB credentials
$hostname = 	   
$username = 
$project  = 
$password = 

//Connects the PHP script to the DB to execute SQL statements
$db = mysqli_connect ($hostname, $username, $password, $project);
if (mysqli_connect_errno ($db))
{ echo "Failed to connect to MySQL: " . mysqli_connect_error ( $db );
  exit ();
}

$request = $_POST['RequestType'];
$data = $_POST['data'];

if ($request == 'login'){
	$ucid = $data['ucid'];
	$pass = $data['password'];

	$s="select * from userCred where ucid='$ucid' ";
	($t=mysqli_query ($db,$s)) or die( mysqli_error( $db )); #Executes query
	$num=mysqli_num_rows($t);//returns the number of rows in $t.
	if ($num ==0) 
		$resp = 'backNoexist';

	else{
		$r=mysqli_fetch_array($t,MYSQLI_ASSOC);
		$hash=$r['hash'];

		if (password_verify($pass,$hash)) //Verifies that a password matches a hash value in the db
			$resp = $r['userType']; 
		else
			$resp = 'backNo';
	}
	//Returns the JSON representation of $resp
	echo json_encode($resp);

}

if ($request == 'CreateQuestion'){
    $topic = $data['topic'];
	$tests = $data['testcases'];
    $difficulty = $data['difficulty'];
    $quest = $data['questiontext'];
    
	//Creating the question
	$query = "SELECT * FROM questionTable WHERE question = '$quest'";
	$cursor = $db->query($query);
	if ($cursor->num_rows == 0) {
		$query = "INSERT INTO questionTable (questTopic, questTest, questDifficulty, question) VALUES ('$topic','$tests', '$difficulty','$quest');";
		$db->query($query) or die('There was an error saving your question');
		$ans =  'Question successfully saved with id '.$db->insert_id;
		//echo json_encode($ans);
	}
	else
		$ans = 'Question already saved';
	//Returns the JSON representation of $ans
	echo json_encode($ans);
	
}	

if ($request == 'GetQuestions'){//list questions 
	$query="SELECT * from questionTable";
	$cursor = $db->query($query);
	while ($row = $cursor->fetch_array()) {
		$questionID = $row[0];
		$questionTopic = $row[1];
        $questionTest = $row[2];
		$questionDifficulty = $row[3];
		$question=$row[4];
		$ans[] = array(
			"questID" => $questionID,
			"topic" => $questionTopic,
			"testcases" => $questionTest,
			"difficulty" => $questionDifficulty,
			"questiontext" => $question);
	}
	echo json_encode($ans);
}
if ($request == 'createExam'){
	$exaName = $data['exaName'];
	$questID = $data['questionsid'];
	$questPoint = $data['questPoint'];

	
	$query = "SELECT * FROM examsTable WHERE exaName = '$exaName'";
	$cursor = $db->query($query);
	
	if ($cursor->num_rows == 0) {
		
		foreach (array_combine($questID, $questPoint) as $q => $p) {
			$query2 = "INSERT INTO examsTable (exaName,questID ,questPoint) VALUES ('$exaName', '$q', '$p')";
			$db->query($query2) or die('There was an error saving your Exam');
		}
		$ans =  'Exam successfully saved';
	}
	else
		$ans = 'Exam name conflict';
	
	echo json_encode($ans);
}
if ($request == 'listExams'){//for student 
		$query = "SELECT DISTINCT exaName FROM examsTable";
		$cursor = $db->query($query);
		if ($cursor->num_rows == 0)
			die('No exams found, try again later...');
		while ($row = $cursor->fetch_assoc()) {
			$exam[] = $row['exaName'];//check adding array if it is needed
		}
		echo json_encode($exam);
}
if ($request == 'showExam'){//for student 
	$exaName = $data['exaName'];
	$query="SELECT * FROM examsTable INNER JOIN questionTable ON examsTable.questID = questionTable.questID WHERE examsTable.exaName='$exaName'";
	//$query = "SELECT * FROM examsTable, questionTable WHERE exaName='$exaName'";
	$cursor = $db->query($query);
	if ($cursor->num_rows == 0) die('This exam does not exist, try again later...');
	while ($row = $cursor->fetch_assoc()) {
		$exam[] = array("examName"=>$row['exaName'],
						"questiontext"=>$row['question'],
						"points"=>$row['questPoint'],
						"questionID"=>$row['questID']);
						
	}

	echo json_encode($exam);	
}
if ($request == 'gradingExam'){//middle sends me this info 
	$ucid = $data['ucid'];
	$exaName = $data['exaName'];
	$questID = $data['questionsid'];
	$answer=$data['answers'];
	$score=$data['scores'];
	$maxScore=$data['maxScores'];
	$comments=$data['comments'];
	$released="N";//I dont need take this inf from data because it is always gonna be N until the professor modifies 
	$testCaseExpected = $data['expectedAnswers'];
	$testCaseAnswered = $data['resultingAnswers'];
	$testPointsDeducted = $data['deductedPointsPerEachTest'];
	$correctName = $data['deductedPointscorrectName'];
  	
	
	$count = count($questID);
	for($i=0; $i < $count; $i++){
		
		$query = "INSERT INTO gradesTable (ucid,exaName,questID,answer,score,maxScore,comments,released, expectedAnswers, resultingAnswers, deductedPointsPerEachTest, deductedPointscorrectName)
		VALUES ('$ucid', '$exaName','$questID[$i]','$answer[$i]','$score[$i]','$maxScore[$i]','$comments[$i]','$released', '$testCaseExpected[$i]', '$testCaseAnswered[$i]', '$testPointsDeducted[$i]', '$correctName[$i]')";
		$db->query($query) or die('There was an error saving the grades');
		
	}
	$ans =  "grade successfully saved";
		
		
	echo json_encode($ans);
}
	
 
if ($request == 'showGradedExam'){//for student and instructor
	$exaName = $data['exaName'];
	$query="SELECT * FROM gradesTable INNER JOIN questionTable ON gradesTable.questID = questionTable.questID WHERE gradesTable.exaName='$exaName'";
	//$query = "SELECT * FROM examsTable, questionTable WHERE exaName='$exaName'";
	$cursor = $db->query($query);
	if ($cursor->num_rows == 0) die('This exam does not exist, try again later...');
	while ($row = $cursor->fetch_assoc()) {
		$exam[] = array("ucid"=>$row['ucid'],
						"gradesID"=>$row['gradesID'],
						"questID"=>$row['questID'],
						"questions"=>$row['question'],
						"answers"=>$row['answer'],
						"scores"=>$row['score'],
						"maxScores"=>$row['maxScore'],
						"comments"=>$row['comments'],
						"expectedAnswers"=>$row['expectedAnswers'],
						"resultingAnswers"=>$row['resultingAnswers'],
						"deductedPointsPerEachTest"=>$row['deductedPointsPerEachTest'],
						"deductedPointscorrectName"=>$row['deductedPointscorrectName']
						);
	}
	$query2="SELECT DISTINCT released FROM gradesTable WHERE exaName='$exaName'"; 
	$cursor = $db->query($query2);
	if ($cursor->num_rows == 0) die('This exam does not exist, try again later...');
	while ($row = $cursor->fetch_assoc()) {
			array_push($exam, $row['released']);
		
	}
    
	echo json_encode($exam);	
}
if ($request == 'modifyGradedExam'){//for instructor
    $ucid = $data['ucid'];
    $exaName = $data['exaName'];
	$gradesID = $data['gradesID'];
	$score=$data['scores'];
	$comments=$data['comments'];
	$released=$data['released'];
	$count = count($gradesID);

	for($i=0; $i < $count; $i++){
		$gradesID[$i] = (int) $gradesID[$i];
		$score[$i] = (int) $score[$i];
	}

	for($i=0; $i < $count; $i++){
		
		$query = "update `gradesTable` set `score`='$score[$i]',`comments`='$comments[$i]',`released`='$released' where `exaName`='$exaName' and `gradesID`='$gradesID[$i]' and `ucid`='$ucid'";
		//echo json_encode($query);

		$db->query($query) or die('There was an error saving the grades');
		
	}
	$ans =  'update successfully saved';
	

	
	echo json_encode($ans);	
}
if ($request == 'listGradedExams'){//for instructor 
		$query = "SELECT DISTINCT exaName,ucid FROM gradesTable";
		$cursor = $db->query($query);
		if ($cursor->num_rows == 0)
			die('No exams found, try again later...');
		while ($row = $cursor->fetch_assoc()) {
			$exam[] = array("exaName"=>$row['exaName'],"ucid"=>$row['ucid']);//check adding array if it is needed
			
		}
		echo json_encode($exam);
}
if ($request == 'listGradedExamsStudent'){//for student 
		$ucid = $data['ucid'];
		$query = "SELECT DISTINCT exaName FROM gradesTable where ucid='$ucid' and released='Y'";
		$cursor = $db->query($query);
		if ($cursor->num_rows == 0)
			die('No exams found, try again later...');
		while ($row = $cursor->fetch_assoc()) {
			$exam[] = $row['exaName'];//check adding array if it is needed
		}
		echo json_encode($exam);
}
if ($request == 'retrieve') {
	$ids = $data['questionsid'];
    $result = array();
	$count = count($ids);

	for ($i = 0; $i < $count; $i++) {
		$query="SELECT * FROM questionTable WHERE questID=".$ids[$i];
		$cursor = $db->query($query);
		while ($row = $cursor->fetch_assoc()) {
			$result[] = array('topic'=>$row['questTopic'], 'questText'=>$row['question'], 'questTest'=>$row['questTest']);
		}
	}

	echo json_encode($result);
}

mysqli_close($db);

?>
