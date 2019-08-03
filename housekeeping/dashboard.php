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
$page['rank'] = 5;
require_once('../includes/core.php');
require_once('./includes/hksession.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.dashboard");

if(isset($_POST['admin_notes'])){
	$db->query("UPDATE ".PREFIX."settings SET value = '".$input->FilterText($_POST['admin_notes'])."' WHERE id = 'hk_notes' LIMIT 1");
	$settings->generateCache();
	$message = $lang->loc['notes.saved'];
}

$page['name'] = $lang->loc['pagename.dashboard'];
$page['category'] = "dashboard";
$page['scrollbar'] = true;
$page['second_scrollbar'] = true;
require_once('./templates/housekeeping_header.php');
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/dashboard.png" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.dashboard']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.dashboard']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
<div class="loginuser"><?php echo $lang->loc['header']; ?>, <?php echo $input->HoloText($user->name); ?></div>
<div class="hr"></div>
<div class="text">
<b><?php echo $lang->loc['statistics']; ?></b><br />
<?php
$sql = $serverdb->query("SELECT COUNT(*) FROM ".PREFIX."users WHERE online > ".(time() - 60*60*24)."");
$stats[0] = $serverdb->result($sql);
$sql = $data->select1();
while($row = $serverdb->fetch_row($sql)){
	$stats[] = $row[0];
}
$sql = $data->select2();
while($row = $serverdb->fetch_row($sql)){
	$stats[] = $row[0];
}
?>

<?php echo $lang->loc['users']; ?>: <?php echo $stats[4]; ?><br />
<?php echo $lang->loc['rooms']; ?>: <?php echo $stats[3]; ?><br />
<?php echo $lang->loc['furnitures']; ?>: <?php echo $stats[1]; ?><br />
<?php echo $lang->loc['groups']; ?>: <?php echo $stats[2]; ?><br />
<?php echo $lang->loc['banned']; ?>: <?php echo $stats[5]; ?><br />
</div>
<div class="hr"></div>
<div class="text">
<b><?php echo $lang->loc['current.statistics']; ?></b><br />
<?php echo $lang->loc['hotel.status']; ?>: <?php echo HotelStatus(); ?><br />
<?php echo $lang->loc['users.today']; ?>: <?php echo $stats[0]; ?><br />
<?php echo $lang->loc['users.online']; ?>: <?php echo $stats[6]; ?><br />
<?php echo $lang->loc['active.rooms']; ?>: <?php echo $stats[7]; ?><br />
</div>
</td>
 <td class="page_main_right">

<table>
<tr>
<div class="center">
	<?php if(isset($message)){ ?><div class="clean-ok"><?php echo $message; ?></div><?php } ?>
	<?php if($settings->checkCache() == true && $user->user("rank") > 6){ ?><div class="clean-yellow"><?php echo $lang->loc['cache.outdated']; ?> <a href="<?php echo PATH; ?>/housekeeping/cache" /><?php echo $lang->loc['update.now']; ?> &raquo;</a></div><?php } ?>
<?php
$this['month'] = date('m');
$this['year'] = date('Y');
$this['time'] = mktime(0,0,0,$this['month'],1,$this['year']);
$this['next_time'] = strtotime("+1 Month",$this['time']);
if($this['next_time'] - 60*60*24*7 < time()){
	$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."collectables WHERE date > '".time()."' AND date <= '".$this['next_time']."' LIMIT 1");
	if($db->result($sql) == 0){
		echo '<div class="clean-gray">'.$lang->loc['collectable.outdated'].' <a href="'.PATH.'/collectables" />'.$lang->loc['go'].' &raquo;</a></div>';
	}
}
if($user->user("rank") == 7){
	$version = version();
	$update = @file_get_contents('http://www.phpretro.com/system/version_check.php?version='.$version['version'].".".$version['revision'].'&stable='.$version['stable']);
	$update = @unserialize($update);
	if(!empty($update)){
	echo '<div class="clean-yellow">'.$lang->loc['update.available'].': '.$update[0]['build'].' '.$update[0]['stable'].' <a href="'.PATH.'/housekeeping/updates" />'.$lang->loc['details'].' &raquo;</a></div>';
	}
}
$count = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."help WHERE picked_up = '0' LIMIT 1"));
if($count > 0){
?>
	<div class="clean-error"><?php echo $count; ?> <?php echo $lang->loc['pending.help.requests']; ?> <a href="<?php echo PATH; ?>/housekeeping/help" /><?php echo $lang->loc['see.them']; ?> &raquo;</a></div>
<?php } ?>
</div>
<td class="left" valign="top">
<form id="notes" action="<?php echo PATH; ?>/housekeeping/dashboard" method="post">
 <div class="text">
 <h1><?php echo $lang->loc['welcome']; ?></h1>
<?php echo $lang->loc['welcome.text']; ?><br />
&nbsp;<br />
<?php echo $lang->loc['notes.desc']; ?>
   <div class="form_head"><?php echo $lang->loc['notes']; ?></div>
   <textarea rows="8" name="admin_notes"><?php echo $settings->find("hk_notes"); ?></textarea>
  <div class="textlabel_cc"><?php echo $lang->loc['save.notes']; ?> &nbsp;<button class="button_mini" onClick="this.form.admin_notes.value=''" /><img src="<?php echo PATH; ?>/housekeeping/images/del.gif" /></button><button type="submit" class="button_mini" /><img src="<?php echo PATH; ?>/housekeeping/images/check.gif" /></button></div>
  </form>
 </div>
 </td>
 <td class="right" valign="top">
 <div class="text">
 <?php echo $lang->loc['admins.desc']; ?>

   <div class="form_head"><?php echo $lang->loc['staff']; ?></div>
   <div class="listview_bg">
    <div id="listview">
     <div class="Scroller-Container">
<?php $sql = $data->select3(5);
while($row = $serverdb->fetch_row($sql)){
	$id = $input->HoloText($row[0]);
	$name = $input->HoloText($row[1]);
	$rank = $input->HoloText($row[2]);
	if($user->IsUserOnline($id)){ echo "<a href=\"".PATH."/housekeeping/users?id=".$id."\"><span class=\"online\">".$name." (".$rank.")</span></a><br />"; }else{ echo "<a href=\"".PATH."/housekeeping/users?id=".$id."\">".$name." (".$rank.")</a><br />"; }
}
?>
</div>

    </div>

    <div id="Scrollbar-Container">
     <img src="<?php echo PATH; ?>/housekeeping/images/up_arrow.gif" class="Scrollbar-Up">
     <div class="Scrollbar-Track">
       <img src="<?php echo PATH; ?>/housekeeping/images/scrollbar_handle.gif" class="Scrollbar-Handle">
     </div>
     <img src="<?php echo PATH; ?>/housekeeping/images/down_arrow.gif" class="Scrollbar-Down">
    </div>

   </div>

<?php echo $lang->loc['chatlog.desc']; ?>
   <div class="form_head"><a href="<?php echo PATH; ?>/housekeeping/logs"><?php echo $lang->loc['chat.log']; ?> &raquo;</a></div>
   <div class="listview_bg">
    <div id="listview2">
     <div class="Scroller2-Container">
<?php $sql = $data->select4(20,0);
while($row = $serverdb->fetch_row($sql)){
	echo "[".$input->HoloText($row[2])."][".$input->HoloText($row[1])."] <span class=\"highlight\">".$input->HoloText($row[0])."</span>: ".$input->HoloText($row[3])."<br />";
}
?>
</div>

    </div>

    <div id="Scrollbar2-Container">
     <img src="<?php echo PATH; ?>/housekeeping/images/up_arrow.gif" class="Scrollbar2-Up">
     <div class="Scrollbar2-Track">
       <img src="<?php echo PATH; ?>/housekeeping/images/scrollbar_handle.gif" class="Scrollbar2-Handle">
     </div>
     <img src="<?php echo PATH; ?>/housekeeping/images/down_arrow.gif" class="Scrollbar2-Down">
    </div>

   </div>


 </div>
 </td>
</tr>
</table>
 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>