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

$lang->addLocale("widget.searchhabbos");

?>

<h3><?php echo $lang->loc['enjoy.more']; ?></h3>

<div class="copytext">

    <p><?php echo $lang->loc['send.this.link']; ?> <?php if($settings->find("register_referral_rewards") != "0"){ ?><?php echo $lang->loc['reward.text']; ?> <?php echo $settings->find("register_referral_rewards"); ?> <?php echo $lang->loc['credits']; ?>.<?php } ?></p>

    <textarea cols="50" rows="2" onclick="this.focus();this.select()" readonly="readonly" style="width:100%"><?php echo PATH; ?>/register?referral=<?php echo $user->id; ?></textarea>

</div>