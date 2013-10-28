<?php
// Check if a username exists in the database
function usernameExists($username){
	$conn = open_db();
	$username = mysql_real_escape_string($username, $conn) or show_error();
	$query = "SELECT id FROM users WHERE username = '$username'";
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Check if an email exists in the database
function emailExists($email){
	$conn = open_db();
	$email = mysql_real_escape_string($email, $conn) or show_error();
	$query = "SELECT id FROM users WHERE email = '$email'";
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Converts the password to a hash string
function hashPwd($password){
	$password = addslashes($password);
	$password = sha1($password);
	return $password;
}

// Check if email is valid
function validEmail($email){
	if(empty($email)) return false;
	// NOT SUPPORTED IN DWARF
	//if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
	return true;
}

// Register a new user
// If registered, the userid is returned
function regiterNewUser($data){
	// retrieve data
	$username = $data['username'];
	$password = $data['password'];
	$name = $data['name'];
	$email = $data['email'];
	
	// check that there is no missing data
	if(empty($username)) return U_EMPTY_USERNAME;
	if(empty($password)) return U_EMPTY_PASSWORD;
	if(empty($name)) return U_EMPTY_NAME;
	if(empty($email)) return U_EMPTY_EMAIL;
	
	// check if the email is valid
	if(!validEmail($email)) return U_INVALID_EMAIL;
	
	// check if the desired username or email are already registered in the db
	if(usernameExists($username)) return U_EXISTS_USERNAME;
	if(emailExists($email)) return U_EXISTS_EMAIL;
	
	// converts the password to a hash string
	$password = hashPwd($password);
	
	$conn = open_db();
	
	// escape strings before the querys
	$username = mysql_real_escape_string($username, $conn) or show_error();
	$password = mysql_real_escape_string($password, $conn) or show_error();
	$name = mysql_real_escape_string($name, $conn) or show_error();
	$email = mysql_real_escape_string($email, $conn) or show_error();
	
	// register the user to the db
	$query = "INSERT INTO users (username, password, name, email) VALUES ('$username', '$password', '$name', '$email')";
	$result = mysql_query($query);
	$id = mysql_insert_id();
	close_db($conn);
	return $id;
}

// Check the info of a login user
function checkLogin($username, $password){
	// converts the password to a hash string
	$password = hashPwd($password);
	
	$conn = open_db();
	
	// escape strings before the querys
	$username = mysql_real_escape_string($username, $conn) or show_error();
	$password = mysql_real_escape_string($password, $conn) or show_error();
	
	$query = "SELECT id, password FROM users WHERE username = '$username'";
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	
	// If something doesn't match
	if((int)$row['id'] <= 0) return U_WRONG_USERNAME;
	if($row['password'] != $password) return U_WRONG_PASSWORD;
	
	// Everything ok, return the id
	return (int)$row['id'];
}

// get user data with id
function getUserData($userid){
	$conn = open_db();
	$query = "SELECT username, name, email FROM users WHERE id = ".(int)$userid;
	$result = mysql_query($query);
	$row = array();
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	
	return $row;
}

// Check if user has at least 1 blog
function userHasBlog($userid){
	$conn = open_db();
	$query = "SELECT id FROM blogs WHERE userid = ".(int)$userid;
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] > 0) return true;
	return false;
}
?>
