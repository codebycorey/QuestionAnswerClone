<?php
/**
 * jQuery Voting System
 * @link http://www.w3bees.com/2013/09/voting-system-with-jquery-php-and-mysql.html
 */

include('config.php');
# start new session
session_start();
    $postId = $_POST['postid'];
    $quesId = $_POST['quesid'];
    echo $_POST['postid'];
    echo $_POST['postid'];
    # check if already voted, if found voted then return
   // if (isset($_SESSION['vote'][$postId])) return;
    # connect mysql db
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');
    # query into db table to know current voting score

  if($_POST['action'] === 'accept'){
    $query = mysqli_query($link, "
      UPDATE question
      SET correctanswer = '{$postId}'
      WHERE id = '{$quesId}'");
  } else {

    $query = mysqli_query($link, "
      SELECT score
      FROM answer
      WHERE id = '{$postId}'
      LIMIT 1");

    # increase or dicrease voting score
    if ($data = mysqli_fetch_array($query)) {
      if ($_POST['action'] === 'up'){
        $score = ++$data['score'];
      } else {
        $score = --$data['score'];
      }
      # update new voting score

      mysqli_query($link, "
        UPDATE answer
        SET score = '{$score}'
        WHERE id = '{$postId}' ");

      # set session with post id as true
      $_SESSION['vote'][$postId] = true;
      # close db connection
      mysqli_close($link);
    }
  }
?>
