<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

require '../../mainfile.php';

$xoopsOption['template_main'] = 'extgallery_public-categories.html';
include ICMS_ROOT_PATH.'/header.php';

if(!isset($_GET['id'])) {
	$catId = 0;
} else {
	$catId = intval($_GET['id']);
}

$catHandler = icms_getModuleHandler('publiccat', 'extgallery');

$catObj = $catHandler->getCat($catId);

if(is_null($catObj)) {
	include(ICMS_ROOT_PATH."/footer.php");
	exit;
}

$cat = $catHandler->objectToArrayWithoutExternalKey($catObj);
$xoopsTpl->assign('cat', $cat);

$catPath = $catHandler->objectToArray($catHandler->getPath($catId));
$xoopsTpl->assign('catPath', $catPath);

$catChild = $catHandler->objectToArray($catHandler->getChildren($catId),array('photo_id'));
$xoopsTpl->assign('catChild', $catChild);

if(isset($catObj)) {
	$xoopsTpl->assign('xoops_pagetitle', $catObj->getVar('cat_name'));
	$xoTheme->addMeta('meta','description',$catObj->getVar('cat_desc'));
}
$xoTheme->addStylesheet('modules/extgallery/include/style.css');

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