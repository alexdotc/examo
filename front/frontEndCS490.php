<?php
	// TODO: change to real mid url
	$URL = 'https://web.njit.edu/~yav3/backEndCS490.php';

	$req = login($_POST['ucid'], $_POST['password'], $URL);
	echo $req;

	function login($ucid, $pass, $URL){
		$post_params = "ucid=$ucid&password=$pass";
		$ch = curl_init();
		$options = array(CURLOPT_URL => $URL,
			         CURLOPT_HTTPHEADER =>
				 array('Content-type:application/x-www-form-urlencoded'),
				 CURLOPT_RETURNTRANSFER => TRUE,
				 CURLOPT_POST => TRUE,
				 CURLOPT_POSTFIELDS => $sendstr);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
?>
