<?php
session_start();
require_once 'includes/smarty_dir.php';
require_once SMARTY_INCL_DIR;
require_once "includes/functions.php";

$smarty = new Smarty;

// check if user is logged
if(isset($_SESSION['uid'])){
	header("Location: index.php");
	exit;
}
else {
	$smarty->assign('userid', 0);
	$smarty->assign('username', 0);
	$smarty->assign('userhasblog', false);
}

$smarty->display("register.tpl");
?>
