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
$index = $input->FilterText($_POST['feedItemIndex']);
if(!is_numeric($index)){ exit; }

$sql = $db->query("SELECT id FROM ".PREFIX."alerts WHERE userid = '".$user->id."' AND `type` > -1 ORDER BY id DESC LIMIT 1 OFFSET ".$index);
if($db->num_rows($sql) > 0){ $id = $db->result($sql); }else{ $id = 0; }
$db->query("DELETE FROM ".PREFIX."alerts WHERE userid = '".$user->id."' AND `type` > -1 AND id = '".$id."' LIMIT 1");
?>