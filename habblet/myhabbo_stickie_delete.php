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

$id = $input->FilterText($_POST['stickieId']);

if($_SESSION['page_edit'] == "home"){ $lang->location = -2; $where = '> -1'; }else{ $lang->location = "-".$_SESSION['page_edit']; $where = '< 1'; }

$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes.location FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes_catalogue.id = ".PREFIX."homes.itemid AND ".PREFIX."homes.ownerid = '".$user->id."' AND ".PREFIX."homes.id = '".$id."' LIMIT 1");
$row = $db->fetch_row($sql);

if($db->num_rows($sql) == 0){ echo "ERROR"; exit; }

if($row[1] == $lang->location){ $db->query("UPDATE ".PREFIX."homes SET location = '-1', variable = '' WHERE id = '".$id."' LIMIT 1"); }else{ $db->query("DELETE FROM ".PREFIX."homes WHERE id = '".$id."' LIMIT 1"); }

echo "SUCCESS";
?>