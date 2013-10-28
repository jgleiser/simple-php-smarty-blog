<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

// check if blogid is setted and that the blog exists
if(!isset($_GET['blogid']) || empty($_GET['blogid']) || !blogExists($_GET['blogid'])){
	header("Location: index.php");
    exit;
}
$blogid = $_GET['blogid'];

$smarty = new Smarty;


// check if user is logged and is the owner of the blog
if(isset($_SESSION['uid'])){
	$userid = $_SESSION['uid'];
	$username = $_SESSION['username'];
	$userhasblog = $_SESSION['userhasblog'];
	
	if(userIsBlogOwner($userid, $blogid)){
		$smarty->assign('userid', $userid);
		$smarty->assign('username', $username);
		$smarty->assign('userhasblog', $userhasblog);
	}
	else {
		header("Location: index.php");
		exit;
	}
	
}
else {
	header("Location: index.php");
	exit;
}

// blog data, need the ownerid and blogid
$data = getBlogData($_GET['blogid']);
$smarty->assign('blog', $data);

$smarty->display("add_article.tpl");
?>
