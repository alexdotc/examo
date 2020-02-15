<?PHP

$credentials=array('user_name'=>$_POST["ucid"],'passwd'=>$_POST["password"]);


// curl backend 
	
	$url = "https://web.njit.edu/~yav3/backEndCS490.php";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($credentials));
	$res_project = curl_exec($ch);
	curl_close ($ch);
	

// curl njit
 
	$url ="https://myhub.njit.edu/vrs/ldapAuthenticateServlet";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($credentials)); 
	$response = curl_exec($ch);
	curl_close ($ch);
  
   
   if (strpos($response,"Invalid UCID")==false)
	
		$res_njit= "NJITyes";
	else 
	   $res_njit= "NJITno";
	
   //add njit respose to the db response
	$decoded_json = json_decode($res_project, true);
    $decoded_json['respNJIT'] = $res_njit;
    $finalJSON = json_encode($decoded_json, JSON_PRETTY_PRINT);                                                                                  

    echo $finalJSON;
  


?>