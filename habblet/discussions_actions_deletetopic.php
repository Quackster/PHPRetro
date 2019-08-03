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

$groupid = $input->FilterText($_POST['groupId']);
$topicid = $input->FilterText($_POST['topicId']);

$memberrow = $db->fetch_row($data->select15($user->id,$groupid));

if($memberrow[2] < 2){ echo "ERROR"; exit; }

$db->query("DELETE FROM ".PREFIX."forum_threads WHERE groupid = '".$groupid."' AND id = '".$topicid."' LIMIT 1");
$db->query("DELETE FROM ".PREFIX."forum_posts WHERE threadid = '".$topicid."'");
echo "SUCCESS";
?>