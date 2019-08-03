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

$skin = $_POST['skinId'];
$id = $input->FilterText($_POST['stickieId']);

if($_SESSION['page_edit'] == "home"){ $lang->location = -2; $where = '> -1'; }else{ $lang->location = "-".$_SESSION['page_edit']; $where = '< 1'; }

switch($skin){
	case 1: $skin = "defaultskin"; break;
	case 2: $skin = "speechbubbleskin"; break;
	case 3: $skin = "metalskin"; break;
	case 4: $skin = "noteitskin"; break;
	case 5: $skin = "notepadskin"; break;
	case 6: $skin = "goldenskin"; break;
	case 7: if($user->IsHCMember("self")){ $skin = "hc_machineskin"; }else{ $skin = "defaultskin"; } break;
	case 8: if($user->IsHCMember("self")){ $skin = "hc_pillowskin"; }else{ $skin = "defaultskin"; } break;
	case 9: if($user->user("rank") > 5){ $skin = "default"; }else{ $skin = "defaultskin"; } break;
	default: $skin = "defaultskin"; break;
}

$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes.variable,".PREFIX."homes.x,".PREFIX."homes.y,".PREFIX."homes.z FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes_catalogue.id = ".PREFIX."homes.itemid AND ".PREFIX."homes.ownerid = '".$user->id."' AND ".PREFIX."homes.id = '".$id."' LIMIT 1");
$row = $db->fetch_row($sql);

$db->query("UPDATE ".PREFIX."homes SET skin = '".$skin."' WHERE id = '".$row[0]."' AND ownerid = '".$user->id."' LIMIT 1");
header('X-JSON: {"id":"'.$row[0].'","cssClass":"n_skin_'.$skin.'","type":"stickie"}');
?>
<div class="movable stickie n_skin_<?php echo $skin; ?>-c" style=" left: <?php echo $row[3]; ?>px; top: <?php echo $row[4]; ?>px; z-index: <?php echo $row[5]; ?>;" id="stickie-<?php echo $row[0]; ?>">
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
				<?php if($userrow[2] > 5){ $html = true; }else{ $html = false; } ?>
				<div class="stickie-markup"><?php echo $input->HoloText($row[2],$html,true); ?></div>
				<div class="stickie-footer">
				</div>
			</div>
		</div>
	</div>
</div>