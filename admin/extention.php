<?php

include '../../../include/cp_header.php';

icms_cp_header();
icms::$module -> displayAdminMenu( 8, icms::$module -> getVar( 'name' ) );

function extentionInstalled() {
 return file_exists(ICMS_ROOT_PATH.'/class/textsanitizer/gallery/gallery.php');
}

function extentionActivated() {
 $conf = include ICMS_ROOT_PATH.'/class/textsanitizer/config.custom.php';
 return $conf['extensions']['gallery'];
}

function activateExtention() {
 $conf = include ICMS_ROOT_PATH.'/class/textsanitizer/config.custom.php';
 $conf['extensions']['gallery'] = 1;
 file_put_contents(ICMS_ROOT_PATH.'/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = ".var_export($conf,true)."\r?>");
}

function desactivateExtention() {
 $conf = include ICMS_ROOT_PATH.'/class/textsanitizer/config.custom.php';
 $conf['extensions']['gallery'] = 0;
 file_put_contents(ICMS_ROOT_PATH.'/class/textsanitizer/config.custom.php', "<?php\rreturn \$config = ".var_export($conf,true)."\r?>");
}

echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_EXTENTION_INFO.'</legend>';
if(!extentionInstalled()) {
	echo "<h3 style=\"color:red;\">"._AM_EXTGALLERY_EXTENTION_NOT_INSTALLED."</h3><br /><form action=\"install-extention.php\" method=\"post\"><input type=\"hidden\" name=\"step\" value=\"download\" /><input class=\"formButton\" value=\""._AM_EXTGALLERY_INSTALL_EXTENTION."\" type=\"submit\" /></form>";
} else {
	echo "<span style=\"color:green;\">"._AM_EXTGALLERY_EXTENTION_OK."</span>";
 echo "<p>"._AM_EXTGALLERY_EXTENTION_NOTICE."</p>";
}
echo '</fieldset>';

icms_cp_footer();

?>