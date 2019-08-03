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
$lang->addLocale("club.confirm");
$lang->addLocale("ajax.buttons");

$option = $input->HoloText($_POST['optionNumber']);
$gender = $_POST['newGender'];
$figure = $_POST['figureData'];

switch($option){
	case 1: $price = 20; $months = 1; break;
	case 2: $price = 50; $months = 3; break;
	case 3: $price = 80; $months = 6; break;
}
?>
<div id="hc_confirm_box">

    <img src="<?php echo PATH; ?>/web-gallery/images/piccolo_happy.gif" alt="" align="left" style="margin:10px;" />
<p><b><?php echo $lang->loc['confirmation']; ?></b></p>
<p><?php echo $months; ?> <?php echo $lang->loc['club.month']; ?> (<?php echo ($months * 31)." ".$lang->loc['days']; ?>) <?php echo $lang->loc['costs']." ".$price." ".$lang->loc['coins']; ?>. <?php echo $lang->loc['you.have']; ?>: <?php echo $user->user("credits")." ".$lang->loc['coins']; ?>.</p>

<p>
<a href="#" class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;">
<b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
<a href="#" ondblclick="habboclub.showSubscriptionResultWindow(<?php echo $option; ?>,'<?php echo $lang->loc['CLUB']; ?>'); return false;" onclick="habboclub.showSubscriptionResultWindow(<?php echo $option; ?>,'<?php echo $lang->loc['CLUB']; ?>'); return false;" class="new-button">
<b><?php echo $lang->loc['ok']; ?></b><i></i></a>
</p>

</div>

<div class="clear"></div>