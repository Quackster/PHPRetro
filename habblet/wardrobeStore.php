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

$slot = $_POST['slot'];
$figure = $input->FilterText($_POST['figure']);
$gender = $_POST['gender'];

$check = new HoloFigureCheck($figure,$gender,$user->IsHCMember("self"));

if($check->error > 0){ exit; }
if(!is_numeric($slot)){ exit; }
if($slot < 1 || $slot > 5){ exit; }

$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."wardrobe WHERE userid = '".$user->id."' AND slotid = '".$slot."' LIMIT 1");
$exists = $db->result($sql);

if($exists > 0){
	$db->query("UPDATE ".PREFIX."wardrobe SET figure = '".$figure."', gender = '".$gender."' WHERE userid = '".$user->id."' AND slotid = '".$slot."' LIMIT 1");
} else {
	$db->query("INSERT INTO ".PREFIX."wardrobe (userid,slotid,figure,gender) VALUES ('".$user->id."','".$slot."','".$figure."','".$gender."')");
}
header("X-JSON: {\"u\":\"".$user->avatarURL($figure,"s,4,4,sml,1,0")."\",\"f\":\"".$figure."\",\"g\":77}");
?>

