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

if (!defined("IN_HOLOCMS")) { header("Location: ".PATH."/"); exit; }

if(time() > ($user->time + (((int) $settings->find("site_session_time")) * 60))){
	$user->error = 1;
}else{
	$user = new HoloUser($user->name,$user->password,true);
	$_SESSION['hk_user'] = $user;
}
if(!empty($page['rank'])){
	$u = $serverdb->fetch_row($core->select3($user->id));
	if($u[3] < $page['rank']){
		$user->error = 4;
	}
}
if($user->ip != $_SERVER['REMOTE_ADDR']){
	$user->error = 5;
}
if($user->error == 4){
	require_once('./housekeeping/permissions.php'); exit;
}elseif($user->error > 0){
	$_SESSION['hk_user'] = null;
	header('Location: '.PATH.'/housekeeping/');
	exit;
}
?>