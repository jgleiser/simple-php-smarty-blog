<?php
/*
This code will unset all the session variables, clean the url of error messages if needed
and redirect to the page refered
*/
session_start();
session_unset();
$referer = $_SERVER['HTTP_REFERER'];
// strip error codes if there is any
$referer = preg_replace("/([&\\?]?)(error=)([-+]\\d+)/", "", $referer);
header("Location: $referer");
exit;
?>
