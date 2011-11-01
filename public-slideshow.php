<?php

require '../../mainfile.php';
include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-slideshow.html';
include ICMS_ROOT_PATH.'/header.php';

if(!isset($_GET['id'])) {
	$catId = 0;
} else {
	$catId = intval($_GET['id']);
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

$photos = $photoHandler->getSlideshowAlbumPhoto($catId);
$xoopsTpl->assign('photos', $photos);
$xoopsTpl->assign('xoops_pagetitle', $catObj->getVar('cat_name'));
$xoTheme->addMeta('meta','description',$catObj->getVar('cat_desc'));

// Include for SlideShow
$xoTheme->addStylesheet('modules/extgallery/include/slideshow/css/slideshow.css');

$xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.js');

$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));
$xoopsTpl->assign('slideshow_delay', icms::$module->config['slideshow_delay']);
$xoopsTpl->assign('slideshow_duration', icms::$module->config['slideshow_duration']);
$xoopsTpl->assign('slideshow_transtype', icms::$module->config['slideshow_transtype']);
$xoopsTpl->assign('slideshow_effecttype', icms::$module->config['slideshow_effecttype']);
$xoopsTpl->assign('slideshow_effectoption', icms::$module->config['slideshow_effectoption']);
$xoopsTpl->assign('slideshow_thumb', icms::$module->config['slideshow_thumb']);
$xoopsTpl->assign('slideshow_caption', icms::$module->config['slideshow_caption']);
$xoopsTpl->assign('slideshow_controller', icms::$module->config['slideshow_controller']);

include(ICMS_ROOT_PATH."/footer.php");

?>