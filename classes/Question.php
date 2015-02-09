<?php

require_once 'Mysql.php';


class Question {

  //Makes sure user is in the database
  function question_Inserted($title, $description) {
    $mysql = New Mysql();
    $no_error = $mysql->insert_Question($title, $title);

    if($no_error) {;
      return "Record added successfully.";
    } else return "Please fix your question";

  }
}


?>
