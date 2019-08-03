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
$lang->addLocale("guestbook.preview");

$ownerid = $input->HoloText($_POST['ownerId']);
$message = $input->bbcode_format($input->HoloText($_POST['message']));
$scope = $input->HoloText($_POST['scope']);
$query = $input->HoloText($_POST['query']);
$widgetid = $input->HoloText($_POST['widgetId']);
?>
<ul class="guestbook-entries">
	<li id="guestbook-entry--1" class="guestbook-entry">
		<div class="guestbook-author">
			<img src="<?php echo $user->avatarURL("self","s,4,4,,1,0"); ?>" alt="<?php echo $user->avatarURL($user->name,"s,4,4,,1,0"); ?>" title="<?php echo $user->avatarURL($user->name,"s,4,4,,1,0"); ?>"/>
		</div>
		<div class="guestbook-message">
		<?php $online = $user->IsUserOnline("self"); if($online == true){ $online = "online"; }else{ $online = "offline"; } ?>
			<div class="<?php echo $online; ?>">
				<a href="<?php echo PATH; ?>/home/<?php echo $user->name; ?>"><?php echo $user->name; ?></a>
			</div>
			<p><?php echo $message; ?></p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
		<div class="guestbook-entry-footer metadata"><?php echo date('M j, Y g:i:s A'); ?></div>
	</li>
</ul>

<div class="guestbook-toolbar clearfix">
<a href="#" class="new-button" id="guestbook-form-continue"><b><?php echo $lang->loc['continue.editing']; ?></b><i></i></a>
<a href="#" class="new-button" id="guestbook-form-post"><b><?php echo $lang->loc['add.entry']; ?></b><i></i></a>	
</div>