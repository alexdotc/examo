<?php

$ucid;
$password;
$project;
$url = "http://myhub.njit.edu/vrs/";
$USER_AGENT = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like
Gecko) Chrome/35.0.2309.372 Safari/537.36";
$backURL = "https://web.njit.edu/~yav3/backEndCS490.php";
$frontURL = "https://web.njit.edu/~alc26/front/frontEndCS490.php";
//Enables php to realize its connecting through Chrome or Safari

//Connects to the incoming POST and JSON responses to then place either POST in
//UCID spot and Password locations before continuing to send them forward to
//to the back end
//JSON is ignored and is sent directly to the front URL

//else check for JSON
$curl = curl_init($frontURL);
$json = file_get_contents($backURL);

if(json_decode($json, true)){ //Checks if true and if true then runs
        $json = json_encode($json);
        //Sends the data to the front through the url
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        curl_close($curl);
        exit; //Exits since the program doesn't need to check for the input
        //twice
}
//Else check for POST
$db = mysqli_connect($frontURL, $ucid, $password, $project);
if(mysqli_connect_errno($db)){
        echo "No request from the front, checking back";
}

$ucid = $_POST['ucid'];
$password = $_POST['password'];

//Send POST data to back
$req = login($_POST['ucid'], $_POST['password'], $backURL);

function login($ucid, $pass, $URL){
        $post_params = "ucid=$ucid&password=$pass";
        $curl2 = curl_init();

        curl_setopt($curl2, CURLOPT_URL, $URL);
        curl_setopt($curl2, CURLOPT_HTTPHEADER, array('Content-type:application/x-www-form-urlencoded'));
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl2, CURLOPT_POST, TRUE);
        curl_setopt($curl2, CURLOPT_POSTFIELDS, $post_params);

        $result = curl_exec($curl2);
        curl_close($curl2);
        return $result;
}

//Cookies are required to access the website
$cookie = "/cookie.txt";

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
