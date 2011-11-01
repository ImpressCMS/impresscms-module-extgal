<?php

$modversion['name'] 			= _MI_EXTGAL_NAME;
$modversion['version'] 			= '1.0';
$modversion['status'] 			= '';
$modversion['status_version'] 	= '';
$modversion['date'] 			= 'xx xxxxx 2011';
$modversion['description'] 		= _MI_EXTGAL_DESC;
$modversion['credits'] 			= "http://www.zoullou.net/  http://www.mrtheme.com";
$modversion['author'] 			= "Zoullou // (ported to ICMS by Mr. Theme)";
$modversion['help'] 			= "";
$modversion['license'] 			= "GPL see LICENSE";
$modversion['official'] 		= 0;
$modversion['dirname'] 			= basename( dirname( __FILE__ ) );

$modversion['onInstall'] 		= 'include/install_function.php';
$modversion['onUpdate'] 		= 'include/update_function.php';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['iconsmall'] = "images/extgallery_small.png";
$modversion['iconbig'] = "images/extgallery_logo.png";
$modversion['image'] = "images/extgallery_logo.png"; /* for backward compatibility */

// Menu
$modversion['hasMain'] = 1;
if(isset(icms::$module) && icms::$module->getVar('dirname') == "extgallery") {

	if(icms::$user != null) {
		$modversion['sub'][0]['name'] = _MI_EXTGALLERY_USERALBUM;
		$modversion['sub'][0]['url'] = "public-useralbum.php?id=".icms::$user->getVar('uid');
	}

	include_once ICMS_ROOT_PATH.'/modules/extgallery/class/publicPerm.php';
	$permHandler = ExtgalleryPublicPermHandler::getHandler();
	if(count($permHandler->getAuthorizedPublicCat(icms::$user, 'public_upload')) > 0) {
		$modversion['sub'][1]['name'] = _MI_EXTGALLERY_PUBLIC_UPLOAD;
		if(icms::$module->config['use_extended_upload'] == 'html') {
		 $modversion['sub'][1]['url'] = "public-upload.php";
		} else {
		 $modversion['sub'][1]['url'] = "public-upload-extended.php";
		}
	}
}

// SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "extgallery_publiccat";
$modversion['tables'][2] = "extgallery_publicphoto";
$modversion['tables'][3] = "extgallery_quota";
$modversion['tables'][4] = "extgallery_publicrating";
$modversion['tables'][5] = "extgallery_publicecard";

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'photoId';
$modversion['comments']['pageName'] = 'public-photo.php';
$modversion['comments']['callbackFile'] = 'include/comment_function.php';
$modversion['comments']['callback']['update'] = 'extgalleryComUpdate';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "extgallerySearch";

$i = 0;
// Config items
$modversion['config'][$i]['name'] = 'display_type';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_DISP_TYPE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_TYPE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(_MI_EXTGALLERY_SLIDESHOW => 'slideshow', _MI_EXTGALLERY_ALBUM => 'album');
$modversion['config'][$i]['default'] = 'album';
$i++;
$modversion['config'][$i]['name'] = 'nb_column';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_NB_COLUMN';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_NB_COLUMN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 4;
$i++;
$modversion['config'][$i]['name'] = 'nb_line';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_NB_LINE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_NB_LINE_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 7;
$i++;
$modversion['config'][$i]['name'] = 'save_large';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_SAVE_L';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_SAVE_L_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'save_original';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_SAVE_ORIG';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_SAVE_ORIG_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'medium_width';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_M_WIDTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_WIDTH_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 600;
$i++;
$modversion['config'][$i]['name'] = 'medium_heigth';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_M_HEIGTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_HEIGTH_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 600;
$i++;
$modversion['config'][$i]['name'] = 'medium_quality';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_M_QUALITY';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_QUALITY_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 75;
$i++;
$modversion['config'][$i]['name'] = 'thumb_width';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_T_WIDTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_T_WIDTH_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 100;
$i++;
$modversion['config'][$i]['name'] = 'thumb_heigth';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_T_HEIGTH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_T_HEIGTH_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 100;
$i++;
$modversion['config'][$i]['name'] = 'thumb_quality';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_T_QUALITY';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_T_QUALITY_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 75;
$i++;
$modversion['config'][$i]['name'] = 'enable_medium_watermark';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_M_WATERMARK';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_WATERMARK_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'enable_medium_border';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_M_BORDER';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_BORDER_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'enable_large_watermark';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_L_WATERMARK';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_L_WATERMARK_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'enable_large_border';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_L_BORDER';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_L_BORDER_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'enable_rating';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_ENABLE_RATING';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ENABLE_RATING_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'display_extra_field';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_DISPLAY_EXTRA';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISPLAY_EXTRA_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'allow_html';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_ALLOW_HTML';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ALLOW_HTML_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'photoname_pattern';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_NAME_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_NAME_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = "`([a-zA-Z0-9]+)[-_]`";
$i++;
$modversion['config'][$i]['name'] = 'admin_nb_photo';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_ADM_NBPHOTO';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_ADM_NBPHOTO_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$i++;
$modversion['config'][$i]['name'] = 'graphic_lib';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_GRAPHLIB';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_GRAPHLIB_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'GD';
$modversion['config'][$i]['options'] = array('GD 2' => 'GD', 'ImageMagick 6 Binary' => 'IM');
$i++;
$modversion['config'][$i]['name'] = 'graphic_lib_path';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_GRAPHLIB_PATH';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_GRAPHLIB_PATH_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '/usr/local/bin/';
$i++;
$modversion['config'][$i]['name'] = 'disp_ph_title';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_DISP_PH_TITLE';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_PH_TITLE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'disp_cat_img';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_DISP_CAT_IMG';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_DISP_CAT_IMG_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'use_extended_upload';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_EXT_UPLOAD';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_EXT_UPLOAD_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'applet';
$modversion['config'][$i]['options'] = array(_MI_EXTGALLERY_EXTENDED => 'applet', _MI_EXTGALLERY_STANDARD => 'html');

// Hidden preferences field
$i++;
$modversion['config'][$i]['name'] = 'watermark_type';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_M_WATERMARK';
$modversion['config'][$i]['description'] = '_MI_EXTGAL_M_WATERMARK_DESC';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'watermark_font';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'AllStarResort.ttf';
$i++;
$modversion['config'][$i]['name'] = 'watermark_text';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $GLOBALS['xoopsConfig']['sitename'];
$i++;
$modversion['config'][$i]['name'] = 'watermark_position';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tr';
$i++;
$modversion['config'][$i]['name'] = 'watermark_color';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFFFF';
$i++;
$modversion['config'][$i]['name'] = 'watermark_fontsize';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 16;
$i++;
$modversion['config'][$i]['name'] = 'watermark_padding';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$i++;
$modversion['config'][$i]['name'] = 'inner_border_color';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFFFF';
$i++;
$modversion['config'][$i]['name'] = 'inner_border_size';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 2;
$i++;
$modversion['config'][$i]['name'] = 'outer_border_color';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#000000';
$i++;
$modversion['config'][$i]['name'] = 'outer_border_size';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$i++;
$modversion['config'][$i]['name'] = 'slideshow_delay';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5000;
$i++;
$modversion['config'][$i]['name'] = 'slideshow_duration';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1000;
$i++;
$modversion['config'][$i]['name'] = 'slideshow_transtype';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'default';
$i++;
$modversion['config'][$i]['name'] = 'slideshow_effecttype';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'back';
$i++;
$modversion['config'][$i]['name'] = 'slideshow_effectoption';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'in:out';
$i++;
$modversion['config'][$i]['name'] = 'slideshow_caption';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'slideshow_thumb';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'slideshow_controller';
$modversion['config'][$i]['title'] = '_MI_EXTGAL_HIDDEN_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

// Templates
$modversion['templates'][1]['file'] = 'extgallery_public-categories.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'extgallery_public-album.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'extgallery_public-photo.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'extgallery_index.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'extgallery_public-sendecard.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'extgallery_public-viewecard.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'extgallery_public-useralbum.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'extgallery_public-userphoto.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'extgallery_public-slideshow.html';
$modversion['templates'][9]['description'] = '';
$modversion['templates'][10]['file'] = 'extgallery_public-upload-applet.html';
$modversion['templates'][10]['description'] = '';

// Blocs
$modversion['blocks'][1]['file'] = "extgallery_blocks.php";
$modversion['blocks'][1]['name'] = _MI_EXTGAL_B_RAND;
$modversion['blocks'][1]['description'] = '';
$modversion['blocks'][1]['show_func'] = "extgalleryRandomShow";
$modversion['blocks'][1]['options'] = "4|0|0|0";
$modversion['blocks'][1]['edit_func'] = "extgalleryBlockEdit";
$modversion['blocks'][1]['template'] = 'extgallery_block_random.html';

$modversion['blocks'][2]['file'] = "extgallery_blocks.php";
$modversion['blocks'][2]['name'] = _MI_EXTGAL_B_LAST;
$modversion['blocks'][2]['description'] = '';
$modversion['blocks'][2]['show_func'] = "extgalleryLastShow";
$modversion['blocks'][2]['options'] = "4|0|0|0";
$modversion['blocks'][2]['edit_func'] = "extgalleryBlockEdit";
$modversion['blocks'][2]['template'] = 'extgallery_block_last.html';

$modversion['blocks'][3]['file'] = "extgallery_blocks.php";
$modversion['blocks'][3]['name'] = _MI_EXTGAL_B_MOST;
$modversion['blocks'][3]['description'] = '';
$modversion['blocks'][3]['show_func'] = "extgalleryTopViewShow";
$modversion['blocks'][3]['options'] = "4|0|0|0";
$modversion['blocks'][3]['edit_func'] = "extgalleryBlockEdit";
$modversion['blocks'][3]['template'] = 'extgallery_block_view.html';

$modversion['blocks'][4]['file'] = "extgallery_blocks.php";
$modversion['blocks'][4]['name'] = _MI_EXTGAL_B_TOPR;
$modversion['blocks'][4]['description'] = '';
$modversion['blocks'][4]['show_func'] = "extgalleryTopRatedShow";
$modversion['blocks'][4]['options'] = "4|0|0|0";
$modversion['blocks'][4]['edit_func'] = "extgalleryBlockEdit";
$modversion['blocks'][4]['template'] = 'extgallery_block_top_rated.html';

$modversion['blocks'][5]['file'] = "extgallery_blocks.php";
$modversion['blocks'][5]['name'] = _MI_EXTGAL_B_TOPE;
$modversion['blocks'][5]['description'] = '';
$modversion['blocks'][5]['show_func'] = "extgalleryTopEcardShow";
$modversion['blocks'][5]['options'] = "4|0|0|0";
$modversion['blocks'][5]['edit_func'] = "extgalleryBlockEdit";
$modversion['blocks'][5]['template'] = 'extgallery_block_top_ecard.html';

$modversion['blocks'][6]['file'] = "extgallery_blocks.php";
$modversion['blocks'][6]['name'] = _MI_EXTGAL_B_RANDSS;
$modversion['blocks'][6]['description'] = '';
$modversion['blocks'][6]['show_func'] = "extgalleryRandomSlideshowShow";
$modversion['blocks'][6]['options'] = "5000|1000|default|back|in:out|1|4|0|0|0";
$modversion['blocks'][6]['edit_func'] = "extgalleryBlockSlideshowEdit";
$modversion['blocks'][6]['template'] = 'extgallery_block_random_slideshow.html';

$modversion['blocks'][7]['file'] = "extgallery_blocks.php";
$modversion['blocks'][7]['name'] = _MI_EXTGAL_B_LASTSS;
$modversion['blocks'][7]['description'] = '';
$modversion['blocks'][7]['show_func'] = "extgalleryLastSlideshowShow";
$modversion['blocks'][7]['options'] = "5000|1000|default|back|in:out|1|4|0|0|0";
$modversion['blocks'][7]['edit_func'] = "extgalleryBlockSlideshowEdit";
$modversion['blocks'][7]['template'] = 'extgallery_block_last_slideshow.html';

$modversion['blocks'][8]['file'] = "extgallery_blocks.php";
$modversion['blocks'][8]['name'] = _MI_EXTGAL_B_MOSTSS;
$modversion['blocks'][8]['description'] = '';
$modversion['blocks'][8]['show_func'] = "extgalleryTopViewSlideshowShow";
$modversion['blocks'][8]['options'] = "5000|1000|default|back|in:out|1|4|0|0|0";
$modversion['blocks'][8]['edit_func'] = "extgalleryBlockSlideshowEdit";
$modversion['blocks'][8]['template'] = 'extgallery_block_view_slideshow.html';

$modversion['blocks'][9]['file'] = "extgallery_blocks.php";
$modversion['blocks'][9]['name'] = _MI_EXTGAL_B_TOPRSS;
$modversion['blocks'][9]['description'] = '';
$modversion['blocks'][9]['show_func'] = "extgalleryTopRatedSlideshowShow";
$modversion['blocks'][9]['options'] = "5000|1000|default|back|in:out|1|4|0|0|0";
$modversion['blocks'][9]['edit_func'] = "extgalleryBlockSlideshowEdit";
$modversion['blocks'][9]['template'] = 'extgallery_block_top_rated_slideshow.html';

$modversion['blocks'][10]['file'] = "extgallery_blocks.php";
$modversion['blocks'][10]['name'] = _MI_EXTGAL_B_TOPESS;
$modversion['blocks'][10]['description'] = '';
$modversion['blocks'][10]['show_func'] = "extgalleryTopEcardSlideshowShow";
$modversion['blocks'][10]['options'] = "5000|1000|default|back|in:out|1|4|0|0|0";
$modversion['blocks'][10]['edit_func'] = "extgalleryBlockSlideshowEdit";
$modversion['blocks'][10]['template'] = 'extgallery_block_top_ecard_slideshow.html';

$modversion['blocks'][11]['file'] = "extgallery_blocks.php";
$modversion['blocks'][11]['name'] = _MI_EXTGAL_B_SUB;
$modversion['blocks'][11]['description'] = '';
$modversion['blocks'][11]['show_func'] = "extgalleryTopSubmitterShow";
$modversion['blocks'][11]['options'] = "5|0";
$modversion['blocks'][11]['edit_func'] = "extgalleryTopSubmitterEdit";
$modversion['blocks'][11]['template'] = 'extgallery_block_top_submitter.html';

// Notifications
$modversion['hasNotification'] = 1;
//$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
//$modversion['notification']['lookup_func'] = 'extgalleryNotifyIteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_EXTGAL_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_EXTGAL_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = '*';
$modversion['notification']['category'][1]['item_name'] = '';

$modversion['notification']['category'][2]['name'] = 'album';
$modversion['notification']['category'][2]['title'] = _MI_EXTGAL_ALBUM_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_EXTGAL_ALBUM_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'public-album.php';
$modversion['notification']['category'][2]['item_name'] = 'id';

$modversion['notification']['category'][3]['name'] = 'event';
$modversion['notification']['category'][3]['title'] = _MI_EXTGAL_PHOTO_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_EXTGAL_PHOTO_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'public-photo.php';
$modversion['notification']['category'][3]['item_name'] = 'photoId';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_photo';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_EXTGAL_NEW_PHOTO_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_EXTGAL_NEW_PHOTO_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_EXTGAL_NEW_PHOTO_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_new_photo';
$modversion['notification']['event'][1]['mail_subject'] = _MI_EXTGAL_NEW_PHOTO_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'new_photo_pending';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['title'] = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_new_photo_pending';
$modversion['notification']['event'][2]['mail_subject'] = _MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYSBJ;
$modversion['notification']['event'][2]['admin_only'] = 1;

$modversion['notification']['event'][3]['name'] = 'new_photo_album';
$modversion['notification']['event'][3]['category'] = 'album';
$modversion['notification']['event'][3]['title'] = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'album_new_photo';
$modversion['notification']['event'][3]['mail_subject'] = _MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYSBJ;

?>