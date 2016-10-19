<?php
require_once '/secure/constants.php';

$file = $_GET['file'];
$size = $_GET['size'];

switch ($size) {
	case "large":
		$path = LARGE_DIR."/".$file.".JPG";
		break;
	case "thumb":
		$path = THUMB_DIR."/".$file.".JPG";
		break;
	case "original":
		$path = ORIGINAL_DIR."/".$file.".JPG";
		break;
}


require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();

require_once 'classes/imagegallery.php';
$gallery = New imagegallery();

$filename = $gallery->get_filename($file);

#open img
$img = imagecreatefromjpeg($path);
header( "Content-type: image/jpg" );

if($size == "original")
{
	header("Content-Disposition: attachment; filename=\"$filename\"");
}
imagejpeg($img);
imagedestroy( $img );


#read img
#output img




?>
