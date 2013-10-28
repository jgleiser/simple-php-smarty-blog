{include file='header.tpl'}
<script type="text/javascript" src="javascript/user_register_validation.js"></script>
{include file='menu.tpl' userid=$userid username=$username userhasblog=$userhasblog}
	<!-- CONTENT -->
      {include file='search_bar.tpl'}
	  

	  <h1 class="title">Register</h1>
	  <form action="register_new_user.php" method="post" name="form_register_user" onsubmit="return checkform(this);">
        <table class="ru_create_table">
		  <tr>
		    <td class="ru_menu">Username:</td>
			<td><input type="text" name="username" class="ru_text_input" /></td>
		  </tr>
		  <tr>
		    <td class="ru_menu">Password:</td>
			<td><input type="password" name="password" class="ru_text_input" /></td>
		  </tr>
		  <tr>
		    <td class="ru_menu">Real name:</td>
			<td><input type="text" name="name" class="ru_text_input" /></td>
		  </tr>
		  <tr>
		    <td class="ru_menu">Email:</td>
			<td><input type="text" name="email" class="ru_text_input" /></td>
		  </tr>
		  <tr>
		    <td class="ru_menu">&nbsp;</td>
			<td class="ru_register"><input type="submit" name="register" value="Register" class="ru_register_input" /></td>
		  </tr>
		  
		</table>
      </form>
	  
      
      
      <!-- END CONTENT -->
{include file='footer.tpl'}
