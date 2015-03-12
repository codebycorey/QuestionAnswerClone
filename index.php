<?php
session_start();
if($_SESSION['status'] !='authorized') {
  header("location: login.php");
  die();
}

?>

<!DOCTYPE html>
<html>
  <head>
  </head>

  <body>
    <p> Welcome "<?php echo $_SESSION['user_id'];?>!"
    <a href="login.php?status=loggedout">Log Out</a> </p>
  </body>
</html>
