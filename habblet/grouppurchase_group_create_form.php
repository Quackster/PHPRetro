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

if($user->user("credits") < 10){
?>
<p id="purchase-result-error"><?php echo $lang->loc['buy.group.failed']; ?></p>
    <div id="purchase-group-errors">
        <p>
            <?php echo $lang->loc['not.enough.credits']; ?><br />
        </p>
    </div>

<p>
<a href="#" class="new-button" onclick="GroupPurchase.close(); return false;"><b><?php echo $lang->loc['done']; ?></b><i></i></a>
</p>

<div class="clear"></div>
<?php
}else{
?>
<div id="group-purchase-header">
   <img src="<?php echo PATH; ?>/web-gallery/images/groups/group_icon.gif" alt="" width="46" height="46" />
</div>

<p>
<?php echo $lang->loc['price']; ?>: <b>10 <?php echo $lang->loc['coins']; ?></b>.<br> <?php echo $lang->loc['you.have']; ?>: <b><?php echo $input->HoloText($user->user("credits")); ?> <?php echo $lang->loc['coins']; ?></b>.
</p>

<form action="#" method="post" id="purchase-group-form-id">

<div id="group-name-area">
    <div id="group_name_message_error" class="error"></div>
    <label for="group_name" id="group_name_text"><?php echo $lang->loc['group.name']; ?>:</label>
    <input type="text" name="group_name" id="group_name" maxlength="30" onKeyUp="GroupUtils.validateGroupElements('group_name', 30, '<?php echo $lang->loc['max.group.name']; ?>');" value=""/><br />
</div>

<div id="group-description-area">
    <div id="group_description_message_error" class="error"></div>
    <label for="group_description" id="description_text"><?php echo $lang->loc['group.description']; ?>:</label>
    <span id="description_chars_left"><label for="characters_left"><?php echo $lang->loc['characters.left']; ?>:</label>
    <input id="group_description-counter" type="text" value="255" size="3" readonly="readonly" class="amount" /></span><br/>
    <textarea name="group_description" id="group_description" onKeyUp="GroupUtils.validateGroupElements('group_description', 255, '<?php echo $lang->loc['max.group.desc']; ?>');"></textarea>
</div>
</form>

<div class="new-buttons clearfix">
	<a class="new-button" id="group-purchase-cancel-button" href="#" onclick='GroupPurchase.close(); return false;'><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>	
	<a class="new-button" href="#" onclick="GroupPurchase.confirm(); return false;"><b><?php echo $lang->loc['buy.group']; ?></b><i></i></a>
</div>
<?php } ?>