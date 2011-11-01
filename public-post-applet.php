<?php

require '../../mainfile.php';

$photoHandler = icms_getModuleHandler('publicphoto', 'extgallery');

$result = $photoHandler->postPhotoTraitement('File0');

if($result == 2) {
    echo "ERROR: "._MD_EXTGALLERY_NOT_AN_ALBUM;
} elseif($result == 4 || $result == 5) {
    echo "ERROR: ".$photoHandler->photoUploader->getError();
} elseif($result == 0) {
    echo "SUCCESS\n";
} elseif($result == 1) {
    echo "SUCCESS\n";
}

?>