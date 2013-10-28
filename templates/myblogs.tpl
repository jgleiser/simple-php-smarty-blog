{include file='header.tpl'}
{include file='menu.tpl' userid=$userid username=$username userhasblog=$userhasblog}
	<!-- CONTENT -->
      {include file='search_bar.tpl'}
	  

	  <h1 class="title">My blogs</h1>
	  <p>
	    {if empty($blogs)}No blogs found{/if}
		{foreach item=blog from=$blogs}
		- <a href="blog.php?id={$blog.id}">{$blog.title}</a><br />
		{/foreach}
	  </p>
	  
      
      
      <!-- END CONTENT -->
{include file='footer.tpl'}
