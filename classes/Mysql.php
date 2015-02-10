<?php

require_once 'includes/constants.php';

class Mysql {

  function display_Table() {
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');

    $query = "SELECT id, title
              FROM question";

    $result = $link->query($query)
      or die($link->error);

    $num_questions = $result->num_rows;

    $question_Table = '';
    while($row = $result->fetch_assoc()) {
      $question_id = $row['id'];
      $question_title = $row['title'];

    $question_Table .=<<<EOD
    $question_Talbe
    <tr>
      <td><a href="displayQuestion.php?question_id=$question_id">
    </tr>
EOD;
    }

    $result->free();
    $link->close();

  }

  function Insert_Answer($ans) {
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

  function verify_Username_and_Pass($un, $pwd) {
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');

    $query = "SELECT id FROM user
            WHERE username = ? AND password = ? LIMIT 1";

    if($stmt = $link->prepare($query)) {
      $stmt->bind_param('ss', $un, $pwd);
      $stmt->bind_result($_SESSION['user_key']);
      $stmt->execute();

      if($stmt->fetch()) {
        $stmt->close();
        return true;
      } else {
      return false;
      echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
      }
    }
  }

}






?>
