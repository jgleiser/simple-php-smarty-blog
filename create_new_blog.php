<?php
session_start();
require_once "includes/functions.php";

// check if user is logged
if(!isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}

// Check if it was called from the form
if(!isset($_POST['create'])){
	header("Location: index.php");
	exit;
}

// blogid stores the id of the new blog or an error message
$blogid = createNewBlog($_POST);

// If error code
if((int)$blogid <= 0){
	$referer = $_SERVER['HTTP_REFERER'];
	// strip previous error codes if there is any
	$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);
	header("Location: $referer?error=$blogid");
    exit;
}
// else, redirect to the blog page
else {
	$_SESSION['userhasblog'] = true; // set that the user has at least 1 blog, for the menu
	header("Location: blog.php?id=$blogid");
    exit;
}
?>
