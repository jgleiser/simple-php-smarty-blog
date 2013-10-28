<div class="search">
      <form action="search.php" method="get" name="form_search">
        Search 
        <select name="s" class="search_option">
           <option value="blog"{if empty($searchmethod) || $searchmethod == "blog"} selected="selected"{/if}>Blogs</option>
           <option value="article"{if !empty($searchmethod) && $searchmethod == "article"} selected="selected"{/if}>Articles</option>
           <option value="tag"{if !empty($searchmethod) && $searchmethod == "tag"} selected="selected"{/if}>Articles using tags</option>
        </select>
        <input class="search_text" name="text" type="text"{if !empty($searchquery)}value="{$searchquery}"{/if} />
        <input class="search_button" name="search" type="submit" value="Search" />
      </form>
      </div>
	  