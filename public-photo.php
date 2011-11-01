<?php

require '../../mainfile.php';
include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$xoopsOption['template_main'] = 'extgallery_public-photo.html';
include ICMS_ROOT_PATH.'/header.php';

if(!isset($_GET['photoId'])) {
	$photoId = 0;
} else {
	$photoId = intval($_GET['photoId']);
}

$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');
$ratingHandler = icms_getModuleHandler('publicrating', 'extgallery');
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
if(!$permHandler->isAllowed(icms::$user, 'public_access', $photo['cat']['cat_id'])) {
	redirect_header("index.php", 3, _NOPERM);
	exit;
}

// Don't update counter if user come from rating page
if(isset($_SERVER['HTTP_REFERER']) && basename($_SERVER['HTTP_REFERER']) != "public-rating.php?photoId=".$photoId) {
	$photoHandler->updateHits($photoId);
}

// Plugin traitement
$plugin = icms_getModuleHandler('plugin', 'extgallery');
$params = array('catId'=>$photo['cat']['cat_id'], 'photoId'=>$photo['photo_id'], 'link'=>array());
$plugin->triggerEvent('photoAlbumLink', $params);
$photo['link'] = $params['link'];

$photo['photo_date'] = date(_MEDIUMDATESTRING, $photo['photo_date']);
$xoopsTpl->assign('photo', $photo);

$cat = $catHandler->objectToArray($catHandler->getCat($photo['cat']['cat_id']));
$xoopsTpl->assign('cat', $cat);

$catPath = $catHandler->objectToArray($catHandler->getPath($photo['cat']['cat_id'], true));
$xoopsTpl->assign('catPath', $catPath);

$photosIds = $photoHandler->getPhotoAlbumId($photoObj->getVar('cat_id'));

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

$xoopsTpl->assign('xoops_pagetitle', $photo['photo_desc']." - ".$cat['cat_name']);
$xoTheme->addMeta('meta','description',$photo['photo_desc']." - ".$cat['cat_desc']);
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
			'allPhotoBy'=>_MD_EXTGALLERY_ALL_PHOTO_BY
		);
$xoopsTpl->assign('lang', $lang);

if(icms::$module->config['enable_rating']) {
	$xoopsTpl->assign('canRate', $permHandler->isAllowed(icms::$user, 'public_rate', $cat['cat_id']));
} else {
	$xoopsTpl->assign('canRate', false);
}
$xoopsTpl->assign('enableExtra', icms::$module->config['display_extra_field']);
$xoopsTpl->assign('canSendEcard', $permHandler->isAllowed(icms::$user, 'public_ecard', $cat['cat_id']));
$xoopsTpl->assign('canDownload', $permHandler->isAllowed(icms::$user, 'public_download', $cat['cat_id']));

$xoopsTpl->assign('extgalleryName', icms::$module->getVar('name'));
$xoopsTpl->assign('disp_ph_title', icms::$module->config['disp_ph_title']);
$xoopsTpl->assign('display_type', icms::$module->config['display_type']);

include ICMS_ROOT_PATH.'/include/comment_view.php';
include ICMS_ROOT_PATH.'/footer.php';

?>