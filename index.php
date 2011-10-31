<?php

require '../../mainfile.php';

$xoopsOption['template_main'] = 'extgallery_index.html';
include ICMS_ROOT_PATH.'/header.php';

$catHandler = icms_getModuleHandler('publiccat', 'extgallery');

$cats = $catHandler->objectToArray($catHandler->getChildren(0),array('photo_id'));
$xoopsTpl->assign('cats', $cats);

$lang = array(
			'categoriesAlbums'=>_MD_EXTGALLERY_CATEGORIESALBUMS,
			'nbAlbums'=>_MD_EXTGALLERY_NBALBUMS,
			'nbPhotos'=>_MD_EXTGALLERY_NBPHOTOS
		);
$xoopsTpl->assign('lang', $lang);

$xoopsTpl->assign('extgalleryName', icms::$module->getVar('name'));
$xoopsTpl->assign('disp_cat_img', icms::$module->config['disp_cat_img']);
$xoopsTpl->assign('display_type', icms::$module->config['display_type']);

include(ICMS_ROOT_PATH."/footer.php");

?>