<?php

require '../../mainfile.php';
include_once ICMS_ROOT_PATH.'/class/pagenav.php';
include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$xoopsOption['template_main'] = 'extgallery_public-album.html';
include ICMS_ROOT_PATH.'/header.php';


if(!isset($_GET['id'])) {
	$catId = 0;
} else {
	$catId = intval($_GET['id']);
}
if(!isset($_GET['start'])) {
	$start = 0;
} else {
	$start = intval($_GET['start']);
}

// Check the access permission
$permHandler = ExtgalleryPublicPermHandler::getHandler();
if(!$permHandler->isAllowed(icms::$user, 'public_access', $catId)) {
	redirect_header("index.php", 3, _NOPERM);
	exit;
}

$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

$catObj = $catHandler->getCat($catId);

if(is_null($catObj)) {
	include(ICMS_ROOT_PATH."/footer.php");
	exit;
}

$cat = $catHandler->objectToArray($catObj);
$xoopsTpl->assign('cat', $cat);

$catPath = $photoHandler->objectToArray($catHandler->getPath($catId));
$xoopsTpl->assign('catPath', $catPath);

$photos = $photoHandler->objectToArray($photoHandler->getAlbumPhotoPage($catId, $start),array('uid'));

// Plugin traitement
$plugin = icms_getModuleHandler('plugin', 'extgallery');
$nbPhoto = count($photos);
for($i=0;$i<$nbPhoto;$i++) {
    $params = array('catId'=>$catId, 'photoId'=>$photos[$i]['photo_id'], 'link'=>array());
    $plugin->triggerEvent('photoAlbumLink', $params);
    $photos[$i]['link'] = $params['link'];
}

$k = icms::$module->config['nb_column'] - (count($photos)%icms::$module->config['nb_column']);
if($k != icms::$module->config['nb_column']) {
	for($i=0;$i<$k;$i++) {
		$photos[] = array();
	}
}

$xoopsTpl->assign('photos', $photos);

$pageNav = new icms_view_PageNav($photoHandler->getAlbumCount($catId), icms::$module->config['nb_column']*icms::$module->config['nb_line'], $start, "start", "id=".$catId);
$xoopsTpl->assign('pageNav', $pageNav->renderNav());

if(isset($catObj)) {
	$xoopsTpl->assign('icms_pagetitle', $catObj->getVar('cat_name'));
	$xoTheme->addMeta('meta','description',$catObj->getVar('cat_desc'));
}
$xoTheme->addStylesheet('modules/extgallery/include/style.css');

$lang = array('hits'=>_MD_EXTGALLERY_HITS, 'comments'=>_MD_EXTGALLERY_COMMENTS, 'rate_score'=>_MD_EXTGALLERY_RATING_SCORE);
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('enableExtra', icms::$module->config['display_extra_field']);
$xoopsTpl->assign('enableRating', icms::$module->config['enable_rating']);
$xoopsTpl->assign('nbColumn', icms::$module->config['nb_column']);
$xoopsTpl->assign('extgalleryName', icms::$module->getVar('name'));
$xoopsTpl->assign('disp_ph_title', icms::$module->config['disp_ph_title']);

include(ICMS_ROOT_PATH."/footer.php");
?>