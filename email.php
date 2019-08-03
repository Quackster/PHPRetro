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
$data = new register_sql;
$lang->addLocale("landing.email");

$page['name'] = $lang->loc['pagename.email.verify'];
$page['bodyid'] = "";

session_start();

require_once('./templates/login_header.php');

if(isset($_GET['key'])){
	$key = $input->FilterText($_GET['key']);
	$sql = $db->query("SELECT * FROM ".PREFIX."verify WHERE key_hash = '".$key."' LIMIT 1");
	if($db->num_rows($sql) > 0){
		$row = $db->fetch_assoc($sql);
		$email_verify_status = $serverdb->result($serverdb->query("SELECT email_verified FROM ".PREFIX."users WHERE id = '".$row['id']."' LIMIT 1"));
		if($email_verify_status == "1"){ $reward = false; }else{ $reward = true; }
		$serverdb->query("UPDATE ".PREFIX."users SET email = '".$row['email']."' WHERE id = '".$row['id']."' LIMIT 1");
		$serverdb->query("UPDATE ".PREFIX."users SET email_verified = '1' WHERE id = '".$row['id']."' LIMIT 1");
		if($reward == true){ $data->update1($row['id'],$settings->find("email_verify_reward")); $db->query("INSERT INTO ".PREFIX."transactions (userid,time,amount,descr) VALUES ('".$row['id']."','".time()."','".$settings->find("email_verify_reward")."','Verifying your email address')"); @$user->refresh(); @SendMUSData('UPRC' . $user->id); }
		$db->query("DELETE FROM ".PREFIX."verify WHERE key_hash = '".$key."' LIMIT 1");
		$sucess = "1";
	}else{
		$sucess = "0";
	}
}else{
	$sucess = "0";
}
if(isset($_GET['remove'])){
	$key = $input->FilterText($_GET['remove']);
	$sql = $db->query("SELECT * FROM ".PREFIX."verify WHERE key_hash = '".$key."' LIMIT 1");
	if($db->num_rows($sql) > 0){
		$row = $db->fetch_assoc($sql);
		$serverdb->query("UPDATE ".PREFIX."users SET email = '', newsletter = '0' WHERE id = '".$row['id']."' LIMIT 1");
		$serverdb->query("UPDATE ".PREFIX."users SET email_verified = '-1' WHERE id = '".$row['id']."' LIMIT 1");
		$db->query("DELETE FROM ".PREFIX."verify WHERE key_hash = '".$key."' LIMIT 1");
		$sucess = "2";
	}else{
		$sucess = "0";
	}
}
if($sucess == "1"){
?>
			<div id="process-content">
	        	<div id ="email-verified-container">
    <div class="cbb clearfix green">
        <h2 class="title heading"><?php echo $lang->loc['email.verify.success']; ?></h2>
    	<div class="box-content">

            <ul>
	            <li><?php echo $lang->loc['email.verify.success.message']; ?></li>
            </ul>
            <a href="<?php echo PATH; ?>/"><?php echo $lang->loc['continue.verify']; ?></a>
    	</div>
    </div>
</div>
<?php }elseif($sucess == "2"){ ?>
			<div id="process-content">
	        	<div id ="email-verified-container">
    <div class="cbb clearfix green">
        <h2 class="title heading"><?php echo $lang->loc['email.verify.success.message']; ?></h2>
    	<div class="box-content">

            <ul>
	            <li><?php echo $lang->loc['email.verify.removed']; ?></li>
            </ul>
            <a href="<?php echo PATH; ?>/"><?php echo $lang->loc['continue.verify']; ?></a>
    	</div>
    </div>
</div>
<?php }else{ ?>
			<div id="process-content">
	        	<div id ="email-verified-container">
    <div class="cbb clearfix red">
        <h2 class="title heading"><?php echo $lang->loc['email.verify.error']; ?></h2>

    	<div class="box-content">
            <ul>
	            <li><?php echo $lang->loc['email.verify.error.message']; ?></li>
            </ul>
            <a href="<?php echo PATH; ?>/"><?php echo $lang->loc['continue.verify']; ?></a>
    	</div>
    </div>
</div>
<?php }
require_once('./templates/login_footer.php');
?>