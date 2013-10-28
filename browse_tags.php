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
	$smarty->assign('userid', 0);
	$smarty->assign('username', 0);
	$smarty->assign('userhasblog', false);
}

// get tags
$tags = get_tags();
$smarty->assign('tags', $tags);

$smarty->display("browse_tags.tpl");
?>
