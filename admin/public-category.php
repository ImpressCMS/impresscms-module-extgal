<?php

include '../../../include/cp_header.php';
include 'function.php';

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

switch($op) {

	case 'create':

		switch($step) {

			case 'enreg':

				$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
				$data = array(
							'cat_pid'=>$_POST['cat_pid'],
							'cat_name'=>$_POST['cat_name'],
							'cat_desc'=>$_POST['cat_desc'],
							'cat_weight'=>$_POST['cat_weight'],
							'cat_date'=>time(),
							'cat_imgurl'=>$_POST['cat_imgurl']
						);
				$catHandler->createCat($data);

				redirect_header("public-category.php", 3, _AM_EXTGALLERY_CAT_CREATED);

				break;

		}

		break;

	case 'modify':

		switch($step) {

			case 'enreg':

				if(isset($_POST['submit'])) {
					$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
					$catHandler->modifyCat($_POST);

					redirect_header("public-category.php", 3, _AM_EXTGALLERY_CAT_MODIFIED);
				} elseif($_POST['delete']) {
					icms_cp_header();
					icms::$module -> displayAdminMenu( 2, icms::$module -> getVar( 'name' ) );
					icms_core_Message::confirm(array("cat_id"=>$_POST['cat_id'],"step"=>'enreg'), 'public-category.php?op=delete', _AM_EXTGALLERY_DELETE_CAT_CONFIRM);
					icms_cp_footer();
				}

				break;

			case 'default':
			default:

				// Check if they are selected category
				if(!isset($_POST['cat_id'])) {
					redirect_header("photo.php",3,_AM_EXTGALLERY_NO_CATEGORY_SELECTED);
					exit;
				}

				$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
				$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

				$cat = $catHandler->getCat($_POST['cat_id']);
				$photosCat = $photoHandler->getCatPhoto($cat);

				icms_cp_header();
				icms::$module -> displayAdminMenu( 2, icms::$module -> getVar( 'name' ) );

				$selectedPhoto = '../images/blank.gif';
				$photoArray = array();
				foreach($photosCat as $photo) {
					if($photo->getVar('photo_serveur') != "") {
						$url = $photo->getVar('photo_serveur')."thumb_".$photo->getVar('photo_name');
					} else {
						$url = ICMS_URL."/uploads/extgallery/public-photo/thumb/thumb_".$photo->getVar('photo_name');
					}
					if($photo->getVar('photo_id') == $cat->getVar('photo_id')) {
						$selectedPhoto = $url;
					}
					$photoArray[$photo->getVar('photo_id')] = $url;
				}

				echo "<script type='text/JavaScript'>";
				echo "function ChangeThumb() {

							var formSelect;
							var thumb = new Array();";

				echo "thumb[0] = '../images/blank.gif';\n";
				foreach($photoArray as $k => $v) {
					echo "thumb[".$k."] = '".$v."';\n";
				}

				echo "formSelect = document.getElementById('photo_id');

							document.getElementById('thumb').src = thumb[formSelect.options[formSelect.selectedIndex].value];
						}";
				echo "</script>";

				echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_MOD_PUBLIC_CAT.'</legend>';

				$photoSelect = "\n".'<select size="1" name="photo_id" id="photo_id" onChange="ChangeThumb();" onkeydown="ChangeThumb();">'."\n";
				$photoSelect .= '<option value="0">&nbsp;</option>'."\n";
				foreach($photosCat as $photo) {
					if($photo->getVar("photo_id") == $cat->getVar('photo_id')) {
						$photoSelect .= '<option value="'.$photo->getVar("photo_id").'" selected="selected">'.$photo->getVar("photo_desc").' ('.$photo->getVar("photo_name").')</option>'."\n";
					} else {
						$photoSelect .= '<option value="'.$photo->getVar("photo_id").'">'.$photo->getVar("photo_desc").' ('.$photo->getVar("photo_name").')</option>'."\n";
					}
				}
				$photoSelect .= '</select>'."\n";

				$form = new icms_Form_Theme(_AM_EXTGALLERY_MOD_PUBLIC_CAT, 'create_cat', 'public-category.php?op=modify', 'post', true);
				$form->addElement(new icms_form_elements_Label(_AM_EXTGALLERY_PARENT_CAT, $catHandler->getSelect('cat_pid', 'leaf', true, $cat->getVar('cat_pid'))));
				$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_NAME, 'cat_name', '70', '255', $cat->getVar('cat_name','e')),false);
				$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_WEIGHT, 'cat_weight', '4', '4', $cat->getVar('cat_weight')),false);
				$form->addElement(new icms_form_elements_DhtmlTextArea(_AM_EXTGALLERY_DESC, 'cat_desc', $cat->getVar('cat_desc','e')), false);
				$elementTrayThumb = new icms_form_elements_ElementTray(_AM_EXTGALLERY_THUMB);
				$elementTrayThumb->addElement(new icms_form_elements_Label("", $photoSelect."<img style=\"float:left; margin-top:5px;\" id=\"thumb\" src=\"$selectedPhoto\" />"));
				$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_CAT_IMG, 'cat_imgurl', '70', '150', $cat->getVar('cat_imgurl','e')),false);
				$form->addElement($elementTrayThumb);
				$elementTrayButton = new icms_form_elements_ElementTray("");
				$elementTrayButton->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
				$elementTrayButton->addElement(new icms_form_elements_Button("", "delete", _DELETE, "submit"));
				$form->addElement($elementTrayButton);
				$form->addElement(new icms_form_elements_Hidden("cat_id", $_POST['cat_id']));
				$form->addElement(new icms_form_elements_Hidden("step", 'enreg'));
				$form->display();

				echo '</fieldset>';

				icms_cp_footer();

				break;

		}

		break;

	case 'delete':

		switch($step) {

			case 'enreg':

				$catHandler = icms_getModuleHandler('publiccat', 'extgallery');

				$catHandler->deleteCat($_POST['cat_id']);

				redirect_header("public-category.php", 3, _AM_EXTGALLERY_CAT_DELETED);

				break;

		}

		break;

	case 'default':
	default:

		$catHandler = icms_getModuleHandler('publiccat', 'extgallery');

		icms_cp_header();
		icms::$module -> displayAdminMenu( 2, icms::$module -> getVar( 'name' ) );

		echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_MODDELETE_PUBLICCAT.'</legend>';

		echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>'."\n";
		echo _AM_EXTGALLERY_MODDELETE_PUBLICCAT_INFO."\n";
		echo '</fieldset><br />'."\n";

		$form = new icms_form_Theme(_AM_EXTGALLERY_MODDELETE_PUBLICCAT, 'modify_cat', 'public-category.php?op=modify', 'post', true);
		$form->addElement(new icms_form_elements_Label(_AM_EXTGALLERY_CATEGORY, $catHandler->getSelect('cat_id', false, false, 0, "", true)));
		$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
		$form->display();

		echo '</fieldset>';
		echo '<br />';
		echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_ADD_PUBLIC_CAT.'</legend>';

		echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>'."\n";
		echo _AM_EXTGALLERY_ADD_PUBLIC_CAT_INFO."\n";
		echo '</fieldset><br />'."\n";

		$form = new icms_form_Theme(_AM_EXTGALLERY_ADD_PUBLIC_CAT, 'create_cat', 'public-category.php?op=create', 'post', true);
		$form->addElement(new icms_form_elements_Label(_AM_EXTGALLERY_PARENT_CAT, $catHandler->getSelect('cat_pid', 'leaf', true)));
		$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_NAME, 'cat_name', '70', '255'),true);
		$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_WEIGHT, 'cat_weight', '4', '4'),false);
		$form->addElement(new icms_form_elements_DhtmlTextArea(_AM_EXTGALLERY_DESC, 'cat_desc', ''), false);
		$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_CAT_IMG, 'cat_imgurl', '70', '150'), false);
		$form->addElement(new icms_form_elements_Hidden("step", 'enreg'));
		$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
		$form->display();

		echo '</fieldset>';

		icms_cp_footer();

		break;
}
?>