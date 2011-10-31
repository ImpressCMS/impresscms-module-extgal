<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once 'photoHandler.php';
include_once 'publicPerm.php';

class ExtgalleryPublicphoto extends ExtgalleryPhoto
{

	function ExtgalleryPublicphoto() {
		parent::ExtgalleryPhoto();
	}

}

class ExtgalleryPublicphotoHandler extends ExtgalleryPhotoHandler {

	function ExtgalleryPublicphotoHandler(&$db)
	{
		$this->ExtgalleryPhotoHandler($db, 'public');
	}

	function deleteFile(&$photo) {
		if(file_exists(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/thumb/thumb_".$photo->getVar('photo_name')))
			unlink(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/thumb/thumb_".$photo->getVar('photo_name'));

		if(file_exists(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/medium/".$photo->getVar('photo_name')))
			unlink(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/medium/".$photo->getVar('photo_name'));

		if(file_exists(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/large/large_".$photo->getVar('photo_name')))
			unlink(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/large/large_".$photo->getVar('photo_name'));

		if($photo->getVar('photo_orig_name') != "" && file_exists(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/original/".$photo->getVar('photo_orig_name')))
			unlink(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/original/".$photo->getVar('photo_orig_name'));
	}

	function getAllSize() {
		return $this->getSum(null,'photo_size');
	}

	function _getUploadPhotoPath() {
		return ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/';
	}

	function getUserAlbumPhotoPage($userId, $start) {

        $catHandler = icms_getModuleHandler('publiccat', 'extgallery');

        $criteria = new icms_db_criteria_Compo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new icms_db_criteria_Item('photo_approved',1));
        $criteria->add(new icms_db_criteria_Item('uid',$userId));
        $criteria->setSort('photo_date, photo_id');
        $criteria->setOrder('DESC');
        $criteria->setStart($start);
        $criteria->setLimit(icms::$module->config['nb_column']*icms::$module->config['nb_line']);
        return $this->getObjects($criteria);
	}

     function getUserAlbumPrevPhoto($userId, $photoDate) {
        $catHandler = icms_getModuleHandler('publiccat', 'extgallery');

        $criteria = new icms_db_criteria_Compo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new icms_db_criteria_Item('photo_approved',1));
        $criteria->add(new icms_db_criteria_Item('uid',$userId));
        $criteria->add(new icms_db_criteria_Item('photo_date',$photoDate,'>'));
        $criteria->setSort('photo_date');
        $criteria->setOrder('ASC');
        $criteria->setLimit(1);
        return $this->getObjects($criteria);
     }

    function getUserAlbumNextPhoto($userId, $photoDate) {
        $catHandler = icms_getModuleHandler('publiccat', 'extgallery');

        $criteria = new icms_db_criteria_Compo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new icms_db_criteria_Item('photo_approved',1));
        $criteria->add(new icms_db_criteria_Item('uid',$userId));
        $criteria->add(new icms_db_criteria_Item('photo_date',$photoDate,'<'));
        $criteria->setSort('photo_date');
        $criteria->setOrder('DESC');
        $criteria->setLimit(1);
        return $this->getObjects($criteria);
    }

    function getUserAlbumCurrentPhotoPlace($userId, $photoDate) {
        $catHandler = icms_getModuleHandler('publiccat', 'extgallery');

        $criteria = new icms_db_criteria_Compo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new icms_db_criteria_Item('photo_approved',1));
        $criteria->add(new icms_db_criteria_Item('uid',$userId));
        $criteria->add(new icms_db_criteria_Item('photo_date',$photoDate,'>='));
        $criteria->setSort('photo_date');
        $criteria->setOrder('ASC');
        return $this->getCount($criteria);
    }

    function getUserAlbumCount($userId) {
        $catHandler = icms_getModuleHandler('publiccat', 'extgallery');

        $criteria = new icms_db_criteria_Compo();
        $criteria->add($catHandler->getCatRestrictCriteria());
        $criteria->add(new icms_db_criteria_Item('photo_approved',1));
        $criteria->add(new icms_db_criteria_Item('uid',$userId));
        return $this->getCount($criteria);
    }

    function getUserPhotoAlbumId($userId) {

        $criteria = new icms_db_criteria_Compo();
        $criteria->add(new icms_db_criteria_Item('uid',$userId));
        $criteria->add(new icms_db_criteria_Item('photo_approved',1));

        $sql = 'SELECT photo_id FROM '.$this->db->prefix('extgallery_publicphoto').' '.$criteria->renderWhere().' ORDER BY photo_date, photo_id DESC;';

        $result = $this->db->query($sql);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[] = $myrow['photo_id'];
        }

        return $ret;

    }

}
?>