<?php

define('_MI_EXTGAL_NAME',"eXtGallery+");
define('_MI_EXTGAL_DESC',"eXtGallery+ is a powerful web gallery module for ICMS");

// Main menu
define('_MI_EXTGALLERY_USERALBUM',"My album");
define('_MI_EXTGALLERY_PUBLIC_UPLOAD',"Upload public");

// Main administration menu
define('_MI_EXTGALLERY_INDEX',"Index");
define('_MI_EXTGALLERY_PUBLIC_CAT',"Category/Albums");
define('_MI_EXTGALLERY_PHOTO',"Photos");
define('_MI_EXTGALLERY_PERMISSIONS',"Permissions");
define('_MI_EXTGALLERY_WATERMARK_BORDER',"Watermark &amp; Border");
define('_MI_EXTGALLERY_SLIDESHOW',"Slideshow");
define('_MI_EXTGALLERY_EXTENTION',"Extention");

// Module options
define('_MI_EXTGAL_DISP_TYPE',"Display type");
define('_MI_EXTGAL_DISP_TYPE_DESC',"Select the display type for photo");
define('_MI_EXTGAL_NB_COLUMN',"Number of Columns in each album");
define('_MI_EXTGAL_NB_COLUMN_DESC',"Set number of columns to display photo thumbnails on album view");
define('_MI_EXTGAL_NB_LINE',"Number of Lines in each album");
define('_MI_EXTGAL_NB_LINE_DESC',"Set number of lines used to display photo thumbnails on album view");
define('_MI_EXTGAL_SAVE_L',"Save large photo");
define('_MI_EXTGAL_SAVE_L_DESC',"If you save large photos - bigger than medium  - the download link will point to them on the photo page");
define('_MI_EXTGAL_M_WIDTH',"Width for medium photo");
define('_MI_EXTGAL_M_WIDTH_DESC',"Photo will be resized to set this value as the maximum Width - in pixels");
define('_MI_EXTGAL_M_HEIGTH',"Height for medium photo");
define('_MI_EXTGAL_M_HEIGTH_DESC',"Photo will be resized to set this value as the maximum Height - in pixels");
define('_MI_EXTGAL_T_WIDTH',"Width for photo thumbnail");
define('_MI_EXTGAL_T_WIDTH_DESC',"Maximum width for photo thumbnails");
define('_MI_EXTGAL_T_HEIGTH',"Height for photo thumbnail");
define('_MI_EXTGAL_T_HEIGTH_DESC',"Maximum height for photo thumbnails");
define('_MI_EXTGAL_M_WATERMARK',"Enable watermarks for medium photos");
define('_MI_EXTGAL_M_WATERMARK_DESC',"Choose whether on not to enable the watermark feature for new medium photos. You must also configure watermark settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_M_BORDER',"Enable border for medium photo");
define('_MI_EXTGAL_M_BORDER_DESC',"Choose whether on not to enable the border feature for new medium photos. You must also configure border settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_L_WATERMARK',"Enable watermarks for large photos");
define('_MI_EXTGAL_L_WATERMARK_DESC',"Choose whether on not to enable the watermark feature for new large photos. You must also configure border settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_L_BORDER',"Enable borders for large photos");
define('_MI_EXTGAL_L_BORDER_DESC',"Choose whether on not to enable the border feature for new large photos. You must also configure border settings under the 'watermarks & borders' tab.");
define('_MI_EXTGAL_NAME_PATTERN',"Auto photo description pattern");
define('_MI_EXTGAL_NAME_PATTERN_DESC',"If you don't provide a description for your photo on upload the file name of the photo will be used to make an auto description.<br /> For example, with a \"Tournament-06-may-2006_1.jpg\" photo name, you will end up with \"Tournament 06 may 2006\" as the description");
define('_MI_EXTGAL_DISPLAY_EXTRA',"Display an extra field");
define('_MI_EXTGAL_DISPLAY_EXTRA_DESC',"Choose whether on not to add more information on submit form. For example, you could use this feature to add a PayPal button to each photo.");
define('_MI_EXTGAL_ALLOW_HTML',"Allow HTML in extra field");
define('_MI_EXTGAL_ALLOW_HTML_DESC',"Allow or Disallow HTML code in description and extra field.");
define('_MI_EXTGAL_HIDDEN_FIELD',"This constant is used only to remove PHP notices. This text isn't use in the module");
define('_MI_EXTGAL_SAVE_ORIG',"Save original photo");
define('_MI_EXTGAL_SAVE_ORIG_DESC',"This config allows you to save uploaded large photos before adding watermarks and borders. It requires that the add 'watermark and border' options are enabled for large photos plus the \"Save large photo\" option <b>must</b> also be enabled.<br /><b>The original version can be downloaded but is dependant on group permission for \"Download original permissions\"</b>.<br />If a user doesn't have permission to download the original, then the \"large\" photo will be downloaded instead.");
define('_MI_EXTGAL_ADM_NBPHOTO',"Number of photos to be displayed on admin page");
define('_MI_EXTGAL_ADM_NBPHOTO_DESC',"Set the number of photos to be displayed on the admin approve and edit table.");
define('_MI_EXTGAL_GRAPHLIB',"Graphic library");
define('_MI_EXTGAL_GRAPHLIB_DESC',"Select the graphic library you want to use. Be careful with this advanced option, don't modify it if you don't know what the effect will be.");
define('_MI_EXTGAL_GRAPHLIB_PATH',"Graphic library path");
define('_MI_EXTGAL_GRAPHLIB_PATH_DESC',"Path to the graphic library on the server <b>WITH</b> trailing slash.");
define('_MI_EXTGAL_ENABLE_RATING',"Enable photo rating");
define('_MI_EXTGAL_ENABLE_RATING_DESC',"Choose whether on not to globally enable or disable the photo ratings feature.");
define('_MI_EXTGAL_DISP_PH_TITLE',"Photo title");
define('_MI_EXTGAL_DISP_PH_TITLE_DESC',"Choose whether on not to display the title of the photograph inside the album.");
define('_MI_EXTGAL_DISP_CAT_IMG',"Category image");
define('_MI_EXTGAL_DISP_CAT_IMG_DESC',"Choose whether or not to display an image to represent the category or not.");
define('_MI_EXTGAL_M_QUALITY',"Medium photo quality");
define('_MI_EXTGAL_M_QUALITY_DESC',"Quality for medium photo from 0 (bad) to 100 (good)");
define('_MI_EXTGAL_T_QUALITY',"Thumb photo quality");
define('_MI_EXTGAL_T_QUALITY_DESC',"Quality for thumb photo from 0 (bad) to 100 (good)");
define('_MI_EXTGALLERY_ALBUM',"Album");
define('_MI_EXTGAL_EXT_UPLOAD',"Upload type page");
define('_MI_EXTGAL_EXT_UPLOAD_DESC',"Select the upload type that is provided to user. Extended require Java plugin.");
define('_MI_EXTGALLERY_EXTENDED',"Extended");
define('_MI_EXTGALLERY_STANDARD',"Standard");

// Bloc Name
define('_MI_EXTGAL_B_RAND',"Random photo");
define('_MI_EXTGAL_B_LAST',"Last photo");
define('_MI_EXTGAL_B_MOST',"Most viewed");
define('_MI_EXTGAL_B_TOPR',"Top rated");
define('_MI_EXTGAL_B_TOPE',"Top eCard");
define('_MI_EXTGAL_B_RANDSS',"Random photo (Slideshow)");
define('_MI_EXTGAL_B_LASTSS',"Last photo (Slideshow)");
define('_MI_EXTGAL_B_MOSTSS',"Most viewed (Slideshow)");
define('_MI_EXTGAL_B_TOPRSS',"Top rated (Slideshow)");
define('_MI_EXTGAL_B_TOPESS',"Top eCard (Slideshow)");
define('_MI_EXTGAL_B_SUB',"Name me in modinfo");


// Notifications
define('_MI_EXTGAL_GLOBAL_NOTIFY',"Global notification");
define('_MI_EXTGAL_GLOBAL_NOTIFYDSC',"GLOBAL_NOTIFYDSC");
define('_MI_EXTGAL_ALBUM_NOTIFY',"Album notification");
define('_MI_EXTGAL_ALBUM_NOTIFYDSC',"_MI_EXTGAL_CAT_NOTIFYDSC");
define('_MI_EXTGAL_PHOTO_NOTIFY',"Photo notification");
define('_MI_EXTGAL_PHOTO_NOTIFYDSC',"_MI_EXTGAL_PHOTO_NOTIFYDSC");
define('_MI_EXTGAL_NEW_PHOTO_NOTIFY',"New photo");
define('_MI_EXTGAL_NEW_PHOTO_NOTIFYCAP',"Notify me when a new photo is added");
define('_MI_EXTGAL_NEW_PHOTO_NOTIFYDSC',"NEW_PHOTO_NOTIFYDSC");
define('_MI_EXTGAL_NEW_PHOTO_NOTIFYSBJ',"New photo submitted");
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFY',"Notify me when a new photo is pending");
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYCAP',"Notify me when a new photo is pending");
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYDSC',"_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYDSC");
define('_MI_EXTGAL_NEW_PHOTO_PENDING_NOTIFYSBJ',"New pending photo");
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFY',"Notify me when a new photo is added in this album");
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYCAP',"Notify me when a new photo is added in this album");
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYDSC',"_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYDSC");
define('_MI_EXTGAL_NEW_PHOTO_ALBUM_NOTIFYSBJ',"New photo submitted");
?>