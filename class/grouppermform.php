<?php 

if (!defined('ICMS_ROOT_PATH')) {
	die("ICMS root path not defined");
}

// require ICMS_ROOT_PATH.'/class/xoopsform/grouppermform.php';

class ExtgalleryGroupPermForm extends icms_form_Groupperm {

 function ExtgalleryGroupPermForm($title, $modid, $permname, $permdesc, $url = "", $anonymous = true) {
  $this->icms_form_Groupperm($title, $modid, $permname, $permdesc, $url, $anonymous);
 }

 function render() {
  // load all child ids for javascript codes
  foreach (array_keys($this->_itemTree)as $item_id) {
   $this->_itemTree[$item_id]['allchild'] = array();
   $this->_loadAllChildItemIds($item_id, $this->_itemTree[$item_id]['allchild']);
  }
  
  $gperm_handler = icms::handler('icms_member_groupperm');
  $member_handler = icms::handler('icms_member');
  $glist = & $member_handler->getGroupList();
  
  foreach (array_keys($glist) as $i) {
   if ($i == ICMS_GROUP_ANONYMOUS && !$this->_showAnonymous) continue;
   // get selected item id(s) for each group
   $selected = $gperm_handler->getItemIds($this->_permName, $i, $this->_modid);
   $ele = new ExtgalleryGroupFormCheckBox($glist[$i], 'perms[' . $this->_permName . ']', $i, $selected);
   $ele->setOptionTree($this->_itemTree);
   $this->addElement($ele);
   unset($ele);
  } 
  $tray = new icms_form_elements_Tray('');
  $tray->addElement(new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit'));
  $tray->addElement(new icms_form_elements_Button('', 'reset', _CANCEL, 'reset'));
  $this->addElement($tray);
  echo '<h4>' . $this->getTitle() . '</h4>';
  if ($this->_permDesc) {
   echo $this->_permDesc . '<br /><br />';
  }
  echo "<form name='" . $this->getName() . "' id='" . $this->getName() . "' action='" . $this->getAction() . "' method='" . $this->getMethod() . "'" . $this->getExtra() . ">\n<table width='100%' class='outer' cellspacing='1' valign='top'>\n";
  $elements = $this->getElements();
  $hidden = '';
  foreach (array_keys($elements) as $i) {
   if (!is_object($elements[$i])) {
    echo $elements[$i];
   } elseif (!$elements[$i]->isHidden()) {
    echo "<tr valign='top' align='left'><td class='head'>" . $elements[$i]->getCaption();
    if ($elements[$i]->getDescription() != '') {
     echo '<br /><br /><span style="font-weight: normal;">' . $elements[$i]->getDescription() . '</span>';
    }
    echo "</td>\n<td class='even'>\n";
    if(is_a($elements[$i], 'ExtgalleryGroupFormCheckBox')) {
     $elements[$i]->render();
    } else {
     echo $elements[$i]->render();
    }
    echo "\n</td></tr>\n";
   } else {
   $hidden .= $elements[$i]->render();
   }
  }
  echo "</table>$hidden</form>";
  echo $this->renderValidationJS( true );

 }

}

class ExtgalleryGroupFormCheckBox extends icms_form_elements_Groupperm {

 function ExtgalleryGroupFormCheckBox($caption, $name, $groupId, $values = null) {
  $this->icms_form_elements_Groupperm($caption, $name, $groupId, $values);
 }

 function render() {
 
  $ele_name = $this->getName();
  echo '<table class="outer"><tr><td class="odd"><table><tr>';
  $cols = 1;
  foreach ($this->_optionTree[0]['children'] as $topitem) {
   if ($cols > 4) {
    echo '</tr><tr>';
    $cols = 1;
   }
   $tree = '<td valign="top">';
   $prefix = '';
   $this->_renderOptionTree($tree, $this->_optionTree[$topitem], $prefix);
   echo $tree;
   echo '</td>';
   $cols++;
  }
  echo '</tr></table></td><td class="even" valign="top">';
  $option_ids = array();
  foreach (array_keys($this->_optionTree) as $id) {
   if (!empty($id)) {
    $option_ids[] = "'".$ele_name.'[groups]['.$this->_groupId.']['.$id.']'."'";
   }
  }
  $checkallbtn_id = $ele_name.'[checkallbtn]['.$this->_groupId.']';
  $option_ids_str = implode(', ', $option_ids);
  echo _ALL." <input id=\"".$checkallbtn_id."\" type=\"checkbox\" value=\"\" onclick=\"var optionids = new Array(".$option_ids_str."); xoopsCheckAllElements(optionids, '".$checkallbtn_id."');\" />";
  echo '</td></tr></table>';
  
 } 

}

?>