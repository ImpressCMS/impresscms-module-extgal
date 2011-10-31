<?php

require '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-userphoto.html';
include XOOPS_ROOT_PATH.'/header.php';

if(!isset($_GET['photoId'])) {
	$photoId = 0;
} else {
	$photoId = intval($_GET['photoId']);
}

$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
$photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');
$ratingHandler = xoops_getmodulehandler('publicrating', 'extgallery');
$permHandler = ExtgalleryPublicPermHandler::getHandler();

$photoObj = $photoHandler->getPhoto($photoId);

// Check is the photo exist
if(!$photoObj) {
	redirect_header("index.php", 3, _NOPERM);
	exit;
}

$photo = $photoHandler->objectToArray($photoObj,array('cat_id', 'uid'));

// Check the category access permission
$permHandler = ExtgalleryPublicPermHandler::getHandler();
if(!$permHandler->isAllowed($xoopsUser, 'public_access', $photo['cat']['cat_id'])) {
	redirect_header("index.php", 3, _NOPERM);
	exit;
}

// Don't update counter if user come from rating page
if(isset($_SERVER['HTTP_REFERER']) && basename($_SERVER['HTTP_REFERER']) != "public-rating.php?photoId=".$photoId) {
	$photoHandler->updateHits($photoId);
}

$photo['photo_date'] = date(_MEDIUMDATESTRING, $photo['photo_date']);
$xoopsTpl->assign('photo', $photo);

$photosIds = $photoHandler->getUserPhotoAlbumId($photoObj->getVar('uid'));

$nbPhoto = count($photosIds);
$currentPhotoPlace = array_search($photoId, $photosIds);

if($nbPhoto == 1) {
	$prev = 0;
	$next = 0;
} else if($currentPhotoPlace == 0) {
	$prev = 0;
	$next = $photosIds[$currentPhotoPlace + 1];
} elseif(($currentPhotoPlace + 1) == $nbPhoto) {
	$prev = $photosIds[$currentPhotoPlace - 1];
	$next = 0;
} else {
	$prev = $photosIds[$currentPhotoPlace - 1];
	$next = $photosIds[$currentPhotoPlace + 1];
}
$xoopsTpl->assign('prevId', $prev);
$xoopsTpl->assign('nextId', $next);
$xoopsTpl->assign('currentPhoto', $currentPhotoPlace + 1);
$xoopsTpl->assign('totalPhoto', $nbPhoto);

$albumName = $photo['user']['uname']._MD_EXTGALLERY_USERS_SUB_PHOTO_ALBUM;
$xoopsTpl->assign('xoops_pagetitle', $albumName);
$xoTheme->addMeta('meta','description', $albumName);

$xoTheme->addStylesheet('modules/extgallery/include/style.css');

$xoopsTpl->assign('rating', $ratingHandler->getRate($photoId));

$lang = array(
			'preview'=>_MD_EXTGALLERY_PREVIEW, 
			'next'=>_MD_EXTGALLERY_NEXT, 
			'of'=>_MD_EXTGALLERY_OF, 
			'voteFor'=>_MD_EXTGALLERY_VOTE_FOR_THIS_PHOTO, 
			'photoInfo'=>_MD_EXTGALLERY_PHOTO_INFORMATION, 
			'resolution'=>_MD_EXTGALLERY_RESOLUTION, 
			'pixels'=>_MD_EXTGALLERY_PIXELS, 
			'view'=>_MD_EXTGALLERY_VIEW, 
			'hits'=>_MD_EXTGALLERY_HITS, 
			'fileSize'=>_MD_EXTGALLERY_FILE_SIZE, 
			'added'=>_MD_EXTGALLERY_ADDED, 
			'score'=>_MD_EXTGALLERY_SCORE, 
			'votes'=>_MD_EXTGALLERY_VOTES, 
			'downloadOrig'=>_MD_EXTGALLERY_DOWNLOAD_ORIG, 
			'donwloads'=>_MD_EXTGALLERY_DOWNLOADS, 
			'sendEcard'=>_MD_EXTGALLERY_SEND_ECARD, 
			'sends'=>_MD_EXTGALLERY_SENDS, 
			'submitter'=>_MD_EXTGALLERY_SUBMITTER,
			'allPhotoBy'=>_MD_EXTGALLERY_ALL_PHOTO_BY, 
			'albumName'=>$albumName
		);
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('enableExtra', $icmsModuleConfig['display_extra_field']);
$xoopsTpl->assign('canRate', $permHandler->isAllowed($xoopsUser, 'public_rate', $photo['cat']['cat_id']));
$xoopsTpl->assign('canSendEcard', $permHandler->isAllowed($xoopsUser, 'public_ecard', $photo['cat']['cat_id']));
$xoopsTpl->assign('canDownload', $permHandler->isAllowed($xoopsUser, 'public_download', $photo['cat']['cat_id']));

$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));

include XOOPS_ROOT_PATH.'/include/comment_view.php';
include XOOPS_ROOT_PATH.'/footer.php';

?>