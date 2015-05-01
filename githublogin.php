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
//$redirect_url = 'http://wsdl-docker.cs.odu.edu:60332';
$redirect_url = 'http://localhost/cs418Project/githublogin.php';

//get request , either code from github, or login request
//if($_SERVER['REQUEST_METHOD'] == 'GET') {
//authorised at github
if(isset($_GET['code'])) {
  $code = $_GET['code'];

  //perform post request now
  $post = http_build_query(array(
    'client_id' => $clientId ,
    'redirect_uri' => $redirect_url ,
    'client_secret' => $clientSecret,
    'code' => $code ,
  ));

  $context = stream_context_create(array("http" => array(
    "method" => "POST",
    "header" => "Content-Type: application/x-www-form-urlencodedrn" .
    "Content-Length: ". strlen($post) . "rn".
    "Accept: application/json" ,
    "content" => $post,
  )));

  $json_data = file_get_contents("https://github.com/login/oauth/access_token", false, $context);

  $r = json_decode($json_data , true);

  $access_token = $r['access_token'];

  $url = "https://api.github.com/user?access_token=$access_token";

  $data =  file_get_contents($url);

  //echo $data;
  $user_data  = json_decode($data , true);
  $username = $user_data['login'];


  $emails =  file_get_contents("https://api.github.com/user/emails?access_token=$access_token");
  $emails = json_decode($emails , true);
  $email = $emails[0];

  $signup_data = array(
    'username' => $username ,
    'email' => $email ,
    'source' => 'github' ,
  );

  signup_login_user($signup_data);
} else {
  $url = "https://github.com/login/oauth/authorize?client_id=$clientId&redirect_uri=$redirect_url&scope=user";
  header("Location: $url");
}


?>
