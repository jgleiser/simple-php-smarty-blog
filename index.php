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

// offset for pagination
if (!isset($_GET['offset'])) $offset = 0;
else $offset = $_GET['offset'];

// get blogs
$blogs = getBlogs(0, $offset);

$smarty->assign('blogs', $blogs[0]);
$smarty->assign('num_blogs', $blogs[1]);
$smarty->assign("offset", $offset);
$smarty->assign("prev_offset", $offset-ITEMS_PER_PAGE);
$smarty->assign("next_offset", $offset+ITEMS_PER_PAGE);
$smarty->assign("items_per_page", ITEMS_PER_PAGE);

$smarty->display("index.tpl");
?>
