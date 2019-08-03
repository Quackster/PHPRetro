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
$data = new home_sql;

$ownerid = $input->HoloText($_POST['ownerId']);
$message = $input->FilterText($_POST['message']);
$scope = $input->HoloText($_POST['scope']);
$query = $input->HoloText($_POST['query']);
$widgetid = $input->HoloText($_POST['widgetId']);

if(!is_numeric($widgetid)){ exit; }

$widgetrow = $db->fetch_row($db->query("SELECT id,location,ownerid,variable FROM ".PREFIX."homes WHERE ".PREFIX."homes.id = '".$widgetid."' LIMIT 1"));
$widgetrow[1] = str_replace('-','',$widgetrow[1]);

if($widgetrow[1] == "0" || $widgetrow[1] == "2"){ $type = "user"; $ownerid = $widgetrow[2]; }else{ $type = "group"; $ownerid = $widgetrow[1]; }

if($type == "user"){
	$isfriend = $data->select4($user->id,$ownerid);
	if($db->num_rows($isfriend) > 0){ $isfriend = true; }else{ $isfriend = false; }
	if($ownerid == $user->id){ $isfriend = true; }
	if($user->id == 0){ exit; }
	if($widgetrow[3] != "private" || ($widgetrow[3] == "private" && $isfriend == true)){
		$db->query("INSERT INTO ".PREFIX."guestbook (message,time,userid,ownerid,owner) VALUES ('".$message."','".time()."','".$user->id."','".$ownerid."','user')");
	}else{ exit; }
}else{
	$memberrow = $db->fetch_row($data->select15($user->id,$ownerid));
	if($memberrow[2] != ""){ $ismember = true; }else{ $ismember = false; }
	if($widgetrow[3] != "private" || ($widgetrow[3] == "private" && $ismember == true)){
		$db->query("INSERT INTO ".PREFIX."guestbook (message,time,userid,ownerid,owner) VALUES ('".$message."','".time()."','".$user->id."','".$ownerid."','group')");
	}else{ exit; }
}

$row = $db->fetch_assoc($db->query("SELECT * FROM ".PREFIX."guestbook WHERE ownerid = '".$ownerid."' AND owner = '".$type."' AND userid = '".$user->id."' ORDER BY id DESC LIMIT 1"));
?>
	<li id="guestbook-entry-<?php echo $row['id']; ?>" class="guestbook-entry">
		<div class="guestbook-author">
			<img src="<?php echo $user->avatarURL("self","s,4,4,,1,0"); ?>" alt="<?php echo $input->HoloText($user->name); ?>" title="<?php echo $input->HoloText($user->name); ?>"/>
		</div>
			<div class="guestbook-actions">
					<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/delete_entry_button.gif" id="gbentry-delete-<?php echo $row['id']; ?>" class="gbentry-delete" style="cursor:pointer" alt=""/>
					<br/>
			</div>
		<div class="guestbook-message">
		<?php $online = $user->IsUserOnline("self"); if($online == true){ $online = "online"; }else{ $online = "offline"; } ?>
			<div class="<?php echo $online; ?>">
				<a href="<?php echo PATH; ?>/home/<?php echo $input->HoloText($user->name); ?>"><?php echo $input->HoloText($user->name); ?></a>
			</div>
			<p><?php echo $input->bbcode_format($input->HoloText($row['message'])); ?></p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
		<div class="guestbook-entry-footer metadata"><?php echo date('M j, Y g:i:s A',$row['time']); ?></div>
	</li>