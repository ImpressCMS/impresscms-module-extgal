<?php

$admin_dirname = basename( dirname( dirname( __FILE__ ) ) );

global $icmsConfig;

$adminmenu[1]['title'] = _MI_EXTGALLERY_INDEX;
$adminmenu[1]['link'] = "admin/index.php";

$adminmenu[2]['title'] = _MI_EXTGALLERY_PUBLIC_CAT;
$adminmenu[2]['link'] = "admin/public-category.php";

//$adminmenu[3]['title'] = 'Categories privées';
//$adminmenu[3]['link'] = "admin/private-category.php";

$adminmenu[4]['title'] = _MI_EXTGALLERY_PHOTO;
$adminmenu[4]['link'] = "admin/photo.php";

$adminmenu[5]['title'] = _MI_EXTGALLERY_PERMISSIONS;
$adminmenu[5]['link'] = "admin/perm-quota.php";

$adminmenu[6]['title'] = _MI_EXTGALLERY_WATERMARK_BORDER;
$adminmenu[6]['link'] = "admin/watermark-border.php";

$adminmenu[7]['title'] = _MI_EXTGALLERY_SLIDESHOW;
$adminmenu[7]['link'] = "admin/slideshow.php";

$adminmenu[8]['title'] = _MI_EXTGALLERY_EXTENTION;
$adminmenu[8]['link'] = "admin/extention.php";

if ( isset( icms::$module ) ) {

	icms_loadLanguageFile( $admin_dirname, 'admin' );
	
	if ( file_exists( '../docs/' . $icmsConfig['language'] . '/readme.html') ) {
		$docs = '../docs/' . $icmsConfig['language'] . '/readme.html" target="_blank"'; 
	} elseif ( file_exists( '../docs/english/readme.html') ) { 
		$docs = '../docs/english/readme.html" target="_blank"'; 
	} else {
		$docs = '';
	}
	
	$module = icms::handler("icms_module")->getByDirname(basename(dirname(dirname(__FILE__))), TRUE);

	$i = -1;
	$i++;
	$headermenu[$i]['title'] = _AM_EXTGALLERY_GO_TO_MODULE;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . $admin_dirname;
	
	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link']  = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $module -> getVar( 'mid' );
	
	$i++;
	$headermenu[$i]['title'] = _AM_EXTGALLERY_UPDATE;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $admin_dirname;

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . $admin_dirname . '/admin/about.php';
}

?>