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

include '../../../include/cp_header.php';

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

	case 'uploadfont':

		switch($step) {

			case 'enreg':

				$uploaddir = ICMS_ROOT_PATH.'/modules/extgallery/fonts/';
				$uploadfile = $uploaddir . basename($_FILES['font_file']['name']);

				if(file_exists($uploadfile)) {
					echo "La police est déja présente sur le serveur.";
				}

				move_uploaded_file($_FILES['font_file']['tmp_name'], $uploadfile);

				redirect_header("watermark-border.php", 3, _AM_EXTGALLERY_FONT_ADDED);

				break;

			case 'default':
			default:

				icms_cp_header();
				icms::$module -> displayAdminMenu( 6, icms::$module -> getVar( 'name' ) );

				echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_AVAILABLE_FONT.'</legend>';

				$fonts = array();

				$rep = ICMS_ROOT_PATH.'/modules/extgallery/fonts/';
				$dir = opendir($rep);
				while ($f = readdir($dir)) {
					if(is_file($rep.$f)) {
						if(preg_match("/.*ttf/",strtolower($f))) {
							$fonts[] = $f;
						}
					}
				}

				foreach($fonts as $font) {
					echo $font.", ";
				}

				echo '</fieldset><br />';

				$form = new icms_form_Theme(_AM_EXTGALLERY_ADD_FONT, 'add_font', 'watermark-border.php?op=uploadfont', 'post', true);
				$form->setExtra('enctype="multipart/form-data"');
				$form->addElement(new icms_form_elements_File(_AM_EXTGALLERY_FONT_FILE, 'font_file', get_cfg_var('upload_max_filesize')*1024*1024),false);
				$form->addElement(new icms_form_elements_Hidden("step", 'enreg'));
				$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
				$form->display();

				icms_cp_footer();

				break;

		}

		break;

	case 'conf':

		switch($step) {

			case 'enreg':

				$configHandler =& icms::handler('config');
				$moduleIdCriteria = new icms_db_criteria_Item('conf_modid',icms::$module->getVar('mid'));

				// Param for applied to the test photo
				$testParam = array();
				$testParam['watermark_type'] = icms::$module->config['watermark_font'];
				$testParam['watermark_font'] = icms::$module->config['watermark_font'];
				$testParam['watermark_text'] = icms::$module->config['watermark_text'];
				$testParam['watermark_position'] = icms::$module->config['watermark_position'];
				$testParam['watermark_color'] = icms::$module->config['watermark_color'];
				$testParam['watermark_fontsize'] = icms::$module->config['watermark_fontsize'];
				$testParam['watermark_padding'] = icms::$module->config['watermark_padding'];
				$testParam['inner_border_color'] = icms::$module->config['inner_border_color'];
				$testParam['inner_border_size'] = icms::$module->config['inner_border_size'];
				$testParam['outer_border_color'] = icms::$module->config['outer_border_color'];
				$testParam['outer_border_size'] = icms::$module->config['outer_border_size'];

				if(isset($_POST['watermark_font'])) {

					$testParam['watermark_font'] = $_POST['watermark_font'];
					if(icms::$module->config['watermark_font'] != $_POST['watermark_font']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','watermark_font'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'watermark_font',
												'conf_value'=>$_POST['watermark_font'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'text'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					$testParam['watermark_type'] = $_POST['watermark_type'];
					if(icms::$module->config['watermark_type'] != $_POST['watermark_type']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','watermark_type'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'watermark_type',
												'conf_value'=>$_POST['watermark_type'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'int'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					if(isset($_POST['watermark_text'])) {
						$testParam['watermark_text'] = $_POST['watermark_text'];
						if(icms::$module->config['watermark_text'] != $_POST['watermark_text']) {
							$criteria = new icms_db_criteria_Compo();
							$criteria->add($moduleIdCriteria);
							$criteria->add(new icms_db_criteria_Item('conf_name','watermark_text'));
							$config = $configHandler->getConfigs($criteria);
							$config = $config[0];
							$configValue = array(
													'conf_modid'=>icms::$module->getVar('mid'),
													'conf_catid'=>0,
													'conf_name'=>'watermark_text',
													'conf_value'=>$_POST['watermark_text'],
													'conf_formtype'=>'hidden',
													'conf_valuetype'=>'text'
												);
							$config->setVars($configValue);
							$configHandler->insertConfig($config);
						}
					}

					$testParam['watermark_position'] = $_POST['watermark_position'];
					if(icms::$module->config['watermark_position'] != $_POST['watermark_position']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','watermark_position'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'watermark_position',
												'conf_value'=>$_POST['watermark_position'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'text'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					$testParam['watermark_color'] = $_POST['watermark_color'];
					if(icms::$module->config['watermark_color'] != $_POST['watermark_color']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','watermark_color'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'watermark_color',
												'conf_value'=>$_POST['watermark_color'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'text'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					$testParam['watermark_fontsize'] = $_POST['watermark_fontsize'];
					if(icms::$module->config['watermark_fontsize'] != $_POST['watermark_fontsize']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','watermark_fontsize'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'watermark_fontsize',
												'conf_value'=>$_POST['watermark_fontsize'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'int'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					$testParam['watermark_padding'] = $_POST['watermark_padding'];
					if(icms::$module->config['watermark_padding'] != $_POST['watermark_padding']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','watermark_padding'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'watermark_padding',
												'conf_value'=>$_POST['watermark_padding'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'int'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}
				}

				if(isset($_POST['inner_border_color'])) {

					$testParam['inner_border_color'] = $_POST['inner_border_color'];
					if(icms::$module->config['inner_border_color'] != $_POST['inner_border_color']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','inner_border_color'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'inner_border_color',
												'conf_value'=>$_POST['inner_border_color'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'text'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					$testParam['inner_border_size'] = $_POST['inner_border_size'];
					if(icms::$module->config['inner_border_size'] != $_POST['inner_border_size']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','inner_border_size'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'inner_border_size',
												'conf_value'=>$_POST['inner_border_size'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'int'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					$testParam['outer_border_color'] = $_POST['outer_border_color'];
					if(icms::$module->config['outer_border_color'] != $_POST['outer_border_color']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','outer_border_color'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'outer_border_color',
												'conf_value'=>$_POST['outer_border_color'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'text'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}

					$testParam['outer_border_size'] = $_POST['outer_border_size'];
					if(icms::$module->config['outer_border_size'] != $_POST['outer_border_size']) {
						$criteria = new icms_db_criteria_Compo();
						$criteria->add($moduleIdCriteria);
						$criteria->add(new icms_db_criteria_Item('conf_name','outer_border_size'));
						$config = $configHandler->getConfigs($criteria);
						$config = $config[0];
						$configValue = array(
												'conf_modid'=>icms::$module->getVar('mid'),
												'conf_catid'=>0,
												'conf_name'=>'outer_border_size',
												'conf_value'=>$_POST['outer_border_size'],
												'conf_formtype'=>'hidden',
												'conf_valuetype'=>'int'
											);
						$config->setVars($configValue);
						$configHandler->insertConfig($config);
					}
				}


				// Refresh the photo exemple

				include_once ICMS_ROOT_PATH.'/modules/extgallery/class/pear/Image/Transform.php';

				// Loading original image
				// Define Graphical library path
				if(icms::$module->config['graphic_lib'] == 'IM') {
					define('IMAGE_TRANSFORM_IM_PATH', icms::$module->config['graphic_lib_path']);
				}
				$imageTransform = Image_Transform::factory(icms::$module->config['graphic_lib']);
				$imageTransform->load("../images/watermark-border-orig.jpg");

				// Making Watermark
				if($testParam['watermark_position'] == "tl") {
					$x = 0;
					$y = 0;
				} elseif($testParam['watermark_position'] == "tr") {
					$x = -1;
					$y = 0;
				} elseif($testParam['watermark_position'] == "bl") {
					$x = 0;
					$y = -1;
				} elseif($testParam['watermark_position'] == "br") {
					$x = -1;
					$y = -1;
				} elseif($testParam['watermark_position'] == "tc") {
					$x = 1;
					$y = 0;
				} elseif($testParam['watermark_position'] == "bc") {
					$x = 1;
					$y = -1;
				} elseif($testParam['watermark_position'] == "lc") {
					$x = 0;
					$y = 1;
				} elseif($testParam['watermark_position'] == "rc") {
					$x = -1;
					$y = 1;
				} elseif($testParam['watermark_position'] == "cc") {
					$x = 1;
					$y = 1;
				}

				$text = ($testParam['watermark_type'] == 0) ? icms::$user->getVar('uname') : $testParam['watermark_text'];

				$watermarkParams = array(
					'text'=>$text,
					'x'=>$x,
					'y'=>$y,
					'color'=>$testParam['watermark_color'],
					'font'=>"../fonts/".$testParam['watermark_font'],
					'size'=>$testParam['watermark_fontsize'],
					'resize_first'=>false,
					'padding'=>$testParam['watermark_padding']
				);
				$imageTransform->addText($watermarkParams);

				// Making border
				$borders = array();
				$borders[] = array('borderWidth'=>$testParam['inner_border_size'], 'borderColor'=>$testParam['inner_border_color']);
				$borders[] = array('borderWidth'=>$testParam['outer_border_size'], 'borderColor'=>$testParam['outer_border_color']);
				$imageTransform->addBorders($borders);

				// Remove old test image
				deleteImageTest();
				// Saving transformation on test image
				$imageTransform->save("../images/watermark-border-test-".substr(md5(uniqid(rand())),27).".jpg");
				$imageTransform->free();

				redirect_header("watermark-border.php", 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);

				break;

		}

		break;

	case 'default':
	default:


		icms_cp_header();
		icms::$module -> displayAdminMenu( 6, icms::$module -> getVar( 'name' ) );

		echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_FONT_MANAGMENT.'</legend>';

		$nbFonts = 0;
		$fonts = array();

		$rep = ICMS_ROOT_PATH.'/modules/extgallery/fonts/';
		$dir = opendir($rep);
		while ($f = readdir($dir)) {
			if(is_file($rep.$f)) {
				if(preg_match("/.*ttf/",strtolower($f))) {
					$nbFonts++;
					$fonts[] = $f;
				}
			}
		}

		echo sprintf(_AM_EXTGALLERY_ADD_FONT_LINK,$nbFonts).'<br /><br />';

		foreach($fonts as $font) {
			echo $font.", ";
		}

		echo '</fieldset><br />';

		echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_WATERMARK_CONF.'</legend>';

		// Display Watermark param form if FreeType is supported
		if(function_exists('imagettfbbox')) {

			$form = new icms_form_Theme(_AM_EXTGALLERY_WATERMARK_CONF, 'watermark_conf', 'watermark-border.php?op=conf', 'post', true);
			$fontSelect = new icms_form_elements_Select(_AM_EXTGALLERY_FONT, 'watermark_font', icms::$module->config['watermark_font']);
			foreach($fonts as $font) {
				$fontSelect->addOption($font, $font);
			}
			$form->addElement($fontSelect);

			$elementTray = new icms_form_elements_Tray(_AM_EXTGALLERY_WATERMARK_TEXT, "&nbsp;");

			$selected1 = icms::$module->config['watermark_type'] == 1 ? " checked=\"checked\"" : "";
			$disable = icms::$module->config['watermark_type'] == 0 ? " disabled=\"disabled\"" : "";
			$style = icms::$module->config['watermark_type'] == 0 ? " style=\"background-color:#DDDDDD;\"" : "";
			$onClick = ' onClick="document.getElementById(\'watermark_text\').disabled = false; document.getElementById(\'watermark_text\').style.backgroundColor = \'#FFFFFF\';"';
			$WTextForm = '<input type="radio" name="watermark_type" value="1"'.$selected1.$onClick.' /> <input name="watermark_text" id="watermark_text" size="50" maxlength="255" value="'.icms::$module->config['watermark_text'].'" type="text"'.$disable.$style.' /><br />';

			$selected2 = icms::$module->config['watermark_type'] == 0 ? " checked=\"checked\"" : "";
			$onClick = ' onClick="document.getElementById(\'watermark_text\').disabled = true; document.getElementById(\'watermark_text\').style.backgroundColor = \'#DDDDDD\';"';
			$WTextForm .= '<input type="radio" name="watermark_type" value="0"'.$selected2.$onClick.' /> '._AM_EXTGALLERY_PRINT_SUBMITTER_UNAME;

			$elementTray->addElement(new icms_form_elements_Label("", $WTextForm), false);
			$form->addElement($elementTray);
			$positionSelect = new icms_form_elements_Select(_AM_EXTGALLERY_POSITION, 'watermark_position',icms::$module->config['watermark_position']);
			$positionSelect->addOption("tl", _AM_EXTGALLERY_TOP_LEFT);
			$positionSelect->addOption("tr", _AM_EXTGALLERY_TOP_RIGHT);
			$positionSelect->addOption("bl", _AM_EXTGALLERY_BOTTOM_LEFT);
			$positionSelect->addOption("br", _AM_EXTGALLERY_BOTTOM_RIGHT);
			$positionSelect->addOption("tc", _AM_EXTGALLERY_TOP_CENTER);
			$positionSelect->addOption("bc", _AM_EXTGALLERY_BOTTOM_CENTER);
			$positionSelect->addOption("lc", _AM_EXTGALLERY_LEFT_CENTER);
			$positionSelect->addOption("rc", _AM_EXTGALLERY_RIGHT_CENTER);
			$positionSelect->addOption("cc", _AM_EXTGALLERY_CENTER_CENTER);
			$form->addElement($positionSelect);
			$form->addElement(new icms_form_elements_ColorPicker(_AM_EXTGALLERY_WATERMARK_COLOR, 'watermark_color', icms::$module->config['watermark_color']),false);
			$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_WATERMARK_FONT_SIZE, 'watermark_fontsize', '2', '2', icms::$module->config['watermark_fontsize']),false);
			$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_WATERMARK_PADDING, 'watermark_padding', '2', '2', icms::$module->config['watermark_padding']),false);
			$form->addElement(new icms_form_elements_Hidden("step", 'enreg'));
			$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
			$form->display();

		// Else display Warning message
		} else {

			echo _AM_EXTGALLERY_WATERMARK_FREETYPE_WARN;

		}

		echo '</fieldset><br />';

		echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_BORDER_CONF.'</legend>';

		$form = new icms_form_Theme(_AM_EXTGALLERY_BORDER_CONF, 'border_conf', 'watermark-border.php?op=conf', 'post', true);
		$form->addElement(new icms_form_elements_ColorPicker(_AM_EXTGALLERY_INNER_BORDER_COLOR, 'inner_border_color', icms::$module->config['inner_border_color']),false);
		$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_INNER_BORDER_SIZE, 'inner_border_size', '2', '2', icms::$module->config['inner_border_size']),false);
		$form->addElement(new icms_form_elements_ColorPicker(_AM_EXTGALLERY_OUTER_BORDER_COLOR, 'outer_border_color', icms::$module->config['outer_border_color']),false);
		$form->addElement(new icms_form_elements_Text(_AM_EXTGALLERY_OUTER_BORDER_SIZE, 'outer_border_size', '2', '2', icms::$module->config['outer_border_size']),false);
		$form->addElement(new icms_form_elements_Hidden("step", 'enreg'));
		$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
		$form->display();

		echo '</fieldset><br />';

		echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_WATERMARK_BORDER_EXEMPLE.'</legend>';
		echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
		echo _AM_EXTGALLERY_WATERMARK_BORDER_EXEMPLE_INFO;
		echo '</fieldset>';
		$imageTest = getImageTest();
		echo '<div style="text-align:center; padding:10px;"><img src="../images/'.$imageTest[0].'" /></div>';

		echo '</fieldset>';

		icms_cp_footer();

		break;

}

function getImageTest() {
	$ret = array();
	$rep = ICMS_ROOT_PATH.'/modules/extgallery/images/';
	$dir = opendir($rep);
	while ($f = readdir($dir)) {
	   if(is_file($rep.$f)) {
	      if(preg_match('/watermark-border-test/',$f)) {
	      	$ret[] = $f;
	      }
	   }
	}
	return $ret;
}

function deleteImageTest() {
	$files = getImageTest();
	foreach($files as $file) {
		unlink(ICMS_ROOT_PATH.'/modules/extgallery/images/'.$file);
	}
}

?>