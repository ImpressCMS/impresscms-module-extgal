<?php

require '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include_once XOOPS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-useralbum.html';
include XOOPS_ROOT_PATH.'/header.php';


if(!isset($_GET['id'])) {
	$userId = 0;
} else {
	$userId = intval($_GET['id']);
}
if(!isset($_GET['start'])) {
	$start = 0;
} else {
	$start = intval($_GET['start']);
}

$photoHandler = xoops_getmodulehandler('publicphoto', 'extgallery');

$photos = $photoHandler->objectToArray($photoHandler->getUserAlbumPhotoPage($userId, $start), array('uid'));

// Plugin traitement
$plugin = xoops_getmodulehandler('plugin', 'extgallery');
$nbPhoto = count($photos);
for($i=0;$i<$nbPhoto;$i++) {
    $params = array('catId'=>$photos[$i]['cat_id'], 'photoId'=>$photos[$i]['photo_id'], 'link'=>array());
    $plugin->triggerEvent('photoAlbumLink', $params);
    $photos[$i]['link'] = $params['link'];
}

$k = $icmsModuleConfig['nb_column'] - (count($photos)%$icmsModuleConfig['nb_column']);
if($k != $icmsModuleConfig['nb_column']) {
	for($i=0;$i<$k;$i++) {
		$photos[] = array();
	}
}
$xoopsTpl->assign('photos', $photos);

$pageNav = new XoopsPageNav($photoHandler->getUserAlbumCount($userId), $icmsModuleConfig['nb_column']*$icmsModuleConfig['nb_line'], $start, "start", "id=".$userId);
$xoopsTpl->assign('pageNav', $pageNav->renderNav());

$albumName = '';
if(count($photos) > 0) {
	$albumName = $photos[0]['user']['uname']._MD_EXTGALLERY_USERS_SUB_PHOTO_ALBUM;
	$xoopsTpl->assign('xoops_pagetitle', $albumName);
	$xoTheme->addMeta('meta','description', $albumName);
}

$xoTheme->addStylesheet('modules/extgallery/include/style.css');

$lang = array('hits'=>_MD_EXTGALLERY_HITS,'comments'=>_MD_EXTGALLERY_COMMENTS,'albumName'=>$albumName);
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('enableExtra', $icmsModuleConfig['display_extra_field']);
$xoopsTpl->assign('nbColumn', $icmsModuleConfig['nb_column']);
$xoopsTpl->assign('extgalleryName', $xoopsModule->getVar('name'));

include(XOOPS_ROOT_PATH."/footer.php");

?>