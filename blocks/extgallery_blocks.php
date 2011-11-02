<?php

function extgalleryRandomShow($options) {

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

	$param = array('limit'=>$options[0]);
	$direction = $options[1];
	$desc = $options[2];

	array_shift($options);
	array_shift($options);
	array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

	$photos = $photoHandler->objectToArray($photoHandler->getRandomPhoto($param));

	if(count($photos) == 0) {
		return array();
	}

	$ret = 	array(
				'photos'=>$photos,
				'direction'=>$direction,
				'desc'=>$desc
			);
	return $ret;
}

function extgalleryLastShow($options) {

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

	$param = array('limit'=>$options[0]);
	$direction = $options[1];
	$desc = $options[2];

	array_shift($options);
	array_shift($options);
	array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

	$photos = $photoHandler->objectToArray($photoHandler->getLastPhoto($param));

	if(count($photos) == 0) {
		return array();
	}

	$ret = 	array(
				'photos'=>$photos,
				'direction'=>$direction,
				'desc'=>$desc
			);
	return $ret;
}

function extgalleryTopViewShow($options) {

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

	$param = array('limit'=>$options[0]);
	$direction = $options[1];
	$desc = $options[2];

	array_shift($options);
	array_shift($options);
	array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

	$photos = $photoHandler->objectToArray($photoHandler->getTopViewPhoto($param));

	if(count($photos) == 0) {
		return array();
	}

	$ret = 	array(
				'photos'=>$photos,
				'direction'=>$direction,
				'desc'=>$desc
			);
	return $ret;
}

function extgalleryTopRatedShow($options) {

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

	$param = array('limit'=>$options[0]);
	$direction = $options[1];
	$desc = $options[2];

	array_shift($options);
	array_shift($options);
	array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

	$photos = $photoHandler->objectToArray($photoHandler->getTopRatedPhoto($param));

	if(count($photos) == 0) {
		return array();
	}

	$ret = 	array(
				'photos'=>$photos,
				'direction'=>$direction,
				'desc'=>$desc
			);
	return $ret;
}

function extgalleryTopEcardShow($options) {

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

	$param = array('limit'=>$options[0]);
	$direction = $options[1];
	$desc = $options[2];

	array_shift($options);
	array_shift($options);
	array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

	$photos = $photoHandler->objectToArray($photoHandler->getTopEcardPhoto($param));

	if(count($photos) == 0) {
		return array();
	}

	$ret = 	array(
				'photos'=>$photos,
				'direction'=>$direction,
				'desc'=>$desc
			);
	return $ret;
}

function extgalleryTopSubmitterShow($options) {

    if ($options[1] != 0) {
        $cat = array_slice($options, 1); //Get information about categories to display
        $catauth = implodeArray2Dextgallery(',', $cat); //Creation of categories list to use - separated by a coma
    }
    $sql = 'SELECT uid, count(photo_id) as countphoto FROM '.icms::$xoopsDB->prefix('extgallery_publicphoto');
    $sql .= ' WHERE (uid>0)';
    if ($options[1] != 0) {
        $sql .= ' AND cat_id IN ('.$catauth.')';
    }
    $sql .= ' GROUP BY uid ORDER BY countphoto DESC';
    if (intval($options[0]) > 0) {
        $sql .= ' LIMIT '.intval($options[0]);
    }
    $result = icms::$xoopsDB->query($sql);
    if (!$result) {
        return '';
    }
    while ($myrow = icms::$xoopsDB->fetchArray($result)) {
        $uid = $myrow['uid'];
        $countphoto = $myrow['countphoto'];
        $uname = icms_member_user_Handler::getUserLink($myrow['uid']);
        $block['designers'][] = array('uid' => $uid, 'uname' => $uname, 'countphoto' => $countphoto);
    }
    return $block;

}

function extgalleryRandomSlideshowShow($options) {
	global $xoTheme;

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

 $delay = $options[0];
 $duration = $options[1];
 $transtype = $options[2];
 $effecttype = $options[3];
 $effectoption = $options[4];
 $nbSlideshow = $options[5];
	$param = array('limit'=>$options[6]);
	$direction = $options[7];
	$desc = $options[8];

 // Include for SlideShow
 $xoTheme->addStylesheet('modules/extgallery/include/slideshow/css/slideshow-block.css');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/Asset.js');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.js');
 if($transtype == 'fold') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.fold.js');
 } elseif($transtype == 'kenburns') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.kenburns.js');
 } elseif($transtype == 'push') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/Element.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/aElement.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.push.js');
 }

	array_shift($options);
	array_shift($options);
	array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

 for($i=0;$i<$nbSlideshow;$i++) {
  $slideshows[] = $photoHandler->objectToArray($photoHandler->getRandomPhoto($param));
 }

 // Retrive module configuration
 $dirname = (isset(icms::$module) ? icms::$module->getVar('dirname') :'system');
 if($dirname == 'extgallery') {
  $moduleConfig = icms::$config;
 } else {
  $moduleHandler = icms::handler( 'icms_module' );
  $module = $moduleHandler->getByDirname('extgallery');
  $config_handler = icms::$config;
  $moduleConfig = $config_handler->getConfigList($module->getVar("mid"));
 }

	$ret = 	array(
					'slideshows'=>$slideshows,
					'direction'=>$direction,
					'desc'=>$desc,
					'delay'=>$delay,
					'duration'=>$duration,
					'transtype'=>$transtype,
					'effecttype'=>$effecttype,
					'effectoption'=>$effectoption,
					'uniqid'=>substr(md5(uniqid(rand())),27),
					'display_type'=>$moduleConfig['display_type'] );
	return $ret;
}

function extgalleryLastSlideshowShow($options) {
	global $xoTheme;

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

 $delay = $options[0];
 $duration = $options[1];
 $transtype = $options[2];
 $effecttype = $options[3];
 $effectoption = $options[4];
 $nbSlideshow = $options[5];
 $param = array('limit'=>$options[6]);
 $direction = $options[7];
 $desc = $options[8];

 // Include for SlideShow
 $xoTheme->addStylesheet('modules/extgallery/include/slideshow/css/slideshow-block.css');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/Asset.js');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.js');
 if($transtype == 'fold') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.fold.js');
 } elseif($transtype == 'kenburns') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.kenburns.js');
 } elseif($transtype == 'push') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/Element.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/aElement.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.push.js');
 }

 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

 for($i=0;$i<$nbSlideshow;$i++) {
  $slideshows[] = $photoHandler->objectToArray($photoHandler->getLastPhoto($param));
 }

	// Retrive module configuration
 $dirname = (isset(icms::$module) ? icms::$module->getVar('dirname') :'system');
 if($dirname == 'extgallery') {
  $moduleConfig = icms::$config;
 } else {
  $moduleHandler = icms::handler( 'icms_module' );
  $module = $moduleHandler->getByDirname('extgallery');
  $config_handler = icms::$config;
  $moduleConfig = $config_handler->getConfigList($module->getVar("mid"));
 }

	$ret = 	array(
					'slideshows'=>$slideshows,
					'direction'=>$direction,
					'desc'=>$desc,
					'delay'=>$delay,
					'duration'=>$duration,
					'transtype'=>$transtype,
					'effecttype'=>$effecttype,
					'effectoption'=>$effectoption,
					'uniqid'=>substr(md5(uniqid(rand())),27),
					'display_type'=>$moduleConfig['display_type'] );
	return $ret;
}

function extgalleryTopViewSlideshowShow($options) {
	global $xoTheme;

	$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

 $delay = $options[0];
 $duration = $options[1];
 $transtype = $options[2];
 $effecttype = $options[3];
 $effectoption = $options[4];
 $nbSlideshow = $options[5];
 $param = array('limit'=>$options[6]);
 $direction = $options[7];
 $desc = $options[8];

 // Include for SlideShow
 $xoTheme->addStylesheet('modules/extgallery/include/slideshow/css/slideshow-block.css');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/Asset.js');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.js');
 if($transtype == 'fold') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.fold.js');
 } elseif($transtype == 'kenburns') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.kenburns.js');
 } elseif($transtype == 'push') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/Element.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/aElement.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.push.js');
 }

 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

 for($i=0;$i<$nbSlideshow;$i++) {
  $slideshows[] = $photoHandler->objectToArray($photoHandler->getTopViewPhoto($param));
 }

	// Retrive module configuration
 $dirname = (isset(icms::$module) ? icms::$module->getVar('dirname') :'system');
 if($dirname == 'extgallery') {
  $moduleConfig = icms::$config;
 } else {
  $moduleHandler = icms::handler( 'icms_module' );
  $module = $moduleHandler->getByDirname('extgallery');
  $config_handler = icms::$config;
  $moduleConfig = $config_handler->getConfigList($module->getVar("mid"));
 }

	$ret = 	array(
					'slideshows'=>$slideshows,
					'direction'=>$direction,
					'desc'=>$desc,
					'delay'=>$delay,
					'duration'=>$duration,
					'transtype'=>$transtype,
					'effecttype'=>$effecttype,
					'effectoption'=>$effectoption,
					'uniqid'=>substr(md5(uniqid(rand())),27),
					'display_type'=>$moduleConfig['display_type'] );
	return $ret;
}

function extgalleryTopRatedSlideshowShow($options) {
 global $xoTheme;

 $photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

 $delay = $options[0];
 $duration = $options[1];
 $transtype = $options[2];
 $effecttype = $options[3];
 $effectoption = $options[4];
 $nbSlideshow = $options[5];
 $param = array('limit'=>$options[6]);
 $direction = $options[7];
 $desc = $options[8];

 // Include for SlideShow
 $xoTheme->addStylesheet('modules/extgallery/include/slideshow/css/slideshow-block.css');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/Asset.js');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.js');
 if($transtype == 'fold') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.fold.js');
 } elseif($transtype == 'kenburns') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.kenburns.js');
 } elseif($transtype == 'push') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/Element.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/aElement.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.push.js');
 }

 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

 for($i=0;$i<$nbSlideshow;$i++) {
  $slideshows[] = $photoHandler->objectToArray($photoHandler->getTopRatedPhoto($param));
 }

	// Retrive module configuration
 $dirname = (isset(icms::$module) ? icms::$module->getVar('dirname') :'system');
 if($dirname == 'extgallery') {
  $moduleConfig = icms::$config;
 } else {
  $moduleHandler = icms::handler( 'icms_module' );;
  $module = $moduleHandler->getByDirname('extgallery');
  $config_handler = icms::$config;
  $moduleConfig = $config_handler->getConfigList($module->getVar("mid"));
 }

	$ret = 	array(
					'slideshows'=>$slideshows,
					'direction'=>$direction,
					'desc'=>$desc,
					'delay'=>$delay,
					'duration'=>$duration,
					'transtype'=>$transtype,
					'effecttype'=>$effecttype,
					'effectoption'=>$effectoption,
					'uniqid'=>substr(md5(uniqid(rand())),27),
					'display_type'=>$moduleConfig['display_type']);
	return $ret;
}

function extgalleryTopEcardSlideshowShow($options) {
 global $xoTheme;

 $photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

 $delay = $options[0];
 $duration = $options[1];
 $transtype = $options[2];
 $effecttype = $options[3];
 $effectoption = $options[4];
 $nbSlideshow = $options[5];
 $param = array('limit'=>$options[6]);
 $direction = $options[7];
 $desc = $options[8];

 // Include for SlideShow
 $xoTheme->addStylesheet('modules/extgallery/include/slideshow/css/slideshow-block.css');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/Asset.js');
 $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.js');
 if($transtype == 'fold') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.fold.js');
 } elseif($transtype == 'kenburns') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.kenburns.js');
 } elseif($transtype == 'push') {
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/Element.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/aElement.js');
  $xoTheme->addScript('modules/extgallery/include/slideshow/js/slideshow.push.js');
 }

 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);
 array_shift($options);

	$categories = array();
	foreach($options as $cat) {
		if($cat == 0) {
			$categories = array();
			break;
		}
		$categories[] = $cat;
	}
	$param['cat'] = $categories;

 for($i=0;$i<$nbSlideshow;$i++) {
  $slideshows[] = $photoHandler->objectToArray($photoHandler->getTopEcardPhoto($param));
 }

	// Retrive module configuration
 $dirname = (isset(icms::$module) ? icms::$module->getVar('dirname') :'system');
 if($dirname == 'extgallery') {
  $moduleConfig = icms::$config;
 } else {
  $moduleHandler = icms::handler( 'icms_module' );;
  $module = $moduleHandler->getByDirname('extgallery');
  $config_handler = icms::$config;
  $moduleConfig = $config_handler->getConfigList($module->getVar("mid"));
 }

	$ret = 	array(
					'slideshows'=>$slideshows,
					'direction'=>$direction,
					'desc'=>$desc,
					'delay'=>$delay,
					'duration'=>$duration,
					'transtype'=>$transtype,
					'effecttype'=>$effecttype,
					'effectoption'=>$effectoption,
					'uniqid'=>substr(md5(uniqid(rand())),27),
					'display_type'=>$moduleConfig['display_type']);
	return $ret;
}

function extgalleryBlockEdit($options) {

	$catHandler = icms_getModuleHandler('publiccat', 'extgallery');

	$form = _MB_EXTGALLERY_PHOTO_NUMBER." : <input name=\"options[]\" size=\"5\" maxlength=\"255\" value=\"".$options[0]."\" type=\"text\" /><br />";
	$hSelected = "";
	$vSelected = "";
	if($options[1] == 0) {
		$hSelected = ' selected="selected"';
	} else {
		$vSelected = ' selected="selected"';
	}
	$form .= _MB_EXTGALLERY_DIRECTION.' : <select name="options[]">';
	$form .= '<option value="0"'.$hSelected.'>'._MB_EXTGALLERY_HORIZONTALLY.'</option>';
	$form .= '<option value="1"'.$vSelected.'>'._MB_EXTGALLERY_VERTICALLY.'</option>';
	$form .= '</select><br />';

	$yChecked = "";
	$nChecked = "";
	if($options[2] == 1) {
		$yChecked = ' checked="checked"';
	} else {
		$nChecked = ' checked="checked"';
	}
	array_shift($options);
	array_shift($options);
	array_shift($options);
	$form .= _MB_EXTGALLERY_DISPLAY_DESC.' : <input type="radio" name="options[]" value="1"'.$yChecked.' />&nbsp;'._YES.'&nbsp;&nbsp;<input type="radio" name="options[]" value="0"'.$nChecked.' />'._NO.'<br />';
	$form .= $catHandler->getBlockSelect($options);
	return $form;
}

function extgalleryBlockSlideshowEdit($options) {

 $catHandler = icms_getModuleHandler('publiccat', 'extgallery');
 $form = _MB_EXTGALLERY_SLIDESHOW_DELAY." : <input name=\"options[]\" size=\"5\" maxlength=\"255\" value=\"".$options[0]."\" type=\"text\" /><br />";
 $form .= _MB_EXTGALLERY_SLIDESHOW_DURATION." : <input name=\"options[]\" size=\"5\" maxlength=\"255\" value=\"".$options[1]."\" type=\"text\" /><br />";

 $transTypeSelect = new icms_form_elements_Select(_MB_EXTGALLERY_TRANSTYPE, 'options[]',$options[2]);
	$transTypeSelect->addOption("default", _MB_EXTGALLERY_DEFAULT);
 $transTypeSelect->addOption("fold", _MB_EXTGALLERY_FOLD);
 $transTypeSelect->addOption("kenburns", _MB_EXTGALLERY_KENBURNS);
 $transTypeSelect->addOption("push", _MB_EXTGALLERY_PUSH);
 $form .= _MB_EXTGALLERY_TRANSTYPE." : ".$transTypeSelect->render().'<br />';

 $effectTypeSelect = new icms_form_elements_Select(_MB_EXTGALLERY_EFFECT_TYPE, 'options[]',$options[3]);
 $effectTypeSelect->addOption("quad", _MB_EXTGALLERY_QUAD);
 $effectTypeSelect->addOption("cubic", _MB_EXTGALLERY_CUBIC);
 $effectTypeSelect->addOption("quart", _MB_EXTGALLERY_QUART);
 $effectTypeSelect->addOption("quint", _MB_EXTGALLERY_QUINT);
 $effectTypeSelect->addOption("expo", _MB_EXTGALLERY_EXPO);
 $effectTypeSelect->addOption("circ", _MB_EXTGALLERY_CIRC);
 $effectTypeSelect->addOption("sine", _MB_EXTGALLERY_SINE);
 $effectTypeSelect->addOption("back", _MB_EXTGALLERY_BACK);
 $effectTypeSelect->addOption("bounce", _MB_EXTGALLERY_BOUNCE);
 $effectTypeSelect->addOption("elastic", _MB_EXTGALLERY_ELASTIC);
 $form .= _MB_EXTGALLERY_EFFECT_TYPE." : ".$effectTypeSelect->render().'<br />';

 $effectOptionSelect = new icms_form_elements_Select(_MB_EXTGALLERY_EFFECT_OPTION, 'options[]',$options[4]);
 $effectOptionSelect->addOption("in", _MB_EXTGALLERY_IN);
 $effectOptionSelect->addOption("out", _MB_EXTGALLERY_OUT);
 $effectOptionSelect->addOption("in:out", _MB_EXTGALLERY_INOUT);
 $form .= _MB_EXTGALLERY_EFFECT_OPTION." : ".$effectOptionSelect->render().'<br />';

	$form .= _MB_EXTGALLERY_SLIDESHOW_NUMBER." : <input name=\"options[]\" size=\"5\" maxlength=\"255\" value=\"".$options[5]."\" type=\"text\" /><br />";
 $form .= _MB_EXTGALLERY_NB_PHOTO_BY_SLIDESHOW." : <input name=\"options[]\" size=\"5\" maxlength=\"255\" value=\"".$options[6]."\" type=\"text\" /><br />";

	$hSelected = "";
	$vSelected = "";
	if($options[7] == 0) {
		$hSelected = ' selected="selected"';
	} else {
		$vSelected = ' selected="selected"';
	}
	$form .= _MB_EXTGALLERY_DIRECTION.' : <select name="options[]">';
	$form .= '<option value="0"'.$hSelected.'>'._MB_EXTGALLERY_HORIZONTALLY.'</option>';
	$form .= '<option value="1"'.$vSelected.'>'._MB_EXTGALLERY_VERTICALLY.'</option>';
	$form .= '</select><br />';

	$yChecked = "";
	$nChecked = "";
	if($options[8] == 1) {
		$yChecked = ' checked="checked"';
	} else {
		$nChecked = ' checked="checked"';
	}
	array_shift($options);
	array_shift($options);
	array_shift($options);
	array_shift($options);
	array_shift($options);
	array_shift($options);
	array_shift($options);
	array_shift($options);
	array_shift($options);

	$form .= _MB_EXTGALLERY_DISPLAY_DESC.' : <input type="radio" name="options[]" value="1"'.$yChecked.' />&nbsp;'._YES.'&nbsp;&nbsp;<input type="radio" name="options[]" value="0"'.$nChecked.' />'._NO.'<br />';
	$form .= $catHandler->getBlockSelect($options);
	return $form;
}

?>