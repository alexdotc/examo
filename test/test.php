<?php

	$DB_HOST = 'localhost';
	$DB_USER = 'root';
	$DB_PASS = '';
	$DB_TYPE = 'users';
	
	$_POST = json_decode(file_get_contents('php://input'), true);

	$cnx = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_TYPE);

	if ($cnx -> connect_error)
		die("Connection failed: " . $cnx->connect_error);

	$query = $cnx->prepare("SELECT type FROM " . $DB_TYPE . " WHERE user = ? AND pass = ?");
	$query->bind_param('ss', $_POST['ucid'], $_POST['password']);
	$query->execute();
	$query->bind_result($result);
	$query->fetch();

	if($result)
            $json = json_encode(array('back' => 'yes'));
	else
            $json = json_encode(array('back' => 'no'));

	echo $json;

	$query->close();
	$mysqli->close();
?>
