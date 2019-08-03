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
$lang->addLocale("searchhabbos.addfriend");

$id = $input->FilterText($_POST['accountId']);

if($serverdb->result($data->select10($id, $user->id), 0) <> 0){
$error = 1;
$message = $lang->loc['habbo.error.1'];
}

if($serverdb->result($data->select11($id, $user->id), 0) <> 0){
$error = 1;
$message = $lang->loc['habbo.error.2'];
}

if($id == $user->id){
$error = 1;
$message = $lang->loc['habbo.error.3'];
}

if($serverdb->num_rows($data->select6($id)) < 1){
$error = 1;
$message = $lang->loc['habbo.error.4'];
}

if($error <> 1){
$requestid = $serverdb->result($data->select12($id), 0);
$requestid = $requestid + 1;

$data->insert1($user->id, $id, $requestid);

$mailer = new HoloMail;
$lang->addLocale("email.footer");
$lang->addLocale("email.friendrequest");
$plaintext = SHORTNAME."\r\n\r\n".$user->name." ".$lang->loc['plain.message']." ".$input->HoloText($user->name)." ".$lang->loc['at']." ".PATH."/home/".$input->HoloText($user->name)."?utm_source=friendrequest&utm_medium=email&utm_campaign=friendrequest . ".$lang->loc['plain.footer']."\r\n\r\n* * *\r\n\r\n".$lang->loc['copyright'];
$html = '<h1 style="font-size: 16px">'.$lang->loc['subject'].'</h1> <p> '.$input->HoloText($user->name).' '.$lang->loc['html.message.1'].' </p> <p style="font-size: 13px;"> <a href="'.PATH."/home/".$input->HoloText($user->name).'?utm_source=friendrequest&utm_medium=email&utm_campaign=friendrequest">'.$lang->loc['html.message.2'].' '.$input->HoloText($user->name).'!</a> </p> <p> '.$lang->loc['plain.footer'].' </p>';
$receiver = $serverdb->fetch_row($serverdb->query("SELECT email,email_verified,email_friendrequest FROM ".PREFIX."users WHERE id = '".$id."' LIMIT 1"));
if($receiver[1] == "1" && $receiver[2] == "1"){
	$mailer->sendSimpleMessage($receiver[0],$lang->loc['subject'],$html,$plaintext);
}

$message = $lang->loc['habbo.success'];
}
?>

<div id="avatar-habblet-dialog-body" class="topdialog-body"><ul>
	<li><?php echo $message; ?></li>
</ul>


<p>
<a href="#" class="new-button done"><b><?php echo $lang->loc['done']; ?></b><i></i></a>
</p></div>