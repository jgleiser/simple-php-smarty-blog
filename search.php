<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

// check that GET[s] equals tag, article or blog
if(!isset($_GET['s']) || empty($_GET['s']) || ($_GET['s']!="tag" && $_GET['s']!="article" && $_GET['s']!="blog")){
	header("Location: index.php");
	exit;
}

// check the search method
// search by tag id
if(isset($_GET['s']) && $_GET['s'] == "tag" && isset($_GET['id'])){
	$articles =  get_article_list_tagid($_GET['id'], 0);
}
// search by tag name
else if(isset($_GET['s']) && $_GET['s'] == "tag" && isset($_GET['text']) && $_GET['text'] != ""){
	$articles =  search_articles_with_tag($_GET['text']);
}
// search articles by headline or body (general search)
else if(isset($_GET['s']) && $_GET['s'] == "article" && isset($_GET['text']) && $_GET['text'] != ""){
	$articles = search_articles($_GET['text']);
}
// search blogs by title or summary
else if(isset($_GET['s']) && $_GET['s'] == "blog" && isset($_GET['text']) && $_GET['text'] != ""){
	$articles = search_blogs($_GET['text']);
}
else $articles = array();

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

$smarty->assign('articles', $articles);
$smarty->assign('searchmethod', $_GET['s']);
if(isset($_GET['text'])) $smarty->assign('searchquery', $_GET['text']);
$smarty->display("search.tpl");

?>