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
$freeze = 0;

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

function retrieve_Userscore($link, $id) {
  $scorequery = mysqli_query($link, "
    select sum(score) totalscore
    from (select score from question
    where ownerid = '$id'
    union all
    select score from answer
    where ownerid = '$id') tb");
  while($row = mysqli_fetch_array($scorequery)) {
    $score = $row['totalscore'];
  }
  return $score;
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

function find_tags($link, $question_id){
  $tagquery = mysqli_query($link, "
    SELECT id, tagname
    FROM tags
    JOIN posttags ON tags.id = posttags.tagid
    WHERE postid = '{$question_id}'");

  $taglinks = '';

  while($row = mysqli_fetch_array($tagquery)) {
    $url = 'displayTag.php?tag_id=' . $row['id'];
    $tagname = $row['tagname'];
    $taglinks .= "<a href=$url>$tagname</a> ";
  }
  return $taglinks;
}

function unfreeze($link, $quesId) {
  $unfreezequery = mysqli_query($link, "
    UPDATE question
    SET freeze = 0
    WHERE id = '{$quesId}'");
}

function freeze($link, $quesId) {
  $unfreezequery = mysqli_query($link, "
    UPDATE question
    SET freeze = 1
    WHERE id = '{$quesId}'");
}

function update_Question($link, $editbody, $quesId) {
  $updateBody = mysqli_query($link, "
    UPDATE question
    SET body = '{$editbody}'
    WHERE id = '{$quesId}'");
}

function delete_Question($link, $quesId) {
  $unfreezequery = mysqli_query($link, "
    UPDATE question
    SET removed = 1
    WHERE id = '{$quesId}'");
    if($deletequery == false) {
      echo "false";
    }
}

if($_POST && isset($_POST['delete'])) {
  delete_Question($link, $_GET['question_id']);
  header("Location: displayQuestion.php?question_id=$question_id");
}
if($_POST && !empty($_POST['answer'])) {
  $response = Insert_Answer($_POST['answer'], $_GET['question_id'], $link);
  header("Location: displayQuestion.php?question_id=$question_id");
}
if($_POST && isset($_POST['unfreeze'])) {
  $response = unfreeze($link, $_GET['question_id']);
  header("Location: displayQuestion.php?question_id=$question_id");
}
if($_POST && isset($_POST['freeze'])) {
  $response = freeze($link, $_GET['question_id']);
  header("Location: displayQuestion.php?question_id=$question_id");
}
if($_POST && isset($_POST['edit'])) {
  $_SESSION['edit'] = true;
  header("Location: displayQuestion.php?question_id=$question_id");
}
if($_POST && isset($_POST['subedit']) &&!empty($_POST['editbody'])) {
  $_SESSION['edit'] = false;
  update_Question($link, $_POST['editbody'], $_GET['question_id']);
  header("Location: displayQuestion.php?question_id=$question_id");
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>QuestionAnswer</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
    <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="css/materialize.css">
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
        <?php $answerid = $row['correctanswer'];
              $freeze = $row['freeze'];
              $delete = $row['removed']?>
    <div class="row item" data-postid="<?php echo $row['id'] ?>" data-score="<?php echo $row['score'] ?>"
      data-owner="<?php echo $row['ownerid'] ?>" data-user="<?php echo $_SESSION['user_key'] ?>"
      data-quesid="<?php echo $question_id ?>">
      <?php if($delete != 1): ?>
      <?php if($freeze == 1): ?>
        <div class="col s12 m12 center">
        <h3>QUESTION FROZEN</h3>
        </div>
      <?php endif ?>
      <div class="col s12 m2 center vote-span"><!-- voting-->
        <p><?php $owner = $row['ownerid'];
                 $username = retrieve_Username($link, $owner);
                 $url = 'displayUser.php?user_id=' . $row['ownerid'];
                 echo "<a href=$url>$username</a> " ;
                 echo retrieve_Userscore($link, $row['ownerid']);?></p>
        <img class="avatar" src="<?php avatar_src($link, $row['ownerid']);?>">
        <div class="vote" data-action="up" title="Vote up">
          <i class="fa fa-chevron-up"></i>
        </div><!--vote up-->
        <div class="vote-score"><?php echo $row['score'] ?></div>
        <div class="vote" data-action="down" title="Vote down">
          <i class="fa fa-chevron-down"></i>
        </div><!--vote down-->
      </div>

      <div class="col s12 m10 post"><!-- post data -->
        <h5><?php echo $row['title'];?></h5>
        <?php if($_SESSION['edit'] == true): ?>
        <form method="post" class="input-field">
          <div>
            <textarea type="text" name="editbody" row="50" id="editbody"><?php echo $row['body']; ?></textarea>
          </div>
        <div>
        <input type="submit" name="subedit" value="Submit">
        </div>
        </form>
        <?php endif ?>
        <?php if($_SESSION['edit'] == false ) {
         echo "<p>" . $row['body'] . "</P>" ;}?>
        <p><?php echo find_tags($link, $question_id)?></p>
        <p><?php echo $row['creationdate'];?></p>
      <?php if($_SESSION['admin']): ?>
        <form method="post">
          <input type="submit" name="edit" value="Edit"/>
          <?php if($freeze == 0) {
            echo '<input type="submit" name="freeze" value="Freeze"/>';
          } else {
            echo '<input type="submit" name="unfreeze" value="Unfreeze"/>';
          }?>
          <input type="submit" name="delete" value="Delete"/>
        </form>
      <?php endif?>
      </div>
    </div><!--item-->
  <?php endif?>
      <?php endwhile?>
    <?php if($delete != 1): ?>
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
      <div class="center col s12 m2 vote-span"><!-- voting-->
        <p><?php $username = retrieve_Username($link, $row['ownerid']);
                 $url = 'displayUser.php?user_id=' . $row['ownerid'];
                 echo "<a href=$url>$username</a> " ;
                 echo retrieve_Userscore($link, $row['ownerid']);?></p>
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

      <div class="col s12 m10 post"><!-- post data -->
        <p><?php echo $row['body'] ?></p>
        <p><?php echo $row['creationdate'] ?></p>
      </div>
    </div><!--item-->
    <?php endwhile?>
    <?php if($freeze != 1): ?>
      <h3>Post and answer to the Question</h3>
      <form method="post">
        <div>
          <label for="answer">Answer Question</label>
          <textarea type="text" name="answer" value="" id="answer" placeholder="answer"></textarea>
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
    <?php endif?>
  <?php endif?>
  <?php if($delete ==1){
    echo "<h3>QUESTION DELETED</h3>";
  }?>
      </div>
    <?php mysqli_close($link);?>
</body>
</html>
