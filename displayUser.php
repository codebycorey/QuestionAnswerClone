<?php
session_start();
include('config.php');

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$query = mysqli_query($link, "
  SELECT *
  FROM user
  WHERE user.id = '".$_GET['user_id']."'
  LIMIT 1");

$quesquery = mysqli_query($link, "
  SELECT *
  FROM question
  WHERE ownerid = '".$_GET['user_id']."'");

$scorequery = mysqli_query($link, "
  select sum(score) totalscore
  from (select score from question
  where ownerid = '".$_GET['user_id']."'
  union all
  select score from answer
  where ownerid = '".$_GET['user_id']."') tb");
while($row = mysqli_fetch_array($scorequery)) {
  $score = $row['totalscore'];
}

function get_gravatar( $email, $s = 200, $d = 'mm', $r = 'g', $img = false) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    return $url;
}

function avatar_src($link, $ownerid) {
  $query = mysqli_query($link, "
    SELECT email, avatar_type, avatar.filename
    FROM avatar
    LEFT JOIN user ON user.avatar_id = avatar.id
    WHERE user.id = '{$ownerid}' ");

  while($row = mysqli_fetch_array($query)){
    if($row['avatar_type'] == 0) {
      $imgname = $row['filename'];
      $src = "avatars/".$imgname;
      echo $src;
    }
    if($row['avatar_type'] == 1){
      $src = get_gravatar($row['email']);
      echo $src;
    }
  }
}

function changeAvatarType($link, $user, $type) {
  $query = mysqli_query($link, "
    UPDATE user
    SET avatar_type = '$type'
    WHERE id = '$user'");
}

function deleteAvatar($link, $user) {
  $query = mysqli_query($link, "
    UPDATE user
    SET avatar_type = 0, avatar_id = 0
    WHERE id = '$user'");
}

if($_POST && isset($_POST['website'])) {
  $user = $_GET['user_id'];
  changeAvatarType($link, $user, 0);
  header("Location: displayUser.php?user_id=$user");
}
if($_POST && !empty($_POST['gravatar'])) {
  $user = $_GET['user_id'];
  changeAvatarType($link, $user, 1);
  header("Location: displayUser.php?user_id=$user");
}

if($_POST && !empty($_POST['remove'])) {
  $user = $_GET['user_id'];
  deleteAvatar($link, $user);
  header("Location: displayUser.php?user_id=$user");
}


?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>QuestionAnswer</title>
    <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="css/materialize.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>
  <script src="js/search.js"></script>
</head>

<body>
  <nav class="lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="#" class="brand-logo">Welcome "<?php echo $_SESSION['user_id'];?>!"</a>
        <form class="right" id="searchform" method="post">
            <input type="text" name="search_query" id="search_query" size="24" placeholder="Who are you looking for?"/>
        </form>
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
  <div id="display_results"></div>
    <h2>User</h2>
      <?php while($row = mysqli_fetch_array($query)): ?>
      <h4><?php echo $row['username'] . " " . $score; ?></h4>
      <h4>Avatar</h4>
      <img src="<?php avatar_src($link, $_GET['user_id'])?>">
      <?php endwhile?>
    <?php if($_SESSION['user_key'] === $_GET['user_id']): ?>
      <h4>Change avatar</h4>
      <form method="post">
        <input type="submit" name="website" value="Uploaded"/>
        <input type="submit" name="gravatar" value="Gravatar"/>
        <input type="submit" name="remove" value="Remove Avatar"/>
      </form>
      <br/>
      <form enctype="multipart/form-data" action="fileupload.php" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000">
        File: <input name="userfile" type="file">
        <input type="submit" value="Upload!">
      </form>
    <?php endif; ?>
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
  </div>
</body>
</html>
