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

if($page['bypass'] != true){
$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;

$owner = $input->FilterText($_POST['ownerId']);
$start = $input->FilterText($_POST['lastEntryId']);
$widget = $input->FilterText($_POST['widgetId']);
}

$widgetrow = $db->fetch_row($db->query("SELECT id,location,ownerid,variable FROM ".PREFIX."homes WHERE ".PREFIX."homes.id = '".$widget."' LIMIT 1"));
$widgetrow[1] = str_replace('-','',$widgetrow[1]);

if($widgetrow[1] == "0" || $widgetrow[1] == "2"){ $type = "user"; $ownerid = $widgetrow[2]; }else{ $type = "group"; $ownerid = $widgetrow[1]; $memberrow = $db->fetch_row($data->select15($user->id,$ownerid)); }

$sql2 = $db->query("SELECT * FROM ".PREFIX."guestbook WHERE ownerid = '".$ownerid."' AND owner = '".$type."' AND id < '".$start."' ORDER BY id DESC LIMIT 20");

while($listrow = $db->fetch_assoc($sql2)){
$posterrow = $db->fetch_row($data->select2($listrow['userid']));
?>

	<li id="guestbook-entry-<?php echo $listrow['id']; ?>" class="guestbook-entry">
		<div class="guestbook-author">
			<img src="<?php echo $user->avatarURL($posterrow[4],"s,4,4,,1,0"); ?>" alt="<?php echo $input->HoloText($posterrow[1]); ?>" title="<?php echo $input->HoloText($posterrow[1]); ?>"/>
		</div>
			<div class="guestbook-actions">
			<?php if(($type == "user" && $ownerid == $user->id) || ($type == "group" && $memberrow[2] > 1) || ($posterrow[0] == $user->id)){ ?>
					<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/delete_entry_button.gif" id="gbentry-delete-<?php echo $listrow['id']; ?>" class="gbentry-delete" style="cursor:pointer" alt=""/>
					<br/>
			<?php }else{ ?>
					<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif" id="gbentry-report-<?php echo $listrow['id']; ?>" class="gbentry-report" style="cursor:pointer" alt=""/>
			<?php } ?>
			</div>
		<div class="guestbook-message">
		<?php $online = $user->IsUserOnline($posterrow[0]); if($online == true){ $online = "online"; }else{ $online = "offline"; } ?>
			<div class="<?php echo $online; ?>">
				<a href="<?php echo PATH; ?>/home/<?php echo $input->HoloText($posterrow[1]); ?>"><?php echo $input->HoloText($posterrow[1]); ?></a>
			</div>
			<p><?php echo $input->bbcode_format($input->HoloText($listrow['message'])); ?></p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
		<div class="guestbook-entry-footer metadata"><?php echo date('M j, Y g:i:s A',$listrow['time']); ?></div>
	</li>
	
<?php } ?>