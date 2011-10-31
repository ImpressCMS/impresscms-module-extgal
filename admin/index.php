<?php

include '../../../include/cp_header.php';
include 'function.php';
include 'moduleUpdateFunction.php';

$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

icms_cp_header();
extgalleryAdminMenu(1);

$code = 'function gd_info() {
       $array = Array(
                       "GD Version" => "",
                       "FreeType Support" => 0,
                       "FreeType Support" => 0,
                       "FreeType Linkage" => "",
                       "T1Lib Support" => 0,
                       "GIF Read Support" => 0,
                       "GIF Create Support" => 0,
                       "JPG Support" => 0,
                       "PNG Support" => 0,
                       "WBMP Support" => 0,
                       "XBM Support" => 0
                     );
       $gif_support = 0;

       ob_start();
       eval("phpinfo();");
       $info = ob_get_contents();
       ob_end_clean();

       foreach(explode("\n", $info) as $line) {
           if(strpos($line, "GD Version")!==false)
               $array["GD Version"] = trim(str_replace("GD Version", "", strip_tags($line)));
           if(strpos($line, "FreeType Support")!==false)
               $array["FreeType Support"] = trim(str_replace("FreeType Support", "", strip_tags($line)));
           if(strpos($line, "FreeType Linkage")!==false)
               $array["FreeType Linkage"] = trim(str_replace("FreeType Linkage", "", strip_tags($line)));
           if(strpos($line, "T1Lib Support")!==false)
               $array["T1Lib Support"] = trim(str_replace("T1Lib Support", "", strip_tags($line)));
           if(strpos($line, "GIF Read Support")!==false)
               $array["GIF Read Support"] = trim(str_replace("GIF Read Support", "", strip_tags($line)));
           if(strpos($line, "GIF Create Support")!==false)
               $array["GIF Create Support"] = trim(str_replace("GIF Create Support", "", strip_tags($line)));
           if(strpos($line, "GIF Support")!==false)
               $gif_support = trim(str_replace("GIF Support", "", strip_tags($line)));
           if(strpos($line, "JPG Support")!==false)
               $array["JPG Support"] = trim(str_replace("JPG Support", "", strip_tags($line)));
           if(strpos($line, "PNG Support")!==false)
               $array["PNG Support"] = trim(str_replace("PNG Support", "", strip_tags($line)));
           if(strpos($line, "WBMP Support")!==false)
               $array["WBMP Support"] = trim(str_replace("WBMP Support", "", strip_tags($line)));
           if(strpos($line, "XBM Support")!==false)
               $array["XBM Support"] = trim(str_replace("XBM Support", "", strip_tags($line)));
       }

       if($gif_support==="enabled") {
           $array["GIF Read Support"]  = 1;
           $array["GIF Create Support"] = 1;
       }

       if($array["FreeType Support"]==="enabled"){
           $array["FreeType Support"] = 1;    }

       if($array["T1Lib Support"]==="enabled")
           $array["T1Lib Support"] = 1;

       if($array["GIF Read Support"]==="enabled"){
           $array["GIF Read Support"] = 1;    }

       if($array["GIF Create Support"]==="enabled")
           $array["GIF Create Support"] = 1;

       if($array["JPG Support"]==="enabled")
           $array["JPG Support"] = 1;

       if($array["PNG Support"]==="enabled")
           $array["PNG Support"] = 1;

       if($array["WBMP Support"]==="enabled")
           $array["WBMP Support"] = 1;

       if($array["XBM Support"]==="enabled")
           $array["XBM Support"] = 1;

       return $array;
   }';

function dskspace($dir)
{
   $s = stat($dir);
   $space = $s[7];
   if (is_dir($dir))
   {
     $dh = opendir($dir);
     while (($file = readdir($dh)) !== false)
       if ($file != "." && $file != "..")
         $space += dskspace($dir."/".$file);
     closedir($dh);
   }
   return $space;
}

function imageMagickSupportType() {

	$cmd = icms::$module->config['graphic_lib_path'].'convert -list format';
	exec($cmd,$data);

	$ret = array(
				'GIF Support'=>"<span style=\"color:#FF0000;\"><b>KO</b></span>",
				'JPG Support'=>"<span style=\"color:#FF0000;\"><b>KO</b></span>",
				'PNG Support'=>"<span style=\"color:#FF0000;\"><b>KO</b></span>"
			);

	foreach($data as $line) {
		preg_match("`GIF\* GIF.*([rw]{2})`",$line,$matches);
		if(isset($matches[1]) && $matches[1] == "rw") {
			$ret['GIF Support'] = "<span style=\"color:#33CC33;\"><b>OK</b></span>";
		}
		preg_match("`JPG\* JPEG.*([rw]{2})`",$line,$matches);
		if(isset($matches[1]) && $matches[1] == "rw") {
			$ret['JPG Support'] = "<span style=\"color:#33CC33;\"><b>OK</b></span>";
		}
		preg_match("`PNG\* PNG.*([rw]{2})`",$line,$matches);
		if(isset($matches[1]) && $matches[1] == "rw") {
			$ret['PNG Support'] = "<span style=\"color:#33CC33;\"><b>OK</b></span>";
		}
	}
	return $ret;
}

function is__writable($path) {
	//will work in despite of Windows ACLs bug
	//NOTE: use a trailing slash for folders!!!
	//see http://bugs.php.net/bug.php?id=27609
	//see http://bugs.php.net/bug.php?id=30931

	if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
		return is__writable($path.uniqid(mt_rand()).'.tmp');
	else if (is_dir($path))
		return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
	// check tmp file for read/write capabilities
	$rm = file_exists($path);
	$f = @fopen($path, 'a');
	if ($f===false)
		return false;
	fclose($f);
	if (!$rm)
		unlink($path);
	return true;
}

if(!function_exists("gd_info")) eval($code);

$gd = gd_info();

echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_UPDATE_INFO.'</legend>';
if(!moduleLastVersionInfo()) {
	echo "<span style=\"color:black; font-weight:bold;\">"._AM_EXTGALLERY_CHECK_UPDATE_ERROR."</span>";
} else if(!isModuleUpToDate()) {
 if(isXoopsVersionSupportLastModuleVersion()) {
  echo "<h3 style=\"color:red;\">"._AM_EXTGALLERY_UPDATE_KO."</h3><br /><form action=\"upgrade.php\" method=\"post\"><input type=\"hidden\" name=\"step\" value=\"download\" /><input class=\"formButton\" value=\""._AM_EXTGALLERY_UPDATE_UPGRADE."\" type=\"submit\" /></form>";
  echo '<br /><fieldset><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_CHANGELOG.'</legend>';
  echo getChangelog();
  echo '</fieldset>';
 } else {
  echo sprintf(_AM_EXTGALLERY_XOOPS_VERSION_NOT_SUPPORTED, "2.3.8")."<br />";
 }
} else {
	echo "<span style=\"color:green;\">"._AM_EXTGALLERY_UPDATE_OK."</span>";
}

echo '</fieldset>';
echo '<br />';

echo '<fieldset><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_SERVER_CONF.'</legend>';

$moduleVersion = icms::$module->getVar('version');
echo _AM_EXTGALLERY_EXTGALLERY_VERSION." : <b>".substr($moduleVersion,0,1).'.'.substr($moduleVersion,1,1).'.'.substr($moduleVersion,2)."</b><br /><br />";

isXoopsVersionSupportInstalledModuleVersion() ? $test = "<span style=\"color:#33CC33;\"><b>OK</b></span>" : $test = "<span style=\"color:#FF0000;\"><b>KO</b></span>" ;
echo _AM_EXTGALLERY_XOOPS_VERSION." : <b>".ICMS_VERSION_NAME." (".$test.")</b><br /><br />";

if(icms::$module->config['graphic_lib'] == 'GD') {
	// GD graphic lib
	$test = ($gd['GD Version'] == "") ? "<span style=\"color:#FF0000;\"><b>KO</b></span>" : $gd['GD Version'];
	echo _AM_EXTGALLERY_GRAPH_GD_LIB_VERSION." : <b>".$test."</b><br />";

	($gd['GIF Read Support'] && $gd['GIF Create Support']) ? $test = "<span style=\"color:#33CC33;\"><b>OK</b></span>" : $test = "<span style=\"color:#FF0000;\"><b>KO</b></span>" ;
	echo _AM_EXTGALLERY_GIF_SUPPORT." : ".$test."<br />";

	($gd['JPG Support']) ? $test = "<span style=\"color:#33CC33;\"><b>OK</b></span>" : $test = "<span style=\"color:#FF0000;\"><b>KO</b></span>";
	echo _AM_EXTGALLERY_JPEG_SUPPORT." : ".$test."<br />";

	($gd['PNG Support']) ? $test = "<span style=\"color:#33CC33;\"><b>OK</b></span>" : $test = "<span style=\"color:#FF0000;\"><b>KO</b></span>";
	echo _AM_EXTGALLERY_PNG_SUPPORT." : ".$test."<br /><br />";
}

if(icms::$module->config['graphic_lib'] == 'IM') {
	// ImageMagick graphic lib
	$cmd = icms::$module->config['graphic_lib_path'].'convert -version';
	exec($cmd,$data,$error);
	$test = !isset($data[0]) ? "<span style=\"color:#FF0000;\"><b>KO</b></span>" : $data[0];
	echo _AM_EXTGALLERY_GRAPH_IM_LIB_VERSION." : <b>".$test."</b><br />";

	$imSupport = imageMagickSupportType();
	echo _AM_EXTGALLERY_GIF_SUPPORT." : ".$imSupport['GIF Support']."<br />";
	echo _AM_EXTGALLERY_JPEG_SUPPORT." : ".$imSupport['JPG Support']."<br />";
	echo _AM_EXTGALLERY_PNG_SUPPORT." : ".$imSupport['PNG Support']."<br /><br />";
}

$isError = false;
$errors = array();

if(!is_dir(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/original')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_ORIG_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/original) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_CREATED."</b></span>";
} else if(!is__writable(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/original/')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_ORIG_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/original) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_WRITABLE."</b></span>";
}

if(!is_dir(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/large')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_LARGE_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/large) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_CREATED."</b></span>";
} else if(!is__writable(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/large/')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_ORIG_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/large) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_WRITABLE."</b></span>";
}

if(!is_dir(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/medium')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_MEDIUM_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/medium) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_CREATED."</b></span>";
} else if(!is__writable(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/medium/')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_ORIG_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/medium) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_WRITABLE."</b></span>";
}

if(!is_dir(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/thumb')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_THUMB_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/thumb) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_CREATED."</b></span>";
} else if(!is__writable(ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/thumb/')) {
	$isError = true;
	$errors[] = "<b>"._AM_EXTGALLERY_PUBLIC_ORIG_PATH."</b> (".ICMS_ROOT_PATH."/uploads/extgallery/public-photo/thumb) : <span style=\"color:#FF0000;\"><b>"._AM_EXTGALLERY_NOT_WRITABLE."</b></span>";
}

if($isError) {
	foreach($errors as $error) {
		echo $error."<br />";
	}
	echo "<br />";
}

echo "Upload max filesize : <b>".get_cfg_var('upload_max_filesize')."</b><br />";
//echo 'Post max size : <b>'.get_cfg_var('post_max_size')."</b><br />";
echo '</fieldset>';

icms_cp_footer();

?>