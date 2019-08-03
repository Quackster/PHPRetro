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

$id = $input->FilterText($_POST['widgetId']);
$zindex = $input->FilterText($_POST['zindex']);

if($_SESSION['page_edit'] == "home"){ $lang->location = -2; $where = '> -1'; }else{ $lang->location = "-".$_SESSION['page_edit']; $where = '< 1'; }

$sql = $db->query("SELECT data,`where` FROM ".PREFIX."homes_catalogue WHERE minrank <= '".$user->id."' AND `where` ".$where." AND id = '".$id."' LIMIT 1");
$widget = $db->result($sql);
$iswhere = $db->result($sql, 0, 1);

if($_SESSION['page_edit'] == "home" && $iswhere == -1){ exit; }elseif($_SESSION['page_edit'] != "home" && $iswhere == 1){ exit; }

$db->query("INSERT INTO ".PREFIX."homes (location,x,y,z,itemid,ownerid) VALUES ('".$lang->location."','15','25','".$zindex."','".$id."','".$user->id."')");

$sql = $db->query("SELECT id FROM ".PREFIX."homes WHERE itemid = '".$id."' AND ownerid = '".$user->id."' AND location = '".$lang->location."' LIMIT 1");
$placedid = $db->result($sql);

header('X-JSON: ["'.$input->HoloText($id).'"]');

$page['edit'] = true;
$widget = $placedid;

if($_SESSION['page_edit'] == "home"){ require('./habblet/myhabbo_widgets.php'); }else{ require('./habblet/groups_widgets.php'); }
?>