<?php

require_once 'includes/constants.php';
require_once 'classes/User.php';
require_once 'classes/Mysql.php';
$user = New User();
$user->confirm_User();

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

function retrieve_Username($link, $id) {
$userQuery = "SELECT * FROM user
          WHERE id = $id";
$userResult = $link->query($userQuery)
  or die($link->error);
while($row = $userResult->fetch_assoc()) {
  $user = $row['username'];
}
return $user;
} // End of retrieve_Username


$query = "SELECT * FROM question
          WHERE id ='" . $_GET['question_id'] . "'";

$result = $link->query($query)
  or die($link->error);

  while($row = $result->fetch_assoc()) {
    $question_id = $row['id'];
    $question_title = $row['title'];
    $question_body = $row['body'];
    $asker = retrieve_Username($link ,$row['ownerid']);
    $creationdate = $row['creationdate'];

$question_Table = '';
$question_Table .=<<<EOD
    <tr><td><strong>Title: </strong>$question_title</td></tr>
    <tr><td><strong>Body: </strong>$question_body</td></tr>
    <tr><td><strong>User: </strong>$asker</td></tr>
    <tr><td><strong>Date: </strong>$creationdate</td></tr>
EOD;
}

$query3 = "SELECT * FROM answer
          WHERE parentid ='" . $_GET['question_id'] . "'";

$result3 = $link->query($query3)
  or die($link->error);

$num_answers = $result3->num_rows;

$answer_Table = '';
while($row = $result3->fetch_assoc()) {
    $answer_id = $row['id'];
    $answer_body = $row['body'];
    $ansowner = retrieve_Username($link, $row['ownerid']);
    $anscreationdate = $row['creationdate'];

if($num_answers > 1) {
$answer_Table .=<<<EOD
    <table>
    <tr><td><strong>Body: </strong>$answer_body</td></tr>
    <tr><td><strong>User: </strong>$ansowner</td></tr>
    <tr><td><strong>Date: </strong>$anscreationdate</td></tr>
    </table>
    <hr>
EOD;
} else {
$answer_Table .=<<<EOD
    <table>
    <tr><td><strong>Body: </strong>$answer_body</td></tr>
    <tr><td><strong>User: </strong>$ansowner</td></tr>
    <tr><td><strong>Date: </strong>$anscreationdate</td></tr>
    <table>
EOD;
}
}

function Insert_Answer($ans, $question_id) {
  $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
    die('There was a problem connecting to the database');

  $ownerID = $_SESSION['user_key'];

  $query = "INSERT INTO answer (parentid, body, ownerid)
            VALUES ('$question_id', '$ans', '$ownerID')";

  if(mysqli_query($link, $query)) {
    return true;
  } else {
    return false;
    echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
  }
}

if($_POST && !empty($_POST['answer'])) {
  $response = Insert_Answer($_POST['answer'], $question_id);
  header("Location: displayQuestion.php?question_id=$question_id");
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
      <a href="index.php">Home</a>
    </p>
      <h2>Question</h2>
      <table><?php echo $question_Table?></table>
      <hr>
      <h2>Answers</h2>
      <?php echo $answer_Table?>
      <h2>Post and answer to the Question</h2>
      <form method="post" action="">
        <div>
          <label for="answer">Answer Question</label>
          <textarea type="text" name="answer" value="" id="answer" placeholder="answer"></textarea>
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
  </body>
</html>
