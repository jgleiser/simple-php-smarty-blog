<?php
// Tags managment

// get all tags
function get_tags(){
	$query = "SELECT id, name FROM tags ORDER BY name ASC";
	$conn = open_db();
	$result = mysql_query($query);
	$data = array();
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
	}
	close_db($conn);
	return $data;
}

// Check if a tag exists
// if doesn't, return 0, else, return tag id
function tag_exists($tagname){
	$tagname = ucfirst(strtolower($tagname));
	$conn = open_db();
	$tagname = mysql_real_escape_string($tagname, $conn);
	$query = "SELECT id FROM tags WHERE name = '$tagname'";
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
		close_db($conn);
		if((int)$row['id'] > 0) return (int)$row['id'];
		else return 0;
	}
	close_db($conn);
	return 0;
}

// checks if a tag is already linked with an article
function check_article_tag_relation($articleid, $tagid){
	$query = "SELECT id FROM article_tag1 WHERE articleid = $articleid AND tagid = $tagid";
	$conn = open_db();
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Add tag to an article
// return T_TAG_EXISTS, the tag that is being added already has a relation with the article
// return T_TAG_ADDED, tag added
function add_tag($tagname, $articleid){
	$tagname = ucfirst(strtolower($tagname));
	
	$tagid = tag_exists($tagname);
	
	if(check_article_tag_relation($articleid, $tagid)) return T_TAG_EXISTS;
	
	$conn = open_db();
	$tagname = mysql_real_escape_string($tagname, $conn);
	
	// if tagid = 0, create the new tag
	if($tagid == 0){
		$query = "INSERT INTO tags (name) VALUES ('$tagname')";
		$result = mysql_query($query);
		$tagid = mysql_insert_id();
	}
	$query = "INSERT INTO article_tag1 (articleid, tagid) VALUES ($articleid, $tagid)";
	$result = mysql_query($query);
	close_db($conn);
	return T_TAG_ADDED;
}

// Add tags to an article
// Tags are passed in a string with the form "tag1 tag2 tag3 ..."
// Supports user error, like "tag1,tag2. tag3 /tag4 tag5-tag6 ..."
function addTagsToArticle($articleid, $tags){
	// separate the tags into an array
	$tagsArr = preg_split("/[\s,\.\-\/]+/", $tags, -1, PREG_SPLIT_NO_EMPTY);
	
	foreach($tagsArr as $tag) add_tag($tag, $articleid);
	
	return;
}

// Used when modding an article
// Checks if some of the tags used in an article is no longer connected
// Add new relations between tags and articles
// Keeps old relations
function modTagsInArticle($articleid, $tags){
	// separate the tags into an array
	$tagsArr = preg_split("/[\s,\.\-\/]+/", $tags, -1, PREG_SPLIT_NO_EMPTY);
	
	// Get all the tags from the article
	$currentTags = get_article_tags($articleid);
	
	// Check if any of the current tags is not in the new tags, then delete it
	foreach($currentTags as $tag){
		if(!in_array($tag['name'], $tagsArr)) delete_article_tag($articleid, $tag['id']);
	}
	
	// Add new relations
	foreach($tagsArr as $tag) add_tag($tag, $articleid);
	
	return;
}

// Delete a relation between a tag and an article
function delete_article_tag($articleid, $tagid){
	$conn = open_db();
	$query = "DELETE FROM article_tag1 WHERE articleid = $articleid AND tagid = $tagid";
	$result = mysql_query($query);
	// check if the tag doesn't have more relations with other articles
	$query = "SELECT id FROM article_tag1 WHERE tagid = $tagid LIMIT 1";
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
		if((int)$row['id'] > 0){ close_db($conn); return true; }
		else {
			// if a tag doesn't have more relations, then si not needed in the db and is deleted
			$query = "DELETE FROM tags WHERE id = $tagid";
			$result = mysql_query($query);
			close_db($conn);
			return true;
		}
	}
	return close_db($conn);
}

?>
