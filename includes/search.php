<?php
// Search functions

// Get articles with a given tag id
function get_article_list_tagid($tagid, $limit = 0){
	$query = "SELECT DISTINCT a.id AS id, a.headline AS headline, a.userid AS userid, u.name AS author, a.blogid AS blogid FROM articles AS a, article_tag1 AS at, users AS u WHERE a.userid = u.id AND a.id = at.articleid AND at.tagid = ".(int)$tagid." ORDER BY id DESC";
	if($limit > 0) $query .= " LIMIT $limit";
	$conn = open_db();
	$result = mysql_query($query);
	$list = array();
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$list[] = $row;
		}
	}
	close_db($conn);
	return $list;
}

// Search for articles with a string containing tags
function search_articles_with_tag($string, $limit = 0){
	$conn = open_db();
	$string = mysql_real_escape_string($string, $conn);
	$query = "SELECT DISTINCT a.id AS id, a.headline AS headline, a.userid AS userid, u.name AS author, a.blogid AS blogid FROM articles AS a, article_tag1 AS at, users AS u, tags AS t WHERE a.userid = u.id AND a.id = at.articleid AND t.id = at.tagid AND t.name LIKE '%$string%' ORDER BY id DESC";
	if($limit > 0) $query .= " LIMIT $limit";
	$result = mysql_query($query);
	$list = array();
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$list[] = $row;
		}
	}
	close_db($conn);
	return $list;
}

// Normal article search function (looks for headlines and bodys)
// if $blogid = 0, search in every blog, else, search in specific blog
function search_articles($string, $blogid = 0){
	$conn = open_db();
	$string = mysql_real_escape_string($string, $conn);
	$query = "SELECT DISTINCT a.id AS id, a.headline AS headline, a.userid AS userid, u.name AS author, a.blogid AS blogid FROM articles AS a, users AS u";
	$query .= " WHERE u.id = a.userid AND ((a.headline LIKE '%$string%') OR (a.article_body LIKE '%$string%'))";
	if($blogid > 0) $query .= " AND a.blogid = ".(int)$blogid;
	$query .= " ORDER BY a.id DESC";
	$result = mysql_query($query);
	$list = array();
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$list[] = $row;
		}
	}
	close_db($conn);
	return $list;
}

// Normal blog search function (looks for headline and summary)
function search_blogs($string){
	$conn = open_db();
	$string = mysql_real_escape_string($string, $conn);
	$query = "SELECT DISTINCT b.id AS id, b.userid AS userid, b.title AS title, u.name AS author, b.summary AS summary FROM blogs AS b, users AS u";
	$query .= " WHERE u.id = b.userid AND ((b.title LIKE '%$string%') OR (b.summary LIKE '%$string%'))";
	$query .= " ORDER BY b.id DESC";
	$result = mysql_query($query);
	$list = array();
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$list[] = $row;
		}
	}
	close_db($conn);
	return $list;
}
?>
