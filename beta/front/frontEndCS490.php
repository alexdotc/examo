<?php

	define('MAGICNUMBER', true);
	include 'unlock.php';

	$URL = 'https://web.njit.edu/~np595/CS490Work/middleAlt.php';

	$req = login($_POST['ucid'], $_POST['password'], $URL);

	$loginRespJSON = json_decode($req, true);

	//TODO: $_SESSION keys based on real JSON responses from back/mid

	if($loginRespJSON['resp'] == 'backYes'){
		$_SESSION['logon'] = true;
		$_SESSION['teacher'] = true;
	}
	else if($loginRespJSON['respNJIT'] == 'NJITyes'){
		$_SESSION['logon'] = true;
		$_SESSION['student'] = true;
	}

	echo json_encode($loginRespJSON);

	function login($ucid, $pass, $URL){
		$post_params = "ucid=$ucid&password=$pass";
		$ch = curl_init();
		$options = array(CURLOPT_URL => $URL,
			         CURLOPT_HTTPHEADER =>
				 array('Content-type:application/x-www-form-urlencoded'),
				 CURLOPT_RETURNTRANSFER => TRUE,
				 CURLOPT_POST => TRUE,
				 CURLOPT_POSTFIELDS => $post_params);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
?>
