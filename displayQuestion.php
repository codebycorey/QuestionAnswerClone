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

function avatar_src($link, $ownerid) {
  $query = mysqli_query($link, "
    SELECT avatar.filename
    FROM avatar
    LEFT JOIN user ON user.avatar_id = avatar.id
    WHERE user.id = '{$ownerid}' ");

  while($row = mysqli_fetch_array($query)){
    $imgname = $row['filename'];
  }

  $src = "avatars/".$imgname;
  echo $src;
  return $src;
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
  <link rel="stylesheet" href="css/style.css">
    <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>
  <script src="js/votescript.js"></script>
  </head>

<body>
  <nav class="lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="<?php echo 'displayUser.php?user_id=' . $_SESSION['user_key'] ?>" class="brand-logo">Welcome "<?php echo $_SESSION['user_id'];?>!"</a>
        <ul class="right">
          <li><a href="login.php?status=loggedout">Log Out</a></li>
        </ul>
        <ul class="right">
          <li><a href="askQuestion.php">Ask a question</a></li>
        </ul>
        <ul class="right">
          <li><a href="index.php">Home</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
          <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </div>
  </nav>

    <div class="container">
    <h3>Question</h3>
      <?php while($row = mysqli_fetch_array($query)): ?>
        <?php $answerid = $row['correctanswer'];?>
    <div class="row item" data-postid="<?php echo $row['id'] ?>" data-score="<?php echo $row['score'] ?>"
      data-owner="<?php echo $row['ownerid'] ?>" data-user="<?php echo $_SESSION['user_key'] ?>"
      data-quesid="<?php echo $question_id ?>">
      <div class="col s12 m1 center vote-span"><!-- voting-->
        <p><?php $owner = $row['ownerid'];
                 $username = retrieve_Username($link, $owner);
                 $url = 'displayUser.php?user_id=' . $row['ownerid'];
                 echo "<a href=$url>$username</a>" ;?></p>
        <img class="avatar" src="<?php avatar_src($link, $row['ownerid']);?>">
        <div class="vote" data-action="up" title="Vote up">
          <i class="fa fa-chevron-up"></i>
        </div><!--vote up-->
        <div class="vote-score"><?php echo $row['score'] ?></div>
        <div class="vote" data-action="down" title="Vote down">
          <i class="fa fa-chevron-down"></i>
        </div><!--vote down-->
      </div>

      <div class="col s12 m11 post"><!-- post data -->
      <h5><?php echo $row['title'];?></h5>
      <p><?php echo "Body: " . $row['body'];?></p>
      <p><?php echo "Date: " . $row['creationdate'];?></p>
      </div>
    </div><!--item-->
      <?php endwhile?>

    <h3>Answers</h3>
    <?php
    $ansquery = mysqli_query($link, "
      SELECT *
      FROM answer
      WHERE parentid = '{$question_id}'
      ORDER BY CASE id WHEN '{$answerid}' THEN 1 ELSE 2 END ASC, score DESC");

      while($row = mysqli_fetch_array($ansquery)): ?>
        <hr>
    <div class="row item" data-postid="<?php echo $row['id'] ?>" data-score="<?php echo $row['score'] ?>"
      data-owner="<?php echo $owner ?>" data-user="<?php echo $_SESSION['user_key'] ?>"
      data-quesid="<?php echo $question_id ?>" data-ansid="<?php echo $answerid?>">
      <div class="center col s12 m1 vote-span"><!-- voting-->
        <p><?php $username = retrieve_Username($link, $row['ownerid']);
          $url = 'displayUser.php?user_id=' . $row['ownerid'];
          echo "<a href=$url>$username</a>" ;?></p>
        <img class="avatar" src="<?php avatar_src($link, $row['ownerid']);?>">
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

      <div class="col s12 m11 post"><!-- post data -->
        <p><?php echo $row['body'] ?></p>
        <p><?php echo $row['creationdate'] ?></p>
      </div>
    </div><!--item-->
    <?php endwhile?>
      <h3>Post and answer to the Question</h3>
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
