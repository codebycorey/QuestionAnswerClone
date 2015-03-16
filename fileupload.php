<?php
session_start();
include('config.php');

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$user = $_SESSION['user_key'];

function insert_Filename($link, $file) {
  $insertquery = mysqli_query($link, "
    INSERT INTO avatar (filename)
    VALUES ('{$file}')");
}

function update_User($link, $file, $user) {
  $selectquery = mysqli_query($link, "
    SELECT id
    FROM avatar
    WHERE filename = '{$file}'");

  while($row = mysqli_fetch_array($selectquery)) {
    $avatarid = $row['id'];
    echo $avatarid;
  }

  $updatequery = mysqli_query($link, "
    UPDATE user
    SET avatar_id = '{$avatarid}'
    WHERE id = '{$user}' ");
}

$img = "avatars/".$_FILES['userfile']['name'];
$file = $_FILES['userfile']['name'];

$t=0;
while(file_exists($img)) {
  $img = "avatars/".$_FILES['userfile']['name'];
  $img = substr($img,0,strpos($img,"."))."_$t".strstr($img,".");
  $file = $_FILES['userfile']['name'];
  $file = substr($file,0,strpos($file,"."))."_$t".strstr($file,".");
  $t++;
}

if(move_uploaded_file($_FILES['userfile']['tmp_name'], $img)) {
  insert_Filename($link, $file);
  if(update_User($link, $file, $user)){
    print "succes";
  }

}
mysqli_close($link);
header("Location: displayUser.php?user_id=$user");
?>
