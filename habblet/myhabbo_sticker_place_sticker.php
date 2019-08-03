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

$id = $input->FilterText($_POST['selectedStickerId']);
$zindex = $input->FilterText($_POST['zindex']);

if($_SESSION['page_edit'] == "home"){ $lang->location = -2; $where = '> -1'; }else{ $lang->location = "-".$_SESSION['page_edit']; $where = '< 1'; }

$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes_catalogue.id = ".PREFIX."homes.itemid AND ".PREFIX."homes.ownerid = '".$user->id."' AND ".PREFIX."homes.id = '".$id."'");
$row = $db->fetch_row($sql);

$db->query("UPDATE ".PREFIX."homes SET location = '".$lang->location."', x = '20', y = '30', z = '".$zindex."' WHERE id = '".$id."' LIMIT 1");

header('X-JSON: ["'.$input->HoloText($id).'"]');
?>
    <div class="movable sticker <?php echo formatItem(1,$row[1],false); ?>" style="left: 20px; top: 30px; z-index: <?php echo $input->HoloText($zindex); ?>" id="sticker-<?php echo $row[0]; ?>">
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="sticker-<?php echo $row[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("sticker-<?php echo $row[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $row[0]; ?>, "sticker", "sticker-<?php echo $row[0]; ?>-edit"); }, false);
</script>
    </div>