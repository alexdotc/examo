<?php
	// TODO: change to real mid url
	$URL = 'http://localhost/test/test.php';

	$req = login(file_get_contents('php://input'), $URL);
	echo $req;

	function login($json, $URL){
		$post_params = $json;
		$ch = curl_init();
		$options = array(CURLOPT_URL => $URL,
			         CURLOPT_HTTPHEADER => array('Content-type:application/json'),
				 CURLOPT_RETURNTRANSFER => TRUE,
				 CURLOPT_POST => TRUE,
				 CURLOPT_POSTFIELDS => $post_params);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
?>
