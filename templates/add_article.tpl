{include file='header.tpl'}
<script type="text/javascript" src="javascript/art_add_upd_validation.js"></script>
{include file='menu.tpl' userid=$userid username=$username blogid=$blog.id blogownerid=$blog.userid userhasblog=$userhasblog}
<!-- CONTENT -->
      {include file='search_bar.tpl'}
      
	  <h1 class="title">Add article</h1>
	  
	  <form action="add_new_article.php" method="post" name="form_add_article" onsubmit="return checkform(this);">
	  <table cellspacing="0" class="upd_table">
	    <tr>
		  <td class="upd_table_title">Headline</td>
		  <td class="upd_table_input"><input type="text" name="headline" class="upd_input_text"></td>
		</tr>
		<tr>
		  <td class="upd_table_title">Body</td>
		  <td class="upd_table_input"><textarea name="article_body" class="upd_input_textarea"></textarea></td>
		</tr>
		<tr>
		  <td class="upd_table_title">Tags<br /><span style="font-size:9px;font-weight:100;">separate with space</span></td>
		  <td class="upd_table_input"><input type="text" name="tags" class="upd_input_text"></td>
		</tr>
        <tr>
          <td colspan="2" class="upd_table_submit"><input name="add" type="submit" value="Add article" class="upd_input_submit"></td>
        </tr>
	  </table>
	  <input type="hidden" name="blogid" value="{$blog.id}" />
	  <input type="hidden" name="userid" value="{$userid}" />
      </form>
	  
      <!-- END CONTENT -->
{include file='footer.tpl'}
