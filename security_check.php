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
$lang->addLocale("redirect");

$pageid = $input->HoloText($_GET['page']);
if(isset($_SESSION['page']) && $pageid == ""){ $pageid = $_SESSION['page']; }
$type = $_GET['type'];

if($type == "token"){
	$_SESSION = array();
	$token = $input->FilterText($_COOKIE['rememberme_token']);
	$sql = $serverdb->query("SELECT id FROM ".PREFIX."users WHERE remember_token = '".$token."' LIMIT 1");
		if($serverdb->num_rows($sql) > 0){
			$id = $serverdb->result($sql);
			$username = $serverdb->result($core->select1($id), 0, 1);
			$password = $serverdb->result($core->select1($id));
		}else{
			$user->destroy();
		}
	$user = new HoloUser($username,$password,true);
	$_SESSION['user'] = $user;
	$_SESSION['reauthenticate'] = "true";
}elseif(isset($_SESSION['user']) && is_object($_SESSION['user'])){
	$user = $_SESSION['user'];
}else{
	header("Location: ".PATH."/"); exit;
}

if($user->error > 2){
	$errornum = $user->error;
	if($errornum == 3){
		header('Location: '.PATH.'/account/logout?reason=banned'); exit;
	}
	$user->destroy();
	header("Location: ".PATH."/?page=".$pageid."&username=".$input->HoloText($username)."&error=".$user->error); exit;
}

$limit = (int) $settings->find("site_highload");
if($limit != 0 && (int) GetOnlineCount() > $limit && strpos($pageid,"client") == false){
	$pageid = PATH."/intermediate";
}

unset($_SESSION['page']);
if($pageid == "" || strpos($pageid,"security_check") != false){ $pageid = PATH; }
?>

<html>
<head>
  <title><?php echo $lang->loc['redirecting']; ?>...</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <style type="text/css">body { background-color: #e3e3db; text-align: center; font: 11px Verdana, Arial, Helvetica, sans-serif; } a { color: #fc6204; }</style>
</head>
<body>

<script type="text/javascript">window.location.replace('<?php echo $pageid; ?>');</script><noscript><meta http-equiv="Refresh" content="0;URL=<?php echo $pageid; ?>"></noscript>

<p class="btn"><?php echo $lang->loc['not.redirected.yet']; ?> <a href="<?php echo $pageid; ?>" id="manual_redirect_link"><?php echo $lang->loc['click.here']; ?></a></p>

<?php echo $settings->find("site_tracking"); ?>

</body>
</html>