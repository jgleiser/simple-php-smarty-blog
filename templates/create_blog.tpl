{include file='header.tpl'}
<script type="text/javascript" src="javascript/blog_add_validation.js"></script>
{include file='menu.tpl' userid=$userid username=$username userhasblog=$userhasblog}
	<!-- CONTENT -->
      {include file='search_bar.tpl'}
	  

	  <h1 class="title">Create Blog</h1>
	  <form action="create_new_blog.php" method="post" name="form_create_blog" onsubmit="return checkform(this);">
        <table class="cb_create_table">
          <tr>
            <td class="cb_menu">Blog Title:</td>
            <td><input name="title" type="text" maxlength="80" class="cb_title_input" /></td>
          </tr>
          <tr>
            <td class="cb_menu">Summary:</td>
            <td><textarea name="summary" cols="" rows="" class="cb_summary_input"></textarea></td>
          </tr>
          <tr>
		    <td>&nbsp;</td>
            <td class="cb_create"><input name="create" type="submit" value="Create" class="cb_create_input" /></td>
          </tr>
        </table>
        <input name="userid" type="hidden" value="{$userid}" />
      </form>
	  
      
      
      <!-- END CONTENT -->
{include file='footer.tpl'}
