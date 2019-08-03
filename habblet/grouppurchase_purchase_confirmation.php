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
$lang->addLocale("group.purchase.confirm");

$name = $input->HoloText($_POST['name']);
$desc = $input->HoloText($_POST['description']);
?>
<input type="hidden" name="webwork.token.name" value="webwork.token"/>
<input type="hidden" name="webwork.token" value="PHPRetro"/>
<div id="group-logo">
   <img src="<?php echo PATH; ?>/web-gallery/images/groups/group_icon.gif" alt="" width="46" height="46" />
</div>

<p>
<?php echo $lang->loc['group.name']; ?>: <b><?php echo $name; ?></b>.<br><?php echo $lang->loc['price']; ?>: <b>10 <?php echo $lang->loc['coins']; ?></b>.<br> <?php echo $lang->loc['you.have']; ?>: <b><?php echo $input->HoloText($user->user("credits")); ?> <?php echo $lang->loc['coins']; ?></b>.
</p>

<div id="group-confirmation-button-area">	
<div class="new-buttons clearfix">
	<a class="new-button" href="#" onclick="GroupPurchase.close(); return false;"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>	
	<a class="new-button" href="#" onclick="GroupPurchase.purchase(); return false;"><b><?php echo $lang->loc['buy.this']; ?></b><i></i></a>
</div>
</div>