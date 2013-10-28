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
if(!isset($_POST['upload'])){
	header("Location: index.php");
	exit;
}

// Upload the photo
$articleid = $_POST['articleid'];
$image = $_FILES['imagefile'];
$result = addImageToArticle($articleid, $image);

$referer = $_SERVER['HTTP_REFERER'];
// strip previous error codes if there is any
$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);

// Redirect to referer
header("Location: $referer");
exit;
?>
