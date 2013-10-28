<?php
session_start();
require_once "includes/functions.php";

// check if a logged user is trying to access this script
if(isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}

// Check that the script is called from the form
if(!isset($_POST['register'])){
	header("Location: index.php");
	exit;	
}

$referer = $_SERVER['HTTP_REFERER'];
// strip error codes if there is any
$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);

$userid = regiterNewUser($_POST);

// If error at registering the user
if((int)$userid <= 0){
	header("Location: $referer?error=$userid");
    exit;
}

// Store the info in session variables and login the user
session_unset();
$_SESSION['uid'] = $userid;
$userdata = getUserData($userid);
$_SESSION['username'] = $userdata['username'];
// Check if user has at least 1 blog and save it in another session var
$_SESSION['userhasblog'] = userHasBlog($userid);

// Redirect to index
header("Location: index.php");
exit;



?>
