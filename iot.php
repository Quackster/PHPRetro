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

require_once('./includes/core.php');
$lang->addLocale("iot");
require_once('./templates/iot_header.php');

switch($_POST['sid']){
	case "58":
		$lang->addLocale("iot.errors");
		if(($_SESSION['register-captcha-bubble'] == strtolower($_POST['captcha']) && !empty($_SESSION['register-captcha-bubble'])) || $settings->find("site_capcha") == "0") {
			unset($_SESSION['register-captcha-bubble']);
		}else{
			$step = 1;
			$error = $lang->loc['invalid.captcha'];
			break;
		}
		$_SESSION['registered'] = "true";
		if($_POST['event'] == "Not member"){ $step = 4; }elseif($_POST['event'] == "Member"){ $step = 2; }else{ $step = 1; } break;
	case "6":
		$lang->addLocale("iot.errors");
		if(isset($_POST['event']) && $_POST['event'] == "change"){ $step = 2; break; }
		if(empty($_POST['name']) || empty($_POST['email'])){ $step = 2; $error = $lang->loc['fill.all.fields']; break; }
		if(!preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $_POST['email'])){ $step = 2; $error = $lang->loc['invalid.email']; break; }
		if($db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."users WHERE name = '".$input->FilterText($_POST['name'])."' LIMIT 1")) == 0){ $step = 2; $error = $lang->loc['no.account.found']; break; }
		$name = $input->HoloText($_POST['name']); $email = $input->HoloText($_POST['email']); $step = 3;
		$_SESSION['help_name'] = $name; $_SESSION['help_email'] = $email; break;
	case "63":
		$lang->addLocale("iot.errors");
		if(!isset($_SESSION['registered'])){ $step = -2; break; }
		if(!preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $_POST['email'])){ $step = 4; $error = $lang->loc['invalid.email']; break; }
		$email = $input->FilterText($_POST['email']); $message = $input->FilterText($_POST['message']); $subject = $input->FilterText($_POST['subject']);
		if($message != "" && $subject != ""){
			$db->query("INSERT INTO ".PREFIX."help (username,ip,message,date,subject) VALUES ('UNREGISTERED','".$_SERVER['REMOTE_ADDR']."','Email: ".$email."\nMessage: ".$message."','".time()."','".$subject."')");
			unset($_SESSION['registered']);
			$step = -1;
		}else{
			$step = 4; $error = 1;
		}
		break;
	case "56":
		if(!isset($_SESSION['registered'])){ $step = -2; break; }
		$email = $input->FilterText($_SESSION['help_email']); $name = $input->FilterText($_SESSION['help_name']); $message = $input->FilterText($_POST['message']); $subject = $input->FilterText($_POST['subject']);
		if($message != "" && $subject != ""){
			if($email != "" && $subject != ""){
				$db->query("INSERT INTO ".PREFIX."help (username,ip,message,date,subject) VALUES ('".$name."','".$_SERVER['REMOTE_ADDR']."','Email: ".$email."\nMessage: ".$message."','".time()."','".$subject."')");
				unset($_SESSION['registered']); unset($_SESSION['help_email']); unset($_SESSION['help_name']);
				$step = -1;
			}else{
				$step = 2; $error = 1;
			}
		}else{
			$step = 3; $error = 1;
		}
		break;
	default:
		$step = 1; break;
}
?>
 <div id="main-content-process">		
  <div style="height: 4px;"></div>
  <div style="height: 18px; padding: 0 0 0 12px;">&nbsp;</div>	
  <div class="portlet">
   <div class="portlet-top-process"><div class="portlet-process-header">&nbsp;</div></div>
   <div class="portlet-body-process">
   <div class="imaindiv">
<?php if($step == -2){ 
$lang->addLocale("iot.step-2"); ?>
<h2><?php echo $lang->loc['error.header']; ?></h2>
<br>
<?php echo $lang->loc['error.info']; ?>
<br><br>
<br><br>
<a href="javascript:window.close();"><?php echo $lang->loc['close.window']; ?></a>
<?php }elseif($step == -1){ 
$lang->addLocale("iot.step-1"); ?>
<h2><?php echo $lang->loc['thank.you']; ?></h2>
<br>
<?php echo $lang->loc['thank.you.message']; ?>
<br><br>
<br><br>
<a href="javascript:window.close();"><?php echo $lang->loc['close.window']; ?></a>
<?php } ?>
<?php if($step > 1){ 
$lang->addLocale("iot.step1"); ?>
<form method="post" action="go"><input type="hidden" name="sid" value="58"><table border="0" cellspacing="0" cellpadding="0" class="ihead">

	<tr>
		<td class="icon"><img src="<?php echo PATH; ?>/web-gallery/header_images/Western2/pass.gif" alt=" " width="47" height="37" /></td>
		<td class="text">
			<h2><?php echo $lang->loc['step.1.header']; ?></h2>
			
				<b><?php if($step == 4){ echo $lang->loc['no']; }else{ echo $lang->loc['yes']; } ?></b>
			
		</td>
		   
			<td class="btn" align="right">
				<table height="21" border="0" cellpadding="0" cellspacing="0" class="button">

					<tr>
						<td class="button-left-side-arrow"></td>
						<td class="middle">
							<input type="hidden" name="event" value="change" /><input type="submit" class="changebutton" value="<?php echo $lang->loc['change']; ?>" />
						</td>
						<td class="button-right-side"></td>
					</tr>
				</table>
			</td>

		
		</tr>
</table>
<br>
</form>
<br>

<?php } ?>
<?php if($step > 2 && $step < 4){ 
$lang->addLocale("iot.step2"); ?>
<form method="post" action="go"><input type="hidden" name="sid" value="6"><table border="0" cellspacing="0" cellpadding="0" class="ihead">
 <tr>
  <td class="icon">
    <img src="<?php echo PATH; ?>/web-gallery/header_images/Western2/pass.gif" alt=" " width="47" height="37" /></td>
  <td class="text">
    <h2><?php echo $lang->loc['step.2.header']; ?></h2>

    
     <b><?php echo $lang->loc['name']; ?>:&nbsp;<?php echo $name; ?></b></td>
  
   <td class="btn" align="right"><table height="21" border="0" cellpadding="0" cellspacing="0" class="button"><tr><td class="button-left-side-arrow"></td><td class="middle"><input type="hidden" name="event" value="change" /><input type="submit" class="changebutton" value="<?php echo $lang->loc['change']; ?>" /></td><td class="button-right-side"></td></tr></table></td>
  
 </tr>
</table>
<br>
</form>

<?php } ?>
<?php switch($step){
case 1: 
$lang->addLocale("iot.step1"); ?>
<form method="post" action="go"><input type="hidden" name="sid" value="58"><table border="0" cellspacing="0" cellpadding="0" class="ihead">

	<tr>
		<td class="icon"><img src="<?php echo PATH; ?>/web-gallery/header_images/Western2/<?php if(!isset($error)){ echo "1"; }else{ echo "error"; } ?>.gif" alt=" " width="47" height="37" /></td>
		<td class="text">
			<h2><?php echo !empty($error) ? '<font class="ErrorHeader">'.$error.'</font>' : $lang->loc['step.1.header']; ?></h2>
			
		</td>
		
		</tr>
</table>
<br>

	<table border="0" cellspacing="0" cellpadding="0" class="content-table">

		<tr>
			<td valign="middle" align="left" style="width: 300px;">
	                        <div class="iinfodiv">
                           <b><input type="radio" name="event" value="Member" /><?php echo $lang->loc['yes']; ?></b>
                           <br><br>
                           <b><input type="radio" name="event" value="Not member" /><?php echo $lang->loc['no']; ?></b>
                           <br><br>
                           <?php if($settings->find("site_capcha") != "0"){ ?>
                           <img src="<?php echo PATH; ?>/captcha.jpg" /><br>
                           <?php echo $lang->loc['check.code']; ?>:<br>
                           <input type="text" name="captcha" size="10" maxlength="10" value="" />
                           <br><br>
                           <?php } ?>
                           <div style="padding-left: 10px;">
                              <table height="21" border="0" cellpadding="0" cellspacing="0" class="button"><tr><td class="button-left-side"></td><td class="middle"><input type="submit" class="proceedbutton" value="<?php echo $lang->loc['proceed']; ?>" /></td><td class="button-right-side-arrow"></td></tr></table></div>
                           </div>
			</td>
		</tr>

	</table>
</form>
<?php break; case 2: 
$lang->addLocale("iot.step2"); ?>
<form method="post" action="go"><input type="hidden" name="sid" value="6"><table border="0" cellspacing="0" cellpadding="0" class="ihead">
 <tr>
  <td class="icon">
    <img src="<?php echo PATH; ?>/web-gallery/header_images/Western2/<?php if(!isset($error)){ echo "2"; }else{ echo "error"; } ?>.gif" alt=" " width="47" height="37" /></td>
  <td class="text">
    <h2><?php echo !empty($error) ? '<font class="ErrorHeader">'.$error.'</font>' : $lang->loc['step.2.header']; ?></h2>

    </td>
  
 </tr>
</table>
<br>

<table border="0" cellspacing="0" cellpadding="0" class="content-table">
 <tr>  
  <td valign="top">
   <div class="iinfodiv" style="margin-left:0px;">
    <table border="0">
     <tr>

      <td valign="top"><img src="<?php echo PATH; ?>/web-gallery/content3/images/process/pen.gif" alt=""/></td>
      <td valign="center"><?php echo $lang->loc['step.2.info']; ?></td>  
      <td align="center">
     </tr>
    </table>
   </div>
  </td>
  <td class="iactiontd" align="center">
   <b><?php echo $lang->loc['name']; ?></b><br><input type="text" name="name"  size="30" maxlength="50" value="" /><br><br>

   <b><?php echo $lang->loc['email']; ?></b><br><input type="text" name="email"  size="30" maxlength="50" value="" /><br><br>
   <div align="right" class="btn-div">
    <table height="21" border="0" cellpadding="0" cellspacing="0" class="button"><tr><td class="button-left-side"></td><td class="middle"><input type="submit" class="proceedbutton" value="<?php echo $lang->loc['proceed']; ?>" /></td><td class="button-right-side-arrow"></td></tr>
    </table>
   </div>
  </td>
 </tr>
</table>
</form>
<?php break; case 3: 
$lang->addLocale("iot.step3"); ?>
<form method="post" action="go"><input type="hidden" name="sid" value="56"><table border="0" cellspacing="0" cellpadding="0" class="ihead">
 <tr>
  <td class="icon"><img src="<?php echo PATH; ?>/web-gallery/header_images/Western2/<?php if(!isset($error)){ echo "3"; }else{ echo "error"; } ?>.gif" alt=" " width="47" height="37" /></td>
  <td class="text"><h2><?php echo $lang->loc['step.3.header']; ?></h2></td>
 </tr>
</table>
<br>

<table border="0" cellspacing="0" cellpadding="0" class="content-table">
 <tr>
  <td>
   <div class="iinfodiv">
    <?php echo $lang->loc['step.3.info']; ?><br><br>
    <?php echo $lang->loc['subject']; ?><br>
    <input type="text" name="subject"  size="50" maxlength="50" value="" /><br> 
    <?php echo $lang->loc['message']; ?><br>
    <textarea name="message"  class="imessageform"></textarea>
   </div>

  <br>
  </td>
 </tr>
</table>
   <div align="center">
   <table height="21" border="0" cellpadding="0" cellspacing="0" class="button">
    <tr><td class="button-left-side"></td><td class="middle"><button type="submit" name="submit" class="proceedbutton"><?php echo $lang->loc['send']; ?></button></td><td class="button-right-side-arrow"></td></tr>
   </table>
   </div>

</form>

<?php break; case 4: 
$lang->addLocale("iot.step4"); ?>
<form method="post" action="go"><input type="hidden" name="sid" value="63"><table border="0" cellspacing="0" cellpadding="0" class="ihead">
 <tr>
  <td class="icon"><img src="<?php echo PATH; ?>/web-gallery/header_images/Western2/<?php if(!isset($error)){ echo "2"; }else{ echo "error"; } ?>.gif" alt=" " width="47" height="37" /></td>
  <td class="text"><h2><?php echo !empty($error) ? '<font class="ErrorHeader">'.$error.'</font>' : $lang->loc['send.a.question']; ?></h2></td></tr>
</table>
<br>

<table border="0" cellspacing="0" cellpadding="0" class="content-table">
 <tr>
  <td>

   <div class="iinfodiv">
    <?php echo $lang->loc['step.4.info']; ?><br><br>
    <?php echo $lang->loc['email']; ?><br>
    <input type="text" name="email"  size="50" maxlength="50" value="" /><br> 
    <?php echo $lang->loc['subject']; ?><br>
    <input type="text" name="subject"  size="50" maxlength="50" value="" /><br> 
    <?php echo $lang->loc['message']; ?><br>
    <textarea name="message"  class="imessageform"></textarea>
   </div>

  <br>
  </td>
 </tr>
</table>
   <div style="float:right;">
   <table height="21" border="0" cellpadding="0" cellspacing="0" class="button">
    <tr><td class="button-left-side"></td><td class="middle"><button type="submit" name="submit" class="proceedbutton"><?php echo $lang->loc['send']; ?></button></td><td class="button-right-side-arrow"></td></tr>
   </table>
   </div>

</form>

<?php } ?>
   </div>
   </div>
   <div class="portlet-bottom-process"></div>
  </div>
 </div>
<?php require_once('./templates/iot_footer.php'); ?>