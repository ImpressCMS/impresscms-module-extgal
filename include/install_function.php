<?php

function xoops_module_pre_install_extgallery(&$module) {
 
 // Check if this XOOPS version is supported
 $minSupportedVersion = explode('.', '2.3.0');
 $currentVersion = explode('.', substr(ICMS_VERSION_NAME,6));
 
 if($currentVersion[0] > $minSupportedVersion[0]) {
  return true;
 } elseif($currentVersion[0] == $minSupportedVersion[0]) {
  if($currentVersion[1] > $minSupportedVersion[1]) {
   return true;
  } elseif($currentVersion[1] == $minSupportedVersion[1]) {
   if($currentVersion[2] > $minSupportedVersion[2]) {
    return true;
   } elseif ($currentVersion[2] == $minSupportedVersion[2]) {
    return true;
   }
  }
 }
 
 return false;

}

function xoops_module_install_extgallery(&$module) {
	
	$module_id = icms::$module->getVar('mid');
	$gpermHandler = icms::handler('icms_member_groupperm');
	$configHandler = icms::$config;
	
	/**
	 * Default public category permission mask
	 */
	
	// Access right
	$gpermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_USERS, $module_id);
	$gpermHandler->addRight('extgallery_public_mask', 1, XOOPS_GROUP_ANONYMOUS, $module_id);
	
	// Public rate
	$gpermHandler->addRight('extgallery_public_mask', 2, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_public_mask', 2, XOOPS_GROUP_USERS, $module_id);
	
	// Public eCard
	$gpermHandler->addRight('extgallery_public_mask', 4, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_public_mask', 4, XOOPS_GROUP_USERS, $module_id);
	
	// Public download
	$gpermHandler->addRight('extgallery_public_mask', 8, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_public_mask', 8, XOOPS_GROUP_USERS, $module_id);
	
	// Public upload
	$gpermHandler->addRight('extgallery_public_mask', 16, XOOPS_GROUP_ADMIN, $module_id);
	
	// Public autoapprove
	$gpermHandler->addRight('extgallery_public_mask', 32, XOOPS_GROUP_ADMIN, $module_id);
	
	// Public display
	$gpermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_USERS, $module_id);
	$gpermHandler->addRight('extgallery_public_mask', 128, XOOPS_GROUP_ANONYMOUS, $module_id);
	
	/**
	 * Default User's category permission
	 */
	
	// Private gallery
	
	// Private rate
	$gpermHandler->addRight('extgallery_private', 2, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_private', 2, XOOPS_GROUP_USERS, $module_id);
	
	// Private eCard
	$gpermHandler->addRight('extgallery_private', 4, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_private', 4, XOOPS_GROUP_USERS, $module_id);
	
	// Private download
	$gpermHandler->addRight('extgallery_private', 8, XOOPS_GROUP_ADMIN, $module_id);
	$gpermHandler->addRight('extgallery_private', 8, XOOPS_GROUP_USERS, $module_id);
	
	// Private autoapprove
	$gpermHandler->addRight('extgallery_private', 16, XOOPS_GROUP_ADMIN, $module_id);
	
	
	
	// Create eXtGallery main upload directory
	$dir = ICMS_ROOT_PATH."/uploads/extgallery";
	if(!is_dir($dir))
		mkdir($dir);
	// Create directory for photo in public album
	$dir = ICMS_ROOT_PATH."/uploads/extgallery/public-photo";
	if(!is_dir($dir))
		mkdir($dir);
	$dir = ICMS_ROOT_PATH."/uploads/extgallery/public-photo/original";
	if(!is_dir($dir))
		mkdir($dir);
	$dir = ICMS_ROOT_PATH."/uploads/extgallery/public-photo/large";
	if(!is_dir($dir))
		mkdir($dir);
	$dir = ICMS_ROOT_PATH."/uploads/extgallery/public-photo/medium";
	if(!is_dir($dir))
		mkdir($dir);
	$dir = ICMS_ROOT_PATH."/uploads/extgallery/public-photo/thumb";
	if(!is_dir($dir))
		mkdir($dir);
	// Create directory for photo in user's album
	//mkdir(ICMS_ROOT_PATH."/uploads/extgallery/user-photo");
	
	// Copy index.html files on uploads folders
	$indexFile = ICMS_ROOT_PATH."/modules/extgallery/include/index.html";
	copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/index.html");
	copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/public-photo/index.html");
	copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/public-photo/original/index.html");
	copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/public-photo/large/index.html");
	copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/public-photo/medium/index.html");
	copy($indexFile, ICMS_ROOT_PATH."/uploads/extgallery/public-photo/thumb/index.html");
	
	return true;
}

?>