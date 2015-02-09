<?php

require_once 'classes/User.php';
$user = New User();
$user->confirm_User();

?>

<!DOCTYPE html>
<html>
  <head>
  </head>

  <body>
    <p> Welcome "<?php echo $_SESSION['user_id'];?>!"
    <a href="login.php?status=loggedout">Log Out</a> </p>
    <p>
      <a href="askQuestion.php">Ask a question</a>
    </p>
  </body>
</html>
