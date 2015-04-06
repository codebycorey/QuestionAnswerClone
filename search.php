<?php
include('config.php');
# start new session
session_start();

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$term = strip_tags(substr($_POST['searchit'],0, 100));
$term = mysql_escape_string($term); // Attack Prevention

if($term=="")
  echo "";
else{
  $query = mysqli_query($link,"
      select id, username
      from user
      where username like '{$term}%'");

  $string = '';

  if (mysqli_num_rows($query)){
    while($row = mysqli_fetch_array($query)){
      $url = 'displayUser.php?user_id=' . $row['id'];
      $username = $row['username'];
      $class = "search";
      $string .= "<a class=$class href=$url>$username</a>";
      $string .= "<br/>\n";
    }
  }
  echo $string;
}
?>
