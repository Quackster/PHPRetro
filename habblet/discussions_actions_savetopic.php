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
$data = new home_sql;
$lang->addLocale("groups.discussion.topic");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['groupId']);
$message = $input->FilterText($_POST['message']);
$name = $input->FilterText($_POST['topicName']);
$captcha = strtolower($_POST['captcha']);

if(($_SESSION['register-captcha-bubble'] == $captcha && !empty($_SESSION['register-captcha-bubble'])) || $settings->find("site_capcha") == "0"){
	unset($_SESSION['register-captcha-bubble']);
} else {
	header('X-JSON: {"captchaError":"true"}'); exit;
}

$sql = $data->select14($id);
$grouprow = $db->fetch_row($sql);
$sql = $data->select15($user->id,$grouprow[0]);
$memberrow = $db->fetch_row($sql);

if($grouprow[9] == 2 && $memberrow[2] < 2){ exit; }
if($grouprow[9] == 1 && $memberrow[2] < 1){ exit; }
if(strlen($name) > 32){ exit; }
if((int) $user->user("email_verified") < 1){ exit; }

$sql = $db->query("INSERT INTO ".PREFIX."forum_threads (starterid,title,open,sticky,views,groupid,time) VALUES ('".$user->id."','".$name."','1','0','0','".$grouprow[0]."','".time()."')");
$forumid = $db->insert_id($sql);
$db->query("INSERT INTO ".PREFIX."forum_posts (threadid,message,posterid,time,edit_time) VALUES ('".$forumid."','".$message."','".$user->id."','".time()."','0')");
?>
<?php echo groupURL($grouprow[0]); ?>/discussions/<?php echo $forumid; ?>/id