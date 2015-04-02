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
  SELECT id, title
  FROM question");


function insert_Question($link, $title, $description) {
  $ownerID = $_SESSION['user_key'];
  $query = mysqli_query($link, "
    INSERT INTO question (title, body, ownerid)
    VALUES ('{$title}', '{$description}', '{$ownerID}') ");
}



if($_POST && !empty($_POST['title']) && !empty($_POST['description'])) {
  insert_Question($link, $_POST['title'], $_POST['description']);
} else {
  $response = "Please make sure both field are filled out";
}


?>

<!DOCTYPE html>
<html>
<head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
      <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css">
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>

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
      <form method="post" action="">
        <div>
          <input type="text" name="title" value="" id="title" placeholder="Title">
        </div>
        <div>
          <textarea type="text" name="description" value="" id="description" placeholder="description"></textarea>
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
  </div>
</body>
</html>
