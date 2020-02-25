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
			$resp = $r['userType']; //response 'P' or'S'
		else
			$resp = 'backNo';
	}
	//Returns the JSON representation of $resp
	echo json_encode($resp);

}
mysqli_close($db);

?>
