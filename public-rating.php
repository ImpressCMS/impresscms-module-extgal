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
include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';

if(!isset($_GET['id'])) {
	$photoId = 0;
} else {
	$photoId = intval($_GET['id']);
}
if(!isset($_GET['rate'])) {
	$rate = 0;
} else {
	$rate = intval($_GET['rate']);
}

$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');
$photo = $photoHandler->get($photoId);

$permHandler = ExtgalleryPublicPermHandler::getHandler();
if(icms::$module->config['enable_rating'] && !$permHandler->isAllowed(icms::$user, 'public_rate', $photo->getVar('cat_id'))) {
	redirect_header("index.php", 3, _MD_EXTGALLERY_NOPERM);
	exit;
}

$ratingHandler = icms_getModuleHandler('publicrating', 'extgallery');

if($ratingHandler->rate($photoId, $rate)) {
	$rating = $ratingHandler->getRate($photoId);
	$photoHandler->modifyPhoto($photoId,array('photo_rating'=>$rating));
	
	redirect_header("public-photo.php?photoId=".$photoId."#photoNav", 3, _MD_EXTGALLERY_VOTE_THANKS);
} else {
	redirect_header("public-photo.php?photoId=".$photoId."#photoNav", 3, _MD_EXTGALLERY_ALREADY_VOTED);
}

?>