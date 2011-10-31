<?php

require '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-slideshow.html';
include XOOPS_ROOT_PATH.'/header.php';

if(!isset($_GET['id'])) {
	$catId = 0;
} else {
	$catId = intval($_GET['id']);
}

// Check the access permission
$permHandler = ExtgalleryPublicPermHandler::getHandler();
if(!$permHandler->isAllowed($xoopsUser, 'public_access', $catId)) {
	redirect_header("index.php", 3, _NOPERM);
	exit;
}

$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');
$photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

$catObj = $catHandler->getCat($catId);

if(is_null($catObj)) {
	include(XOOPS_ROOT_PATH."/footer.php");
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
$xoopsTpl->assign('slideshow_delay', $icmsModuleConfig['slideshow_delay']);
$xoopsTpl->assign('slideshow_duration', $icmsModuleConfig['slideshow_duration']);
$xoopsTpl->assign('slideshow_transtype', $icmsModuleConfig['slideshow_transtype']);
$xoopsTpl->assign('slideshow_effecttype', $icmsModuleConfig['slideshow_effecttype']);
$xoopsTpl->assign('slideshow_effectoption', $icmsModuleConfig['slideshow_effectoption']);
$xoopsTpl->assign('slideshow_thumb', $icmsModuleConfig['slideshow_thumb']);
$xoopsTpl->assign('slideshow_caption', $icmsModuleConfig['slideshow_caption']);
$xoopsTpl->assign('slideshow_controller', $icmsModuleConfig['slideshow_controller']);

include(XOOPS_ROOT_PATH."/footer.php");

?>