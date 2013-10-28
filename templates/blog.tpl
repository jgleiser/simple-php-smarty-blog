{include file='header.tpl'}
{include file='menu.tpl' userid=$userid username=$username blogid=$blog.id blogownerid=$blog.userid userhasblog=$userhasblog}
	<!-- CONTENT -->
      {include file='search_bar.tpl'}
	  

	  <h1 class="title">{$blog.title}</h1>
	  <p>
	   {$blog.summary}
	  </p>
	  <div class="author"><em>by {$blog.author|escape}</em></div>
	  <div class="art_date ">{$blog.created|escape}</div>
	  <h2 class="subtitle">Newest articles</h2>
	  <p>
	    {if empty($articles)}No articles found{/if}
		{foreach item=article from=$articles}
		- <a href="article.php?blogid={$blog.id}&id={$article.id}">{$article.headline}</a> by {$article.author}<br />
		{/foreach}
	  </p>
	  
      
      
      <!-- END CONTENT -->
{include file='footer.tpl'}
