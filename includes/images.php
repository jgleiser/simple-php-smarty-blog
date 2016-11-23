<?php

// Max image size
define("MAX_WIDTH", 200);
define("MAX_HEIGHT", 200);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// THIS AREA IS TO SEPARATE BIG FUNCTIONS FROM THE REST FOR EASIER READING /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Resize image into a width-height rectangle using GD library.
// function modified from http://dwarf.ict.griffith.edu.au/~rwt/examples/gb-image/show.php?file=includes/defs.php
function resize_image_file($src_file, $dst_file, $width, $height){
  // Compute new dimensions
  list($width_orig, $height_orig) = getimagesize($src_file);
    
  $ratio_orig = $width_orig/$height_orig;
  
  if ($width/$height > $ratio_orig) {
     $width = $height*$ratio_orig;
  } else {
     $height = $width/$ratio_orig;
  }
  
  // Resample $srcfile
  $image_p = imagecreatetruecolor($width, $height);
  $image = imagecreatefromjpeg($src_file);
  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
  
  // Output resized image to $dst_file
  imagejpeg($image_p, "$dst_file", 100);
}


// Process uploaded JPEG image file, resizing if necessary.
// Requires a world-writable "uploads/images" subdirectory, and over-writes file images/tmp.jpg.
// If the file is fine, return an array with (data, name, type, size).
// Otherwise, return NULL.
// function modified from http://dwarf.ict.griffith.edu.au/~rwt/examples/gb-image/show.php?file=includes/defs.php
function process_uploaded_image_file($image){
  // Check upload succeeded
  if (!is_uploaded_file($image['tmp_name']) || $image['size'] == 0) {
    return NULL;
  } 

  // Extract details
  $imagedata = addslashes(file_get_contents($image['tmp_name']));
  $imagename = addslashes(basename($image['name']));
  $imagesize = getimagesize($image['tmp_name']); // an array
  $imagewidthheight = addslashes($imagesize[3]); 
  $imagetype = $imagesize['mime'];

  // Check file is a JPEG
  if ($imagetype != "image/jpeg") {
    return NULL;
  }

  // Resize uploaded JPEG file, if necessary
  // (shouldn't reuse name tmp.jpg repeatedly)
  if ($imagesize[0] > MAX_WIDTH || $imagesize[1] > MAX_HEIGHT) {

      resize_image_file($image['tmp_name'], "uploads/images/tmp.jpg", MAX_WIDTH, MAX_HEIGHT);
      list($width,$height) = getimagesize("uploads/images/tmp.jpg");
      $imagedata = addslashes(file_get_contents("uploads/images/tmp.jpg"));
      $imagewidthheight = "width=\"$width\" height=\"$height\"";
  }

  return array($imagedata, $imagename, $imagetype, $imagewidthheight);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// END OF BIG AREA /////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Check if an image already exists in the DB
// Return 0 if doesn't exists
// Return the id of the image if exists
function imageExists($imagedata){
	$conn = open_db();
	$query = "SELECT id FROM photos WHERE imagedata = '$imagedata' LIMIT 1";
	$result = mysqli_query($conn, $query);
	if($result) $row = mysqli_fetch_assoc($result);
	close_db($conn);
	if(empty($row) || (int)$row['id'] <= 0) return 0;
	else return (int)$row['id'];
}

// Adds a new image to the site and db
// function modified from http://dwarf.ict.griffith.edu.au/~rwt/examples/gb-image/show.php?file=includes/defs.php
function addImage($image){
	$image_details = process_uploaded_image_file($image);
	if(empty($image_details)) return 0;
	list($imagedata, $imagename, $imagetype, $imagewidthheight) = $image_details;
	
	// check if the added image already exists in the db
	// if yes, return the image id
	$existentid = imageExists($imagedata);
	if((int)$existentid > 0){
		return $existentid;
	}
	
	$conn = open_db();
	$query = "INSERT INTO photos (imagedata, imagename, imagetype, imagesize) VALUES ('$imagedata', '$imagename', '$imagetype', '$imagewidthheight')";
	$result = mysqli_query($conn, $query);
	$id = mysqli_insert_id($conn);
	close_db($conn);
	return $id;
}

// Return the image in the given database entry.
// function modified from http://dwarf.ict.griffith.edu.au/~rwt/examples/gb-image/show.php?file=includes/defs.php
function getImage($id){
	$conn = open_db();
	$query = "SELECT imagedata, imagename, imagetype, imagesize FROM photos WHERE id = $id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result);
	close_db($conn);
	return $row;
}

// Get all the images in the database
function getAllImages(){
	$conn = open_db();
	$query = "SELECT id, imagename, imagesize FROM photos";
	$result = mysqli_query($conn, $query);
	$list = array();
	while($row = mysqli_fetch_assoc($result)){
	  $list[] = $row;
	}
	close_db($conn);
	return $list;
}

// Get all the images from a given article
function getArticleImages($articleid){
	$conn = open_db();
	$query = "SELECT p.id AS id, p.imagename AS imagename, p.imagesize AS imagesize FROM photos AS p, article_photo1 AS ap WHERE p.id = ap.photoid AND ap.articleid = ".(int)$articleid;
	$result = mysqli_query($conn, $query);
	$list = array();
	while($row = mysqli_fetch_assoc($result)){
	  $list[] = $row;
	}
	close_db($conn);
	return $list;
}

// checks if a photo is already linked with an article
function check_article_photo_relation($articleid, $photoid){
	$query = "SELECT id FROM article_photo1 WHERE articleid = ".(int)$articleid." AND photoid = ".(int)$photoid;
	$conn = open_db();
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	if((int)$row['id'] > 0) return true;
	return false;
}

// Adds a photo into an article
function addImageToArticle($articleid, $image){
	// add photo to db or get the id if it exists
	$photoid = addImage($image);
	// check if relation between the photo and the article exists
	if(check_article_photo_relation($articleid, $photoid)) return P_PHOTO_EXISTS;
	
	// Add the relation
	$conn = open_db();
	$query = "INSERT INTO article_photo1 (articleid, photoid) VALUES ($articleid, $photoid)";
	$result = mysqli_query($conn, $query);
	close_db($conn);
	return P_PHOTO_ADDED;
}

// Delete a relation between a photo and an article
function delete_article_photo($articleid, $photoid){
	$conn = open_db();
	$query = "DELETE FROM article_photo1 WHERE articleid = $articleid AND photoid = $photoid";
	$result = mysqli_query($conn, $query);
	// check if the photo doesn't have more relations with other articles
	$query = "SELECT id FROM article_photo1 WHERE photoid = $photoid LIMIT 1";
	$result = mysqli_query($conn, $query);
	if($result){
		$row = mysqli_fetch_assoc($result);
		if((int)$row['id'] > 0){ close_db($conn); return true; }
		else {
			// if a photo doesn't have more relations, then is not needed in the db and is deleted
			$query = "DELETE FROM photos WHERE id = $photoid";
			$result = mysqli_query($conn, $query);
			close_db($conn);
			return true;
		}
	}
	return close_db($conn);
}
?>
