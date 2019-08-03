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

$entryid = $input->FilterText($_POST['entryId']);
$widgetid = $input->FilterText($_POST['widgetId']);

$widgetrow = $db->fetch_row($db->query("SELECT id,location,ownerid,variable FROM ".PREFIX."homes WHERE ".PREFIX."homes.id = '".$widgetid."' LIMIT 1"));
$widgetrow[1] = str_replace('-','',$widgetrow[1]);

if($widgetrow[1] == "0" || $widgetrow[1] == "2"){ $type = "user"; $ownerid = $widgetrow[2]; }else{ $type = "group"; $ownerid = $widgetrow[1]; $memberrow = $db->fetch_row($data->select15($user->id,$ownerid)); }

$posterid = $db->result($db->query("SELECT userid FROM ".PREFIX."guestbook WHERE id = '".$entryid."' LIMIT 1"));

if(($type == "user" && $ownerid == $user->id) || ($type == "group" && $memberrow[2] > 1) || ($posterid == $user->id)){
	$db->query("DELETE FROM ".PREFIX."guestbook WHERE id = '".$entryid."' LIMIT 1");
}
?>