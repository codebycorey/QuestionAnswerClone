<?php
session_start();
include('config.php');

function signup_login_user($signup_data) {
  $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

  $searchquery = mysqli_query($link, "
    ");
  $length = count($signup_data);
  for ($i = 0; $i < $length; $i++) {
    echo $signup_data[$i];
  }
 // header("Location: http://localhost/cs418Project/index.php");

}

$clientId = "00927f47bb816f187daf";
$clientSecret = "4f78fdba28613156c7a76ad1a6de37febb53b9ac";
$redirect_url = 'http://wsdl-docker.cs.odu.edu:60332/githublogin.php';
//$redirect_url = 'http://localhost/cs418Project/githublogin.php';

$ROOTURI = "http://wsdl-docker.cs.odu.edu:60332/";

//get request , either code from github, or login request
//authorised at github
if(isset($_GET['code'])) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL,"https://github.com/login/oauth/access_token");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(array(
      'code' => $_GET['code'],
      'client_id' => $clientId,
      'client_secret' => $clientSecret
    ))
  );
  curl_setopt($ch, CURLOPT_HTTPHEADER,array("Accept: application/json"));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $server_output = curl_exec ($ch);
  curl_close ($ch);

  $json = json_decode($server_output,true);

  if( !$json ||
    !isset($json['access_token']) ||
    strpos($json['access_token'],' ') !== FALSE){echo "Bad access token. <a href='$ROOTURI'>Reload the page.</a> Try again.";die();}

  $accessToken = json_decode($server_output,true)["access_token"];

} else {
  $url = "https://github.com/login/oauth/authorize?client_id=$clientId&redirect_uri=$redirect_url&scope=user";
  header("Location: $url");
}


?>
