<?php
session_start();
require_once "includes/functions.php";

// check if user is logged
if(!isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}

// check that user is owner of the blog where is adding the article
if(!userIsBlogOwner($_SESSION['uid'], $_POST['blogid'])){
	header("Location: index.php");
	exit;
}

// Check if it was called from the form
if(!isset($_POST['update'])){
	header("Location: index.php");
	exit;
}

// Update the article, $result can get an error code
$result = mod_article((int)$_POST['articleid'], $_POST);

// If error code
if((int)$result <= 0){
	$referer = $_SERVER['HTTP_REFERER'];
	// strip previous error codes if there is any
	$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);
	header("Location: $referer?error=$result");
    exit;
}
// else, redirect to the article page
else {
	header("Location: article.php?blogid=".(int)$_POST['blogid']."&id=".(int)$_POST['articleid']);
    exit;
}
?>
