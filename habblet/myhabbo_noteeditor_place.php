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
require_once('./includes/session.php');

$maxlength = $_POST['maxlength'];
$skin = $_POST['skin'];
$scope = $_POST['scope'];
$query = $_POST['query'];

if($user->user("rank") > 5){ $html = true; }else{ $html = false; }
$note = nl2br($input->bbcode_format($input->HoloText($_POST['noteText'],$html)));

if(strlen($note) > 500){ exit; }

switch($skin){
	case 1: $skin = "defaultskin"; break;
	case 2: $skin = "speechbubbleskin"; break;
	case 3: $skin = "metalskin"; break;
	case 4: $skin = "noteitskin"; break;
	case 5: $skin = "notepadskin"; break;
	case 6: $skin = "goldenskin"; break;
	case 7: if($user->IsHCMember("self")){ $skin = "hc_machineskin"; }else{ $skin = "defaultskin"; } break;
	case 8: if($user->IsHCMember("self")){ $skin = "hc_pillowskin"; }else{ $skin = "defaultskin"; } break;
	case 8: if($user->user("rank") > 5){ $skin = "default"; }else{ $skin = "defaultskin"; } break;
	default: $skin = "defaultskin"; break;
}
$sql = $db->query("SELECT MAX(z) FROM ".PREFIX."homes WHERE ownerid = '".$user->id."' AND location = '0'");
$zindex = $db->result($sql);
$zindex = $zindex + 2;

$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes_catalogue.id = ".PREFIX."homes.itemid AND ".PREFIX."homes.ownerid = '".$user->id."' AND ".PREFIX."homes_catalogue.data = 'stickienote' AND ".PREFIX."homes.location = '-1' LIMIT 1");
$row = $db->fetch_row($sql);

$db->query("UPDATE ".PREFIX."homes SET skin = '".$skin."', variable = '".$input->FilterText($_POST['noteText'])."', location = '-2', x = '10', y = '10', z = '".$zindex."', skin = '".$skin."' WHERE id = '".$row[0]."' LIMIT 1");

header('X-JSON: '.$row[0]);
?>
<div class="movable stickie n_skin_<?php echo $skin; ?>-c" style=" left: 10px; top: 10px; z-index: <?php echo $zindex; ?>;" id="stickie-<?php echo $row[0]; ?>">
	<div class="n_skin_<?php echo $skin; ?>" >
		<div class="stickie-header">
			<h3>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="stickie-<?php echo $row[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("stickie-<?php echo $row[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $row[0]; ?>, "stickie", "stickie-<?php echo $row[0]; ?>-edit"); }, false);
</script>
			</h3>
			<div class="clear"></div>
		</div>
		<div class="stickie-body">
			<div class="stickie-content">
				<div class="stickie-markup"><?php echo $note; ?></div>
				<div class="stickie-footer">
				</div>
			</div>
		</div>
	</div>
</div>
