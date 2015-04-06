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
  $quesId = mysqli_insert_id($link);
  if(!empty($_POST['tags'])) {
    insert_Tags($link, $_POST['tags'], $quesId);
  }
}

function insert_Tags($link, $tags, $quesId) {
  echo $quesId;
  $tagArray = preg_split('/\s+/', $tags);
  for($i = 0; $i < count($tagArray); $i++) {
    $query = mysqli_query($link, "
      INSERT INTO tags (tagname)
      VALUES ('{$tagArray[$i]}')");

    $query2 = mysqli_query($link, "
      INSERT INTO posttags
      SELECT '{$quesId}', id
      FROM tags
      WHERE tagname = '$tagArray[$i]'");
    if($query2 == false) {
      echo 'false';
    }
  }
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
      <div class="nav-wrapper"><a id="logo-container" href="<?php echo 'displayUser.php?user_id=' . $_SESSION['user_key'] ?>" class="brand-logo">Welcome "<?php echo $_SESSION['user_id'];?>!"</a>
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
  <div id="display_results"></div>
    <h2>Ask a Question</h2>
    <div class="col s12 m12">
      <form method="post">
        <div>
          <input type="text" name="title" value="" id="title" placeholder="Title">
        </div>
        <div>
          <textarea type="text" name="description" value="" id="description" placeholder="description"></textarea>
        </div>
        <div>
          <input type="text" name="tags" value="" id="tags" placeholder="Tags">
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
  </div></div>
</body>
</html>
