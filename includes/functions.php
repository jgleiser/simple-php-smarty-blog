<?php

// CONSTANTS
// All constants used are negative, this is because in some functions a correct output is a positive integer that represents an id
// so making them negative, there is no option that a desired output will be misunderstood by a message.

// U_ references to constants related to user management
// Code starts with 1xx
define("U_EMPTY_USERNAME", -101);
define("U_EMPTY_PASSWORD", -102);
define("U_EMPTY_NAME", -103);
define("U_EMPTY_EMAIL", -104);
define("U_EXISTS_USERNAME", -105);
define("U_EXISTS_EMAIL", -106);
define("U_WRONG_USERNAME", -107);
define("U_WRONG_PASSWORD", -108);
define("U_INVALID_EMAIL", -109);
$userInvalidMessages = array(U_EMPTY_USERNAME, U_EMPTY_PASSWORD, U_EMPTY_NAME, U_EMPTY_EMAIL, U_EXISTS_USERNAME, U_EXISTS_EMAIL, U_WRONG_USERNAME, U_WRONG_PASSWORD, U_INVALID_EMAIL);

// B_ references to constants related to blogs
// Code starts with 2xx
define("B_EMPTY_USERID", -201);
define("B_EMPTY_TITLE", -202);
define("B_EMPTY_SUMMARY", -203);
define("B_EXISTS_TITLE", -204);
$blogInvalidMessages = array(B_EMPTY_USERID, B_EMPTY_TITLE, B_EMPTY_SUMMARY, B_EXISTS_TITLE);

// A_ references to constants related to articles
// Code starts with 3xx
define("A_EMPTY_HEADLINE", -301);
define("A_EMPTY_BODY", -302);
define("A_EMPTY_USERID", -303);
define("A_EMPTY_BLOGID", -304);
define("A_EXISTS_HEADLINE", -305);
$artcleInvalidMessages = array(A_EMPTY_HEADLINE, A_EMPTY_BODY, A_EMPTY_USERID, A_EMPTY_BLOGID, A_EXISTS_HEADLINE);

// T_ references to tags
// Code starts with 5xx
define("T_TAG_EXISTS", -500);
define("T_TAG_ADDED", -501);
$tagMessages = array(T_TAG_EXISTS, T_TAG_ADDED);

// P_ references to photos
// Code starts with 6xx
define("P_PHOTO_EXISTS", -600);
define("P_PHOTO_ADDED", -601);
$photoMessages = array(P_PHOTO_EXISTS, P_PHOTO_ADDED);

// E_ references to error messages
define("E_U_EMPTY_USERNAME", "Please write a username");
define("E_U_EMPTY_PASSWORD", "Please write a password");
define("E_U_EMPTY_NAME", "Please write your name");
define("E_U_EMPTY_EMAIL", "Please write your email");
define("E_U_EXISTS_USERNAME", "Chosen username is already registered, please choose another");
define("E_U_EXISTS_EMAIL", "The email is already registered, please use another email or contact us");
define("E_U_WRONG_USERNAME", "Username is not registered, please try again");
define("E_U_WRONG_PASSWORD", "Password is incorrect");
define("E_U_INVALID_EMAIL", "Email is invalid");

// Maximum items per page for pagination
define("ITEMS_PER_PAGE", 2);

// DEFINITIONS
include_once 'includes/mysql.php';
include_once 'includes/users.php';
include_once 'includes/blogs.php';
include_once 'includes/articles.php';
include_once 'includes/tags.php';
include_once 'includes/comments.php';
include_once 'includes/search.php';
include_once 'includes/images.php';
?>
