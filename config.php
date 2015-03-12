<?php
# db configuration 
define('DB_HOST',		'locahost');
define('DB_USER',		'root');
define('DB_PASS',		'root');
define('DB_NAME',		'mydb');

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