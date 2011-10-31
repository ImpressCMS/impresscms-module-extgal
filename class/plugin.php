<?php

if (!defined("ICMS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class ExtgalleryPluginHandler {

    function ExtgalleryPluginHandler(&$db) {

    }

    function triggerEvent($event, &$param) {

        include ICMS_ROOT_PATH."/modules/extgallery/plugin/plugin.php";

        foreach($extgalleryPlugin as $plugin=>$status) {

            if(!$status) {
                continue;
            }

            include_once ICMS_ROOT_PATH."/modules/extgallery/plugin/$plugin/$plugin.php";

            $class = 'Extgallery'.ucfirst($plugin);

            $pluginObj = new $class();
            $pluginObj->$event($param);

        }

    }

    function includeLangFile() {

        include ICMS_ROOT_PATH."/modules/extgallery/plugin/plugin.php";

        foreach($extgalleryPlugin as $plugin=>$status) {

            if(!$status) {
                continue;
            }

            include_once ICMS_ROOT_PATH."/modules/extgallery/plugin/$plugin/language/english/main.php";

        }

    }

}

?>