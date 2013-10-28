<?php
include_once 'mysql_data.php';

/* Show MySQL error. */
function show_error() {
  die("Error ". mysql_errno() . " : " . mysql_error() . "<br />\n");
}


// opens de db, returns $conn for the connection data
function open_db(){
	$conn = mysql_connect(HOST, USER, PASSWORD) or die ("Error connecting to the database.<br />\n");
	mysql_select_db(DATABASE, $conn) or show_error();
	return $conn;
}

// closes de db using the given $conn resource
function close_db($conn){
	return mysql_close($conn);
}
?>
