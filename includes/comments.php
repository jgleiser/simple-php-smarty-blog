<?php
// Add comments, $data y for the $_POST variable
// returns the id of the comment
function addComment($data){
	$conn = open_db();
	// escape strings
	$title = mysql_real_escape_string($_POST['title'], $conn) or show_error();
	$comment_text = mysql_real_escape_string($_POST['comment_text'], $conn) or show_error();
	// do query
	$query = "INSERT INTO comments (title, userid, comment_text, articleid) VALUES ('$title', ".(int)$_POST['userid'].",'$comment_text' ,".(int)$_POST['articleid'].")";
	$result = mysql_query($query);
	$id = mysql_insert_id();
	close_db($conn);
	
	return $id;
}

// Check if a given comment is in an article that belongs to an userid
function commentBelongsToUsersArticle($commentid, $userid){
	$conn = open_db();
	$query = "SELECT c.id AS id FROM comments AS c, articles AS a WHERE c.articleid = a.id AND a.userid = ".(int)$userid;
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] == (int)$userid) return true;
	return false;
}

// Delete comment
// $userid is the id of the user that is author of the article that has a comment
function delComment($commentid, $userid){
	// Check if a given comment is in an article that belongs to the userid
	if(!commentBelongsToUsersArticle($commentid, $userid)){
		return false;
	}
	$conn = open_db();
	$query = "DELETE FROM comments WHERE id = ".(int)$commentid;
	$result = mysql_query($query);
	close_db($conn);
	return $result;
}

// Get all the comments from an article
function getComments($articleid){
	$conn = open_db();
	$query = "SELECT c.id AS id, c.title AS title, u.name AS author, c.comment_text AS comment_text, DATE_FORMAT(c.created, '%d/%m/%Y %H:%i') AS created FROM comments AS c, users AS u WHERE u.id = c.userid AND c.articleid = ".(int)$articleid." ORDER BY c.id DESC";
	$result = mysql_query($query);
	$list = array();
	while($row =  mysql_fetch_assoc($result)){
		$list[] = $row;
	}
	close_db($conn);
	return $list;
}

?>
