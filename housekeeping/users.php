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

$page['dir'] = '\housekeeping';
$page['housekeeping'] = true;
if($_GET['do'] == "savedetails" || $_GET['do'] == "savebadges"){
$page['rank'] = 7;
}else{
$page['rank'] = 6;
}
require_once('../includes/core.php');
require_once('./includes/hksession.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.users");

if(isset($_POST['search'])){
	$sql = $serverdb->query("SELECT id,name FROM ".PREFIX."users WHERE name LIKE '%".$input->FilterText($_POST['query'])."%' LIMIT 50");
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"; $i = 0;
	while($row = $db->fetch_row($sql)){
		if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
		$search_results .= "<tr id=\"".$even."\"><td><a href=\"".PATH."/housekeeping/users?id=".$row[0]."\">".$row[1]."</a></td><td class=\"selectid\">".$row[0]."</td></tr>\n";
		$i++;
	}
	$search_results .= "</tr></table>";
}else{
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr><td><b>".$lang->loc['search.desc']."</b></td></tr></table>";
}

if(isset($_GET['do'])){
foreach($_POST as &$value){
	$value = $input->FilterText($value);
}
$id = $_POST['id'];
switch($_GET['do']){
case "savedetails":
$row = $db->fetch_row($core->select3($input->FilterText($id)));
if(!is_numeric($_POST['rank']) || ((int) $_POST['rank'] < 1 || (int) $_POST['rank'] > 7)){ $error = $lang->loc['error.invalid.rank']; }
if((int) $_POST['id'] == (int) $user->id && $user->user("rank") == "7" && $_POST['rank'] != "7"){ $error = $lang->loc['error.derank.admin']; }
if((int) $row[3] >= (int) $user->user("rank") && $user->user("rank") != "7"){ $error = $lang->loc['error.higher.rank']; }
if(empty($error)){
	$data->update2($_POST['id'],$_POST['rank'],$_POST['motto'],$_POST['credits'],$_POST['birth'],$_POST['email']);
	$message = $lang->loc['message.saved.details'];
}
@SendMUSData('UPRA' . $id);
@SendMUSData('UPRH' . $id);
break;
case "savebadges":
if(!empty($_POST['delete'])){
	$data->delete2($id,$_POST['badge']);
}else{
	if(!empty($_POST['new_badge'])){
		$data->insert2($id,$_POST['new_badge']);
	}else{
		$data->update3($id,$_POST['badge']);
	}
}
@SendMusData('UPRS' . $id);
$message = $lang->loc['message.badges.saved'];
break;
case "savebans":
	$length = $_POST['length'];
	$ip = $_POST['ip'];
	$userid = $_POST['user'];
	$reason = $_POST['reason'];
	$date = HoloDate(); $date = $date['date_full'];
	$date = explode(" ", $date);
	$time = explode(":", $date[1]);
	$date = explode("-", $date[0]);
	if(empty($userid) && !empty($ip)){ $userid = $id; }
	if(isset($_POST['unban'])){
		$data->delete3($userid,$ip);
		$message = $lang->loc['message.user.unbanned'];
		break;
	}
	switch($length){
	case "2h": $time[0] = $time[0] + 2; break;
	case "4h": $time[0] = $time[0] + 4; break;
	case "12h": $time[0] = $time[0] + 12; break;
	case "1d": $date[0] = $date[0] + 1; break;
	case "2d": $date[0] = $date[0] + 2; break;
	case "7d": $date[0] = $date[0] + 7; break;
	case "2w": $date[0] = $date[0] + 14; break;
	case "1m": $date[1] = $date[1] + 1; break;
	case "6m": $date[1] = $date[1] + 6; break;
	case "1y": $date[2] = $date[2] + 1; break;
	case "perm": $date[2] = $date[2] + 25; break;
	default: $error = $lang->loc['error.invalid.ban']; break 2;
	}
				 
	if($time[0] > 23){
		$diff = $time[0] - 24;
		$time[0] = $diff + 1;
		$date[0] = $date[0] + 1;
	}
		
	if($input->IsEven($month)){
		if($date[0] > 30){
			$diff = $date[0] - 30;
			$date[0] = $diff;
			$date[1] = $date[1] + 1;
			}
	} else {
		if($date[0] > 31){
			$diff = $date[0] - 31;
			$date[0] = $diff;
			   $date[1] = $date[1] + 1;
		}
	}
		
	if($date[1] > 11){
		$diff = 12 - $date[1];
		$date[1] = $diff;
		$date[2] + 1;
	}
	
	if($date[0] < 10 && strrpos($date[0], "0") === false){ $date[0] = "0" . $date[0]; }
	if($date[1] < 10 && strrpos($date[1], "0") === false){ $date[1] = "0" . $date[1]; }
	if($time[0] < 10 && strrpos($time[0], "0") === false){ $time[0] = "0" . $time[0]; }
		
	$ban_date = $date[0] . "-" . $date[1] . "-" . $date[2] . " " . $time[0] . ":" . $time[1] . ":" . $time[2];
	
	$row = $db->fetch_row($core->select3($id));
	if($id == $user->id || $row[3] == "7"){
		$error = $lang->loc['error.cannot.ban'];
	}elseif(empty($userid) && empty($ip)){
		$error = $lang->loc['error.empty.ban'];
	}else{
		$data->delete3($userid,$ip);
		$data->update4($userid,$ip,$ban_date,$reason);
		$message = $lang->loc['message.saved.ban'];
		@SendMUSData('HKSB' . $id . chr(2) . $input->HoloText($reason));
	}
break;
case "tools":
if(isset($_POST['resetfigure'])){ $data->update5($id); @SendMUSData('UPRA' . $id); }
if(isset($_POST['sendalert'])){ header('Location: '.PATH.'/housekeeping/alerts?id='.$id); }
if(isset($_POST['resetclub'])){ $data->update6($id); @SendMUSData('UPRC' . $id); }
$message = $lang->loc['message.done'];
break;
}
}

if(!empty($_GET['id'])){
	$id = $input->FilterText($_GET['id']);
}elseif(!isset($id)){
	$id = $serverdb->result($serverdb->query("SELECT MAX(id) FROM ".PREFIX."users LIMIT 1"));
}

$page['name'] = $lang->loc['pagename.users'];
$page['category'] = "users";
require_once('./templates/housekeeping_header.php');

$row = $db->fetch_row($core->select3($id));
$cms_row = $db->fetch_assoc($db->query("SELECT * FROM ".PREFIX."users WHERE id = '".$id."' LIMIT 1"));
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/users.png" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.users']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.users']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
 <div class="text">
 <p><?php echo $lang->loc['desc']; ?></p>
 </div>
<form name="users_search" action="<?php echo PATH; ?>/housekeeping/users" method="POST">
 <div class="text">
   <div class="user_listview_bg">
    <div id="listview">
     <div class="Scroller-Container">
<?php echo $search_results; ?>
     </div>
    </div>

    <div id="Scrollbar-Container">
     <img src="<?php echo PATH; ?>/housekeeping/images/up_arrow.gif" class="Scrollbar-Up" />
     <div class="Scrollbar-Track">
       <img src="<?php echo PATH; ?>/housekeeping/images/scrollbar_handle.gif" class="Scrollbar-Handle" />
     </div>
     <img src="<?php echo PATH; ?>/housekeeping/images/down_arrow.gif" class="Scrollbar-Down" />
    </div>
   </div>
<div class="searcuser">

<input type="text" name="query" id="searchname" value="">
<button type="submit" name="search" id="button_search"><?php echo $lang->loc['search']; ?></button>
</div>
</div>
</form>
</td>
 <td class="page_main_right">
<div class="center">
<?php
if(isset($message) && !empty($message)){ echo '<div class="clean-ok">'.$message.'</div>'; }
if(isset($error) && !empty($error)){ echo '<div class="clean-error">'.$error.'</div>'; }
?>
</div>
<table>
<tr>
 <td class="center" valign="top">
 <div class="cform_head">User</div>

 <div class="cform">
<div class="text">
<h1><?php echo $lang->loc['details']; ?></h1>
<div class="hr"></div>
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="avatar" width="70"><img src="<?php echo $user->avatarURL($row[6],"b,2,3,sml,1,0"); ?>"><br />&nbsp;<br /><?php echo $lang->loc['id']; ?>: <?php echo $input->HoloText($row[0]); ?></td>
<td>
<form method="POST" id="details" action="<?php echo PATH; ?>/housekeeping/users?do=savedetails">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr><td width="80"><?php echo $lang->loc['username']; ?>:</td><td><input type="text" disabled="true" value="<?php echo $input->HoloText($row[1]); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['password']; ?>:</td><td><input type="password" disabled="true" value="hiddenpassword"></td></tr>
<tr><td width="80"><?php echo $lang->loc['rank']; ?>:</td><td><input type="text" name="rank" value="<?php echo $input->HoloText($row[3]); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['motto']; ?>:</td><td><input type="text" name="motto" value="<?php echo $input->HoloText($row[8]); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['credits']; ?>:</td><td><input type="text" name="credits" value="<?php echo $input->HoloText($row[9]); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['habbo.dob']; ?>:</td><td><input type="text" disabled="true" value="<?php echo $input->HoloText($row[13]); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['dob']; ?>:</td><td><input type="text" name="birth" value="<?php echo $input->HoloText($row[5]); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['email']; ?>:</td><td><input type="text" name="email" value="<?php echo $input->HoloText($cms_row['email']); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['lastvisit']; ?>:</td><td><input type="text" disabled="true" value="<?php echo date('F j, Y g:i:s A',$cms_row['lastvisit']); ?>"></td></tr>
<tr><td width="80"><?php echo $lang->loc['ipaddress.last']; ?>:</td><td><input type="text" disabled="true" value="<?php echo $input->HoloText($cms_row['ipaddress_last']); ?>"></td></tr>
</table>
</td>
</table>
<div class="button"><input type="submit" value="<?php echo $lang->loc['save']; ?>" /></div>
</form>

<h1><?php echo $lang->loc['badges']; ?></h1>
<div class="hr"></div>
<form method="POST" id="badges" action="<?php echo PATH; ?>/housekeeping/users?do=savebadges">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="avatar" width="70">&nbsp;</td>
<td>
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr><td width="80"><?php echo $lang->loc['badge']; ?>:</td><td>
	<select name="badge" title="<?php echo $lang->loc['badge.desc']; ?>" name="badge">
<?php
$sql = $data->select11($id);
while($row2 = $db->fetch_row($sql)){
if($row2[2] == "1"){ $selected = ' selected="true"'; }else{ $selected = ''; }
echo '<option name="'.$row2[1].'"'.$selected.'>'.$row2[1].'</option>';
}
?>
	</select>

</td></tr>
<tr><td width="80"><?php echo $lang->loc['new']; ?>:</td><td>
	<input type="text" name="new_badge" title="<?php echo $lang->loc['new.desc']; ?>" value="" />
</td></tr>
</table>
</td>
</table>
<div class="button"><input type="submit" name="save" value="<?php echo $lang->loc['save']; ?>" /></div>
<div class="button"><input type="submit" name="delete" value="<?php echo $lang->loc['delete']; ?>" title="<?php echo $lang->loc['delete.desc']; ?>" /></div>
</form>

<h1><?php echo $lang->loc['bans']; ?></h1>
<div class="hr"></div>
<form method="POST" id="bans" action="<?php echo PATH; ?>/housekeeping/users?do=savebans">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="avatar" width="70">&nbsp;</td>
<td>
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr><td width="80"><?php echo $lang->loc['ban']; ?>:</td><td>
<input type="checkbox" name="user" value="<?php echo $row[0]; ?>" /><?php echo $lang->loc['ban.user']; ?>&nbsp;&nbsp;<input type="checkbox" name="ip" value="<?php echo $cms_row['ipaddress_last']; ?>" /><?php echo $lang->loc['ban.ip']; ?>
</td></tr>
<tr><td width="80"><?php echo $lang->loc['length']; ?>:</td><td>
<select name="length">
<?php $length = explode("|", $lang->loc['length.values']); ?>
<option value='2h'><?php echo $length[0]; ?></option>
<option value='4h'><?php echo $length[1]; ?></option>
<option value='12h'><?php echo $length[2]; ?></option>
<option value='1d'><?php echo $length[3]; ?></option>
<option value='2d'><?php echo $length[4]; ?></option>
<option value='7d'><?php echo $length[5]; ?></option>
<option value='2w'><?php echo $length[6]; ?></option>
<option value='1m'><?php echo $length[7]; ?></option>
<option value='6m'><?php echo $length[8]; ?></option>
<option value='1y'><?php echo $length[9]; ?></option>
<option value='perm'><?php echo $length[10]; ?></option>
</select>
</td></tr>
<tr><td width="80"><?php echo $lang->loc['reason']; ?>:</td><td>
	<input type="text" name="reason" value="" />
</td></tr>
<tr><td width="80"><?php echo $lang->loc['status']; ?>:</td><td>
	<p>
<?php
$sql = $data->select12($id);
if($db->num_rows($sql) == 0){ echo $lang->loc['no.bans']; }else{
$row = $db->fetch_row($sql);
if(!empty($row[1])){ echo $lang->loc['type.ipban']."<br />\n"; }else{ echo $lang->loc['type.userban']."<br />\n"; }
echo $lang->loc['expire.date'].": ".$row[2]."<br />";
echo $lang->loc['ban.reason'].": ".$input->HoloText($row[3]);
}
?>
	</p>
</td></tr>
</table>
</td>
</table>
<div class="button"><input type="submit" name="ban" value="<?php echo $lang->loc['ban.button']; ?>" /></div>
<div class="button"><input type="submit" name="unban" value="<?php echo $lang->loc['unban.button']; ?>" /></div>
</form>

<h1><?php echo $lang->loc['tools']; ?></h1>
<div class="hr"></div>
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="avatar" width="70">&nbsp;</td>
<td>
<form method="POST" id="tools" action="<?php echo PATH; ?>/housekeeping/users?do=tools">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table class="userstats" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="button"><input type="submit" name="resetfigure" value="<?php echo $lang->loc['reset.figure']; ?>" /></div></td>
<td><div class="button"><input type="submit" name="sendalert" value="<?php echo $lang->loc['send.alert']; ?>" /></div></td>
<td><div class="button"><input type="submit" name="resetclub" value="<?php echo $lang->loc['reset.club']; ?>" /></div></td>
</tr>
</table>
</form>
</td>
</table>
</table>
</div>

 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>