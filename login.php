<?php
session_start();

include('config.php');

function verify_Username_and_Pass($un, $pwd) {

  $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Could not connect to MySQL DB ') . mysql_error();

  $query = mysqli_query($link, "
    SELECT id FROM user
    WHERE username = '{$un}' AND password = '{$pwd}'");

  $numrows = mysqli_num_rows($query);

  if($numrows === 1) {
    while($row = mysqli_fetch_assoc($query)) {
      $_SESSION['user_key'] = $row['id'];
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

// Did the user enter a username/password and click submit?
if($_POST && !empty($_POST['username']) && !empty($_POST['password'])) {
  $response = validate_User($_POST['username'], $_POST['password']);
  $_SESSION['user_id'] = $_POST['username'];
} else {
  "Please make sure both fields are filled out";
}

?>

<!DOCTYPE html>
<html>
  <head>
  </head>

  <body>
    <div class="login">
    <h1>Please log in to access the rest of the website</h1>
      <form method="post" action="">
        <div>
          <label for="username">Username</label>
          <input type="text" name="username" value="" id="username" placeholder="Username">
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" name="password" value="" id="password" placeholder="Password">
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
      <a href="register.php">Register</a>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
    </div>
  </body>
</html>
