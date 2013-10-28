<?php
session_start();
require_once "includes/functions.php";

// check if user is logged
if(!isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}

// delete comment
$result = delComment($_GET['commentid'], $_GET['$userid']);

// redirect
$referer = $_SERVER['HTTP_REFERER'];
// strip previous error codes if there is any
$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);

header("Location: $referer");
exit;
?>
