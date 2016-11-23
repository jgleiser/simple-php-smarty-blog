<?php
// Article managment

// Get all the articles of one blog
function get_article_list($blogid, $offset = 0, $limit = 0){
	$items_per_page = ITEMS_PER_PAGE;
	$conn = open_db();
	$query = "SELECT SQL_CALC_FOUND_ROWS a.id AS id, a.headline AS headline, u.name AS author FROM articles AS a, users AS u WHERE u.id = a.userid AND a.blogid = ".(int)$blogid." ORDER BY id DESC";
	if((int)$offset >= 0) $query .= " LIMIT $offset, $items_per_page";
	else if((int)$offset < 0 && (int)$limit > 0) $query .= " LIMIT $limit";
	$result = mysqli_query($conn, $query);
	$list = array();
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
	}
	
	// Get total number of articles
	$result2 = mysqli_query($conn, "SELECT FOUND_ROWS()");
	$row = mysqli_fetch_array($result2);
	$rows_found = $row[0];
	
	close_db($conn);
	return array($list, $rows_found);
}

// Get the id of the newest article from a blog (only 1)
function get_article_newest($blogid){
	$query = "SELECT id FROM articles WHERE blogid = ".(int)$blogid." ORDER BY id DESC LIMIT 1";
	$conn = open_db();
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	close_db($conn);
	return (int)$row['id'];
}

// Get the details of one article given his id
function get_article_detail($articleid){
	$query = "SELECT a.id AS id, a.headline AS headline, a.userid AS userid, u.name AS author, article_body AS article_body, a.blogid AS blogid, DATE_FORMAT(a.created, '%d/%m/%Y %H:%i') AS created FROM articles AS a, users AS u WHERE u.id = a.userid AND a.id = ".(int)$articleid;
	$conn = open_db();
	$result = mysqli_query($conn, $query);
	if($result){
		$row = mysqli_fetch_assoc($result);
	}
	close_db($conn);
	return $row;
}

// Get all the tags from one article given his id
function get_article_tags($articleid){
	$query = "SELECT tag.id AS id, tag.name AS name FROM tags AS tag, article_tag1 WHERE tag.id = article_tag1.tagid AND article_tag1.articleid = ".(int)$articleid;
	$conn = open_db();
	$result = mysqli_query($conn, $query);
	$data = array();
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row;
		}
	}
	close_db($conn);
	return $data;
}

// Check if an article headline exists in a blog
function articleHeadlineExists($blogid, $headline, $articleid = 0){
	$conn = open_db();
	$headline = mysqli_real_escape_string($conn, $headline) or show_error($conn);
	$query = "SELECT id FROM articles WHERE blogid = ".(int)$blogid." AND headline = '$headline'";
	if((int)$articleid > 0) $query .= " AND id != ".(int)$articleid;
	$result = mysqli_query($conn, $query);
	if($result){
		$row = mysqli_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Inserts a new article to the db, $data is for the $_POST variable, returns de id of the new article.
function add_article($data){
	// retrieve data
	$headline = $data['headline'];
	$article_body = $data['article_body'];
	$userid = $data['userid'];
	$blogid = $data['blogid'];
	$tags = $data['tags'];
	
	// check that there is no missing data
	if(empty($headline)) return A_EMPTY_HEADLINE;
	if(empty($article_body)) return A_EMPTY_BODY;
	if(empty($userid)) return A_EMPTY_USERID;
	if(empty($blogid)) return A_EMPTY_BLOGID;
	
	// check if the article headline exists in the blog
	if(articleHeadlineExists($blogid, $headline)) return A_EXISTS_HEADLINE;
	
	$conn = open_db();
	
	// escape strings before the querys
	$headline = mysqli_real_escape_string($conn, $headline) or show_error($conn);
	$article_body = mysqli_real_escape_string($conn, $article_body) or show_error($conn);
	
	$query = "INSERT INTO articles (headline, userid, article_body, blogid) VALUES ('$headline', ".(int)$userid.", '$article_body', ".(int)$blogid.")";
	$result = mysqli_query($conn, $query);
	$id = mysqli_insert_id($conn);
	close_db($conn);
	
	// if the article was correctly inserted, create the tags
	if($id > 0) addTagsToArticle($id, $tags);
	
	return $id;
}

// Updates an existing article in the db, $data is for $_POST
function mod_article($articleid, $data){
	// retrieve data
	$headline = $data['headline'];
	$article_body = $data['article_body'];
	$blogid = $data['blogid'];
	$tags = $data['tags'];
	
	// check that there is no missing data
	if(empty($headline)) return A_EMPTY_HEADLINE;
	if(empty($article_body)) return A_EMPTY_BODY;
	if(empty($blogid)) return A_EMPTY_BLOGID;
	
	// check if the article headline exists in the blog
	if(articleHeadlineExists($blogid, $headline, $articleid)) return A_EXISTS_HEADLINE;
	
	$conn = open_db();
	
	// escape strings before the querys
	$headline = mysqli_real_escape_string($conn, $headline) or show_error($conn);
	$article_body = mysqli_real_escape_string($conn, $article_body) or show_error($conn);
	
	$query = "UPDATE articles SET headline = '$headline', article_body = '$article_body' WHERE id = ".(int)$articleid;
	$result = mysqli_query($conn, $query);
	
	// if the update was successful, mod the tags
	$checkTags = false;
	if($result) $checkTags = true;
	
	close_db($conn);
	
	if($checkTags) modTagsInArticle($articleid, $tags);
	
	return $result;
}

// Deletes an article from the db
function delete_article($articleid){
	// get all tags related to the article and delete the relation
	// this helps to delete tags that won't be used anymore by any article
	// for better description, check delete_article_tag function on tags.php
	$tags = get_article_tags($articleid);
	foreach($tags as $tag){
		delete_article_tag($articleid, $tag['id']);
	}
	// same as above but with photos
	$photos = getArticleImages($articleid);
	foreach ($photos as $photo){
		delete_article_photo($articleid, $photo['id']);
	}
	
	$conn = open_db();
	$query = "DELETE FROM articles WHERE id = ".(int)$articleid;
	$result = mysqli_query($conn, $query);
	close_db($conn);
	return $result;
}

// check for previous and next articles in one blog
// this function is used to create the previous and next links in the article details page so the user can browse between them
function check_prev_next_article($articleid){
	$conn = open_db();
	
	// Get the blogid from the article
	$query = "SELECT blogid FROM articles WHERE id = ".(int)$articleid;
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$blogid = $row['blogid'];
	
	// to get previous id
	$query1 = "SELECT id FROM articles WHERE blogid = $blogid AND id < ".(int)$articleid." ORDER BY id DESC LIMIT 1";
	// to get next id
	$query2 = "SELECT id FROM articles WHERE blogid = $blogid AND id > ".(int)$articleid." ORDER BY id ASC LIMIT 1";
	
	$result1 = mysqli_query($conn, $query1);
	$result2 = mysqli_query($conn, $query2);
	$row1 = mysqli_fetch_assoc($result1);
	$row2 = mysqli_fetch_assoc($result2);
	
	close_db($conn);
	
	$data = array();
	// store prev
	if((int)$row1['id'] > 0) $data['prev'] = $row1['id'];
	else $data['prev'] = 0;
	// store next
	if((int)$row2['id'] > 0) $data['next'] = $row2['id'];
	else $data['next'] = 0;
	
	return $data;
}

?>
