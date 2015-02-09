<?php
session_start();
require_once 'classes/User.php';
$user = new User();

// If the user clicks the "Log Out" link on the index page.
if(isset($_GET['status']) && $_GET['status'] == 'loggedout') {
  $user->log_User_Out();
}

// Did the user enter a username/password and click submit?
if($_POST && !empty($_POST['username']) && !empty($_POST['password'])) {
  $response = $user->validate_User($_POST['username'], $_POST['password']);
  $_SESSION['user_id'] = 'username';
}


?>


<!DOCTYPE html>
<html>
  <head>
  </head>

  <body>
    <div class="login">
      <form method="post" action="">
        <div>
          <label for="username">Username</label>
          <input type="text" name="username" value="" id="username" placeholder="Username">
        </div>
        <div>
          <label for="username">Password</label>
          <input type="text" name="password" value="" id="password" placeholder="Password">
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
    </div>
  </body>
</html>
