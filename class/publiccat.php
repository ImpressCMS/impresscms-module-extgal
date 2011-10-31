<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

include_once 'catHandler.php';

class ExtgalleryPubliccat extends ExtgalleryCat {

	function ExtgalleryPubliccat() {
		parent::ExtgalleryCat();
	}

}

class ExtgalleryPubliccatHandler extends ExtgalleryCatHandler {

	function ExtgalleryPubliccatHandler(&$db)
	{
		parent::ExtgalleryCatHandler($db, 'public');
	}

	function createCat($data) {
		$cat = $this->create();
		$cat->setVars($data);

		if(!$this->_haveValidParent($cat)) {
			return false;
		}

		$this->insert($cat,true);
		$this->rebuild();

		$criteria = new icms_db_criteria_Compo();
		$criteria->setSort('cat_id');
		$criteria->setOrder('DESC');
		$criteria->setLimit(1);

		$cat = $this->getObjects($criteria);
		$cat = $cat[0];

		$moduleId = icms::$module->getVar('mid');

		// Retriving permission mask
		$gpermHandler =& icms::handler('icms_member_groupperm');
		$moduleId = icms::$module->getVar('mid');
		$groups = icms::$user->getGroups();

		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('gperm_name','extgallery_public_mask'));
		$criteria->add(new icms_db_criteria_Item('gperm_modid',$moduleId));
		$permMask = $gpermHandler->getObjects($criteria);


		// Retriving group list
		$memberHandler =& icms::handler('icms_member');
		$glist = $memberHandler->getGroupList();

		// Applying permission mask
		$permArray = include ICMS_ROOT_PATH.'/modules/extgallery/include/perm.php';
        $modulePermArray = $permArray['modulePerm'];
	    $pluginPermArray = $permArray['pluginPerm'];

		foreach($permMask as $perm) {

		    foreach($modulePermArray as $permMask) {
		        if($perm->getVar('gperm_itemid') == $permMask['maskId']) {
                    $gpermHandler->addRight($permMask['name'], $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
		        }
		    }

		    foreach($pluginPermArray as $permMask) {
		        if($perm->getVar('gperm_itemid') == $permMask['maskId']) {
                    $gpermHandler->addRight($permMask['name'], $cat->getVar('cat_id'), $perm->getVar('gperm_groupid'), $moduleId);
		        }
		    }

		}

	}

	function _haveValidParent(&$cat) {
		// Check if haven't photo in parent category (parent category isn't an album)
		$parentCat = $this->get($cat->getVar('cat_pid'));
		return !$this->_isAlbum($parentCat);
	}

	function _getPermHandler() {
		return ExtgalleryPublicPermHandler::getHandler();
	}

}

?>