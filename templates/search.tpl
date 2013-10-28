{include file='header.tpl'}
{include file='menu.tpl' userid=$userid username=$username blogid=$blog.id blogownerid=$blog.userid userhasblog=$userhasblog}
	<!-- CONTENT -->
      {include file='search_bar.tpl' searchmethod=$searchmethod searchquery=$searchquery}

	  <h1 class="title">Search</h1>
      <center>
	  {if empty($articles)} No articles found
	  {elseif $searchmethod == "tag" || $searchmethod == "article"}
	    <table class="article_list">
		  <tr>
		    <th class="article_list_th">Headline</th>
			<th class="article_list_th">Author</th>
		  </tr>
		  {foreach item=article from=$articles}
		  <tr>
		    <td class="article_list_row1"><a href="article.php?blogid={$article.blogid}&id={$article.id}">{$article.headline}</a></td>
			<td class="article_list_row2">{$article.author}</td>
		  </tr>
		  {/foreach}
		</table>
	  {elseif $searchmethod == "blog"}
	    <table class="article_list">
		  <tr>
		    <th class="article_list_th">Title</th>
			<th class="article_list_th">Owner</th>
		  </tr>
		  {foreach item=blog from=$articles}
		  <tr>
		    <td class="article_list_row1"><a href="blog.php?id={$blog.id}">{$blog.title}</a></td>
			<td class="article_list_row2">{$blog.author}</td>
		  </tr>
		  {/foreach}
		</table>
	  {/if}
	  </center>
      
      
      <!-- END CONTENT -->
{include file='footer.tpl'}
