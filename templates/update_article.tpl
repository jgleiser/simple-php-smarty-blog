{include file='header.tpl'}
<script type="text/javascript" src="javascript/art_add_upd_validation.js"></script>
<script type="text/javascript" src="javascript/checkDel.js"></script>
{include file='menu.tpl' userid=$userid username=$username blogid=$blog.id blogownerid=$blog.userid userhasblog=$userhasblog}
<!-- CONTENT -->
{include file='search_bar.tpl'}
      <br />
      {if $userid == $blog.userid}
      <div class="options">
        <a href="update_article.php?blogid={$blog.id|escape}&id={$details.id|escape}">Update article</a> | <a href="javascript:void(0)" onclick="javascript:checkDelArticle({$blog.id|escape}, {$details.id|escape})">Delete article</a>
      </div>
	  {/if}
      <h2 class="subtitle">Article details</h2>
      <form action="update_article_action.php" method="post" name="form_update" onsubmit="return checkform(this);">
	  <table cellspacing="0" class="upd_table">
	    <tr>
		  <td class="upd_table_title">Headline</td>
		  <td class="upd_table_input"><input type="text" name="headline" value="{$details.headline|escape}" class="upd_input_text"></td>
		</tr>
		<tr>
		  <td class="upd_table_title">Body</td>
		  <td class="upd_table_input"><textarea name="article_body" class="upd_input_textarea">{$details.article_body|escape}</textarea></td>
		</tr>
		<tr>
		  <td class="upd_table_title">Tags<br /><span style="font-size:9px;font-weight:100;">separate with space</span></td>
		  <td class="upd_table_input"><input type="text" name="tags" class="upd_input_text" value="{foreach item=tag from=$tags}{$tag.name} {/foreach}"></td>
		</tr>
        <tr>
          <td colspan="2" class="upd_table_submit"><input name="update" type="submit" value="Update article" class="upd_input_submit" /></td>
        </tr>
	  </table>
	  <input type="hidden" name="blogid" value="{$blog.id}" />
	  <input type="hidden" name="articleid" value="{$details.id|escape}" />
	  <input type="hidden" name="userid" value="{$userid}" />
      </form>
	  <br />
      <hr />
      <h2 class="subtitle">Manage photos</h2>
      <form action="update_article_add_photo.php" method="post" enctype="multipart/form-data" name="form_up_photo">
      <p>
  		<span class="upd_photo_title">Upload photo</span>
        <input type="file" name="imagefile" value="Image file" size="30">
  		<input type="submit" name="upload" value="Upload image">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <input type="hidden" name="blogid" value="{$blog.id}" />
	    <input type="hidden" name="articleid" value="{$details.id|escape}" />
	    <input type="hidden" name="userid" value="{$userid}" />
      </p>
      </form>
      <p>
{if empty($photos)}
        No photos found
{else}
		{foreach item=photo from=$photos name=list}
		<div style="float:left;margin:5px;">
		  <img src="get_image.php?id={$photo.id}" {$photo.imagesize} alt="{$photo.imagename}"><br />
		  <a href="update_article_del_photo.php?blogid={$blog.id}&articleid={$details.id}&photoid={$photo.id}">Delete photo</a>
		</div>
		{if $smarty.foreach.list.iteration % 3 == 0}
		<div style="clear: both;"></div>
		{elseif $smarty.foreach.list.last && $smarty.foreach.list.iteration % 3 != 0}
		<div style="clear: both;"></div>
		{/if}
		{/foreach}
{/if}
      </p>
	  
	  <hr />
      <h2 class="subtitle">Manage comments</h2>
	  
	  {if empty($comments)}
	  <p>No comments found</p>
	  {else}
	  {foreach item=comment from=$comments}
	  <div class="comments">
	    Comment by <strong>{$comment.author}</strong> on {$comment.created}<br />
		<strong>{$comment.title}</strong><br />
		{$comment.comment_text}<br />
		<a href="del_comment.php?userid={$userid}&commentid={$comment.id}">Delete</a>
	  </div>
	  {/foreach}
	  <br />
	  {/if}
      
	  <p>
	    <a href="article.php?blogid={$blog.id|escape}&id={$details.id|escape}">Back to article</a>
	  </p>

      <!-- END CONTENT -->
{include file='footer.tpl'}
