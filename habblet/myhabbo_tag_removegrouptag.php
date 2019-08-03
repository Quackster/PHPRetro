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
$page['allow_guests'] = true;
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;

$id = $input->FilterText($_POST['groupId']);
$tag = $input->FilterText($_POST['tagName']);

$grouprow = $db->fetch_row($data->select14($id));
$memberrow = $db->fetch_row($data->select15($user->id,$grouprow[0]));

if($memberrow[2] < 2){ exit; }

$db->query("DELETE FROM ".PREFIX."tags WHERE ownerid = '".$id."' AND tag = '".$tag."' AND type = 'group' LIMIT 1");

$page['bypass'] = true;
require_once('./habblet/myhabbo_tag_listgrouptags.php');
?>