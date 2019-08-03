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
$data = new home_sql;
$lang->addLocale("avatarinfo");

$ownerid = $_POST['ownerAccountId'];
$id = $input->FilterText($_POST['anAccountId']);

$row = $db->fetch_row($data->select2($id));
$badge = $db->fetch_row($data->select9($row[0]));
if($user->IsUserOnline($row[0]) == true){ $online = "online_anim"; }else{ $online = "offline"; }
?>
<div class="avatar-list-info-container">
	<div class="avatar-info-basic clearfix">
		<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close" id="avatar-list-info-close-<?php echo $row[0]; ?>"></a></div>
		<div class="avatar-info-image">
			<?php if($badge[0] != "" && $row[6] != "0"){ ?><img src="<?php echo $settings->find("site_c_images_path").$settings->find("site_badges_path").$badge[0].".gif"; ?>"><?php } ?>
			<img src="<?php echo $user->avatarURL($row[4],"b,4,4,,1,0"); ?>" alt="<?php echo $input->HoloText($row[1]); ?>" />
		</div>
<h4><a href="<?php echo PATH; ?>/home/<?php echo $input->HoloText($row[1]); ?>"><?php echo $input->HoloText($row[1]); ?></a></h4>
<p>
<a href="<?php echo PATH; ?>/client" target="client" onclick="HabboClient.openOrFocus(this); return false;"><img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/profile/habbo_<?php echo $online; ?>.gif" /></a>
</p>
<p><?php echo $lang->loc['created.on']; ?>: <b><?php echo $input->HoloText($row[3]); ?></b></p>
<p><a href="<?php echo PATH; ?>/home/<?php echo $input->HoloText($row[1]); ?>" class="arrow"><?php echo $lang->loc['view.habbos.page']; ?></a></p>
	</div>
</div>