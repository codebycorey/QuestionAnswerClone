<?php

require_once 'classes/User.php';
$user = New User();
$user->confirm_User();

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
  <tr>
    <td><a href="displayQuestion.php?question_id=$question_id">$question_title</a></td>
  </tr>
EOD;
    }

    $result->free();
    $link->close();
?>

<!DOCTYPE html>
<html>
  <head>
  </head>

  <body>
    <p> Welcome "<?php echo $_SESSION['user_id'];?>!"
    <a href="login.php?status=loggedout">Log Out</a> </p>
    <p>
      <a href="askQuestion.php">Ask a question</a>
    </p>
    <h2>List of Questions</h2>
    <table>
      <?php echo $question_Table?>
    </table>
  </body>
</html>
