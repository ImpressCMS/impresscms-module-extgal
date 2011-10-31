<?php

require '../../mainfile.php';
include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

if(!isset($_GET['id'])) {
	$photoId = 0;
} else {
	$photoId = intval($_GET['id']);
}

$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');
$photo = $photoHandler->get($photoId);

switch(strtolower(strrchr($photo->getVar('photo_name'), "."))) {
	case ".png": $type = "image/png"; break;
	case ".gif": $type = "image/gif"; break;
	case ".jpg": $type = "image/jpeg"; break;
	default: $type = "application/octet-stream"; break;
}

$permHandler = ExtgalleryPublicPermHandler::getHandler();

// If require image don't exist
if($photo->getVar('cat_id') == 0) {

 header ("Content-type: image/jpeg");
	readfile(ICMS_ROOT_PATH."/modules/extgallery/images/dont-exist.jpg");

// If user is allowed to view this picture
} elseif($permHandler->isAllowed(icms::$user, 'public_access', $photo->getVar('cat_id'))) {
	$photo = $photoHandler->objectToArray($photo);

	header ("Content-type: ".$type."");
	readfile(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/thumb/thumb_".$photo['photo_name']);
 
// If user isn't allowed to view this picture
} else {

	header ("Content-type: image/jpeg");
	readfile(ICMS_ROOT_PATH."/modules/extgallery/images/not-allowed.jpg");
 
}

?>