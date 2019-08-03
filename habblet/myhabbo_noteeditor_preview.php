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
$lang->addLocale("stickie.preview");

$maxlength = $_POST['maxlength'];
$skin = $_POST['skin'];
$scope = $_POST['scope'];
$query = $_POST['query'];

if($user->user("rank") > 5){ $html = true; }else{ $html = false; }
$note = nl2br($input->bbcode_format($input->HoloText($_POST['noteText'],$html)));

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
?>
<div id="webstore-notes-container">




<div class="movable stickie n_skin_<?php echo $skin; ?>-c" style=" left: 0px; top: 0px; z-index: 1;" id="stickie--1">
	<div class="n_skin_<?php echo $skin; ?>" >
		<div class="stickie-header">
			<h3>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="stickie--1-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("stickie--1-edit", "click", function(e) { openEditMenu(e, -1, "stickie", "stickie--1-edit"); }, false);
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
</div>

<p class="warning"><?php echo $lang->loc['notes.warning.not.editable']; ?></p>

<p>
<a href="#" class="new-button" id="webstore-notes-edit"><b><?php echo $lang->loc['go.back.and.edit']; ?></b><i></i></a>
<a href="#" class="new-button" id="webstore-notes-add"><b><?php echo $lang->loc['add.note.to.page']; ?></b><i></i></a>
</p>

<div class="clear"></div>