<?php

require_once 'includes/constants.php';

class Mysql {

  function insert_Question($title, $description) {

    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');

    $query = "INSERT INTO question (title, body, ownerid)
              VALUES ('$title', '$description', '1')";

    if(mysqli_query($link, $query)) {
      return true;
      } else {
      return false;
      echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
    }

  }

  function verify_Username_and_Pass($un, $pwd) {

    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');

    $query = "select * FROM user
            WHERE username = $un AND password = $pwd
            LIMIT 1";

    if(mysqli_query($link, $query)) {
      return true;
      } else {
      return false;
      echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
    }
  }

}






?>
