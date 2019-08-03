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
$lang->addLocale("minimail.deletemessage");

$label = $_POST['label'];
$id = $input->FilterText($_POST['messageId']);
$start = $_POST['start'];
$conversation = $_POST['conversationId'];

$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE id = '".$id."' LIMIT 1");
$row = $db->fetch_assoc($sql);

if($row['deleted'] == "1"){
$db->query("DELETE FROM ".PREFIX."minimail WHERE id = '".$id."' LIMIT 1");
$page['bypass'] = "true";
$page = "trash";
$message = $lang->loc['delete.error.1'];
require('./habblet/minimail_loadMessages.php');
} else {
$db->query("UPDATE ".PREFIX."minimail SET deleted = '1' WHERE id = '".$id."' LIMIT 1");
$page['bypass'] = true;
$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."'");
header('X-JSON: {"message":"'.$lang->loc['delete.error.2'].'","totalMessages":'.$db->result($sql).'}');

require('./habblet/minimail_loadMessages.php');
} ?>