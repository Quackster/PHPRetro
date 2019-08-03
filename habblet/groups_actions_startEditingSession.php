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
$page['no_ajax'] = true;
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;
$id = $input->FilterText($_GET['id']);

$sql = $data->select15($user->id,$id);
if($db->num_rows($sql) < 1){ $error = true; }
$row = $db->fetch_row($sql);
if($row[2] < 2){ $error = true; }
$sql = $db->query("SELECT * FROM ".PREFIX."homes_edit WHERE pageid = '".$id."' AND `type` = 'group' LIMIT 1");
if($db->num_rows($sql) > 1){ header('Location: '.PATH.'/groups/'.$input->HoloText($id).'/id?concurrentEditing=true'); exit; }
if($error != true){ $db->query("INSERT INTO ".PREFIX."homes_edit (pageid,editorid,`type`,time) VALUES ('".$id."','".$user->id."','group','".time()."')"); }

header('Location: '.PATH.'/groups/'.$id.'/id');
?>