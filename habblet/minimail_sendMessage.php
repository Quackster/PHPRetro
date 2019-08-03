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
$lang->addLocale("minimail.sentmessage");
$data = new me_sql;

$messageid = $input->FilterText($_POST['messageId']);
$recipientids = $_POST['recipientIds'];
$subject = $input->FilterText($_POST['subject']);
$body = $input->FilterText($_POST['body']);

$ids = explode(",", $recipientids);

if(isset($_POST['messageId'])){
	$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE id = '".$messageid."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	if($row['conversationid'] == "0"){
		$sql = $db->query("SELECT MAX(conversationid) FROM ".PREFIX."minimail");
		$conid = $db->result($sql);
		$conid = $conid + 1;
		$db->query("UPDATE ".PREFIX."minimail SET conversationid = '".$conid."' WHERE id = '".$row['id']."' LIMIT 1");
	} else {
		$conid = $row['conversationid'];
	}
	$subject = "Re: ".$row['subject'];
	$ids[0] = $row['senderid'];
} else {
	$conid = "0";
}

$mailer = new HoloMail;
$lang->addLocale("email.footer");
$lang->addLocale("email.minimail");
$plaintext = SHORTNAME."\r\n\r\n".$user->name." ".$lang->loc['plain.message']." ".PATH."/?utm_source=minimail&utm_medium=email&utm_campaign=minimail . ".$lang->loc['plain.footer']."\r\n\r\n* * *\r\n\r\n".$lang->loc['copyright'];
$html = '<h1 style="font-size: 16px">'.$lang->loc['subject'].'</h1> <p> '.$input->HoloText($user->name).' '.$lang->loc['html.message.1'].' '.$input->HoloText($subject).' </p> <p style="font-size: 13px;"> <a href="'.PATH.'/?utm_source=minimail&utm_medium=email&utm_campaign=minimail">'.$lang->loc['html.message.2'].'</a> </p> <p> '.$lang->loc['plain.footer'].' </p>';
foreach($ids as $id){
	if($serverdb->result($data->select10($user->id,$id)) == 0){ continue; }
    $db->query("INSERT INTO ".PREFIX."minimail (senderid,to_id,subject,time,message,conversationid) VALUES ('".$user->id."','".$id."','".$subject."','".time()."','".$body."','".$conid."')");
	$receiver = $serverdb->fetch_row($serverdb->query("SELECT email,email_verified,email_minimail FROM ".PREFIX."users WHERE id = '".$id."' LIMIT 1"));
	if($receiver[1] == "1" && $receiver[2] == "1"){
		$mailer->sendSimpleMessage($receiver[0],$lang->loc['subject'],$html,$plaintext);
	}
}

$page['bypass'] = true;
$label = "inbox";
$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."'");
header('X-JSON: {"message":"'.$lang->loc['sent.message'].'","totalMessages":'.$db->result($sql).'}');
require('./habblet/minimail_loadMessages.php');
?>