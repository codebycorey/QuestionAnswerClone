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
    <p>test page</p>
    <a href="login.php?status=loggedout">Log Out</a>
  </body>
</html>
