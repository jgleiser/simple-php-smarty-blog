<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

// check if blogid is setted and that the blogid exists
if(!isset($_GET['blogid']) || empty($_GET['blogid']) || !blogExists($_GET['blogid'])){
	header("Location: index.php");
    exit;
}

// check for articleid, if is not valid, gets the newest article from the blog
if(!isset($_GET['id'])) $id = get_article_newest($_GET['blogid']);
else $id = $_GET['id'];

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

// get article details
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
// check for prev and next articles
$prev_next = check_prev_next_article($id);

$details['article_body'] = nl2br($details['article_body']);

// blog data, need the ownerid and blogid
$data = getBlogData($_GET['blogid']);
$smarty->assign('blog', $data);

$smarty->assign('details', $details);
$smarty->assign('tags', $tags);
$smarty->assign('photos', $photos);
$smarty->assign('comments', $comments);
$smarty->assign('prev_next', $prev_next);
$smarty->display("article.tpl");

?>
