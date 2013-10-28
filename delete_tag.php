<?php
require_once "includes/functions.php";

// check for article id and tag id
if(!isset($_GET['artid']) || !isset($_GET['tagid'])){
	header("Location: index.php");
	exit;
}
else {
	$articleid = $_GET['artid'];
	$tagid = $_GET['tagid'];
	delete_article_tag($articleid, $tagid);
	header("Location: manage_tags.php?id=$articleid");
	exit;
}
?>
