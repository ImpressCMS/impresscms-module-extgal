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

class ExtgalleryPublicrating extends icms_core_Object
{

	var $externalKey = array();

	function ExtgalleryPublicrating()
	{
		$this->initVar('rating_id', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('photo_id', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('rating_rate', XOBJ_DTYPE_INT, 0, false);
		
		$this->externalKey['photo_id'] = array('className'=>'publicphoto', 'getMethodeName'=>'getPhoto', 'keyName'=>'photo', 'core'=>false);
		$this->externalKey['uid'] = array('className'=>'user', 'getMethodeName'=>'get', 'keyName'=>'user', 'core'=>true);
	}
	
	function getExternalKey($key) {
		return $this->externalKey[$key];
	}
	
}

class ExtgalleryPublicratingHandler extends ExtgalleryPersistableObjectHandler {
	
	function ExtgalleryPublicratingHandler(&$db)
	{
		$this->ExtgalleryPersistableObjectHandler($db, 'extgallery_publicrating', 'ExtgalleryPublicrating', 'rating_id');
	}
	
	function rate($photoId, $rating) {
		
		$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');
		
		$userId = (is_object(icms::$user)) ? icms::$user->getVar('uid') : 0 ;
		$rate = $this->create();
		$rate->assignVar('photo_id',$photoId);
		$rate->assignVar('uid',$userId);
		$rate->assignVar('rating_rate',$rating);
		
		if($this->_haveRated($rate)) {
			return false;
		}
		
		if(!$this->insert($rate,true)) {
			return false;
		}
		
		return $photoHandler->updateNbRating($photoId);
	}
	
	function getRate($photoId) {
		$criteria = new icms_db_criteria_Item('photo_id',$photoId);
		$avg = $this->getAvg($criteria,'rating_rate');
		return round($avg);
	}
	
	function _haveRated(&$rate) {
		// If the user is annonymous
		if($rate->getVar('uid') == 0) {
			return false;
		}
		
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('photo_id',$rate->getVar('photo_id')));
		$criteria->add(new icms_db_criteria_Item('uid',$rate->getVar('uid')));
		
		if($this->getCount($criteria) > 0) {
			return true;
		}
		
		return false;
	}
	
}

?>