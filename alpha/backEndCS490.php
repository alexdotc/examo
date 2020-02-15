<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);

$hostname = ""     ; 	  // 
$username = "" ;
$project  = "" ;
$password = "" ;


$db = mysqli_connect ($hostname, $username, $password, $project);
if (mysqli_connect_errno ($db))
{ echo "Failed to connect to MySQL: " . mysqli_connect_error ( $db );
  exit ();
}

$ucid = $_POST['user_name'];
$pass = $_POST['passwd'];

$s="select * from userCred where ucid='$ucid'";
($t=mysqli_query ($db,$s)) or die( mysqli_error( $db )); #Executes query
$num=mysqli_num_rows($t);
if ($num ==0) 
  $resp = array("resp"=>"noExist");

$r=mysqli_fetch_array($t,MYSQLI_ASSOC);
$hash=$r['hash'];

if (password_verify($pass,$hash)) //Verifies that a password matches a hash value in the db
	{$resp =array("resp"=>"backYes");} 
else
	$resp = array("resp"=>"backNo");

//Returns the JSON representation of $resp
$resp_string = json_encode($resp);                                                                                   

echo $resp_string;
mysqli_close($db);

?>