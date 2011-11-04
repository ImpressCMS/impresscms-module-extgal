<?php

include '../../../include/cp_header.php';

if(isset($_POST['op'])) {
	$op = $_POST['op'];
} else {
	$op = 'default';
}

switch($op) {
 
 case 'enreg':
 
	$configHandler =& icms::handler('config');
	$moduleIdCriteria = new icms_db_criteria_Item('conf_modid',icms::$module->getVar('mid'));
  
  if(isset($_POST['slideshow_delay'])) {

   if(icms::$module->config['slideshow_delay'] != $_POST['slideshow_delay']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_delay'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_delay',
          'conf_value'=>$_POST['slideshow_delay'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  if(isset($_POST['slideshow_duration'])) {

   if(icms::$module->config['slideshow_duration'] != $_POST['slideshow_duration']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_duration'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_duration',
          'conf_value'=>$_POST['slideshow_duration'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  if(isset($_POST['slideshow_transtype'])) {

   if(icms::$module->config['slideshow_transtype'] != $_POST['slideshow_transtype']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_transtype'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_transtype',
          'conf_value'=>$_POST['slideshow_transtype'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  if(isset($_POST['slideshow_effecttype'])) {

   if(icms::$module->config['slideshow_effecttype'] != $_POST['slideshow_effecttype']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_effecttype'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_effecttype',
          'conf_value'=>$_POST['slideshow_effecttype'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  if(isset($_POST['slideshow_effectoption'])) {

   if(icms::$module->config['slideshow_effectoption'] != $_POST['slideshow_effectoption']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_effectoption'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_effectoption',
          'conf_value'=>$_POST['slideshow_effectoption'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  if(isset($_POST['slideshow_thumb'])) {

   if(icms::$module->config['slideshow_thumb'] != $_POST['slideshow_thumb']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_thumb'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_thumb',
          'conf_value'=>$_POST['slideshow_thumb'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  if(isset($_POST['slideshow_caption'])) {

   if(icms::$module->config['slideshow_caption'] != $_POST['slideshow_caption']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_caption'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_caption',
          'conf_value'=>$_POST['slideshow_caption'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  if(isset($_POST['slideshow_controller'])) {

   if($icmsModuleConfig['slideshow_controller'] != $_POST['slideshow_controller']) {
    $criteria = new icms_db_criteria_Compo();
    $criteria->add($moduleIdCriteria);
    $criteria->add(new icms_db_criteria_Item('conf_name','slideshow_controller'));
    $config = $configHandler->getConfigs($criteria);
    $config = $config[0];
    $configValue = array(
          'conf_modid'=>icms::$module->getVar('mid'),
          'conf_catid'=>0,
          'conf_name'=>'slideshow_controller',
          'conf_value'=>$_POST['slideshow_controller'],
          'conf_formtype'=>'hidden',
          'conf_valuetype'=>'text'
         );
    $config->setVars($configValue);
    $configHandler->insertConfig($config);
   }
   
  }
  
  redirect_header("slideshow.php", 3, _AM_EXTGALLERY_CONFIGURATION_SAVED);
  
  break;
 
	case 'default':
	default:

		icms_cp_header();
		icms::$module -> displayAdminMenu( 7, icms::$module -> getVar( 'name' ) );

		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_EXTGALLERY_SLIDESHOW_CONF.'</legend>';
  
  //echo "<pre>";print_r($icmsModuleConfig);echo "</pre>";
  
  if(icms::$module->config['display_type'] == 'slideshow') {
   
   $form = new icms_form_Theme(_AM_EXTGALLERY_SLIDESHOW_CONF, 'slideshow_conf', 'slideshow.php', 'post', true);
   
  // $form->addElement(new XoopsFormText(_AM_EXTGALLERY_SLIDESHOW_DELAY, 'slideshow_delay', '5', '5', $icmsModuleConfig['slideshow_delay']),false);
   //$form->addElement(new XoopsFormText(_AM_EXTGALLERY_SLIDESHOW_DURATION, 'slideshow_duration', '5', '5', $icmsModuleConfig['slideshow_duration']),false);
   
   $transTypeSelect = new icms_form_elements_Select(_AM_EXTGALLERY_TRANSTYPE, 'slideshow_transtype',$icmsModuleConfig['slideshow_transtype']);
   $transTypeSelect->addOption("default", _AM_EXTGALLERY_DEFAULT);
   $transTypeSelect->addOption("fold", _AM_EXTGALLERY_FOLD);
   $transTypeSelect->addOption("kenburns", _AM_EXTGALLERY_KENBURNS);
   //$transTypeSelect->addOption("push", _AM_EXTGALLERY_PUSH);
			$form->addElement($transTypeSelect);
   
 //  $effectTypeSelect = new XoopsFormSelect(_AM_EXTGALLERY_EFFECT_TYPE, 'slideshow_effecttype',$icmsModuleConfig['slideshow_effecttype']);
//			$effectTypeSelect->addOption("quad", _AM_EXTGALLERY_QUAD);
  // $effectTypeSelect->addOption("cubic", _AM_EXTGALLERY_CUBIC);
   //$effectTypeSelect->addOption("quart", _AM_EXTGALLERY_QUART);
   //$effectTypeSelect->addOption("quint", _AM_EXTGALLERY_QUINT);
   //$effectTypeSelect->addOption("expo", _AM_EXTGALLERY_EXPO);
   //$effectTypeSelect->addOption("circ", _AM_EXTGALLERY_CIRC);
   //$effectTypeSelect->addOption("sine", _AM_EXTGALLERY_SINE);
   //$effectTypeSelect->addOption("back", _AM_EXTGALLERY_BACK);
   //$effectTypeSelect->addOption("bounce", _AM_EXTGALLERY_BOUNCE);
   //$effectTypeSelect->addOption("elastic", _AM_EXTGALLERY_ELASTIC);
	//		$form->addElement($effectTypeSelect);
   
  // $effectOptionSelect = new XoopsFormSelect(_AM_EXTGALLERY_EFFECT_OPTION, 'slideshow_effectoption',$icmsModuleConfig['slideshow_effectoption']);
//			$effectOptionSelect->addOption("in", _AM_EXTGALLERY_IN);
  // $effectOptionSelect->addOption("out", _AM_EXTGALLERY_OUT);
   //$effectOptionSelect->addOption("in:out", _AM_EXTGALLERY_INOUT);
	//		$form->addElement($effectOptionSelect);
   
 //  $form->addElement(new XoopsFormRadioYN(_AM_EXTGALLERY_SS_THUMB, 'slideshow_thumb', $icmsModuleConfig['slideshow_thumb']));
 //  $form->addElement(new XoopsFormRadioYN(_AM_EXTGALLERY_SS_CAPTION, 'slideshow_caption', $icmsModuleConfig['slideshow_caption']));
  // $form->addElement(new XoopsFormRadioYN(_AM_EXTGALLERY_SS_CONTROLLER, 'slideshow_controller', $icmsModuleConfig['slideshow_controller']));
   
   $form->addElement(new icms_form_elements_Hidden("op", 'enreg'));
   $form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
   
   $form->display();
   
  } else {
   echo _AM_EXTGALLERY_SLIDESHOW_NOT_ENABLE;
  }
  
  echo '</fieldset>';

		icms_cp_footer();

		break;

}

?>