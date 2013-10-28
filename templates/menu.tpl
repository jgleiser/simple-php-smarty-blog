</head>
<body marginheight="0" marginwidth="0">

<center>
<div class="container">
{if empty($userid)}
  <div class="login">
	<form action="login_check.php" method="post" name="form_login">
	  Username: <input name="username" type="text" class="login_username" maxlength="30" />
      Password: <input type="password" name="password" class="login_password" />
	  <input class="login_button" name="login" type="submit" value="Login" />
	</form>
  </div>
{else}
  <div class="logged">
    Logged in as: {$username} | <a href="logout.php" class="logout">Logout</a>
  </div>
{/if}

  <div class="header"></div>
  
  <table cellspacing="0" class="middle">
    <tr>
	  <td class="menu">
	  <!-- MENU -->
        <br />
{if empty($userid)}
		- <a class="menu-link" href="register.php">Register</a><br />
		<br />
{/if}
		- <a class="menu-link" href="index.php">View blogs</a><br />
		- <a class="menu-link" href="browse_tags.php">Browse tags</a><br />
	    - <a class="menu-link" href="doc.php">Documentation</a><br />
{if !empty($userid)}
		<br />
		User Menu<br />
		- <a class="menu-link" href="create_blog.php">Create blog</a><br />
  {if  $userhasblog}
		- <a class="menu-link" href="myblogs.php">My blogs</a><br />
  {/if}
{/if}

{if !empty($blogid)}
		<br />
		Blog Menu<br />
        - <a class="menu-link" href="view_articles.php?blogid={$blogid}">View Articles</a><br />
{/if}
{if !empty($userid) && !empty($blogid) && !empty($blogownerid) && $userid == $blogownerid}
        - <a class="menu-link" href="add_article.php?blogid={$blogid}">Add Article</a><br />
{/if}
      </td>
      <td class="menu_separator"></td>
      <td class="content">
	  