<?php

require '../../mainfile.php';
include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';
include_once ICMS_ROOT_PATH.'/class/icms_form_elements_loader.php';

if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

$permHandler = ExtgalleryPublicPermHandler::getHandler();
if(count($permHandler->getAuthorizedPublicCat(icms::$user, 'public_upload')) < 1) {
	redirect_header("index.php", 3, _MD_EXTGALLERY_NOPERM);
	exit;
}

switch($step) {

	case 'enreg':

	    $photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

	    $result = $photoHandler->postPhotoTraitement('photo_file', false);

	    if($result == 2) {
	       redirect_header("public-upload.php", 3, _MD_EXTGALLERY_NOT_AN_ALBUM);
	    } elseif($result == 4 || $result == 5) {
	       redirect_header("public-upload.php", 3, _MD_EXTGALLERY_UPLOAD_ERROR.' :<br />'.$photoHandler->photoUploader->getError());
	    } elseif($result == 0) {
	       redirect_header("public-upload.php", 3, _MD_EXTGALLERY_PHOTO_UPLOADED);
	    } elseif($result == 1) {
 		   redirect_header("public-upload.php", 3, _MD_EXTGALLERY_PHOTO_PENDING);
	    }


		break;

	case 'default':
	default:

		include_once ICMS_ROOT_PATH.'/header.php';

		$catHandler = icms_getModuleHandler('publiccat', 'extgallery');

		$form = new icms_form_Theme(_MD_EXTGALLERY_PUBLIC_UPLOAD, 'add_photo', 'public-upload.php', 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		$form->addElement(new icms_form_elements_Label(_MD_EXTGALLERY_ALBUMS, $catHandler->getLeafSelect('cat_id', false, 0, "", "public_upload")));
		$form->addElement(new icms_form_elements_Text(_MD_EXTGALLERY_PHOTO_TITLE, 'photo_title', '50', '150'),false);
		$form->addElement(new icms_form_elements_TextArea(_MD_EXTGALLERY_DESC, 'photo_desc'));
		$form->addElement(new icms_form_elements_File(_MD_EXTGALLERY_PHOTO, 'photo_file', 3145728),false);
		if(icms::$module->config['display_extra_field']) {
			$form->addElement(new icms_form_elements_TextArea(_MD_EXTGALLERY_EXTRA_INFO, "photo_extra"));
		}

		$plugin = icms_getModuleHandler('plugin', 'extgallery');
		$plugin->triggerEvent('photoForm', $form);

		$form->addElement(new icms_form_elements_Hidden("step", 'enreg'));
		$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));

		$form->display();

		include(ICMS_ROOT_PATH."/footer.php");

		break;

}

?>