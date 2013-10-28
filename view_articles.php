<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

// check for blog id
if(!isset($_GET['blogid'])){
	header("Location: index.php");
	exit;
}

// Need to setup a blogid for the dynamic menu
if(empty($_GET['blogid'])) $blogid = 0;
else $blogid = $_GET['blogid'];

// offset for pagination
if (!isset($_GET['offset'])) $offset = 0;
else $offset = $_GET['offset'];

// get all articles
$articles = get_article_list($blogid, $offset);

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

// blog data, need the ownerid and blogid
$data = getBlogData($blogid);
$smarty->assign('blog', $data);

$smarty->assign('articles', $articles[0]);
$smarty->assign('num_articles', $articles[1]);
$smarty->assign("offset", $offset);
$smarty->assign("prev_offset", $offset-ITEMS_PER_PAGE);
$smarty->assign("next_offset", $offset+ITEMS_PER_PAGE);
$smarty->assign("items_per_page", ITEMS_PER_PAGE);

$smarty->display("view_articles.tpl");

?>
