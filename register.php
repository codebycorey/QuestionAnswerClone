<?php
require_once 'includes/constants.php';
session_start();

function insert_New_User($un, $pwd) {
  $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');
    $query = "INSERT INTO user (username, password)
              VALUES ('$un', '$pwd')";
    if(mysqli_query($link, $query)) {
      return true;
      } else {
      return false;
      echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
    }
}

function user_Inserted($un, $pwd) {
  $no_error = insert_New_User($un, $pwd);

  if($no_error) {
    return "User Successfully added.";
  } else return "Username already taken, please use another";
}

// Did the user enter a username/password and click submit?
if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
  if($_POST['password'] == $_POST['password2']) {
    $response = user_Inserted($_POST['username'], $_POST['password']);
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
  </head>

  <body>
    <div class="login">
    <h1>Please create a User Account to access the rest of the website</h1>
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
          <label for="password2">Retype Password</label>
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
