<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

$smarty = new Smarty;

// check if user is logged
if(isset($_SESSION['uid'])){
	$userid = $_SESSION['uid'];
	$username = $_SESSION['username'];
	$userhasblog = $_SESSION['userhasblog'];
	$smarty->assign('userid', $userid);
	$smarty->assign('username', $username);
	$smarty->assign('userhasblog', $userhasblog);
}
else {
	header("Location: index.php");
	exit;
}

$smarty->display("create_blog.tpl");
?>
