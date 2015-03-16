<?php
session_start();
include('config.php');

if($_SESSION['status'] !='authorized') {
  header("location: login.php");
  die();
}

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$question_id = $_GET['question_id'];

$query = mysqli_query($link, "
  SELECT *
  FROM question
  WHERE id = '{$question_id}'
  LIMIT 1");

function retrieve_Username($link, $id) {
  $userquery = mysqli_query($link, "
    SELECT *
    FROM user
    WHERE id = '{$id}'
    LIMIT 1");
  while($row = mysqli_fetch_array($userquery)) {
    $user = $row['username'];
  }
  return $user;
}

function Insert_Answer($ans, $question_id, $link) {

  $ownerID = $_SESSION['user_key'];

  $query = mysqli_query($link,"
    INSERT INTO answer (parentid, body, ownerid)
    VALUES ('$question_id', '$ans', '$ownerID')");
}

if($_POST && !empty($_POST['answer'])) {
  $response = Insert_Answer($_POST['answer'], $_GET['question_id'], $link);
  header("Location: displayQuestion.php?question_id=$question_id");
}

?>
<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>
  <script src="js/votescript.js"></script>
  </head>

<body>
    <nav>
      <p> Welcome "<?php echo $_SESSION['user_id'];?>!"
      <a href="login.php?status=loggedout">Log Out</a> </p>
      <p><a href="index.php">Home</a></p>
    </nav>
    <div class="container">
    <h2>Question</h2>
      <?php while($row = mysqli_fetch_array($query)): ?>
        <?php $answerid = $row['correctanswer'];?>
      <div class="item" data-postid="<?php echo $row['id'] ?>" data-score="<?php echo $row['score'] ?>"
      data-owner="<?php echo $row['ownerid'] ?>" data-user="<?php echo $_SESSION['user_key'] ?>"
      data-quesid="<?php echo $question_id ?>">
      <div class="vote-span"><!-- voting-->
        <div class="vote" data-action="up" title="Vote up">
          <i class="fa fa-chevron-up"></i>
        </div><!--vote up-->
        <div class="vote-score"><?php echo $row['score'] ?></div>
        <div class="vote" data-action="down" title="Vote down">
          <i class="fa fa-chevron-down"></i>
        </div><!--vote down-->
      </div>

      <div class="post"><!-- post data -->
      <h4><?php echo "Title: " . $row['title'];?></h4>
      <p><?php echo "Body: " . $row['body'];?></p>
      <p><?php $owner = $row['ownerid'];
               $username = retrieve_Username($link, $owner);
               $url = 'displayUser.php?user_id=' . $row['ownerid'];
               echo "User: <a href=$url>$username</a>" ;?></p>
      <p><?php echo "Date: " . $row['creationdate'];?></p>
      </div>
    </div><!--item-->
      <?php endwhile?>

    <h2>Answers</h2>
    <?php
    $ansquery = mysqli_query($link, "
      SELECT *
      FROM answer
      WHERE parentid = '{$question_id}'
      ORDER BY CASE id WHEN '{$answerid}' THEN 1 ELSE 2 END ASC, score DESC");

      while($row = mysqli_fetch_array($ansquery)): ?>
        <hr>
    <div class="item" data-postid="<?php echo $row['id'] ?>" data-score="<?php echo $row['score'] ?>"
      data-owner="<?php echo $owner ?>" data-user="<?php echo $_SESSION['user_key'] ?>"
      data-quesid="<?php echo $question_id ?>">
      <div class="vote-span"><!-- voting-->
        <div class="vote" data-action="up" title="Vote up">
          <i class="fa fa-chevron-up"></i>
        </div><!--vote up-->
        <div class="vote-score"><?php echo $row['score'] ?></div>
        <div class="vote" data-action="down" title="Vote down">
          <i class="fa fa-chevron-down"></i>
        </div><!--vote down-->
        <div class="vote" data-action="accept" title="Accept Answer">
          <i class="fa fa-check"></i>
        </div><!--vote down--><!--Accept Answer-->
      </div>

      <div class="post"><!-- post data -->
        <p><?php echo $row['body'] ?></p>
        <p><?php $username = retrieve_Username($link, $row['ownerid']);
            $url = 'displayUser.php?user_id=' . $row['ownerid'];
            echo "User: <a href=$url>$username</a>" ;?></p>
        <p><?php echo $row['creationdate'] ?></p>
      </div>
    </div><!--item-->
    <?php endwhile?>
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
      </div>
    <?php mysqli_close($link);?>
</body>
</html>
