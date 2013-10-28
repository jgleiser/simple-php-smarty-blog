<?php
session_start();
require_once "includes/functions.php";

// check if user is logged
if(!isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}

// Check if it was called from the form
if(!isset($_POST['add'])){
	header("Location: index.php");
	exit;
}

// add comment
$id = addComment($_POST);

// redirect
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
exit;
?>
