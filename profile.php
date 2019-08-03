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
require_once('./includes/session.php');
$data = new profile_sql;
$lang->addLocale("home.profile");

$page['id'] = "profile";
$page['name'] = $lang->loc['pagename.profile'];
$page['bodyid'] = "profile";
$page['cat'] = "home";

if(isset($_GET['tab'])){
	if($_GET['tab'] < 1 || $_GET['tab'] > 5 ){
		header("Location: ".PATH."/profile?tab=1"); exit;
	}else{
		$tab = $_GET['tab'];
	}
}elseif(isset($_POST['tab'])){
	if($_POST['tab'] < 1 || $_POST['tab'] > 5 ){
		header("Location: ".PATH."/profile?tab=1"); exit;
	}else{
		$tab = $_POST['tab'];
	}
}else{
	$tab = "1";
}

switch($tab){
case "1":
	$lang->addLocale("profile.tab1");
	if(isset($_POST['figureData'])){
		$new_figure = $input->FilterText($_POST['figureData']);
		$new_gender = $input->FilterText($_POST['newGender']);
		if($new_gender !== "M" && $new_gender !== "F"){
			$result = $lang->loc['error.general'];
			$error = "1";
		} else {
			$check = new HoloFigureCheck($new_figure,$new_gender,$user->IsHCMember("self"));
			if($check->error > 0){
				$result = $lang->loc['error.general'];
				$error = "1";
			} else {
				$data->update1($new_figure,$new_gender,$user->id);
				$user->refresh();
				$result = $lang->loc['success.profile'];
				$mylook1 = $input->FilterText($_POST['figureData']);
				$mysex1 = $input->FilterText($_POST['newGender']);
				@SendMUSData('UPRA' . $user->id);
			}
		}
	} else {
		$mylook1 = $user->user("figure");
		$mysex1 = $user->user("sex");
	}

	$slot1 = $db->query("SELECT figure,gender FROM ".PREFIX."wardrobe WHERE slotid = '1' AND userid = '".$user->id."' LIMIT 1");
	$slot1 = $db->fetch_assoc($slot1);
	if(!empty($slot1['figure'])){ $slot1_url = $user->avatarURL($slot1['figure'],"s,4,4,sml,1,0"); }
	$slot2 = $db->query("SELECT figure,gender FROM ".PREFIX."wardrobe WHERE slotid = '2' AND userid = '".$user->id."' LIMIT 1");
	$slot2 = $db->fetch_assoc($slot2);
	if(!empty($slot2['figure'])){ $slot2_url = $user->avatarURL($slot2['figure'],"s,4,4,sml,1,0"); }
	$slot3 = $db->query("SELECT figure,gender FROM ".PREFIX."wardrobe WHERE slotid = '3' AND userid = '".$user->id."' LIMIT 1");
	$slot3 = $db->fetch_assoc($slot3);
	if(!empty($slot3['figure'])){ $slot3_url = $user->avatarURL($slot3['figure'],"s,4,4,sml,1,0"); }
	$slot4 = $db->query("SELECT figure,gender FROM ".PREFIX."wardrobe WHERE slotid = '4' AND userid = '".$user->id."' LIMIT 1");
	$slot4 = $db->fetch_assoc($slot4);
	if(!empty($slot4['figure'])){ $slot4_url = $user->avatarURL($slot4['figure'],"s,4,4,sml,1,0"); }
	$slot5 = $db->query("SELECT figure,gender FROM ".PREFIX."wardrobe WHERE slotid = '5' AND userid = '".$user->id."' LIMIT 1");
	$slot5 = $db->fetch_assoc($slot5);
	if(!empty($slot5['figure'])){ $slot5_url = $user->avatarURL($slot5['figure'],"s,4,4,sml,1,0"); }

break;
case "2":
	$lang->addLocale("profile.tab2");
	if(isset($_POST['motto'])){
		if(strlen($_POST['motto']) > 32){
			$result = $lang->loc['motto.too.long'];
			$error = "1";
			$motto = $_POST['motto'];
		} else {
			$motto = $input->FilterText($_POST['motto']);
			$data->update2($motto,$user->id);
			$user->refresh();
			$result = $lang->loc['success.profile'];
			$motto = $_POST['motto'];
			@SendMUSData('UPRA' . $user->id);
		}
		if($_POST['visibility'] == "EVERYONE"){ $visibility = 1; }else{ $visibility = 0; }
		if($_POST['emailMiniMailAlertEnabled'] == "true"){ $minimail_alert = 1; }else{ $minimail_alert = 0; }
		if($_POST['emailFriendRequestAlertEnabled'] == "true"){ $request_alert = 1; }else{ $request_alert = 0; }
		if($_POST['showOnlineStatus'] == "true"){ $showstatus = 1; }else{ $showstatus = 0; }
		$serverdb->query("UPDATE ".PREFIX."users SET show_home = '".$visibility."', show_online = '".$showstatus."', email_minimail = '".$minimail_alert."', email_friendrequest = '".$request_alert."' WHERE id = '".$user->id."' LIMIT 1");
	}else{
		$motto = $input->HoloText($user->user("mission"));
		$visibility = $user->user("show_home");
		$minimail_alert = $user->user("email_minimail");
		$request_alert = $user->user("email_friendrequest");
		$showstatus = $user->user("show_online");
	}
break;
case "3":
	$lang->addLocale("profile.tab3");
	if(isset($_POST['email'])){
		if(($_SESSION['register-captcha-bubble'] == $_POST['captcha'] && !empty($_SESSION['register-captcha-bubble'])) || $settings->find("site_capcha") == "0"){
			unset($_SESSION['register-captcha-bubble']);
			$pass1 = $_POST['password'];
			$pass1_hash = $input->HoloHash($pass1, $user->name);
			$day1 = $_POST['day'];
			$month1 = $_POST['month'];
			$year1 = $_POST['year'];
			$formatted_dob = "".$day1."-".$month1."-".$year1."";
			$mail1 = $input->FilterText($_POST['email']);
			if($_POST['directemail'] == "on"){ $newsletter = "checked=\"checked\""; }else{ $newsletter = ""; }
			if($pass1_hash == $user->user("password") && $formatted_dob == $user->user("birth")){
				$email_check = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $mail1);
				if($email_check == "1"){
					if($_POST['directemail'] == "on"){ $newsletter = "1"; }else{ $newsletter = "0"; }
					$serverdb->query("UPDATE ".PREFIX."users SET newsletter = '".$newsletter."', email = '".$mail1."', email_verified = '-1' WHERE id = '".$user->id."' LIMIT 1");
					$sendemail = true;
					$result = $lang->loc['email.changed']." ".$mail1;
				} else {
					$result = $lang->loc['invalid.email'];
					$error = "1";
				}
			} else {
				$result = $lang->loc['record.not.match'];
				$error = "1";
			}
		}else{
			$result = $lang->loc['invalid.captcha'];
			$error = "1";
		}
	}elseif(isset($_POST['resendconfirmation'])){
		$mail1 = $user->user("email");
		$sendemail = true;
		$result = $lang->loc['email.verify.sent'];
	}else{
		$mail1 = $user->user("email");
		if($user->user("newsletter") == "1"){ $email_settings['newsletter'] = "checked=\"checked\""; }else{ $email_settings['newsletter'] = ""; }
	}
	if($settings->find("email_verify_enabled") == 1 && $sendemail == true){
	$hash = "";
	$length = 8;
	$possible = "0123456789qwertyuiopasdfghjkzxcvbnm";
	$i = 0;
	while ($i < $length) {
	$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	if (!strstr($hash, $char)) {
	  $hash .= $char;
	  $i++;
	}
	}
	$hash = sha1($hash);
	$num = $key;
	$sql = $db->query("SELECT * FROM ".PREFIX."verify WHERE id = '".$user->id."' LIMIT 1");
	if($db->num_rows($sql) > 0){
		$sql1 = "UPDATE ".PREFIX."verify SET key_hash = '".$hash."', email = '".$mail1."' WHERE id = '".$user->id."' LIMIT 1";
	}else{
		$sql1 = "INSERT INTO ".PREFIX."verify (id,email,key_hash) VALUES ('".$user->id."','".$mail1."','".$hash."')";
	}
	$db->query($sql1);

	$lang->addLocale("email.confirmationemail");
	$subject = $lang->loc['email.subject']." ".SHORTNAME;
	$to = $mail1;
	$html = 
	'<h1 style="font-size: 16px">'.$lang->loc['email.verify.1'].'</h1>

	<p>
	'.$lang->loc['email.verify.2'].' <a href="'.PATH.'/email?key='.$hash.'">'.$lang->loc['email.verify.2.b'].'</a>
	</p>

	<p>
	'.$lang->loc['email.verify.3'].'
	</p>

	<blockquote>
	<p>
	<b>'.$lang->loc['email.verify.4'].'</b> '.$user->name.'<br>
	<b>'.$lang->loc['email.verify.5'].'</b> '.$user->user("birth").'
	</p>
	</blockquote>

	<p>
	'.$lang->loc['email.verify.6'].'
	</p>

	<p>'.$lang->loc['email.verify.7'] .'<br><br>
	'.$lang->loc['email.verify.8'].'<p>
	'.PATH.'/</p>

	<p>
	'.$lang->loc['email.verify.9'].' <a href="'.PATH.'/email?remove='.$hash.'">'.$lang->loc['email.verify.9.b'].'</a>.
	</p>

	<p>
	'.$lang->loc['email.verify.11'].'<a href="'.PATH.'/help">'.$lang->loc['email.verify.12'].'</a>.
	</p>';
	$mailer = new HoloMail;
	$mailer->sendSimpleMessage($to,$subject,$html);
	}else{
		$serverdb->query("UPDATE ".PREFIX."users SET email_verified = '1' WHERE id = '".$row[0]."' LIMIT 1");
	}
break;
case "4":
	$lang->addLocale("profile.tab4");
	if(isset($_POST['currentpassword'])){
		if(($_SESSION['register-captcha-bubble'] == $_POST['captcha'] && !empty($_SESSION['register-captcha-bubble'])) || $settings->find("site_capcha") == "0"){
			unset($_SESSION['register-captcha-bubble']);
			$pass1 = $_POST['currentpassword'];
			$pass1_hash = $input->HoloHash($pass1, $user->name);
			$day1 = $_POST['day'];
			$month1 = $_POST['month'];
			$year1 = $_POST['year'];
			$formatted_dob = "".$day1."-".$month1."-".$year1."";
			$newpass = $_POST['newpassword'];
			$newpass_hash = $input->HoloHash($newpass, $user->name);
			$newpass_conf = $_POST['newpasswordconfirm'];
			if($pass1_hash == $user->user("password") && $formatted_dob == $user->user("birth")){
				if($newpass == $newpass_conf){
					if(strlen($newpass) < 6){
					$result = $lang->loc['error.password.1'];
					$error = "1";
					} else {
						if(strlen($newpass) > 25){
							$result = $lang->loc['error.password.2'];
							$error = "1";
						} else {
							$data->update4($newpass_hash,$user->id);
							$user->refresh();
							$result = $lang->loc['change.password.success'];
						}
					}
				} else {
					$result = $lang->loc['error.password.3'];
					$error = "1";
				}
			} else {
				$result = $lang->loc['record.not.match'];
				$error = "1";
			}
		}else{
			$result = $lang->loc['invalid.captcha'];
			$error = "1";
		}
	}
}

require_once('./templates/community_header.php');

?>

<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div>
<div class="content">
<div class="habblet-container" style="float:left; width:210px;">
<div class="cbb settings">

<h2 class="title"><?php echo $lang->loc['account.settions']; ?></h2>
<div class="box-content">
            <div id="settingsNavigation">
            <ul>
		<?php
		if($tab == "1"){
                echo "<li class=\"selected\">".$lang->loc['my.clothing']."
                </li>";
		} else {
                echo "<li><a href=\"".PATH."/profile?tab=1\">".$lang->loc['my.clothing']."</a>
                </li>";
		}
		if($tab == "2"){
                echo "<li class=\"selected\">".$lang->loc['my.preferences']."
                </li>";
		} else {
                echo "<li><a href=\"".PATH."/profile?tab=2\">".$lang->loc['my.preferences']."</a>
                </li>";
		}
		if($tab == "3"){
                echo "<li class=\"selected\">".$lang->loc['my.email']."
                </li>";
		} else {
                echo "<li><a href=\"".PATH."/profile?tab=3\">".$lang->loc['my.email']."</a>
                </li>";
		}
		if($tab == "4"){
                echo "<li class=\"selected\">".$lang->loc['my.password']."
                </li>";
		} else {
                echo "<li><a href=\"".PATH."/profile?tab=4\">".$lang->loc['my.password']."</a>
                </li>";
		}
		if($tab == "5"){
                echo "<li class=\"selected\">".$lang->loc['friend.management']."
                </li>";
		} else {
                echo "<li><a href=\"".PATH."/profile?tab=5\">".$lang->loc['friend.management']."</a>
                </li>";
		}
		?>
            </ul>
            </div>
</div></div>
<?php if(!$user->IsHCMember("self") ){ ?>
    <div class="cbb habboclub-tryout">
        <h2 class="title"><?php echo $lang->loc['join.habbo.club']; ?></h2>
        <div class="box-content">
            <div class="habboclub-banner-container habboclub-clothes-banner"></div>
            <p class="habboclub-header"><?php echo $lang->loc['habbo.club.desc']; ?></p>

            <p class="habboclub-link"><a href="<?php echo PATH; ?>/club"><?php echo $lang->loc['check.out']; ?> &gt;&gt;</a></p>
        </div>
    </div>
<?php } ?>
</div>

<?php switch($tab){
case "1": ?>
<div class="habblet-container" style="float:left; width: 560px;">
<div class="cbb clearfix settings">

<h2 class="title"><?php echo $lang->loc['change.looks']; ?></h2>
<div class="box-content">

<?php
if(!empty($result)){
	if($error == "1"){
	echo "<div class=\"rounded rounded-red\">";
	} else {
	echo "<div class=\"rounded rounded-green\">";
	}
	echo "".$result."<br />
	</div><br />";
}
?>
	<div>&nbsp;</div>

<div id="settings-editor">
<?php echo $lang->loc['no.flash']; ?>: <a target="_blank" href="http://www.adobe.com/go/getflashplayer">http://www.adobe.com/go/getflashplayer</a>
</div>

<?php if($user->IsHCMember("self")){ ?><div id="settings-wardrobe" style="display: none">
<ol id="wardrobe-slots">
	<li>
		<p id="wardrobe-slot-1" style="background-image: url(<?php echo $slot1_url; ?>)">
	   		<span id="wardrobe-store-1" class="wardrobe-store"></span>
	   		<span id="wardrobe-dress-1" class="wardrobe-dress"></span>
   		</p>
    </li>
	<li>
		<p id="wardrobe-slot-2" style="background-image: url(<?php echo $slot2_url; ?>)">
	   		<span id="wardrobe-store-2" class="wardrobe-store"></span>
	   		<span id="wardrobe-dress-2" class="wardrobe-dress"></span>
   		</p>
    </li>
	<li>
		<p id="wardrobe-slot-3" style="background-image: url(<?php echo $slot3_url; ?>)">
	   		<span id="wardrobe-store-3" class="wardrobe-store"></span>
	   		<span id="wardrobe-dress-3" class="wardrobe-dress"></span>
   		</p>
    </li>
	<li>
		<p id="wardrobe-slot-4" style="background-image: url(<?php echo $slot4_url; ?>)">
	   		<span id="wardrobe-store-4" class="wardrobe-store"></span>
	   		<span id="wardrobe-dress-4" class="wardrobe-dress"></span>
   		</p>
    </li>
	<li>
		<p id="wardrobe-slot-5" style="background-image: url(<?php echo $slot5_url; ?>)">
	   		<span id="wardrobe-store-5" class="wardrobe-store"></span>
	   		<span id="wardrobe-dress-5" class="wardrobe-dress"></span>
   		</p>
    </li>
</ol>

<script type="text/javascript">
<?php if(!empty($slot1['figure'])){ ?>
Wardrobe.add(1, "<?php echo $slot1['figure']; ?>", "<?php echo $slot1['gender']; ?>", true);
$("wardrobe-dress-" + 1).show();
<?php } ?>
<?php if(!empty($slot2['figure'])){ ?>
Wardrobe.add(2, "<?php echo $slot2['figure']; ?>", "<?php echo $slot2['gender']; ?>", true);
$("wardrobe-dress-" + 2).show();
<?php } ?>
<?php if(!empty($slot3['figure'])){ ?>
Wardrobe.add(3, "<?php echo $slot3['figure']; ?>", "<?php echo $slot3['gender']; ?>", true);
$("wardrobe-dress-" + 3).show();
<?php } ?>
<?php if(!empty($slot4['figure'])){ ?>
Wardrobe.add(4, "<?php echo $slot4['figure']; ?>", "<?php echo $slot4['gender']; ?>", true);
$("wardrobe-dress-" + 4).show();
<?php } ?>
<?php if(!empty($slot5['figure'])){ ?>
Wardrobe.add(5, "<?php echo $slot5['figure']; ?>", "<?php echo $slot5['gender']; ?>", true);
$("wardrobe-dress-" + 5).show();
<?php } ?>
L10N.put("profile.figure.wardrobe_replace.title", "<?php echo $lang->loc['replace?']; ?>");
L10N.put("profile.figure.wardrobe_replace.dialog", "<p\>\n<?php echo $lang->loc['replace.old.wardrobe'] ?>\n</p\>\n\n<p\>\n<a href=\"#\" class=\"new-button\" id=\"wardrobe-replace-cancel\"\><b\><?php echo $lang->loc['cancel']; ?></b\><i\></i\></a\>\n<a href=\"#\" class=\"new-button\" id=\"wardrobe-replace-ok\"\><b\><?php echo $lang->loc['ok']; ?></b\><i\></i\></a\>\n</p\>\n\n<div class=\"clear\"\></div\>\n");
L10N.put("profile.figure.wardrobe_invalid_data", "<?php echo $lang->loc['cannot.save.wardrobe']; ?>");
L10N.put("profile.figure.wardrobe_instructions", "<?php echo $lang->loc['wardrobe.error']; ?>");
Wardrobe.init();
</script>
</div><?php } ?>

<div id="settings-hc" style="display: none">
	<div class="rounded rounded-hcred clearfix">
<a href="<?php echo PATH; ?>/club" id="settings-hc-logo"></a>
<?php echo $lang->loc['marked.with.hc.symbol'][0]; ?> <img src="<?php echo PATH; ?>/web-gallery/v2/images/habboclub/hc_mini.png" /> <?php echo $lang->loc['marked.with.hc.symbol'][1]; ?> <a href="<?php echo PATH; ?>/club"><?php echo $lang->loc['join.now']; ?></a>
	</div>
</div>

<div id="settings-oldfigure" style="display: none">
	<div class="rounded rounded-lightbrown clearfix">
<?php echo $lang->loc['things.not.selectable.anymore']; ?>
	</div>
</div>

<form method="post" action="<?php echo PATH; ?>/profile/characterupdate" id="settings-form" style="display: none">
<input type="hidden" name="tab" value="1" />
<input type="hidden" name="__app_key" value="PHPRetro" />
<input type="hidden" name="figureData" id="settings-figure" value="<?php echo $mylook1; ?>" />
<input type="hidden" name="newGender" id="settings-gender" value="<?php echo $mysex1; ?>" />
<input type="hidden" name="editorState" id="settings-state" value="" />
<a href="#" id="settings-submit" class="new-button disabled-button"><b><?php echo $lang->loc['save.changes']; ?></b><i></i></a>

<script type="text/javascript" language="JavaScript">
var swfobj = new SWFObject("<?php echo PATH; ?>/flash/HabboRegistration.swf", "habboreg", "435", "400", "8");
swfobj.addParam("base", "<?php echo PATH; ?>/flash/");
swfobj.addParam("wmode", "opaque");
swfobj.addParam("AllowScriptAccess", "always");
swfobj.addVariable("figuredata_url", "<?php echo PATH; ?>/xml/figuredata.xml");
swfobj.addVariable("draworder_url", "<?php echo PATH; ?>/xml/draworder.xml");
swfobj.addVariable("localization_url", "<?php echo PATH; ?>/xml/figure_editor.xml");
swfobj.addVariable("figure", "<?php echo $mylook1; ?>");
swfobj.addVariable("gender", "<?php echo $mysex1; ?>");

swfobj.addVariable("showClubSelections", "1");
<?php if( $user->IsHCMember("self") ){ ?>swfobj.addVariable("userHasClub", "1");<?php } ?>

if (deconcept.SWFObjectUtil.getPlayerVersion()["major"] >= 8) {
	<?php if( !$user->IsHCMember("self")){ ?>$("settings-editor").setStyle({ textAlign: "center"});<?php } ?>
	swfobj.write("settings-editor");
	$("settings-form").show();
	<?php if( $user->IsHCMember("self")){ ?>$("settings-wardrobe").show();<?php } ?>
}
</script>

</form>

</div>

</div>
</div>
</div>
</div>
<?php break;
case "2": ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title"><?php echo $lang->loc['change.profile']; ?></h2>
            <div class="box-content">

            


<form action="<?php echo PATH; ?>/profile/profileupdate" method="post" id="profileForm">
<input type="hidden" name="tab" value="2" />
<input type="hidden" name="__app_key" value="HoloCMS" />

<?php
if(!empty($result)){
	if($error == "1"){
	echo "<div class=\"rounded rounded-red\">";
	} else {
	echo "<div class=\"rounded rounded-green\">";
	}
	echo $result . "<br />
	</div><br />";
}
?>

<h3><?php echo $lang->loc['your.motto']; ?></h3>

<p>
<?php echo $lang->loc['motto.description']; ?>
</p>

<p>
<span class="label"><?php echo $lang->loc['motto']; ?>:</span>
<input type="text" name="motto" size="32" maxlength="32" value="<?php echo $input->HoloText($motto); ?>" id="avatarmotto" />
</p>

<h3><?php echo $lang->loc['your.page']; ?></h3>

<p>
<?php echo $lang->loc['who.can.view']; ?>:<br />
<label><input type="radio" name="visibility" value="EVERYONE" <?php if($visibility == 1){ echo "checked=\"checked\""; } ?> /><?php echo $lang->loc['visible.everyone']; ?></label>

<label><input type="radio" name="visibility" value="NOBODY" <?php if($visibility == 0){ echo "checked=\"checked\""; } ?> /><?php echo $lang->loc['visible.noone']; ?></label>
</p>

<h3><?php echo $lang->loc['email.alerts']; ?></h3>

<p>
<label><input type="checkbox" name="emailMiniMailAlertEnabled" value="true" <?php if($minimail_alert == 1){ echo "checked=\"checked\""; } ?> /><?php echo $lang->loc['recieve.alerts.2']; ?></label> <br />
<label><input type="checkbox" name="emailFriendRequestAlertEnabled" value="true" <?php if($request_alert == 1){ echo "checked=\"checked\""; } ?> /><?php echo $lang->loc['recieve.alerts.3']; ?></label>
</p>

<h3><?php echo $lang->loc['online.status']; ?></h3>
<p>
<?php echo $lang->loc['select.who.see.online']; ?>:<br />
<label><input type="radio" name="showOnlineStatus" value="true" <?php if($showstatus == 1){ echo "checked=\"checked\""; } ?> /><?php echo $lang->loc['everybody']; ?></label>
<label><input type="radio" name="showOnlineStatus" value="false" <?php if($showstatus == 0){ echo "checked=\"checked\""; } ?> /><?php echo $lang->loc['nobody']; ?></label>
</p>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" id="profileForm-submit"><b><?php echo $lang->loc['save.changes']; ?></b><i></i></a>
<noscript><input type="submit" value="<?php echo $lang->loc['save.changes']; ?>" name="save" class="submit" /></noscript>
</div>

</form>

<script type="text/javascript">
$("profileForm-submit").observe("click", function(e) { e.stop(); $("profileForm").submit(); });
$("profileForm-submit").show();

</script>

</div>
</div>
</div>
</div>
</div>
<?php break;
case "3": ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title"><?php echo $lang->loc['change.email.settings']; ?></h2>
            <div class="box-content">

<?php
if(!empty($result)){
	if($error == "1"){
	echo "<div class=\"rounded rounded-red\">";
	} else {
	echo "<div class=\"rounded rounded-green\">";
	}
	echo "".$result."<br />
	</div><br />";
}
?>
            


<span id="confirmform-texts">
<form action="<?php echo PATH; ?>/profile/resendconfirmation" method="post" id="confirmform">
<input type="hidden" name="tab" value="3" />
<input type="hidden" name="__app_key" value="PHPRetro" />
<input type="hidden" name="resendconfirmation" value="" />

<h3><?php echo $lang->loc['confirm.email']; ?></h3>

<p class="last">
<?php echo $lang->loc['email.verify.message']; ?>
</p>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" id="confirmform-submit"><b><?php echo $lang->loc['activate.my.email']; ?></b><i></i></a>
<noscript><input type="submit" value="<?php echo $lang->loc['activate.my.email']; ?>" name="save" class="submit" /></noscript>

</div>

</form>

<br/><br/>
<hr/>
</span>    

<form action="<?php echo PATH; ?>/profile/emailupdate" method="post" id="emailform">
<input type="hidden" name="tab" value="3" />
<input type="hidden" name="__app_key" value="PHPRetro" />

<div class="settings-step">

	<h4>1.</h4>
	<div class="settings-step-content">

<h3><?php echo $lang->loc['current.details']; ?></h3>

<p>
 <label for="currentpassword"><?php echo $lang->loc['current.password']; ?></label><br />
 <input type="password" size="32" maxlength="32" name="password" id="currentpassword" class="currentpassword " />
</p>


<div><label for="birthdate"><?php echo $lang->loc['birthday']; ?>:</label></div>
<?php $lang->loc['month'] = explode("|", $lang->loc['month']); ?>
<div id="required-birthday" ><select name="month" id="month" class="dateselector"><option value=""><?php echo $lang->loc['month'][0]; ?></option><option value="1"><?php echo $lang->loc['month'][1]; ?></option><option value="2"><?php echo $lang->loc['month'][2]; ?></option><option value="3"><?php echo $lang->loc['month'][3]; ?></option><option value="4"><?php echo $lang->loc['month'][4]; ?></option><option value="5"><?php echo $lang->loc['month'][5]; ?></option><option value="6"><?php echo $lang->loc['month'][6]; ?></option><option value="7"><?php echo $lang->loc['month'][7]; ?></option><option value="8"><?php echo $lang->loc['month'][8]; ?></option><option value="9"><?php echo $lang->loc['month'][9]; ?></option><option value="10"><?php echo $lang->loc['month'][10]; ?></option><option value="11"><?php echo $lang->loc['month'][11]; ?></option><option value="12"><?php echo $lang->loc['month'][12]; ?></option></select> <select name="day" id="day" class="dateselector"><option value=""><?php echo $lang->loc['day']; ?></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select> <select name="year" id="year" class="dateselector"><option value=""><?php echo $lang->loc['year']; ?></option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option><option value="1900">1900</option></select> </div>

</div>

</div>
<div class="settings-step">

	<h4>2.</h4>
	<div class="settings-step-content">

<h3><?php echo $lang->loc['enter.email']; ?></h3>

<p><?php echo $lang->loc['verify.email.text']; ?></p>

<p>
<label for="email"><?php echo $lang->loc['email.address']; ?>:</label><br />
<input type="text" name="email" id="email" size="32" maxlength="48" value="<?php echo $mail1; ?>" />
</p>

<p>
 <input name="directemail" id="directemail" <?php echo $email_settings['newsletter']; ?> type="checkbox"> <label for="directemail"><?php echo $lang->loc['yes.i.want.spam']; ?></label>
</p>

	</div>
</div>

<?php if($settings->find("site_capcha") == "1"){ ?>
<div class="settings-step">

	<h4>3.</h4>
	<div class="settings-step-content">

<h3>
<label for="bean_captcha" class="registration-text"><?php echo $lang->loc['type.captcha']; ?></label>
</h3>

<div id="captcha-code-error"></div>

<p></p>

<div class="register-label" id="captcha-reload">
    <p>
        <img src="<?php echo PATH; ?>/web-gallery/v2/images/shared_icons/reload_icon.gif" width="15" height="15" alt=""/>
        <a id="captcha-reload-link" href="#"><?php echo $lang->loc['captcha.reload']; ?></a>
    </p>
</div>

<script type="text/javascript">
document.observe("dom:loaded", function() {
    Event.observe($("captcha-reload"), "click", function(e) {Utils.reloadCaptcha()});
});
</script>

<p id="captcha-container">
    <img id="captcha" src="<?php echo PATH; ?>/captcha.jpg?t=<?php echo time(); ?>" alt="" width="200" height="50" />

</p>

<p>
<input type="text" name="captcha" id="captcha-code" value="" class="registration-text required-captcha" />
</p>
    </div>
</div>
<?php } ?>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" id="emailform-submit"><b><?php echo $lang->loc['save.changes']; ?></b><i></i></a>
<noscript><input type="submit" value="<?php echo $lang->loc['save.changes']; ?>" name="save" class="submit" /></noscript>
</div>
<hr/>                               
</form>

<script type="text/javascript">
$("emailform-submit").observe("click", function(e) { e.stop(); $("emailform").submit(); });
$("emailform-submit").show();
</script>
<?php if((int) $user->user("email_verified") < 1 && (int) $settings->find("email_verify_enabled") == 1){ ?>
<script type="text/javascript">
$("confirmform-submit").observe("click", function(e) { e.stop(); $("confirmform").submit(); });
$("confirmform-submit").show();
</script>
<?php }else{ ?>
<script type="text/javascript">
$("confirmform-texts").hide();
</script>                
<?php } ?>
</div></div></div></div>
</div>
<?php break;
case "4": ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title"><?php echo $lang->loc['change.password.settings']; ?></h2>
            <div class="box-content">

<?php
if(!empty($result)){
	if($error == "1"){
	echo "<div class=\"rounded rounded-red\">";
	} else {
	echo "<div class=\"rounded rounded-green\">";
	}
	echo "".$result."<br />
	</div><br />";
}
?>

<p><?php echo $lang->loc['change.password.warning']; ?></p>

<form action="<?php echo PATH; ?>/profile/passwordupdate" method="post" id="pwform">

<input type="hidden" name="tab" value="4" />
<input type="hidden" name="__app_key" value="PHPRetro" />

<div class="settings-step">

	<h4>1.</h4>
	<div class="settings-step-content">

<h3><?php echo $lang->loc['current.details']; ?></h3>

<p>
 <label for="currentpassword"><?php echo $lang->loc['current.password']; ?></label><br />
 <input type="password" size="32" maxlength="32" name="currentpassword" id="currentpassword" class="currentpassword " />
</p>

<div>
<div><label for="birthdate"><?php echo $lang->loc['birthday']; ?>:</label></div>
<?php $lang->loc['month'] = explode("|", $lang->loc['month']); ?>
<div id="required-birthday" ><select name="month" id="month" class="dateselector"><option value=""><?php echo $lang->loc['month'][0]; ?></option><option value="1"><?php echo $lang->loc['month'][1]; ?></option><option value="2"><?php echo $lang->loc['month'][2]; ?></option><option value="3"><?php echo $lang->loc['month'][3]; ?></option><option value="4"><?php echo $lang->loc['month'][4]; ?></option><option value="5"><?php echo $lang->loc['month'][5]; ?></option><option value="6"><?php echo $lang->loc['month'][6]; ?></option><option value="7"><?php echo $lang->loc['month'][7]; ?></option><option value="8"><?php echo $lang->loc['month'][8]; ?></option><option value="9"><?php echo $lang->loc['month'][9]; ?></option><option value="10"><?php echo $lang->loc['month'][10]; ?></option><option value="11"><?php echo $lang->loc['month'][11]; ?></option><option value="12"><?php echo $lang->loc['month'][12]; ?></option></select> <select name="day" id="day" class="dateselector"><option value=""><?php echo $lang->loc['day']; ?></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select> <select name="year" id="year" class="dateselector"><option value=""><?php echo $lang->loc['year']; ?></option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option><option value="1900">1900</option></select> </div>

</div>

	</div>
</div>
<div class="settings-step">

	<h4>2.</h4>
	<div class="settings-step-content">

<h3><?php echo $lang->loc['enter.new.password']; ?></h3>

<p><?php echo $lang->loc['new.password.details']; ?></p>

<p>
 <label for="bean_password"><?php echo $lang->loc['new.password']; ?></label><br /> 
 <input type="password" size="32" maxlength="32" name="newpassword"
    value=""
    id="bean_password" class="required-password required-password2 " />
</p>

<p>
 <label for="bean_retypedPassword"><?php echo $lang->loc['new.password.again']; ?></label><br />
 <input type="password" size="32" maxlength="32" name="newpasswordconfirm"
 value="" 
 id="bean_retypedPassword" class="required-retypedPassword required-retypedPassword2 " />
</p>

	</div>

</div>

<?php if($settings->find("site_capcha") == "1"){ ?>
<div class="settings-step">

	<h4>3.</h4>
	<div class="settings-step-content">

<h3>
<label for="bean_captcha" class="registration-text"><?php echo $lang->loc['type.captcha']; ?></label>
</h3>

<div id="captcha-code-error"></div>

<p></p>

<div class="register-label" id="captcha-reload">
    <p>
        <img src="<?php echo PATH; ?>/web-gallery/v2/images/shared_icons/reload_icon.gif" width="15" height="15" alt=""/>
        <a id="captcha-reload-link" href="#"><?php echo $lang->loc['captcha.reload']; ?></a>
    </p>
</div>

<script type="text/javascript">
document.observe("dom:loaded", function() {
    Event.observe($("captcha-reload"), "click", function(e) {Utils.reloadCaptcha()});
});
</script>

<p id="captcha-container">
    <img id="captcha" src="<?php echo PATH; ?>/captcha.jpg?t=<?php echo time(); ?>" alt="" width="200" height="50" />

</p>

<p>
<input type="text" name="captcha" id="captcha-code" value="" class="registration-text required-captcha" />
</p>
    </div>
</div>
<?php } ?>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" id="pwform-submit"><b><?php echo $lang->loc['change.password.button']; ?></b><i></i></a>
<noscript><input type="submit" value="<?php echo $lang->loc['change.password.button']; ?>" name="save" class="submit" /></noscript>

</div>

</form>

<script type="text/javascript">
$("pwform-submit").observe("click", function(e) { e.stop(); $("pwform").submit(); });
$("pwform-submit").show();
</script>

</div></div></div></div>

</div>
<?php break;
case "5": 
$lang->addLocale("profile.friendmanagement"); ?>
<div id="friend-management" class="habblet-container">
                <div class="cbb clearfix settings">
                    <h2 class="title"><?php echo $lang->loc['friend.management']; ?></h2>
                    <div id="friend-management-container" class="box-content">
                        <div id="category-view" class="clearfix">
                            <div id="search-view">
                                <?php echo $lang->loc['search.friend']; ?>:
				                <div id="friend-search" class="friendlist-search">
					                <input type="text" maxlength="32" id="friend_query" class="friend-search-query" />
					                <a class="friendlist-search new-button search-icon" id="friend-search-button"><b><span></span></b><i></i></a>
					            </div>
                            </div>

<?php /*                            <div id="category-list">
<div id="friends-category-title">
    <?php echo $lang->loc['friend.categories']; ?>
</div>

<div class="category-default category-item selected-category" id="category-item-0"><?php echo $lang->loc['friends']; ?></div>
    <input type="text" maxlength="32" id="category-name" class="create-category" /><div id="add-category-button" class="friendmanagement-small-icons add-category-item add-category"></div>
                            </div>
*/ ?>

                        </div>
<?php
$page['bypass'] = true;
$pagenum = 1;
$pagesize = 30;
$search = "";
require_once('./habblet/friendmanagement_viewcategory.php');
?>
        </div>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
        L10N.put("friendmanagement.tooltip.deletefriends", "<?php echo $lang->loc['confirm.friends.1']; ?>\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a class=\"friends-delete-button\" id=\"delete-friends-button\"\><?php echo $lang->loc['delete']; ?></a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"cancel-delete-friends\"\><?php echo $lang->loc['cancel']; ?></a\>\n</div\>\n\n");
        L10N.put("friendmanagement.tooltip.deletefriend", "<?php echo $lang->loc['confirm.friends.2']; ?>\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a id=\"delete-friend-%friend_id%\"\><?php echo $lang->loc['delete']; ?></a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"remove-friend-can-%friend_id%\"\><?php echo $lang->loc['cancel']; ?></a\>\n</div\>");
        L10N.put("friendmanagement.tooltip.deletecategory", "<?php echo $lang->loc['confirm.friends.3']; ?>\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a class=\"delete-category-button\" id=\"delete-category-%category_id%\"\><?php echo $lang->loc['delete']; ?></a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"cancel-cat-delete-%category_id%\"\><?php echo $lang->loc['cancel']; ?></a\>\n</div\>");
  new FriendManagement({ currentCategoryId: 0, pageListLimit: 30, pageNumber: 1});
</script>

<?php } ?>

<?php

require_once('./templates/community_footer.php');

?>