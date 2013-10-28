<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

// check if blogid is setted and that the blog exists
if(!isset($_GET['id']) || empty($_GET['id']) || !blogExists($_GET['id'])){
	header("Location: index.php");
    exit;
}

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

// Get blog data
$data = getBlogData($_GET['id']);
$data['summary'] = nl2br($data['summary']);
$smarty->assign('blog', $data);

$articles = get_article_list($_GET['id'], -1, 5);
$smarty->assign('articles', $articles[0]);

$smarty->display("blog.tpl");
?>
