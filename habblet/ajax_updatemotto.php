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
$data = new me_sql;

if(isset($_POST['motto'])){

	if(strlen($_POST['motto']) > 38){
		echo $input->HoloText($user->user("mission"));
	} else {
		$motto = $input->FilterText($_POST['motto']);
		$data->update1($user->id, $motto);
		$user->refresh();
		echo $input->HoloText($user->user("mission"));
		@SendMUSData('UPRA' . $user->id);
	}

} else {
	echo $input->HoloText($user->user("mission"));
}
?>