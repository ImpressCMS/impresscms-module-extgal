<?php

include '../../../include/cp_header.php';

if(isset($_POST['step'])) {
	$step = $_POST['step'];
} else {
	$step = 'default';
}

if(isset($_GET['op'])) {
	$op = $_GET['op'];
} else {
	$op = 'default';
}

$module_id = icms::$module->getVar('mid');

switch($step) {

	case 'enreg':

		$gpermHandler = icms::handler('icms_member_groupperm');

		if($_POST['type'] == "public") {

			// Delete old public mask
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item('gperm_name','extgallery_public_mask'));
			$criteria->add(new icms_db_criteria_Item('gperm_modid',$module_id));
			$gpermHandler->deleteAll($criteria);

			foreach($_POST['perms']['extgallery_public_mask']['group'] as $groupId => $perms) {
				foreach(array_keys($perms) as $perm) {
					$gpermHandler->addRight('extgallery_public_mask', $perm, $groupId, $module_id);
				}
			}

		}

		redirect_header("perm-quota.php", 3, _AM_EXTGALLERY_PERM_MASK_UPDATED);

		break;

	case 'default':
	default:
	
		include_once '../class/grouppermform.php';
		
	    $permArray = include ICMS_ROOT_PATH.'/modules/extgallery/include/perm.php';
	    $modulePermArray = $permArray['modulePerm'];
	    $pluginPermArray = $permArray['pluginPerm'];

		icms_cp_header();
		icms::$module -> displayAdminMenu( 5, icms::$module -> getVar( 'name' ) );
        ob_end_flush();
		$member_handler = icms::handler('icms_member');
		$gperm_handler = icms::handler('icms_member_groupperm');
		$pluginHandler = icms_getModuleHandler('plugin', 'extgallery');

		$pluginHandler->includeLangFile();

		// Retriving the group list
		$glist =& $member_handler->getGroupList();

		function getChecked($array,$v) {
			if(in_array($v,$array)) {
				return ' checked="checked"';
			} else {
				return '';
			}
		}

		echo '<script type="text/javascript" src="../include/admin.js"></script>';

		$nbPerm = count($modulePermArray);
		$nbPerm += count($pluginPermArray) + 1;

		/**
		 * Public category permission mask
		 */
		echo '<fieldset id="defaultBookmark" style="border: #e8e8e8 1px solid;"><legend><a href="#defaultBookmark" style="font-weight:bold; color:#990000;" onClick="extgal_toggle(\'default\'); toggleIcon(\'defaultIcon\');"><img id="defaultIcon" src="../images/minus.gif" />&nbsp;'._AM_EXTGALLERY_PUBLIC_PERM_MASK.'</a></legend><div id="default">';
		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
		echo _AM_EXTGALLERY_PUBLIC_PERM_MASK_INFO;
		echo '</fieldset><br />';
		echo '<table class="outer" style="width:100%;">';
		echo '<form method="post" action="perm-quota.php">';
		echo '<tr>';
		echo '<th colspan="'.$nbPerm.'" style="text-align:center;">'._AM_EXTGALLERY_PUBLIC_PERM_MASK.'</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="head">'._AM_EXTGALLERY_GROUP_NAME.'</td>';

		foreach($modulePermArray as $perm) {
		    echo '<td class="head" style="text-align:center;">'.constant($perm['maskTitle']).'</td>';
		}

		foreach($pluginPermArray as $perm) {
		    echo '<td class="head" style="text-align:center;">'.constant($perm['maskTitle']).'</td>';
		}

		echo '</tr>';
		$i = 0;
		foreach ($glist as $k => $v) {
			$style = ($i++%2 == 0) ? "odd" : "even" ;
			echo '<tr>';
			echo '<td class="'.$style.'">'.$v.'</td>';

			foreach($modulePermArray as $perm) {
			    $permAccessGroup = $gperm_handler->getGroupIds('extgallery_public_mask', $perm['maskId'], $module_id);
    		    echo '<td class="'.$style.'" style="text-align:center;"><input name="perms[extgallery_public_mask][group]['.$k.']['.$perm['maskId'].']" type="checkbox"'.getChecked($permAccessGroup,$k).' /></td>';
    		}

    		foreach($pluginPermArray as $perm) {
			    $permAccessGroup = $gperm_handler->getGroupIds('extgallery_public_mask', $perm['maskId'], $module_id);
    		    echo '<td class="'.$style.'" style="text-align:center;"><input name="perms[extgallery_public_mask][group]['.$k.']['.$perm['maskId'].']" type="checkbox"'.getChecked($permAccessGroup,$k).' /></td>';
    		}

			echo '</tr>';
		}
		echo '<input type="hidden" name="type" value="public" />';
		echo '<input type="hidden" name="step" value="enreg" />';
		echo '<tr><td colspan="'.$nbPerm.'" style="text-align:center;" class="head"><input type="submit" value="'._SUBMIT.'" /></td></tr></form>';
		echo '</table><br />';

		echo '</div></fieldset><br />';

        echo "<form name='opform' id='opform' action='perm-quota.php' method='GET'>\n
        <select size='1'onchange=\"document.forms.opform.submit()\" name='op' id='op'>\n
        <option value=''></option>\n";

        foreach($modulePermArray as $perm) {
            if($op == $perm['name']) {
                echo "<option value='".$perm['name']."' selected='selected'>".constant($perm['title'])."</option>\n";
            } else {
                echo "<option value='".$perm['name']."'>".constant($perm['title'])."</option>\n";
            }
        }

        foreach($pluginPermArray as $perm) {
            if($op == $perm['name']) {
                echo "<option value='".$perm['name']."' selected='selected'>".constant($perm['title'])."</option>\n";
            } else {
                echo "<option value='".$perm['name']."'>".constant($perm['title'])."</option>\n";
            }
        }

        echo "</select>\n
        </form>\n<br />\n";


		// Retriving category list for Group perm form
		$catHandler = icms_getModuleHandler('publiccat', 'extgallery');
		$cats = $catHandler->getTree();

		foreach($modulePermArray as $perm) {

		    if($op != $perm['name']) {
		        continue;
		    }

		    $form = new ExtgalleryGroupPermForm(constant($perm['title']), $module_id, $perm['name'], constant($perm['desc']), 'admin/perm-quota.php');
      		foreach ($cats as $cat) {
      			$form->addItem($cat->getVar('cat_id'), $cat->getVar('cat_name'), $cat->getVar('cat_pid'));
      		}

      		echo '<fieldset id="'.$perm['name'].'Bookmark" style="border: #e8e8e8 1px solid;"><legend><a href="#'.$perm['name'].'Bookmark" style="font-weight:bold; color:#990000;" onClick="extgal_toggle(\''.$perm['name'].'\'); toggleIcon(\''.$perm['name'].'Icon\');"><img id="'.$perm['name'].'Icon" src="../images/minus.gif" />&nbsp;'.constant($perm['title']).'</a></legend><div id="'.$perm['name'].'">';
      		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
      		echo constant($perm['info']);
      		echo '</fieldset>';
      		echo $form->render().'<br />';
      		echo '</div></fieldset><br />';

		    break;

		}

		foreach($pluginPermArray as $perm) {

		    if($op != $perm['name']) {
		        continue;
		    }

		    $form = new ExtgalleryGroupPermForm(constant($perm['title']), $module_id, $perm['name'], constant($perm['desc']), 'admin/perm-quota.php');
      		foreach ($cats as $cat) {
      			$form->addItem($cat->getVar('cat_id'), $cat->getVar('cat_name'), $cat->getVar('cat_pid'));
      		}

      		echo '<fieldset id="'.$perm['name'].'Bookmark" style="border: #e8e8e8 1px solid;"><legend><a href="#'.$perm['name'].'Bookmark" style="font-weight:bold; color:#990000;" onClick="extgal_toggle(\''.$perm['name'].'\'); toggleIcon(\''.$perm['name'].'Icon\');"><img id="'.$perm['name'].'Icon" src="../images/minus.gif" />&nbsp;'.constant($perm['title']).'</a></legend><div id="'.$perm['name'].'">';
      		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTGALLERY_INFORMATION.'</legend>';
      		echo constant($perm['info']);
      		echo '</fieldset>';
      		echo $form->render().'<br />';
      		echo '</div></fieldset><br />';

		    break;

		}

		icms_cp_footer();

		break;
}
?>