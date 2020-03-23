<?php

	define('MAGICNUMBER', true);
	include 'unlock.php';

	$URL = 'https://web.njit.edu/~np595/CS490Work/middleCS490Beta.php';

	$req = login($_POST['ucid'], $_POST['password'], $URL);

	$loginRespJSON = json_decode($req, true);

	if($loginRespJSON['resp'] == 'P'){
		$_SESSION['logon'] = true;
		$_SESSION['teacher'] = true;
                $_SESSION['user'] = $_POST['ucid'];
	}
	else if($loginRespJSON['resp'] == 'S'){
		$_SESSION['logon'] = true;
		$_SESSION['student'] = true;
                $_SESSION['user'] = $_POST['ucid'];
	}

	echo $req;

	function login($ucid, $pass, $URL){
		$post_params = http_build_query(array('RequestType' => 'login', 'data' => array('ucid' => $ucid, 'password' => $pass)));
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
