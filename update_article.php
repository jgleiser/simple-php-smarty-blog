<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

// check if id is set
if(!isset($_GET['id'])){
	header("Location: index.php");
	exit;
}
else $id = $_GET['id'];

// check if blogid is setted and that the blogid exists
if(!isset($_GET['blogid']) || empty($_GET['blogid']) || !blogExists($_GET['blogid'])){
	header("Location: index.php");
    exit;
}
else $blogid = $_GET['blogid'];

$smarty = new Smarty;

// check if user is logged
if(isset($_SESSION['uid'])){
	$userid = $_SESSION['uid'];
	$username = $_SESSION['username'];
	$userhasblog = $_SESSION['userhasblog'];
	// check that the logged user is the owner
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

$details = get_article_detail($id);
$tags = get_article_tags($id);
$photos = getArticleImages($id);
$comments = getComments($id);
if(!empty($comments)){
	$i=0;
	foreach($comments as $comment){
		$comments[$i++]['comment_text'] = nl2br($comment['comment_text']);
	}
}

// blog data, need the ownerid and blogid
$data = getBlogData($blogid);
$smarty->assign('blog', $data);

$smarty->assign('details', $details);
$smarty->assign('tags', $tags);
$smarty->assign('photos', $photos);
$smarty->assign('comments', $comments);
$smarty->display("update_article.tpl");

?>
