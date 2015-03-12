<?php
# db configuration
define('DB_HOST',		'locahost');
define('DB_USER',		'admin');
define('DB_PASS',		'5pR1nG2OlS');
define('DB_NAME',		'questionanswer');

# db connect
function dbConnect($close=true){
	global $link;

	if (!$close) {
		mysql_close($link);
		return true;
	}

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect to MySQL DB ') . mysql_error();
	if (!mysql_select_db(DB_NAME, $link))
		return false;
}

?>
