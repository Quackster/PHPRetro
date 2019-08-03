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

$page['dir'] = '\housekeeping';
$page['housekeeping'] = true;
$page['rank'] = 7;
require_once('../includes/core.php');
require_once('./includes/hksession.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.newsletter");
define('RATE',1000); //how fast when sending messages in miliseconds

if($_GET['do'] == "send"){
	$mailer = $_SESSION['newsletter']['mailer'];
	$emails = $_SESSION['newsletter']['emails'];
	$subject = $_SESSION['newsletter']['subject'];
	$message = $_SESSION['newsletter']['message'];
	$total = $_SESSION['newsletter']['total'];
	$at = $_SESSION['newsletter']['at'];
	$lang->addLocale("newsletter.send");
	echo "<html><head><title>".$lang->loc['sending.newsletter']."...</title></head><body>";
	if(!empty($emails[$at])){
		$email = $emails[$at];
		echo $lang->loc['sending.message']." <strong>".$at."</strong> ".$lang->loc['of']." <strong>".$total."</strong> ".$lang->loc['to']." ".$email."...<br />";
		$result = $mailer->sendNewsletter($email,$subject,$message);
		if(!$result){
			$_SESSION['newsletter']['error'][] = $email;
			echo $lang->loc['error.sending'].": ".$email."<br />";
		}else{
			$_SESSION['newsletter']['success']++;
			echo $lang->loc['sent'].".";
		}
		echo 
		'
		<script type="text/javascript">
		<!--
		function delayer(){
			window.location = "'.PATH.'/housekeeping/newsletter?do=send"
		}
		setTimeout(\'delayer()\', '.RATE.')
		//-->
		</script>
		';
		$_SESSION['newsletter']['at']++;
	}else{
		$success = $_SESSION['newsletter']['success'];
		$errors = $_SESSION['newsletter']['error'];
		echo $lang->loc['done.sent']." <strong>".$_SESSION['newsletter']['success']."</strong> ".$lang->loc['of']." <strong>".$total."</strong> ".$lang->loc['messages.success'].".<br /><br />";
		if(count($errors) > 0){
			echo $lang->loc['error'].":<br />";
			foreach($errors as $error){
				echo "<strong>".$error."</strong>";
			}
		}
		echo "<br /><br />".$lang->loc['click']." <a href=\"".PATH."/housekeeping/\">".$lang->loc['here']."</a> ".$lang->loc['to.go.back'].".";
	}
	echo "</body></html>";
	exit;
}elseif($_GET['do'] == "save"){
	$sql = $serverdb->query("SELECT email FROM ".PREFIX."users WHERE email != '' AND newsletter = '1' AND email_verified = '1'");
	$emails = array();
	while($row = $serverdb->fetch_row($sql)){
		$emails[] = $row[0];
	}
	$mailer = new HoloMail;
	$message = $input->HoloText($_POST['message'],true);
	$subject = $input->HoloText($_POST['subject'],true);
	if(!empty($_POST['header'])){ $message = $mailer->htmlToMessage($_POST['header']) . $message; }
	if(!empty($_POST['footer'])){ $message .= $mailer->htmlToMessage($_POST['footer']); }
	if($_POST['status'] == "true"){
		$_SESSION['newsletter']['mailer'] = $mailer;
		$_SESSION['newsletter']['emails'] = $emails;
		$_SESSION['newsletter']['subject'] = $subject;
		$_SESSION['newsletter']['message'] = $message;
		$_SESSION['newsletter']['total'] = count($emails);
		$_SESSION['newsletter']['at'] = 0;
		$_SESSION['newsletter']['error'] = array();
		$_SESSION['newsletter']['success'] = 0;
		header('Location: '.PATH.'/housekeeping/newsletter?do=send');
		exit;
	}else{
		@set_time_limit(0);
		foreach($emails as $email){
			$mailer->sendNewsletter($email,$subject,$message);
		}
	}
	header('Location: '.PATH.'/housekeeping');
}

$default_email = HoloMail::htmlToMessage('./templates/newsletter_body.php');

$page['name'] = $lang->loc['pagename.newsletter'];
$page['category'] = "tools";
require_once('./templates/housekeeping_header.php');

$icon = "newsletter.png";
$description = $lang->loc['newsletter.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/newsletter?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="subject">'.$lang->loc['subject'].':</label><br />
<input type="text" name="subject" value="'.$input->HoloText($row['subject']).'" title="'.$lang->loc['subject.desc'].'" /><br />
<label for="message">'.$lang->loc['message'].':</label><br />
<textarea name="message" title="'.$lang->loc['message.desc'].'">'.$default_email.'</textarea><br />
<label for="header">'.$lang->loc['header'].':</label><br />
<input type="text" name="header" title="'.$lang->loc['header.desc'].'" value="./templates/newsletter_header.php" />
<label for="header">'.$lang->loc['footer'].':</label><br />
<input type="text" name="footer" title="'.$lang->loc['footer.desc'].'" value="./templates/newsletter_footer.php" />
<label for="status">'.$lang->loc['status'].':</label><br />
<input type="checkbox" style="width: auto" name="status" value="true" checked="true" title="'.$lang->loc['status.desc'].'" /><lable class="checklabel" for="status">'.$lang->loc['show'].'</label><br />
<div class="button"><input type="submit" name="send" value="'.$lang->loc['send'].'" /></div>
</form>
</div>';

?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.newsletter']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.newsletter']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
<div class="text">
<?php echo $description; ?>
</div>
</td>
 <td class="page_main_right">
<div class="center">
<?php echo $content; ?>
</div>
 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>