<?php

function xoops_module_update_extgallery(&$xoopsModule, $oldVersion = null) {

	$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
	$catHandler->rebuild();

	if($oldVersion < 101) {

		$db =& Database::getInstance();
		// Remove the UNIQUE key on the rating table. This constraint is software cheked now
		$sql = "ALTER TABLE `".$db->prefix('extgallery_publicrating')."` DROP INDEX `photo_rate` ;";
		$db->query($sql);

	}

	if($oldVersion < 102) {

		$db =& Database::getInstance();

		$sql = "ALTER TABLE `".$db->prefix('extgallery_publiccat')."` ADD `cat_imgurl` VARCHAR(150) NOT NULL AFTER `cat_nb_photo` ;";
		$db->query($sql);

		$sql = "ALTER TABLE `".$db->prefix('extgallery_publicphoto')."` ADD `photo_title` VARCHAR(150) NOT NULL AFTER `photo_id` ;";
		$db->query($sql);

		$sql = "ALTER TABLE `".$db->prefix('extgallery_publicphoto')."` ADD `photo_weight` int(11) NOT NULL AFTER `photo_extra` ;";
		$db->query($sql);

	}
	
	if($oldVersion < 104) {

		$db =& Database::getInstance();

		$sql = "ALTER TABLE `".$db->prefix('extgallery_publicphoto')."` ADD `dohtml` BOOL NOT NULL DEFAULT '0';";
		$db->query($sql);
		
		$sql = "ALTER TABLE `".$db->prefix('extgallery_publicphoto')."` CHANGE `photo_desc` `photo_desc` TEXT;";
		$db->query($sql);
  
	// Set display parmission for all XOOPS base Groups
	$sql = "SELECT cat_id FROM `".$db->prefix('extgallery_publiccat')."`;";
	$result = $db->query($sql);
	$module_id = icms::$module->getVar('mid');
	$gpermHandler = icms::handler('icms_member_groupperm');
	while($cat = $db->fetchArray($result)) {
		$gpermHandler->addRight('public_displayed', $cat['cat_id'], XOOPS_GROUP_ADMIN, $module_id);
		$gpermHandler->addRight('public_displayed', $cat['cat_id'], XOOPS_GROUP_USERS, $module_id);
		$gpermHandler->addRight('public_displayed', $cat['cat_id'], XOOPS_GROUP_ANONYMOUS, $module_id);
	}

	}
 
 if($oldVersion < 106) {
 
  if(!file_exists(ICMS_ROOT_PATH."/uploads/extgallery/index.html")) {
   $indexFile = ICMS_ROOT_PATH."/modules/extgallery/include/index.html";
   copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/index.html");
  }
  
  if(!file_exists(ICMS_ROOT_PATH."/uploads/extgallery/public-photo/index.html")) {
   $indexFile = ICMS_ROOT_PATH."/modules/extgallery/include/index.html";
   copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/public-photo/index.html");
  }
  
 }
 
 if($oldVersion < 107) {
 
  // Fix extention Bug if it's installed
  if(file_exists(ICMS_ROOT_PATH.'/class/textsanitizer/gallery/gallery.php')) {
   $conf = include ICMS_ROOT_PATH.'/class/textsanitizer/config.php';
   $conf['extensions']['gallery'] = 1;
   file_put_contents(ICMS_ROOT_PATH.'/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = ".var_export($conf,true)."\r?>");
  }
  
 }

    return true;
}

?>