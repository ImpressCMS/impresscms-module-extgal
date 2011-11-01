<?php

if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

include '../../../include/cp_header.php';
include 'moduleUpdateFunction.php';

// Change this variable if you use a cloned version of eXtGallery
$localModuleDir = 'extgallery';

$moduleName = 'extgallery';
$downloadServer = _MU_MODULE_DOWNLOAD_SERVER;

$lastVersionString = getLastModuleVersion();
$moduleFileName = $moduleName.'-'.$lastVersionString.'.tar.gz';
$langFileName = $moduleName.'-lang-'.$lastVersionString.'_'.$xoopsConfig['language'].'.tar.gz';

switch($step) {

	case 'download':

		icms_cp_header();
		icms::$module -> displayAdminMenu();

		if(isModuleUpToDate()) {

			echo _AM_EXTGALLERY_UPDATE_OK;
			icms_cp_footer();
			break;
		}

		if(!$handle = @fopen($downloadServer.$moduleFileName, 'r')) {
			printf(_AM_EXTGALLERY_MD_FILE_DONT_EXIST, $downloadServer, $moduleFileName);
			icms_cp_footer();
			break;
		}
		$localHandle = @fopen(ICMS_ROOT_PATH.'/uploads/'.$moduleFileName, 'w+');

		// Downlad module archive
		if ($handle) {
		    while (!feof($handle)) {
		        $buffer = fread($handle, 8192);
		        fwrite($localHandle, $buffer);
		    }
		    fclose($localHandle);
		    fclose($handle);
		}

		// English file are included on module package
		if($icmsConfig['language'] != "english") {
			if(!$handle = @fopen($downloadServer.$langFileName, 'r')) {
				printf(_AM_EXTGALLERY_LG_FILE_DONT_EXIST, $downloadServer, $langFileName);
			} else {
				$localHandle = @fopen(ICMS_ROOT_PATH.'/uploads/'.$langFileName, 'w+');
				// Download language archive
				if ($handle) {
				    while (!feof($handle)) {
				        $buffer = fread($handle, 8192);
				        fwrite($localHandle, $buffer);
				    }
				    fclose($localHandle);
				    fclose($handle);
				}
			}
		}

		icms_core_Message::confirm(array('step' => 'install'), 'upgrade.php', _AM_EXTGALLERY_DOWN_DONE, _AM_EXTGALLERY_INSTALL);

		icms_cp_footer();

		break;

	case 'install':

		icms_cp_header();
		icms::$module -> displayAdminMenu();

		if(!file_exists(ICMS_ROOT_PATH."/uploads/".$moduleFileName)) {

			echo _AM_EXTGALLERY_MD_FILE_DONT_EXIST_SHORT;
			icms_cp_footer();

			break;
		}

		$g_pcltar_lib_dir = ICMS_ROOT_PATH.'/modules/'.$localModuleDir.'/class';
		include "../class/pcltar.lib.php";

		//TrOn(5);

		// Extract module files
		PclTarExtract(ICMS_ROOT_PATH."/uploads/".$moduleFileName,ICMS_ROOT_PATH."/modules/".$localModuleDir."/","modules/".$moduleName."/");
		// Delete downloaded module's files
		unlink(ICMS_ROOT_PATH."/uploads/".$moduleFileName);

		if(file_exists(ICMS_ROOT_PATH."/uploads/".$langFileName)) {
			// Extract language files
			PclTarExtract(ICMS_ROOT_PATH."/uploads/".$langFileName,ICMS_ROOT_PATH."/modules/".$localModuleDir."/","modules/".$moduleName."/");
			// Delete downloaded module's files
			unlink(ICMS_ROOT_PATH."/uploads/".$langFileName);
		}
  
  // Delete folder created by a small issu in PclTar lib
  if(is_dir(ICMS_ROOT_PATH."/modules/".$localModuleDir."/modules")) {
   rmdir(ICMS_ROOT_PATH."/modules/".$localModuleDir."/modules");
  }

		// Delete template_c file
		if ($handle = opendir(ICMS_ROOT_PATH.'/templates_c')) {

   while (false !== ($file = readdir($handle))) {
    if($file != '.' && $file != '..' && $file != 'index.html') {
     unlink(ICMS_ROOT_PATH.'/templates_c/'.$file);
    }
   }

   closedir($handle);
		}
		//TrDisplay();

		icms_core_Message::confirm(array('dirname' => $localModuleDir, 'op' => 'update_ok', 'fct' => 'modulesadmin'), XOOPS_URL.'/modules/system/admin.php', _AM_EXTGALLERY_INSTALL_DONE, _AM_EXTGALLERY_UPDATE);

		icms_cp_footer();

		break;

	default:
	case 'default':

		redirect_header("index.php", 3, "");

		break;
}

?>