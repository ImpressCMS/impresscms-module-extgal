<?php

if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

include '../../../include/cp_header.php';
include 'function.php';

// Change this variable if you use a cloned version of eXtGallery
$localModuleDir = 'extgallery';

$downloadServer = 'http://downloads.sourceforge.net/zoullou/';
//$downloadServer = 'http://localhost/divers/extgallery/';
$extentionFileName = 'extgallery-extention-hook.tar.gz';

switch($step) {

	case 'download':

		icms_cp_header();
		icms::$module -> displayAdminMenu();

		if(!$handle = @fopen($downloadServer.$extentionFileName, 'r')) {
			printf(_AM_EXTGALLERY_EXT_FILE_DONT_EXIST, $downloadServer, $extentionFileName);
			icms_cp_footer();
			break;
		}
		$localHandle = @fopen(ICMS_ROOT_PATH.'/uploads/'.$extentionFileName, 'w+');

		// Downlad module archive
		if ($handle) {
		    while (!feof($handle)) {
		        $buffer = fread($handle, 8192);
		        fwrite($localHandle, $buffer);
		    }
		    fclose($localHandle);
		    fclose($handle);
		}

		icms_core_Message::confirm(array('step' => 'install'), 'install-extention.php', _AM_EXTGALLERY_DOWN_DONE, _AM_EXTGALLERY_INSTALL);

		icms_cp_footer();

		break;

	case 'install':

		if(!file_exists(ICMS_ROOT_PATH."/uploads/".$extentionFileName)) {

   icms_cp_header();
   icms::$module -> displayAdminMenu( );
			echo _AM_EXTGALLERY_EXT_FILE_DONT_EXIST_SHORT;
			icms_cp_footer();

			break;
		}

		$g_pcltar_lib_dir = ICMS_ROOT_PATH.'/modules/'.$localModuleDir.'/class';
		include "../class/pcltar.lib.php";

		// Extract extention files
		PclTarExtract(ICMS_ROOT_PATH."/uploads/".$extentionFileName,ICMS_ROOT_PATH."/class/textsanitizer/","class/textsanitizer/");
		// Delete downloaded extention's files
		unlink(ICMS_ROOT_PATH."/uploads/".$extentionFileName);
  
    // Delete folder created by a small issu in PclTar lib
  if(is_dir(ICMS_ROOT_PATH."/class/textsanitizer/class")) {
   rmdir(ICMS_ROOT_PATH."/class/textsanitizer/class");
  }
  
  // Activate extention
  $conf = include ICMS_ROOT_PATH.'/class/textsanitizer/config.php';
  $conf['extensions']['gallery'] = 1;
  file_put_contents(ICMS_ROOT_PATH.'/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = ".var_export($conf,true)."\r?>");

  redirect_header("extention.php", 3, _AM_EXTGALLERY_EXTENTION_INSTALLED);
  
		break;

	default:
	case 'default':

		redirect_header("index.php", 3, "");

		break;
}

?>