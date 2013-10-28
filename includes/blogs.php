<?php
// Check if a blog exists in the database
function blogExists($blogid){
	$conn = open_db();
	$query = "SELECT id FROM blogs WHERE id = ".(int)$blogid;
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Check if a blog title is already registered
function blogTitleExists($title){
	$conn = open_db();
	$title = mysql_real_escape_string($title, $conn) or show_error();
	$query = "SELECT id FROM blogs WHERE title = '$title'";
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Create a new blog
// If created, the blogid is returned
function createNewBlog($data){
	// retrieve data
	$userid = $data['userid'];
	$title = $data['title'];
	$summary = $data['summary'];
	
	// check that there is no missing data
	if(empty($userid)) return B_EMPTY_USERID;
	if(empty($title)) return B_EMPTY_TITLE;
	if(empty($summary)) return B_EMPTY_SUMMARY;
	
	// check if the desired title is already used by another blog
	if(blogTitleExists($title)) return B_EXISTS_TITLE;
	
	$conn = open_db();
	
	// escape strings before the querys
	$title = mysql_real_escape_string($title, $conn) or show_error();
	$summary = mysql_real_escape_string($summary, $conn) or show_error();
	
	// register the user to the db
	$query = "INSERT INTO blogs (userid, title, summary) VALUES (".(int)$userid.", '$title', '$summary')";
	$result = mysql_query($query);
	$id = mysql_insert_id();
	close_db($conn);
	return $id;
}

// Delete a blog
function deleteBlog($blogid){
	$conn = open_db();
	$query = "DELETE FROM blogs WHERE id = ".(int)$blogid;
	$result = mysql_query($query);
	close_db($conn);
	return $result;
}

// Get data from a blog
function getBlogData($blogid){
	$conn = open_db();
	$query = "SELECT b.id AS id, b.userid AS userid, u.name AS author, b.title AS title, b.summary AS summary, DATE_FORMAT(b.created, '%d/%m/%Y %H:%i') AS created FROM blogs AS b, users AS u WHERE u.id = b.userid AND b.id = ".(int)$blogid;
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	return $row;
}

// Check if an userid is owner of the blog
function userIsBlogOwner($userid, $blogid){
	$conn = open_db();
	$query = "SELECT id FROM blogs WHERE userid = ".(int)$userid." AND id = ".(int)$blogid;
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
	}
	close_db($conn);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Get all the blogs, option to specific user
function getBlogs($userid = 0, $offset = 0){
	$items_per_page = ITEMS_PER_PAGE;
	$conn = open_db();
	
	$query = "SELECT SQL_CALC_FOUND_ROWS DISTINCT b.id AS id, b.userid AS userid, u.name AS author, b.title AS title FROM blogs AS b, users AS u WHERE b.userid = u.id";
	if((int)$userid > 0) $query .= " AND b.userid = ".(int)$userid;
	$query .= " ORDER BY b.id DESC LIMIT $offset, $items_per_page";
	
	$result = mysql_query($query);
	$list = array();
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$list[] = $row;
		}
	}
	
	// Get total number of articles
	$result2 = mysql_query("SELECT FOUND_ROWS()");
	$row = mysql_fetch_array($result2);
	$rows_found = $row[0];
	
	close_db($conn);
	return array($list, $rows_found);
}

?>
