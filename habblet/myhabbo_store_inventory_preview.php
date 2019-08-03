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

if($page['bypass'] != true){
$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');

$id = $input->FilterText($_POST['itemId']);
$type = $input->FilterText($_POST['type']);

switch($type){
	case "stickers": $type = 1; $json['type'] = '"Sticker"'; $json['widget'] = 'null'; $json['preview'] = true; break;
	case "backgrounds": $type = 4; $json['type'] = '"Background"'; $json['widget'] = 'null'; $json['preview'] = true; break;
	case "widgets": $type = 2; $json['type'] = '"Widget"'; $json['widget'] = '"true"'; $json['preview'] = false; break;
	case "notes": $type = 3; $json['type'] = '"WebCommodity"'; $json['widget'] = 'null'; $json['preview'] = false; break;
}

if($type == 2){
$sql = $db->query("SELECT id,data,name FROM ".PREFIX."homes_catalogue WHERE id = '".$id."'");
}else{
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes_catalogue.name,".PREFIX."homes_catalogue.desc FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes_catalogue.id = ".PREFIX."homes.itemid AND ".PREFIX."homes.id = '".$id."'");
}
$row = $db->fetch_row($sql);

if($json['preview'] == true){ $json['preview'] = '"'.formatItem($type,$row[1],false).'"'; }else{ $json['preview'] = "null"; }

header('X-JSON: ["'.formatItem($type,$row[1],true).'",'.$json['preview'].',"'.$row[3].'",'.$json['type'].','.$json['widget'].',1]');
}else{
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes_catalogue.name,".PREFIX."homes_catalogue.desc FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id AND ".PREFIX."homes.id = '".$id."' LIMIT 1");
$row = $db->fetch_row($sql);
}
$lang->addLocale("homes.store.inventory.preview");
?>
<h4>&nbsp;</h4>

<div id="inventory-preview-box"></div>

<div id="inventory-preview-place" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place"><b><?php echo $lang->loc['place']; ?></b><i></i></a>
	</div>
</div>