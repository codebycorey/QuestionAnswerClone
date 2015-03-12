<?php
session_start();
include('config.php');

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$query = mysqli_query($link, "
  SELECT *
  FROM user
  WHERE id = '".$_GET['user_id']."'
  LIMIT 1");

$quesquery = mysqli_query($link, "
  SELECT *
  FROM question
  WHERE ownerid = '".$_GET['user_id']."'");

?>


<!DOCTYPE html>
<html>
<head>

  <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <p> Welcome "<?php echo $_SESSION['user_id'];?>!"
    <a href="login.php?status=loggedout">Log Out</a> </p>
    <p><a href="index.php">Home</a></p>
    <h2>User</h2>
      <?php while($row = mysqli_fetch_array($query)): ?>
      <h4><?php echo "Username: " . $row['username'];?></h4>
      <?php endwhile?>

    <h2>Asked Questions</h2>
      <?php while($row = mysqli_fetch_array($quesquery)): ?>
      <div class="question">
        <p><?php
        $url = 'displayQuestion.php?question_id=' . $row['id'];
        $site_title = $row['title'];
        echo "<a href=$url>$site_title</a>" ?></p>
      </div>
    <?php endwhile?>
    <?php mysqli_close($link);?>
</body>
</html>
