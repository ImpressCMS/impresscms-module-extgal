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

if (!defined("ICMS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once 'ExtgalleryPersistableObjectHandler.php';
include_once 'extgalleryMailer.php';

class ExtgalleryPublicecard extends icms_core_Object
{

	var $externalKey = array();

	function ExtgalleryPublicecard()
	{
		$this->initVar('ecard_id', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('ecard_cardid', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('ecard_fromname', XOBJ_DTYPE_TXTBOX, 0, false);
		$this->initVar('ecard_fromemail', XOBJ_DTYPE_EMAIL, '', false, 255);
		$this->initVar('ecard_toname', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('ecard_toemail', XOBJ_DTYPE_EMAIL, '', false, 255);
		$this->initVar('ecard_greetings', XOBJ_DTYPE_TXTBOX, 0, false);
		$this->initVar('ecard_desc', XOBJ_DTYPE_TXTAREA, 0, false);
		$this->initVar('ecard_date', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('ecard_ip', XOBJ_DTYPE_TXTBOX, 0, true);
		$this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('photo_id', XOBJ_DTYPE_INT, 0, false);
		
		$this->externalKey['photo_id'] = array('className'=>'publicphoto', 'getMethodeName'=>'getPhoto', 'keyName'=>'photo', 'core'=>false);
		$this->externalKey['uid'] = array('className'=>'user', 'getMethodeName'=>'get', 'keyName'=>'user', 'core'=>true);
	}
	
	function getExternalKey($key) {
		return $this->externalKey[$key];
	}
	
}

class ExtgalleryPublicecardHandler extends ExtgalleryPersistableObjectHandler {
	
	function ExtgalleryPublicecardHandler(&$db)
	{
		$this->ExtgalleryPersistableObjectHandler($db, 'extgallery_publicecard', 'ExtgalleryPublicecard', 'ecard_id');
	}
	
	function createEcard($data) {
	
		$ecard = $this->create();
		$ecard->setVars($data);
		$ecard->setVar('ecard_date',time());
		$uid = is_a(icms::$user, "XoopsUser") ? icms::$user->getVar('uid') : 0;
		$ecard->setVar('uid',$uid);
		$ecard->setVar('ecard_cardid',md5(uniqid(rand(), true)));
		
		if(!$this->insert($ecard, true)) {
			return false;
		}
		$this->send($ecard);
		
	}
	
	function send(&$ecard) {
		
		$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');
		$photo = $photoHandler->get($ecard->getVar('photo_id'));
		
		$mailer = new extgalleryMailer('included');
		
		$mailer->setEcardId($ecard->getVar('ecard_cardid','p'));
		$mailer->setSubject(sprintf(_MD_EXTGALLERY_ECARD_TITLE, $ecard->getVar('ecard_fromname','p')));
		$mailer->setToEmail($ecard->getVar('ecard_toemail','p'));
		$mailer->setToName($ecard->getVar('ecard_toname','p'));
		$mailer->setFromEmail($ecard->getVar('ecard_fromemail','p'));
		$mailer->setFromName($ecard->getVar('ecard_fromname','p'));
		$mailer->setGreetings($ecard->getVar('ecard_greetings','p'));
		$mailer->setDescription($ecard->getVar('ecard_desc','p'));
		$mailer->setPhoto($photo);
		$mailer->send();
	}
	
	function getEcard($ecardId) {
		$criteria = new icms_db_criteria_Item('ecard_cardid',$ecardId);
		$ecard = $this->getObjects($criteria);
		if(count($ecard) != 1) {
			return false;
		}
		return $ecard[0];
	}
	
}

?>