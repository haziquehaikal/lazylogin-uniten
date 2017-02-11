<?php


if (isset($_POST['username'])){
$username = $_POST['username'];
$password = $_POST['password'];

$url = "http://info.uniten.edu.my/info/Ticketing.ASP?WCI=Biodata";
$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_HEADER, true );
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch,CURLOPT_HTTPAUTH, CURLAUTH_NTLM );
curl_setopt($ch,CURLOPT_USERPWD, $username.':'.$password );
curl_setopt($ch,CURLOPT_TIMEOUT, 10 );
curl_setopt($ch,CURLOPT_VERBOSE, true );

$output = curl_exec($ch);
$t = curl_getinfo($ch);

//get http respond code to perform auth
if($t['http_code'] == 200){
  session_start();
  $_SESSION['username'] = $username;
  //set path

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
}
}


?>
