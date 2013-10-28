<?php
require_once "includes/functions.php";

if(isset($_POST['upload'])){
	$image = $_FILES['imagefile'];
	$id = addImage($image);
}

if(!empty($id)){
	echo "id of uploaded image = $id<br />\n";
}

$imagesid = getAllImages();

?>
<form method="post" action="test_images.php" enctype="multipart/form-data">
<p>
  <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
  <input type="file" name="imagefile" value="Image file" size="30"> <br />
  <input type="submit" name="upload" value="Upload image">
</p>
</form>
<?php
foreach($imagesid as $img){
?>
<img src="get_image.php?id=<?php echo $img['id']; ?>" <?php echo $img['imagesize']; ?> alt="<?php echo $img['imagename']; ?>"><br />
<?php
}
?>
