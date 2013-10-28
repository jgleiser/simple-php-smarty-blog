{include file='header.tpl'}
{include file='menu.tpl' userid=$userid username=$username blogid=$blog.id blogownerid=$blog.userid userhasblog=$userhasblog}
	<!-- CONTENT -->
      {include file='search_bar.tpl'}
	  

	  <h1 class="title">Article list</h1>
      <center>
	    {if empty($articles)}
		No articles found
		{else}
		<table class="article_list">
		  <tr>
		    <th class="article_list_th">Headline</th>
			<th class="article_list_th">Author</th>
		  </tr>
		  {foreach item=article from=$articles}
		  <tr>
		    <td class="article_list_row1"><a href="article.php?blogid={$blog.id}&id={$article.id}">{$article.headline}</a></td>
			<td class="article_list_row2">{$article.author}</td>
		  </tr>
		  {/foreach}
		</table>
{* Show links to previous/next pages *}
<p>
{if $prev_offset < 0}
  First | Previous
{else}
  <a href="view_articles.php?blogid={$blog.id }&offset=0">First</a> | <a href="view_articles.php?blogid={$blog.id }&offset={$prev_offset}">Previous</a>
{/if} |

{section name=pages start=0 loop=$num_articles step=$items_per_page}
  {if $offset == $smarty.section.pages.index}
    {$smarty.section.pages.iteration} | 
  {else}
    <a href="view_articles.php?blogid={$blog.id }&offset={$smarty.section.pages.index}">{$smarty.section.pages.iteration}</a> |
  {/if}
  
{/section}

{if $next_offset >= $num_articles}
  Next | Last
{else}
  <a href="view_articles.php?blogid={$blog.id }&offset={$next_offset}">Next</a> | <a href="view_articles.php?blogid={$blog.id }&offset={$num_articles-1}">Last</a>
{/if}
		{/if}
	  </center>
      
      
      <!-- END CONTENT -->
{include file='footer.tpl'}
