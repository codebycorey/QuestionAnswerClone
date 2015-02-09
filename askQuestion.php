<?php
require_once 'classes/User.php';
require_once 'classes/Question.php';
$user = New User();
$user->confirm_User();
$insert = New Question();

if($_POST && !empty($_POST['title']) && !empty($_POST['description'])) {
  $response = $insert->question_Inserted($_POST['title'], $_POST['description']);
  $_SESSION['user_id'] = 'username';
} else {
  $response = "Please make sure both field are filled out";
}


?>

<!DOCTYPE html>
<html>
  <head>
  </head>

  <body>
    <p> Welcome "<?php echo $_SESSION['user_id'];?>!"
    <a href="login.php?status=loggedout">Log Out</a> </p>
    <p><a href="index.php">home</a><p>
      <form method="post" action="">
        <div>
          <label for="title">Title</label>
          <input type="text" name="title" value="" id="title" placeholder="Title">
        </div>
        <div>
          <label for="description">description</label>
          <textarea type="text" name="description" value="" id="description" placeholder="description"></textarea>
        </div>
        <div>
        <input type="submit" value="Submit">
        </div>
      </form>
      <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
  </body>
</html>
