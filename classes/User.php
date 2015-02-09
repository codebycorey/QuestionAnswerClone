<?php

require 'Mysql.php';


class User {

  //Makes sure user is in the database
  function validate_User($un, $pwd) {
    $mysql = New Mysql();
    $ensure_credentials = $mysql->verify_Username_and_Pass($un, $pwd);

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
      session_destroy();
    }
  }

  function confirm_User() {
    session_start();
    if($_SESSION['status'] !='authorized') header("location: login.php");
  }
}


?>
