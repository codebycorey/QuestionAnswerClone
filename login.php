<?php
session_start();

include('config.php');


function signup_login_user($signup_data) {
  $length = count($signup_data);
  for ($i = 0; $i < $length; $i++) {
    echo $signup_data[$i];
  }
}


// GITHUB CREDENTIALS for API ACCESS, get these from GitHub
function signup_github() {
  $clientId = "00927f47bb816f187daf";
  $clientSecret = "4f78fdba28613156c7a76ad1a6de37febb53b9ac";
  $redirect_url = 'http://wsdl-docker.cs.odu.edu:60332';

  echo "test1";
  //get request , either code from github, or login request
 // if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "test2";
    //authorised at github
    if(isset($_GET['code'])) {
      $code = $_GET['code'];

      //perform post request now
      $post = http_build_query(array(
        'client_id' => $client_id ,
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
 // }
}

function verify_Username_and_Pass($un, $pwd) {

  $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Could not connect to MySQL DB ') . mysql_error();

  $query = mysqli_query($link, "
    SELECT id, admin
    FROM user
    WHERE username = '{$un}' AND password = '{$pwd}'");

  $numrows = mysqli_num_rows($query);

  if($numrows === 1) {
    while($row = mysqli_fetch_assoc($query)) {
      $_SESSION['user_key'] = $row['id'];
      $_SESSION['edit'] = false;
      if($row['admin']==1){
        $_SESSION['admin'] = true;
      }
      return true;
    }
  } else {
    return false;
  }

  mysqli_close($link);
}

function validate_User($un, $pwd) {
  $ensure_credentials = verify_Username_and_Pass($un, $pwd);
  if($ensure_credentials) {
    $_SESSION['status'] = 'authorized';
    header("location: index.php");
  } else return "Please enter a correct username and password";
}

function log_User_Out() {
  if(isset($_SESSION['status'])) {
    unset($_SESSION['status']);

    if(isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time() - 1000);

    // Unset all of the session variables.
    session_unset();

    // Destroy the session.
    session_destroy();
  }
}


// If the user clicks the "Log Out" link on the index page.
if(isset($_GET['status']) && $_GET['status'] == 'loggedout') {
  log_User_Out();
}

if($_POST && isset($_POST['github'])) {
  signup_github();
  echo "test1";
}

// Did the user enter a username/password and click submit?
if($_POST && isset($_POST['formsubmit']) && !empty($_POST['username']) && !empty($_POST['password'])) {
  $response = validate_User($_POST['username'], $_POST['password']);
  $_SESSION['user_id'] = $_POST['username'];
} else {
  "Please make sure both fields are filled out";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>QuestionAnswer</title>
      <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>

</head>

<body>
    <div class="container">
    <h1>Please log in to access the rest of the website</h1>
      <form method="post">
        <div>
          <input type="text" name="username" value="" id="username" placeholder="Username">
        </div>
        <div>
          <input type="password" name="password" value="" id="password" placeholder="Password">
        </div>
        <div>
        <input type="submit" name="formsubmit" value="Submit">
        <input type="submit" name="github" value="Github">
        </div>
      </form>
      <a href="register.php">Register</a>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
    </div>
</body>
</html>
