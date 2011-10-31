<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

if (!defined("ICMS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once ICMS_ROOT_PATH.'/class/mail/xoopsmultimailer.php';

class extgalleryMailer {
	
	var $mailer;
	var $type;
	var $tags = array();
	
	var $ecardId;
	var $subject;
	var $toEmail;
	var $toName;
	var $fromEmail;
	var $fromName;
	var $greetings;
	var $description;
	var $photo;
	
	function extgalleryMailer($type) {
		$this->mailer = new XoopsMultiMailer();
		$this->type = $type;
	}
	
	function imageIncluded() {
		if($this->photo->getVar('photo_serveur') == "") {
			$photoPath = ICMS_ROOT_PATH.'/uploads/extgallery/public-photo/medium/'.$this->photo->getVar('photo_name');
		} else {
			$photoPath = $this->photo->getVar('photo_serveur').$this->photo->getVar('photo_name');
		}
		$this->tags['PHOTO_SRC'] = 'cid:photo';
		$this->tags['STAMP_SRC'] = 'cid:stamp';
		$this->mailer->AddEmbeddedImage($photoPath, "photo");
		$this->mailer->AddEmbeddedImage(ICMS_ROOT_PATH.'/modules/extgallery/images/stamp.gif', "stamp");
	}
	
	function imageLinked() {
		if($this->photo->getVar('photo_serveur') == "") {
			$photoUrl = ICMS_URL.'/uploads/extgallery/public-photo/medium/'.$this->photo->getVar('photo_name');
		} else {
			$photoUrl = $this->photo->getVar('photo_serveur').$this->photo->getVar('photo_name');
		}
		$this->tags['PHOTO_SRC'] = $photoUrl;
		$this->tags['STAMP_SRC'] = ICMS_URL.'/modules/extgallery/images/stamp.gif';
	}
	
	function send() {
		$this->assignTags();
		if($this->type == "included") {
			$this->imageIncluded();
		} else if($this->type == "linked") {
			$this->imageLinked();
		}
		
		$this->mailer->From = $this->fromEmail;
		$this->mailer->FromName = $this->fromName;
		$this->mailer->Subject = $this->subject;
		$this->mailer->Body = $this->loadTemplate("ecard_html.tpl");
		$this->mailer->AltBody = $this->loadTemplate("ecard_text.tpl");
		$this->mailer->AddAddress($this->toEmail, $this->toName);
		//$this->mailer->AddReplyTo($this->fromEmail, $this->fromName);
		$this->mailer->Send();
	}
	
	function assignTags() {
		global $icmsConfig;
		$this->tags['ECARD_LINK'] = ICMS_URL.'/modules/extgallery/public-viewecard.php?id='.$this->ecardId;
		$this->tags['EXP_EMAIL'] = $this->fromEmail;
		$this->tags['EXP_NAME'] = $this->fromName;
		$this->tags['REC_NAME'] = $this->toName;
		$this->tags['GREETINGS'] = $this->greetings;
		$this->tags['DESCRIPTION'] = $this->description;
		$this->tags['MODULE_LINK'] = ICMS_URL.'/modules/extgallery/';
		$this->tags['SITE_NAME'] = $icmsConfig['sitename'];
		$this->tags['SITE_URL'] = ICMS_URL;
	}
	
	function loadTemplate($name) {
		global $icmsConfig;
		
		if(file_exists(ICMS_ROOT_PATH.'/modules/extgallery/language/'.$icmsConfig['language'].'/mail_template/'.$name)) {
			$path = ICMS_ROOT_PATH.'/modules/extgallery/language/'.$icmsConfig['language'].'/mail_template/'.$name;
		} else {
			$path = ICMS_ROOT_PATH.'/modules/extgallery/language/english/mail_template/'.$name;
		}
		$fd = @fopen($path, 'r');
		$body = fread($fd, filesize($path));
		// replace tags with actual values
		foreach ( $this->tags as $k => $v ) {
			$body = str_replace("{".$k."}", $v, $body);
		}
		return $body;
	}
	
	function setEcardId($ecardId) {
		$this->ecardId = $ecardId;
	}
	
	function setSubject($subject) {
		$this->subject = $subject;
	}
	
	function setToEmail($email) {
		$this->toEmail = $email;
	}
	
	function setToName($name) {
		$this->toName = $name;
	}
	
	function setFromEmail($email) {
		$this->fromEmail = $email;
	}
	
	function setFromName($name) {
		$this->fromName = $name;
	}
	
	function setGreetings($greetings) {
		$this->greetings = $greetings;
	}
	
	function setDescription($description) {
		$this->description = $description;
	}
	
	function setPhoto(&$photo) {
		$this->photo = $photo;
	}
	
}

?>