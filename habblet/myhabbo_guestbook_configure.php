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
$data = new home_sql;

$id = $input->FilterText($_POST['widgetId']);

$widgetrow = $db->fetch_row($db->query("SELECT id,location,ownerid,variable FROM ".PREFIX."homes WHERE ".PREFIX."homes.id = '".$id."' LIMIT 1"));
$widgetrow[1] = str_replace('-','',$widgetrow[1]);

if($widgetrow[1] == "0" || $widgetrow[1] == "2"){
	if($widgetrow[2] != $user->id){ exit; }
}else{
	$memberrow = $db->fetch_row($data->select15($user->id,$widgetrow[1]));
	if($memberrow[2] < 2){ exit; }
}

if($widgetrow[3] == "public" || $widgetrow[3] == ""){ $status = "private"; }else{ $status = "public"; }

$db->query("UPDATE ".PREFIX."homes SET variable = '".$status."' WHERE id = '".$id."' LIMIT 1");

header('Content-Type: text/javascript; charset=utf-8');
?>
var el = $("guestbook-type");
if (el) {
	if (el.hasClassName("public")) {
		el.className = "private";
		new Effect.Pulsate(el,
			{ duration: 1.0, afterFinish : function() { Element.setOpacity(el, 1); } }
		);						
	} else {						
		new Effect.Pulsate(el,
			{ duration: 1.0, afterFinish : function() { Element.setOpacity(el, 0); el.className = "public"; } }
		);						
	}
}