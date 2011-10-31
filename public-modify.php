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
include_once ICMS_ROOT_PATH.'/class/icms_form_elements_loader.php';

if(isset($_GET['op'])) {
	$op = $_GET['op'];
} else {
	$op = 'default';
}

if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

if(!isset(icms::$user)) {
	redirect_header("index.php");
	exit;
} else if(!icms::$user->isAdmin()) {
	redirect_header("index.php");
	exit;
}

switch($op) {

	case 'edit':

		switch($step) {

			case 'enreg':

				$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

				$photo = $photoHandler->getPhoto($_POST['photo_id']);

				$data['cat_id'] = $_POST['cat_id'];
				$data['photo_desc'] = $_POST['photo_desc'];
				$data['photo_title'] = $_POST['photo_title'];
				$data['photo_weight'] = $_POST['photo_weight'];

				if(isset($_POST['photo_extra']))
					$data['photo_extra'] = $_POST['photo_extra'];

				$photoHandler->modifyPhoto(intval($_POST['photo_id']),$data);

				// If the photo category change
				if($photo->getVar('cat_id') != $_POST['cat_id']) {
					$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
					$oldCat = $catHandler->getCat($photo->getVar('cat_id'));
					$newCat = $catHandler->getCat($_POST['cat_id']);

					// Set new category as album
					$catHandler->modifyCat(array('cat_id'=>intval($_POST['cat_id']),'cat_isalbum'=>1));

					// Update album count
					if($oldCat->getVar('cat_nb_photo') == 1) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add(new icms_db_criteria_Item('nleft',$oldCat->getVar('nleft'),'<'));
						$criteria->add(new icms_db_criteria_Item('nright',$oldCat->getVar('nright'),'>'));
						$catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album - 1', $criteria);
					}

					if($newCat->getVar('cat_nb_photo') == 0) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add(new icms_db_criteria_Item('nleft',$newCat->getVar('nleft'),'<'));
						$criteria->add(new icms_db_criteria_Item('nright',$newCat->getVar('nright'),'>'));
						$catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album + 1', $criteria);
					}

					// Update photo count
					$criteria = new icms_db_criteria_Compo();
					$criteria->add(new icms_db_criteria_Item('nleft',$newCat->getVar('nleft'),'<='));
					$criteria->add(new icms_db_criteria_Item('nright',$newCat->getVar('nright'),'>='));
					$catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo + 1', $criteria);

					$criteria = new icms_db_criteria_Compo();
					$criteria->add(new icms_db_criteria_Item('nleft',$oldCat->getVar('nleft'),'<='));
					$criteria->add(new icms_db_criteria_Item('nright',$oldCat->getVar('nright'),'>='));
					$catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo - 1', $criteria);

					// If the old album don't contains other photo
					if($photoHandler->nbPhoto($oldCat) == 0) {
						$catHandler->modifyCat(array('cat_id'=>$photo->getVar('cat_id'),'cat_isalbum'=>0));
						redirect_header("public-categories.php?id=".$photo->getVar('cat_id'), 3, _MD_EXTGALLERY_PHOTO_UPDATED);
					} else {
						redirect_header("public-album.php?id=".$photo->getVar('cat_id'), 3, _MD_EXTGALLERY_PHOTO_UPDATED);
					}
				} else {
					redirect_header("public-photo.php?photoId=".$photo->getVar('photo_id'), 3, _MD_EXTGALLERY_PHOTO_UPDATED);
				}

				break;

			case 'default':
			default:

				include_once ICMS_ROOT_PATH.'/header.php';

				$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
				$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

				$photo = $photoHandler->getPhoto(intval($_GET['id']));

				echo '<img src="'.ICMS_URL.'/uploads/extgallery/public-photo/thumb/thumb_'.$photo->getVar('photo_name').'" />';

				$form = new icms_form_Theme(_MD_EXTGALLERY_MODIFY_PHOTO, 'add_photo', 'public-modify.php?op=edit', 'post', true);
				$form->addElement(new icms_form_elements_(_MD_EXTGALLERY_CATEGORY, $catHandler->getLeafSelect('cat_id', false, $photo->getVar('cat_id'))));
				$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_PHOTO_WEIGHT, 'photo_weight', '3', '11', $photo->getVar('photo_weight')),false);
				$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_PHOTO_TITLE, 'photo_title', '50', '150', $photo->getVar('photo_title')),false);
				$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_DESC, 'photo_desc', '90', '255', $photo->getVar('photo_desc')),false);
				if($icmsModuleConfig['display_extra_field'])
					$form->addElement(new icms_form_elements_TextArea(_MD_EXTGALLERY_EXTRA_INFO, "photo_extra", $photo->getVar('photo_extra')));
				$form->addElement(new icms_form_elements_Hidden("photo_id", $_GET['id']));
				$form->addElement(new icms_form_elements_Hidden("step", 'enreg'));
				$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
				$form->display();

				include(ICMS_ROOT_PATH."/footer.php");

				break;

		}

		break;

	case 'delete':

		$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
		$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

		$photo = $photoHandler->getPhoto(intval($_GET['id']));
		$photoHandler->deletePhoto($photo);

		$cat = $catHandler->getCat($photo->getVar('cat_id'));

		// Update photo count
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('nleft',$cat->getVar('nleft'),'<='));
		$criteria->add(new icms_db_criteria_Item('nright',$cat->getVar('nright'),'>='));
		$catHandler->updateFieldValue('cat_nb_photo', 'cat_nb_photo - 1', $criteria);

		if($cat->getVar('cat_nb_photo') == 1) {

			// Update album count
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item('nleft',$cat->getVar('nleft'),'<'));
			$criteria->add(new icms_db_criteria_Item('nright',$cat->getVar('nright'),'>'));
			$catHandler->updateFieldValue('cat_nb_album', 'cat_nb_album - 1', $criteria);

			$catHandler->modifyCat(array('cat_id'=>$photo->getVar('cat_id'),'cat_isalbum'=>0));

			redirect_header("public-categories.php?id=".$photo->getVar('cat_id'));
		} else {
			redirect_header("public-album.php?id=".$photo->getVar('cat_id'));
		}

		break;

}

?>