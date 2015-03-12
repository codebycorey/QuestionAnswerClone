<?php
/**
 * jQuery Voting System
 * @link http://www.w3bees.com/2013/09/voting-system-with-jquery-php-and-mysql.html
 */
require_once 'includes/constants.php';
# start new session
#
if ($_SERVER['HTTP_X_REQUESTED_WITH']) {
	if (isset($_POST['postid']) AND isset($_POST['action'])) {
		$postId = (int) mysql_real_escape_string($_POST['postid']);
		# check if already voted, if found voted then return
		# connect mysql db
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');
		# query into db table to know current voting score
		$query = "SELECT score
			from answer
			WHERE id = $postId
			LIMIT 1";

		# increase or dicrease voting score
		if (mysqli_query($link, $query)) {
			if ($_POST['action'] === 'up'){
				$score = ++$data['score'];
			} else {
				$score = --$data['score'];
			}
			# update new voting score
			$query2 = "UPDATE answer
				SET score = $score
				WHERE id = $postId";

			mysqli_query($link, $query2);

			# set session with post id as true
			# close db connection
			return true;
		}
	}
}
?>
