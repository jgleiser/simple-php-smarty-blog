<?php
/*
 * Return the image from the entry with the given id.
 */
require_once "includes/functions.php";

// check that the id of the image is set
if(!isset($_GET['id']) || empty($_GET['id'])){
	header("Location: index.php");
	exit;
}
else $id = $_GET['id'];

$image = getImage($id);

$data = $image['imagedata'];
$name = $image['imagename'];
$type = $image['imagetype'];
$size = strlen($data);

// echo "name = $name, type = $type, size = $size<br>\n";
// exit;

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $data;
?>
