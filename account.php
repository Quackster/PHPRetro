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

$page['bypass_user_check'] = true;
require_once('./includes/core.php');
$data = new index_sql;

$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "landing";

$var = $_GET['var1'];
$var2 = $_GET['var2'];
$date = HoloDate();

if(!isset($_POST['page']) && session_is_registered(page)){ $_POST['page'] = $_SESSION['page']; }

switch($var){
case "submit":
	if(empty($_SESSION['login']['enabled']) || $_SESSION['login']['enabled'] == false){
		header('Location: '.PATH.'/'); exit;
	}
	if($user->id > 0){
		header("Location:".PATH."me");
	}
	$lang->addLocale("redirect");
	unset($_SESSION['error']);
	$name = $input->FilterText($_POST['username']);
	$password = $input->HoloHash($_POST['password'], $name);
	$remember_me = $_POST['_login_remember_me'];
	
	$user = new HoloUser($name,$password,true,$remember_me);
	$_SESSION['user'] = $user;
	$lang->addLocale("landing.login");
	
	if($user->error > 0){
		$login_error = $lang->loc['error.'.$user->error];
		if($user->error == 3){
			$login_error = $lang->loc['banned.1'].$user->banned['reason'].$lang->loc['banned.2'].$user->banned['expire'].".";
		}
	}
	if($_SESSION['login']['tries'] > 4 && $settings->find("site_capcha") == "1"){
		if(($_SESSION['register-captcha-bubble'] == strtolower($_POST['bean_captchaResponse']) && !empty($_SESSION['register-captcha-bubble'])) || $settings->find("site_capcha") == "0") {
			unset($_SESSION['register-captcha-bubble']);
		}else{
			$login_error = $lang->loc['error.captcha'];
		}
	}
if(!empty($login_error)){
setcookie("rememberme", "", time()-60*60*24*100, "/"); setcookie("cookpass", "", time()-60*60*24*100, "/");
setcookie("rememberme_token", "", time()-60*60*24*100, "/"); setcookie("cookpass", "", time()-60*60*24*100, "/");
$_SESSION['error'] = $login_error;
$_SESSION['login']['tries']++;
?>
<html>
<head>
  <title><?php echo $lang->loc['redirecting']; ?>...</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <style type="text/css">body { background-color: #e3e3db; text-align: center; font: 11px Verdana, Arial, Helvetica, sans-serif; } a { color: #fc6204; }</style>
</head>
<body>

<script type="text/javascript">window.location.replace('<?php echo PATH; ?>/?page=<?php echo $input->HoloText($_POST['page']); ?>&username=<?php echo $input->HoloText($_POST['username']); ?>&rememberme=<?php if(isset($_POST['_login_remember_me'])){ echo "true"; }else{ echo "false"; } ?>');</script><noscript><meta http-equiv="Refresh" content="0;URL=<?php echo PATH; ?>/?page=<?php echo $input->HoloText($_POST['page']); ?>&username=<?php echo $input->HoloText($_POST['username']); ?>&rememberme=<?php if(isset($_POST['_login_remember_me'])){ echo "true"; }else{ echo "false"; } ?>"></noscript>

<p class="btn"><?php echo $lang->loc['not.redirected.yet']; ?> <a href="<?php echo PATH; ?>/?page=<?php echo $input->HoloText($_POST['page']); ?>&username=<?php echo $input->HoloText($_POST['username']); ?>&rememberme=<?php if(isset($_POST['_login_remember_me'])){ echo "true"; }else{ echo "false"; } ?>" id="manual_redirect_link"><?php echo $lang->loc['click.here']; ?></a></p>

<?php echo $settings->find("site_tracking"); ?>

</body>
</html>
<?php
}else{
	unset($_SESSION['login']);
	$_SESSION['user'] = $user;
	if(isset($_POST['page']) == true){ header("Location: ".PATH."/security_check?page=".$_POST['page']); exit; }elseif(isset($_SESSION['page']) == true){ header("Location: ".PATH."/security_check?page=".$_SESSION['page']); unset($_SESSION['page']); exit; }else{ header("Location: ".PATH."/security_check"); exit; }
}
break;
case "password":
	require_once('./forgot.php');
break;
case "logout":
	if($_GET['origin'] != "popup"){ require_once('./logout.php'); }
break;
case "logout_ok":
	require_once('./logout.php');
break;
case "unloadclient":
break;
case "reauthenticate":
	require_once('./reauthenticate.php');
break;
case "disconnected":
	require_once('./logout.php');
break;
default:
header("HTTP/1.0 404 Not Found");
	require_once('./error.php');
break;
}
?>