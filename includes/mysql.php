<?php
include_once 'mysql_data.php';

/* Show MySQL error. */
function show_error($conn) {
  die("Error ". mysqli_errno($conn) . " : " . mysqli_error($conn) . "<br />\n");
}


// opens de db, returns $conn for the connection data
function open_db(){
	$conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE) or die ("Error connecting to the database.<br />\n");
	//mysql_select_db(DATABASE, $conn) or show_error($conn);
	return $conn;
}

// closes de db using the given $conn resource
function close_db($conn){
	return mysqli_close($conn);
}
?>
