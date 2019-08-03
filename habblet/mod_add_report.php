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

$type = $input->FilterText($_GET['type']);
$id = $input->FilterText($_POST['objectId']);

$count = $_SESSION['report_count'];
if(!is_numeric($count)){ $count = 0; }
$_SESSION['report_count'] = $count + 1;

if($count > 10){ echo "SPAM"; exit; }
if(!is_numeric($id)){ echo "ERROR"; exit; }

$db->query("INSERT INTO ".PREFIX."help (username,ip,message,date,subject) VALUES ('".$user->name."','".$_SERVER['REMOTE_ADDR']."','Someone reported abuse on ".$type." id: ".$id."','".time()."','Abuse report on ".$type."')");
echo "SUCCESS";
?>
