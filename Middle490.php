<?php

$ucid; //Must remove when working
$password;
$url = "http://myhub.njit.edu/vrs/"; 
//Authentication wasn't working, this does and returns a bad request since my ucid doesn't work for some reason
$USER_AGENT = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like
Gecko) Chrome/35.0.2309.372 Safari/537.36";
$backURL = "https://web.njit.edu/~yav3/backEndCS490.php";
$frontURL = "https://web.njit.edu/~alc26/front/frontEndCS490.php";
//Enables php to realize its connecting through Chrome or Safari

//Cookies are required to access the website
$cookie = "/cookie.txt";

//Place the Post input here to read out and take over the ucid and password for
//the login check



//If the return from back is true then skip over the login check seeing as the
//Login return will no longer be the ucid or password, seeing as they are
//changed
if($ucid == null && $password == null){
        echo "ucid or password is empty";
        exit;
}
else if($ucid == "back" && $password == "back"){

        exit;
}
//Else if ucid and password is entered then continue through the list. I'm not
//putting it in an else since both prior if statments either exit while
//returning that there is no ucid or password or sending the JSON to the front

$post = "user_name=".$ucid."&passwd=".$password;

//From here and below with curl is for communication between the website and
//PHP to determine log in credentials within the housing login, in this case
//its the normal school's login
$ch = curl_init(); //Activates usage to connect to urls

curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_USERAGENT, $USER_AGENT);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, isset($_SERVER['REQUEST_URI']));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec($ch);

if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}

$result = curl_exec($ch);

curl_close($ch);
echo $result;
return;

?>
