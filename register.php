<?php
session_start();
include('config.php');

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

function send_email($username, $email, $hash) {
  $postQueryParameters =
    http_build_query(array(
      "from" => 'Mailgun Sandbox <mailgun@sandbox4a441c68b0d149a98588d0144cce5371.mailgun.org>', // Get and use your own
      "to"  => $email,
      "subject" => "Verification for Question Answer",
      "text" => "Please click this link to activate your account:
http://wsdl-docker.cs.odu.edu:60332/verify.php?email=$email&hash=$hash"
    ));
  $username = "api";
  $password = "key-de38703ac31e847db11023898d64b8ff"; // Get and use your own

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/sandbox4a441c68b0d149a98588d0144cce5371.mailgun.org/messages");  // Get and use your own
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);
  curl_setopt($ch, CURLOPT_POSTFIELDS,$postQueryParameters);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec ($ch);
  if($output != false){
    curl_close ($ch);
    return $output;
  }else {
    $output = curl_error($ch);
    curl_close ($ch);
    return $output;
  }
}

function insert_New_User($link, $username, $email, $password, $avatar, $hash) {
    $query = mysqli_query($link ,"
      INSERT INTO user (username, email, password, avatar_type, hash)
      VALUES ('{$username}', '{$email}', '{$password}', '{$avatar}', '{$hash}')");
    return $query;
}

function user_Inserted($link, $username, $email, $password, $avatar, $hash) {
  $no_error = insert_New_User($link, $username, $email, $password, $avatar, $hash);

  if($no_error) {
    $no_error = send_email($username, $email, $hash);
    if($no_error) {
      return "User Successfully added.";
    } else return $no_error;
  } else return "Username already taken, please use another";
}

// Did the user enter a username/password and click submit?
if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['avatar'])) {
  if($_POST['email'] === $_POST['email2']) {
    if($_POST['password'] === $_POST['password2']) {
      $hash = md5(rand(0,1000));
      $response = user_Inserted($link, $_POST['username'], $_POST['email'], $_POST['password'], $_POST['avatar'], $hash);
    } else {
      $response = "Your passwords do not match";
    }
  } else {
    $response = "Your emails do not match";
  }
} else {
  $response = "Please make sure all field are filled out";
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
  <nav class="lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="#" class="brand-logo"></a>
        <ul class="right">
          <li><a href="login.php">Log In</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
          <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </div>
  </nav>
    <div class="container">
    <h1>Please create a User Account to access the rest of the website</h1>
      <form method="post">
        <div class="input_field">
        <div>
          <input type="text" name="username" value="<?php if(isset($_POST['username'])) {echo $_POST['username'];}?>" id="username" placeholder="Username">
        </div>
        <div>
          <input type="email" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];}?>" id="email" placeholder="Email">
        </div>
        <div>
          <input type="email" name="email2" value="" id="email2" placeholder="Retype Email">
        </div>
        <div>
          <input type="password" name="password" value="" id="password" placeholder="Password">
        </div>
        <div>
          <input type="password" name="password2" value="" id="password2" placeholder="Retype Password">
        </div>
        <p>Avatar Type</p>
        <div>
          <input type="radio" name="avatar" id="website" value="0">
          <label for="website">Default</label>
        </div>
        <div>
          <input type="radio" name="avatar" id="gravatar" value="1">
          <label for="gravatar">Gravatar</label>
        </div>
        <div>
          <input type="submit" value="Submit">
        </div>
        </div>
      </form>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
    </div>
</body>
</html>
