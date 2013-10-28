<?php
session_start();
require_once "includes/functions.php";

// check if user is logged
if(!isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}

// check that blogid, articleid and photoid are setted
if(!isset($_GET['blogid']) || !isset($_GET['articleid']) || !isset($_GET['photoid'])){
	header("Location: index.php");
	exit;
} 

// check that user is owner of the blog where is adding the article
if(!userIsBlogOwner($_SESSION['uid'], $_GET['blogid'])){
	header("Location: index.php");
	exit;
}


// Delete the photo
$articleid = $_GET['articleid'];
$photoid = $_GET['photoid'];
delete_article_photo($articleid, $photoid);

$referer = $_SERVER['HTTP_REFERER'];
// strip previous error codes if there is any
$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);

// Redirect to referer
header("Location: $referer");
exit;
?>
