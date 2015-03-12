<?php

include_once 'includes/constants.php';

class User {

  function verify_Username_and_Pass($un, $pwd) {
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');

    $query = "SELECT id FROM user
              WHERE username = '$un' AND password = '$pwd'";

    $result = $link->query($query)
      or die($link->error);

    $num_rows = $result->num_rows;

      if($num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_key'] = $row['id'];
        return true;
      } else {
      return false;
      echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
      }
    }

  //Makes sure user is in the database
  function validate_User($un, $pwd) {
    $ensure_credentials = $this->verify_Username_and_Pass($un, $pwd);

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

  function confirm_User() {
    session_start();
    if($_SESSION['status'] !='authorized') header("location: login.php");
  }

}
?>
