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

$id = $_SESSION['page_edit'];
$db->query("DELETE FROM ".PREFIX."homes_edit WHERE pageid = '".$id."' AND editorid = '".$user->id."' AND type = 'group' LIMIT 1");
$db->query("DELETE FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id AND ".PREFIX."homes.location = '-".$id."' AND ".PREFIX."homes_catalogue.type = '2' AND ".PREFIX."homes.ownerid = '".$user->id."'");
$db->query("UPDATE ".PREFIX."homes SET x = '1', y = '1', z = '1', location = '-1', skin = 'defaultskin', variable = '' WHERE location = '-".$id."' AND ownerid = '".$user->id."'");
unset($_SESSION['page_edit']);

header('Location: '.PATH.'/groups/'.$id.'/id');
?>