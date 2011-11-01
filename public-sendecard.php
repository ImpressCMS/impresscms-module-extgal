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

if(isset($_GET['id'])) {
	$photoId = intval($_GET['id']);
} else if(isset($_POST['photo_id'])) {
	$photoId = intval($_POST['photo_id']);
} else {
	$photoId = 0;
}
if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');
$photo = $photoHandler->getPhoto($photoId);

$permHandler = ExtgalleryPublicPermHandler::getHandler();

if(!$permHandler->isAllowed(icms::$user, 'public_ecard', $photo->getVar('cat_id'))) {
	redirect_header("index.php", 3, _MD_EXTGALLERY_NOPERM);
	exit;
}

switch($step) {
	
	case 'send':
		
		include_once ICMS_ROOT_PATH.'/modules/extgallery/class/php-captcha.inc.php';
		
		// Enable captcha only if GD is Used
		if(icms::$module->config['graphic_lib'] == 'GD') {
			if (!PhpCaptcha::Validate($_POST['captcha'])) {
				redirect_header("public-photo.php?photoId=".$photoId."#photoNav", 3, _MD_EXTGALLERY_CAPTCHA_ERROR);
				exit;
			}
		}
		
		$ecardHandler = icms_getModuleHandler('publicecard', 'extgallery');
		$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');
		
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip  = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		$data = array(
					'ecard_fromname'=>$_POST['ecard_fromname'],
					'ecard_fromemail'=>$_POST['ecard_fromemail'],
					'ecard_toname'=>$_POST['ecard_toname'],
					'ecard_toemail'=>$_POST['ecard_toemail'],
					'ecard_greetings'=>$_POST['ecard_greetings'],
					'ecard_desc'=>$_POST['ecard_desc'],
					'ecard_ip'=>$ip,
					'photo_id'=>$photoId
				);
		
		$ecardHandler->createEcard($data);
		$photoHandler->updateEcard($photoId);
		
		redirect_header("public-photo.php?photoId=".$photoId."#photoNav", 3, _MD_EXTGALLERY_ECARD_SENT);
		
		break;
		
	case 'default':
	default:
		
		$xoopsOption['template_main'] = 'extgallery_public-sendecard.html';
		include ICMS_ROOT_PATH.'/header.php';
		
		if($photo->getVar('photo_serveur') != "") {
			$photoUrl = $photo->getVar('photo_serveur')."thumb_".$photo->getVar('photo_name');
		} else {
			$photoUrl = ICMS_URL."/uploads/extgallery/public-photo/thumb/thumb_".$photo->getVar('photo_name');
		}
		
		$fromName = is_a(icms::$user, "XoopsUser") ? icms::$user->getVar('uname') : "";
		$fromEmail = is_a(icms::$user, "XoopsUser") ? icms::$user->getVar('email') : "";
		
		$form = new icms_form_Theme(_MD_EXTGALLERY_SEND_ECARD, 'send_ecard', 'public-sendecard.php', 'post', true);
		$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_FROM_NAME, 'ecard_fromname', '70', '255', $fromName),false);
		$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_FROM_EMAIL, 'ecard_fromemail', '70', '255', $fromEmail),false);
		$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_TO_NAME, 'ecard_toname', '70', '255', ''),false);
		$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_TO_EMAIL, 'ecard_toemail', '70', '255', ''),false);
		$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_GREETINGS, 'ecard_greetings', '110', '255', ''),false);
		$form->addElement(new icms_form_elements_TextArea(_MD_EXTGALLERY_DESC, 'ecard_desc', ''), false);
		// Enable captcha only if GD is Used
		if(icms::$module->config['graphic_lib'] == 'GD') {
			$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_SECURITY, 'captcha', '10', '5', ''),false);
		}
		$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
		$form->addElement(new icms_form_elements_Hidden("photo_id", $photoId));
		$form->addElement(new icms_form_elements_Hidden("step", 'send'));
		$form->assign($xoopsTpl);
		
		$xoopsTpl->assign('photo', $photoUrl);
		$xoopsTpl->assign('xoops_pagetitle', "Send ".$photo->getVar('photo_desc')." to eCard");
		$xoTheme->addMeta('meta','description',$photo->getVar('photo_desc'));
		$xoTheme->addStylesheet('modules/extgallery/include/style.css');
		
		$lang = array(
			'to'=>_MD_EXTGALLERY_TO, 
			'from'=>_MD_EXTGALLERY_FROM
		);
		$xoopsTpl->assign('lang', $lang);
		
		include ICMS_ROOT_PATH.'/footer.php';
		
		break;

}

?>