<?php
if (isset($_SERVER['HTTP_ORIGIN'])){
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Max-Age: 86400");
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
  header("Access-Control-Allow-Methods:POST");

  if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
  header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

  exit(0);

}


$username = $_POST['username'];
$password = $_POST['password'];
$cookie_file_path = "class/cookie.txt";

$url = "http://info.uniten.edu.my/info/Ticketing.ASP?WCI=Biodata";
$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_HEADER, true );
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch,CURLOPT_HTTPAUTH, CURLAUTH_NTLM );
curl_setopt($ch,CURLOPT_USERPWD, $username.':'.$password );
//curl_setopt($ch, CURLOPT_USERPWD, $dummy);
curl_setopt($ch,CURLOPT_TIMEOUT, 10 );
curl_setopt($ch,CURLOPT_VERBOSE, true );
//curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
//curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);

$output = curl_exec($ch);
$t = curl_getinfo($ch);

//get http respond code to perform auth
if($t['http_code'] == 200){
  session_start();
  $_SESSION['username'] = $username;
  header("Location:http://".$_SERVER['HTTP_HOST']."/ors/dataportal");

}
else if($t['http_code'] == 0){
  echo "<h1>Unable to connect to uniten server</h1>";
}
else  if($t['http_code'] == 500){
  $err = '';
  $err .= "500 server error";
  return $err;
  echo '500 server error';
}
else if($t['http_code'] ==  401){

  echo "<script>alert('Wrong username or password');</script>";
  header("Location:login.php?error=error login");
}


?>
