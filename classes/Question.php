<?php

require_once 'includes/constants.php';

class Question {

  //Makes sure user is in the database
  function question_Inserted($title, $description) {
    $no_error = $this->insert_Question($title, $title);

    if($no_error) {
      return "Record added successfully.";
    } else return "Please make sure both field are filled out";

  }

  function insert_Question($title, $description) {
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');
    $ownerID = $_SESSION['user_key'];
    $query = "INSERT INTO question (title, body, ownerid)
              VALUES ('$title', '$description', '$ownerID')";
    if(mysqli_query($link, $query)) {
      return true;
      } else {
      return false;
      echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
    }
  }
}


?>
