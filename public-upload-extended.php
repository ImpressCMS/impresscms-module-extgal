<?php

require '../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-upload-applet.html';
include XOOPS_ROOT_PATH.'/header.php';

//echo "<pre>";print_r($icmsModuleConfig);echo "</pre>";
$_SESSION['juvar.tmpsize'] = 0;
$catHandler = xoops_getmodulehandler('publiccat', 'extgallery');

$xoopsTpl->assign('categorySelect', $catHandler->getLeafSelect('cat_id', false, 0, "", "public_upload"));
$xoopsTpl->assign('imageQuality', $icmsModuleConfig['medium_quality'] / 100);
$xoopsTpl->assign('appletLang', _MD_EXTGALLERY_APPLET_LANG);

if($icmsModuleConfig['save_large'] || $icmsModuleConfig['save_original']) {
 $xoopsTpl->assign('imageWidth', -1);
 $xoopsTpl->assign('imageHeight', -1);
} else {
 $xoopsTpl->assign('imageWidth', $icmsModuleConfig['medium_width']);
 $xoopsTpl->assign('imageHeight', $icmsModuleConfig['medium_heigth']);
}

include XOOPS_ROOT_PATH.'/footer.php';

?>