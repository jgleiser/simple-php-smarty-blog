<?php
session_start();
require_once "includes/functions.php";

// check if user is logged
if(!isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}

// check that user is owner of the blog where is adding the article
if(!userIsBlogOwner($_SESSION['uid'], $_GET['blogid'])){
	header("Location: index.php");
	exit;
}

// check for article id
if(!isset($_GET['id'])){
	header("Location: index.php");
	exit;
}

// delete article
$articleid = $_GET['id'];
delete_article($articleid);
header("Location: view_articles.php?blogid=".(int)$_GET['blogid']);
exit;

?>
