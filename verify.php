<?php
session_start();
include('config.php');

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$message = "";

if(isset($_GET['email']) && !empty($_GET['email']) &&  isset($_GET['hash']) && !empty($_GET['hash'])){
  $email = mysql_escape_string($_GET['email']); // Set email variable
  $hash = mysql_escape_string($_GET['hash']); // Set hash variable
  $query = mysqli_query($link, "
    SELECT email, hash, verified
    FROM user
    WHERE email = '{$email}'
    AND hash = '{$hash}'
    LIMIT 1");
  if(mysqli_num_rows($query) == 1) {
    $update = mysqli_query($link, "
      UPDATE user
      SET verified = 1
      WHERE email = '{$email}'
      AND hash = '{$hash}'");
    $message = "You are now verified";
  } else {
    $message = "Second Query messed up";
  }
} else {
  $message = "Link is messed up";
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
      <div class="nav-wrapper">
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

  <div class="container row">
  <?php echo "<h1>".$message."</h1>";
        echo "<p>".$email."</p>";?>
  </div>
</body>
</html>
