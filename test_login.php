<?php
if (!isset($_SESSION['userid'])) session_start();
include_once 'includes/functions.php';

if(isset($_POST['register'])){
	$uid = regiterNewUser($_POST);
	if(in_array($uid, $userInvalidMessages)) echo "Error $uid<br />\n";
}

if(isset($_POST['login'])){
	$uid = checkLogin($_POST['username'], $_POST['password']);
	if(in_array($uid, $userInvalidMessages)) echo "Error $uid<br />\n";
	else {
		$_SESSION['userid'] = $uid;
		$userdata = getUserData($uid);
		$_SESSION['username'] = $userdata['username'];
		$_SESSION['name'] = $userdata['name'];
		$_SESSION['email'] = $userdata['email'];
	}
}

if(isset($_GET['logout'])){
	session_unset();
	echo "<script type='text/javascript'>window.location.replace(\"test_login.php\");</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login test</title>
</head>
<body>

<h3>FORM 1: REGISTER USER</h3>
<form action="test_login.php" method="post" name="form_register">
<p>
  Username: <input name="username" type="text" /><br />
  Password: <input name="password" type="password" /><br />
  Email: <input name="email" type="text" /><br />
  Name: <input name="name" type="text" /><br />
  <input name="register" type="submit" value="Register" />
</p>
</form>
<hr />
<h3>FORM 2: LOGIN</h3>
<form action="test_login.php" method="post" name="form_login">
<p>
  Username: <input name="username" type="text" /><br />
  Password: <input name="password" type="password" /><br />
  <input name="login" type="submit" value="Login" />
</p>
</form>
<hr />
<h3>LOGGED USER DATA</h3>
<p>
  <?php
  if(isset($_SESSION['userid'])){
  	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$name = $_SESSION['name'];
	$email = $_SESSION['email'];
  }
  ?>
  Userid: <?php echo $userid; ?><br />
  Username: <?php echo $username; ?><br />
  Name: <?php echo $name; ?><br />
  Email: <?php echo $email; ?><br />
  <br />
  <a href="test_login.php?logout">Logout</a>
</p>
<hr />
<h3>RANDOM TEST</h3>

</body>
</html>
