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
$data = new home_sql;

$id = $input->FilterText($_GET['id']);

$row = $db->fetch_row($data->select13($id));
$song = substr($row[0], 0, -1);
$song = str_replace(array(":4:",":3:",":2:","1:"),array("&track4=","&track3=","&track2=","&track1="),$song);
$userrow = $db->fetch_row($data->select2($row[2]));
echo "status=0&name=".$input->HoloText($row[1])."&author=".$input->HoloText($userrow[1]).$song;
?>