{include file='header.tpl'}
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
      <h1 class="title">{$details.headline|escape}</h1>
      <div class="article">
        {$details.article_body}
      </div>
	  {if !empty($photos)}
	  <br />
	  <div class="photos">
	    {foreach item=photo from=$photos}
  		<img src="get_image.php?id={$photo.id}" {$photo.imagesize} alt="{$photo.imagename}"> 
		{/foreach}
	  </div>
	  {/if}
      <br />
      <div class="author"><em>by {$details.author|escape}</em></div>
	  <div class="art_date ">{$details.created|escape}</div>
      <div class="tags">Tags: {if empty($tags)}none{/if}{foreach item=tag from=$tags}<a href="search.php?s=tag&id={$tag.id}">{$tag.name}</a> {/foreach}</div>
      <br />
	  
	  <h4>Add a comment</h4>
	  {if empty($userid)}
	  <p>You need to be logged to write a comment</p>
	  {else}
	  <form action="add_comment.php" method="post">
	    <table>
		  <tr>
		    <td class="comments_title">Title</td>
			<td><input type="text" name="title" class="comment_title_input" /></td>
		  </tr>
		  <tr>
		    <td class="comments_title">Comment</td>
			<td><textarea name="comment_text" class="comment_text_input"></textarea></td>
		  </tr>
		  <tr>
		    <td>&nbsp;</td>
			<td><input type="submit" name="add" value="Add comment" /></td>
		  </tr>
		</table>
		<input type="hidden" name="userid" value="{$userid}" />
		<input type="hidden" name="articleid" value="{$details.id}" />
	  </form>
	  {/if}
	  
	  {if !empty($comments)}
	  {foreach item=comment from=$comments}
	  <div class="comments">
	    Comment by <strong>{$comment.author}</strong> on {$comment.created}<br />
		<strong>{$comment.title}</strong><br />
		{$comment.comment_text}
	  </div>
	  {/foreach}
	  <br />
	  {/if}
      <center>
      <table class="table_prev_next">
        <tr>
          <td class="table_prev_opt">{if $prev_next.prev > 0}<a href="article.php?blogid={$blog.id}&id={$prev_next.prev}">{/if}Previous{if $prev_next.prev > 0}</a>{/if}</td>
		  <td class="table_next_opt">{if $prev_next.next > 0}<a href="article.php?blogid={$blog.id}&id={$prev_next.next}">{/if}Next{if $prev_next.prev > 0}</a>{/if}</td>
        </tr>
      </table>
      </center>
      <!-- END CONTENT -->
{include file='footer.tpl'}
