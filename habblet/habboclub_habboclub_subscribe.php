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
$data = new credits_sql;
$lang->addLocale("club.buy");
$lang->addLocale("ajax.buttons");

$option = $input->HoloText($_POST['optionNumber']);
$gender = $input->FilterText($_POST['newGender']);
$figure = $input->FilterText($_POST['figureData']);

switch($option){
	case 1: $price = 20; $months = 1; break;
	case 2: $price = 50; $months = 3; break;
	case 3: $price = 80; $months = 6; break;
}

if($user->user("credits") < $price){
	$msg = $lang->loc['club.subscribe.error.1'];
} else {
	$sql = $data->select2($user->id);
	if($db->num_rows($sql) > 0){
		$months_left = $db->result($sql);
	} else {
		$months_left = 0;
	}
	$months_left = $months_left + $months;
	$data->update1($user->id,($user->user("credits") - $price));
	$user->GiveHC("self", $months);
	if((isset($_POST['newGender']) && isset($_POST['figureData'])) && ($figure != "" && $gender != "")){ $data->update2($figure,$gender,$user->id); }
	$user->refresh();
	$db->query("INSERT INTO ".PREFIX."transactions (userid,amount,time,descr) VALUES ('".$user->id."','-".$price."','".time()."','Club subscription (".$months." month(s))')");
	$db->query("DELETE FROM ".PREFIX."alerts WHERE userid = '".$user->id."' AND type = '-1' AND alert = 'clubalert'");
	@SendMUSData('UPRC' . $user->id);
	$msg = $lang->loc['club.subscribe.success'];
}
?>
<div id="hc_confirm_box">

    <img src="<?php echo PATH; ?>/web-gallery/images/piccolo_happy.gif" alt="" align="left" style="margin:10px;" />
<p><b><?php echo $lang->loc['subscribe']; ?></b></p>
<p><?php echo $msg; ?></p>

<p>
<a href="#" class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;">
<b><?php echo $lang->loc['ok']; ?></b><i></i></a>
</p>

</div>

<div class="clear"></div>