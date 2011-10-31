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

$GLOBALS['xoopsOption']['template_main'] = 'extgallery_public-viewecard.html';
include XOOPS_ROOT_PATH.'/header.php';

$myts = MyTextSanitizer::getInstance();

if(isset($_GET['id'])) {
	$ecardId = $myts->addSlashes($_GET['id']);
} else {
	$ecardId = 0;
}

$ecardHandler = xoops_getmodulehandler('publicecard', 'extgallery');

$ecardObj = $ecardHandler->getEcard($ecardId);

// Check is the photo exist
if(!$ecardObj) {
	redirect_header("index.php", 3, _NOPERM);
	exit;
}

$ecard = $ecardHandler->objectToArray($ecardObj,array('photo_id'));

if($ecard['photo']['photo_serveur'] == "") {
	$ecard['photoUrl'] = XOOPS_URL.'/uploads/extgallery/public-photo/medium/'.$ecard['photo']['photo_name'];
} else {
	$ecard['photoUrl'] = $ecard['photo']['photo_serveur'].$ecard['photo']['photo_name'];
}

$xoopsTpl->assign('ecard', $ecard);
$xoTheme->addStylesheet('modules/extgallery/include/style.css');

$lang = array(
	'clickFormMore'=>_MD_EXTGALLERY_CLICK_FOR_MORE
);
$xoopsTpl->assign('lang', $lang);

include XOOPS_ROOT_PATH.'/footer.php';

?>