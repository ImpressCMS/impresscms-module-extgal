<?php

require '../../mainfile.php';
$xoopsOption['template_main'] = 'extgallery_public-upload-applet.html';
include ICMS_ROOT_PATH.'/header.php';

//echo "<pre>";print_r(icms::$module->config);echo "</pre>";
$_SESSION['juvar.tmpsize'] = 0;
$catHandler = icms_getModuleHandler('publiccat', 'extgallery');

$xoopsTpl->assign('categorySelect', $catHandler->getLeafSelect('cat_id', false, 0, "", "public_upload"));
$xoopsTpl->assign('imageQuality', icms::$module->config['medium_quality'] / 100);
$xoopsTpl->assign('appletLang', _MD_EXTGALLERY_APPLET_LANG);

if(icms::$module->config['save_large'] || icms::$module->config['save_original']) {
 $xoopsTpl->assign('imageWidth', -1);
 $xoopsTpl->assign('imageHeight', -1);
} else {
 $xoopsTpl->assign('imageWidth', icms::$module->config['medium_width']);
 $xoopsTpl->assign('imageHeight', icms::$module->config['medium_heigth']);
}

include ICMS_ROOT_PATH.'/footer.php';

?>