<?php

// Define constants here

define('DB_SERVER', 'localhost');
define('DB_USER', 'admin');
define('DB_PASSWORD', '5pR1nG2OlS');
define('DB_NAME', 'questionanswer');

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
      die('There was a problem connecting to the database');

?>
