{include file='header.tpl'}
{include file='menu.tpl' userid=$userid username=$username blogid=$blog.id blogownerid=$blog.userid userhasblog=$userhasblog}
<!-- CONTENT -->
      {include file='search_bar.tpl'}

	  <h1 class="title">Browse Tags</h1>
      <center>
	  {if empty($tags)} No tags found
	  {else}
	    <table class="tags_list">
		  {foreach item=tag from=$tags name=list}
		  {if $smarty.foreach.list.iteration % 3 == 1}
		  <tr>
		  {/if}
		    <td class="tags_list_row"><a href="search.php?s=tag&id={$tag.id}">{$tag.name}</a></td>
		  {if $smarty.foreach.list.iteration % 3 == 0}
		  </tr>
		  {elseif $smarty.foreach.list.last && $smarty.foreach.list.iteration % 3 != 0}
		  </tr>
		  {/if}
		  {/foreach}
		</table>
	  {/if}
	  </center>
      
      
      <!-- END CONTENT -->
{include file='footer.tpl'}
