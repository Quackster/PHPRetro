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
$lang->addLocale("minimail.undeletemessage");

$id = $input->FilterText($_POST['messageId']);
$start = $_POST['start'];
$label = $_POST['label'];

$db->query("UPDATE ".PREFIX."minimail SET deleted = '0' WHERE id = '".$id."' LIMIT 1");

$page['bypass'] = true;
$label = "trash";
$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '1'");
header('X-JSON: {"message":"'.$lang->loc['undelete.message'].'","totalMessages":'.$db->result($sql).'}');
require('./habblet/minimail_loadMessages.php');
?>