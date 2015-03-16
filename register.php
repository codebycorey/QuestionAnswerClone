<?php
session_start();
include('config.php');

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

function insert_New_User($link, $username, $password) {
    $query = mysqli_query($link ,"
      INSERT INTO user (username, password)
      VALUES ('{$username}', '{$password}')");
    return true;
}

function user_Inserted($link, $username, $password) {
  $no_error = insert_New_User($link, $username, $password);

  if($no_error) {
    return "User Successfully added.";
  } else return "Username already taken, please use another";
}

// Did the user enter a username/password and click submit?
if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
  if($_POST['password'] == $_POST['password2']) {
    $response = user_Inserted($link, $_POST['username'], $_POST['password']);
  } else {
    $response = "Your passwords do not match";
  }
} else {
  $response = "Please make sure all field are filled out";
}



?>

<!DOCTYPE html>
<html>
<head>
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
      <form method="post" action="">
        <div>
          <input type="text" name="username" value="" id="username" placeholder="Username">
        </div>
        <div>
          <input type="password" name="password" value="" id="password" placeholder="Password">
        </div>
        <div>
          <input type="password" name="password2" value="" id="password2" placeholder="Retype Password">
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
    </div>
</body>
</html>
