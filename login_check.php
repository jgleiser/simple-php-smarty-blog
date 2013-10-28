<?php
session_start();
require_once "includes/functions.php";

// Check if it was called with the login button
if(!isset($_POST['login'])){
	header("Location: index.php");
	exit;
}

$username = $_POST['username'];
$password = $_POST['password'];
$referer = $_SERVER['HTTP_REFERER'];

// If username is empty then go back and do nothing (accidental click)
if(empty($username)){
	header("Location: $referer");
    exit;
}

// Check the login
// $login has the userid or the error code depending if the username or password is invalid
$login = checkLogin($username, $password);

// strip error codes if there is any
$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);

if((int)$login <= 0){
	// check if $referer has another get var
	if(preg_match("/\\?/", $referer)){
	  header("Location: $referer&error=$login");
      exit;
	}
	else {
	  header("Location: $referer?error=$login");
      exit;
	}
}

// Store the info in session variables
session_unset();
$_SESSION['uid'] = $login;
$_SESSION['username'] = $username;
// Check if user has at least 1 blog and save it in another session var
$_SESSION['userhasblog'] = userHasBlog($login);

// Redirect to referer
header("Location: $referer");
exit;
?>
