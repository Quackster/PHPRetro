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

if($settings->find("site_allow_guests") != "1"){
    $page['allow_guests'] = false;
}

if($user->error > 2){
	$errornum = $user->error;
	if($errornum == 3){
		header('Location: '.PATH.'/account/logout?reason=banned'); exit;
	}
	$user->destroy();
	header('Location: '.PATH.'/?error='.$errornum);
	exit;
}

if(!isset($_SESSION['user']) && $page['allow_guests'] != true){
	if(!isset($page['dir'])){ $_SESSION['page'] = $_SERVER["REQUEST_URI"]; }
	if(strrpos($_SESSION['page'],"client") != false){ header("Location: ".PATH."/login_popup"); }else{ header("Location: ".PATH."/"); } exit;
}elseif(!isset($_SESSION['user']) && $page['allow_guests'] == true){
	if(!isset($page['dir'])){ $_SESSION['page'] = $_SERVER["REQUEST_URI"]; }
}
if(!empty($page['rank'])){
	$u = $serverdb->fetch_row($core->select3($id));
	if($u[3] < $page['rank']){
		$user->error = 4;
	}
}
if($user->ip != $_SERVER['REMOTE_ADDR']){
	$user->error = 5;
}
if(time() > ($user->time + (((int) $settings->find("site_session_time")) * 60))){
	$_SESSION['reauthenticate'] = true;
	$user = new HoloUser($user->name,$user->password,true);
	$_SESSION['user'] = $user;
}

?>