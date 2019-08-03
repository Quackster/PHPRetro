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
$data = new register_sql;
$lang->addLocale("register.ajax.errors");

$name = $input->FilterText($_POST['name']);
$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $name);

if($serverdb->result($data->select2($name)) > 0){
	header("X-JSON: {\"registration_name\":\"".$lang->loc['ajax.error.2']."\"}");
} elseif($filter != $name){
	header("X-JSON: {\"registration_name\":\"".$lang->loc['ajax.error.3']."\"}");
} elseif(strlen($name) > 24){
	header("X-JSON: {\"registration_name\":\"".$lang->loc['ajax.error.4']."\"}");
} elseif(strlen($name) < 1){
	header("X-JSON: {\"registration_name\":\"".$lang->loc['ajax.error.5']."\"}");
} else {
	$first = substr($name, 0, 4);
	if (strnatcasecmp($first,"MOD-") == false) {
		header("X-JSON: {\"registration_name\":\"".$lang->loc['ajax.error.5']."\"}");
	} else {
		header("X-JSON: {}");
	}
}

?>

