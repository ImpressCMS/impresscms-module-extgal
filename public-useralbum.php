<?php

require '../../mainfile.php';
include_once ICMS_ROOT_PATH.'/class/pagenav.php';
include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

$xoopsOption['template_main'] = 'extgallery_public-useralbum.html';
include ICMS_ROOT_PATH.'/header.php';


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

$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

$photos = $photoHandler->objectToArray($photoHandler->getUserAlbumPhotoPage($userId, $start), array('uid'));

// Plugin traitement
$plugin = icms_getModuleHandler('plugin', 'extgallery');
$nbPhoto = count($photos);
for($i=0;$i<$nbPhoto;$i++) {
    $params = array('catId'=>$photos[$i]['cat_id'], 'photoId'=>$photos[$i]['photo_id'], 'link'=>array());
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

$pageNav = new icms_view_PageNav($photoHandler->getUserAlbumCount($userId), icms::$module->config['nb_column']*icms::$module->config['nb_line'], $start, "start", "id=".$userId);
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

$xoopsTpl->assign('enableExtra', icms::$module->config['display_extra_field']);
$xoopsTpl->assign('nbColumn', icms::$module->config['nb_column']);
$xoopsTpl->assign('extgalleryName', icms::$module->getVar('name'));

include(ICMS_ROOT_PATH."/footer.php");

?>