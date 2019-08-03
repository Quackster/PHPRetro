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
$data = new forgot_sql;
$lang->addLocale("landing.forgot");

$page['name'] = $lang->loc['pagename.forgot.password'];
$page['bodyid'] = "";

session_start();

require_once('./templates/login_header.php');
	$mailer = new HoloMail;
	if(isset($_POST['actionForgot'])){
		$lang->addLocale("forgot.email");
		$forgot_name = $input->FilterText($_POST['forgottenpw-username']);
		$forgot_mail = $input->FilterText($_POST['forgottenpw-email']);
		$sql = $serverdb->query("SELECT id,name,email FROM ".PREFIX."users WHERE name = '".$forgot_name."' AND email = '".$forgot_mail."' AND email_verified = '1'");
		if($serverdb->num_rows($sql) > 0){
		  $password = "";
		  $length = 8;
		  $possible = "0123456789qwertyuiopasdfghjkzxcvbnm";
		  $i = 0;
		  while ($i < $length) {
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			if (!strstr($password, $char)) {
			  $password .= $char;
			  $i++;
			}
		  }
		$row = $db->fetch_row($sql);
		$hashed_pass = $input->HoloHash($password, $row[1]);
		$success = $lang->loc['forgot.mail.send'];
		$data->update1($row[0], $hashed_pass);
		$subject = $lang->loc['forgot.mail.subject'];
		$html = 
		'<h1>'.$lang->loc['forgot.mail.header'].'</h1>
		
		<p>
		'.$lang->loc['hello'].' <b>'.$forgot_name.'</b>'.$lang->loc['your.password'].'<br /><b>'.$password.'</b><br />'.$lang->loc['please.change'].'
		</p>';
		$mailer->sendSimpleMessage($forgot_mail,$subject,$html);
		}else{
			$result = $lang->loc['forgot.error.invalid'];
		}
	}elseif(isset($_POST['actionList'])){
		$lang->addLocale("forgot.email");
		$forgot_mail = $_POST['ownerEmailAddress'];
		if($serverdb->num_rows($serverdb->query("SELECT name FROM ".PREFIX."users WHERE email = '".$forgot_mail."'")) > 0){
			$plain_text = SHORTNAME."\n\n".$lang->loc['list.of.accounts']."\n\n".$lang->loc['hello']." ".$forgot_mail.",\n\n".$lang->loc['forgot.email.all.accounts'].$forgot_mail.":\n";
			$html = 
			$lang->loc['list.of.accounts']."
			
			<p>
			".$lang->loc['hello']." <b>".$forgot_mail."</b></p>
			
			<p>".$lang->loc['forgot.email.all.accounts']." <b>".$forgot_mail."</b>:</p><blockquote>";
					$sql = $serverdb->query("SELECT name FROM ".PREFIX."users WHERE email = '".$forgot_mail."'");
					while($row = $db->fetch_row($sql)){
						$plain_text .= $lang->loc['account'].": ".$row[0]."\n\n";
						$html .= "<p>".$lang->loc['account'].": <b>".$row[0]."</b><br /></p>\n";
					}
					$plain_text .= "\n\n\n* * *\n\n".$lang->loc['forgot.email.footer'];
					$html .= "</blockquote>";
		$subject = $lang->loc['forgot.name.subject'];
		$mailer->sendSimpleMessage($forgot_mail,$subject,$html,$plain_text);
		$success = $lang->loc['forgot.mail.send'];
	}else{
		$result2 = $lang->loc['forgot.error.invalid'];
	}
}

if(!isset($success)){
?>
<style type="text/css">
		div.left-column { float: left; width: 50% }
		div.right-column { float: right; width: 49% }
		label { display: block }
		input { width: 98% }
		input.process-button { width: auto; float: right }
	</style>

			<div id="process-content">
	        	<div class="left-column">
<div class="cbb clearfix">
    <h2 class="title"><?php echo $lang->loc['forgot.pass']; ?></h2>
    <div class="box-content">
	<?php if(!empty($result)){ ?>
	    <div class="rounded rounded-red">
                <?php echo $result; ?> <br />
        </div>
        <div class="clear"></div>
	<?php } ?>

        <p><?php echo $lang->loc['forgot.pass.content']; ?></p>

        <div class="clear"></div>

        <form method="post" action="forgot" id="forgottenpw-form">
            <p>
            <label for="forgottenpw-username"><?php echo $lang->loc['forgot.username']; ?></label>
            <input type="text" name="forgottenpw-username" id="forgottenpw-username" value="" />
            </p>

            <p>
            <label for="forgottenpw-email"><?php echo $lang->loc['forgot.email']; ?></label>
            <input type="text" name="forgottenpw-email" id="forgottenpw-email" value="" />
            </p>

            <p>
            <input type="submit" value="<?php echo $lang->loc['forgot.button']; ?>" name="actionForgot" class="submit process-button" id="forgottenpw-submit" />
            </p>
            <input type="hidden" value="default" name="origin" />
        </form>
    </div>
</div>

</div>


<div class="right-column">

<div class="cbb clearfix">
    <h2 class="title"><?php echo $lang->loc['forgot.name']; ?></h2>
    <div class="box-content">
	<?php if(!empty($result2)){ ?>
	    <div class="rounded rounded-red">
                <?php echo $result2; ?> <br />
        </div>
        <div class="clear"></div>
	<?php } ?>

        <p><?php echo $lang->loc['forgot.name.message']; ?></p>

        <div class="clear"></div>

        <form method="post" action="forgot" id="accountlist-form">
            <p>

            <label for="accountlist-owner-email"><?php echo $lang->loc['forgot.email']; ?></label>
            <input type="text" name="ownerEmailAddress" id="accountlist-owner-email" value="" />
            </p>

            <p>
            <input type="submit" value="<?php echo $lang->loc['forgot.button.get.accounts']; ?>" name="actionList" class="submit process-button" id="accountlist-submit" />
            </p>
            <input type="hidden" value="default" name="origin" />
        </form>

    </div>
</div>

<div class="cbb clearfix">
    <h2 class="title"><?php echo $lang->loc['forgot.false.alarm']; ?></h2>
    <div class="box-content">
        <p><?php echo $lang->loc['forgot.false.alarm.content']; ?></p>
        <p><a href="<?php echo PATH; ?>/"><?php echo $lang->loc['forgot.back']; ?> &raquo;</a></p>
    </div>
</div>

</div>

<?php

}else{
?>
			<div id="process-content">
	        	<div class="cbb clearfix">
    <h2 class="title"><?php echo $lang->loc['forgot.success.header']; ?></h2>
    <div class="box-content">
    <p><?php echo $success; ?></p>
    <p><a href="<?php echo PATH; ?>/">Back to homepage &raquo;</a></p>

    </div>
</div>

<?php
}
require('./templates/login_footer.php');

?>
