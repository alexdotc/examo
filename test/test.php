<?php

	$DB_HOST = 'localhost';
	$DB_USER = 'root';
	$DB_PASS = '';
	$DB_TYPE = 'users';
	
	$json = json_decode($_POST['json'], true)

	$cnx = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_TYPE);

	if ($cnx -> connect_error)
		die("Connection failed: " . $cnx->connect_error);

	$query = $cnx->prepare("SELECT type FROM " . $DB_TYPE . " WHERE user = ? AND pass = ?");
	$query->bind_param('ss', $json['user'], $json['pass']);
	$query->execute();
	$query->bind_result($result);
	$query->fetch();

	if($result)
            $json = json_encode(array('back' => 'yes'))
	else
            $json = json_encode(array('back' => 'no'))

	$query->close();
	$mysqli->close();
?>
