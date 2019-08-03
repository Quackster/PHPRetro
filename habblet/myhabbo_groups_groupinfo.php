<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2009 Yifan Lu. All rights reserved.
|| # http://www.yifanlu.com
|| # Parts Copyright (C) 2009 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|| # All images, scripts, and layouts
|| # Copyright (C) 2009 Sulake Ltd. All rights reserved.
|+==================================================================
|| # PHPRetro is provided "as is" and comes without
|| # warrenty of any kind. PHPRetro is free software!
|| # License: GNU Public License 3.0
|| # http://opensource.org/licenses/gpl-license.php
\+================================================================*/

$page['dir'] = '\habblet';

require_once('../includes/core.php');
$data = new home_sql;
$lang->addLocale("homes.widget.groups");

$ownerid = $_POST['ownerId'];
$id = $input->FilterText($_POST['groupId']);

$row = $db->fetch_row($data->select10($id));
?>
<div class="groups-info-basic">
	<div class="groups-info-close-container"><a href="#" class="groups-info-close"></a></div>
	
	<div class="groups-info-icon"><a href="<?php echo groupURL($row[0]); ?>"><img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $row[1]; ?>.gif" /></a></div>
	<h4><a href="<?php echo groupURL($row[0]); ?>"><?php echo $input->HoloText($row[2]); ?></a></h4>
	    <img id="groupname-<?php echo $row[0]; ?>-report" class="report-button report-gn"
			alt="report"
			src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif"
			style="display: none;" />
	
	<p>
<?php if($row[7] == '1'){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/favourite_group_icon.gif" width="15" height="15" class="groups-list-icon" alt="<?php echo $lang->loc['favorite']; ?>" title="<?php echo $lang->loc['favorite']; ?>" /><?php } ?>
<?php if($row[6] > 1 && $row[8] == $ownerid){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/owner_icon.gif" width="15" height="15" class="groups-list-icon" alt="<?php echo $lang->loc['owner']; ?>" title="<?php echo $lang->loc['owner']; ?>" /><?php } ?>
<?php if($row[6] > 1 && $row[8] != $ownerid){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/administrator_icon.gif" width="15" height="15" class="groups-list-icon" alt="<?php echo $lang->loc['admin'] ?>" title="<?php echo $lang->loc['admin']; ?>" /><?php } ?>
<?php echo $lang->loc['group.created']; ?>:<br />
<b><?php echo $input->HoloText($row[4]); ?></b>
	</p>
	
	<div class="groups-info-description"><?php echo $input->HoloText($row[3]); ?></div>
	    <img id="groupdesc-<?php echo $row[0]; ?>-report" class="report-button report-gd"
	        alt="report"
	        src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif"
            style="display: none;" />
</div>