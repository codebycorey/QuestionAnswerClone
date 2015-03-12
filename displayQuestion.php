<?php
session_start();
include('config.php');

if($_SESSION['status'] !='authorized') {
  header("location: login.php");
  die();
}

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$query = mysqli_query($link, "
  SELECT *
  FROM question
  WHERE id = '".$_GET['question_id']."'
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

$ansquery = mysqli_query($link, "
  SELECT *
  FROM answer
  WHERE parentid = '" . $_GET['question_id'] . "'");

?>
<!DOCTYPE html>
<html>
<head>

  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="js/votescript.js"></script>
  </head>

<body>
    <p> Welcome "<?php echo $_SESSION['user_id'];?>!"
    <a href="login.php?status=loggedout">Log Out</a> </p>
    <p><a href="index.php">Home</a></p>
    <h2>Question</h2>
      <?php while($row = mysqli_fetch_array($query)): ?>
      <h4><?php echo "Title: " . $row['title'];?></h4>
      <p><?php echo "Body: " . $row['body'];?></p>
      <p><?php $username = retrieve_Username($link, $row['ownerid']);
               $url = 'displayUser.php?user_id=' . $row['ownerid'];
      echo "User: <a href=$url>$username</a>" ;?></p>
      <p><?php echo "Date: " . $row['creationdate'];?></p>
      <?php endwhile?>

    <h2>Answers</h2>
      <?php while($row = mysqli_fetch_array($ansquery)): ?>
        <hr>
    <div class="item" data-postid="<?php echo $row['id'] ?>" data-score="<?php echo $row['score'] ?>">
      <p><?php echo $row['id'] ?></p>
      <div class="vote-span"><!-- voting-->
        <div class="vote" data-action="up" title="Vote up">
          <i class="icon-chevron-up"></i>
        </div><!--vote up-->
        <div class="vote-score"><?php echo $row['score'] ?></div>
        <div class="vote" data-action="down" title="Vote down">
          <i class="icon-chevron-down"></i>
        </div><!--vote down-->
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
    <?php mysqli_close($link);?>
</body>
</html>
