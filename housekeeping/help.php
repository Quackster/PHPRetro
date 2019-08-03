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
$lang->addLocale("housekeeping.help");

$page['name'] = $lang->loc['pagename.help'];
$page['category'] = "users";
require_once('./templates/housekeeping_header.php');

if(isset($_GET['do']) && $_GET['do'] == "pickup"){
	$id = $input->FilterText($_GET['id']);
	$db->query("UPDATE ".PREFIX."help SET picked_up = '1' WHERE id = '".$id."' LIMIT 1");
	$message = $lang->loc['message.help.picked.up'];
	unset($_POST); unset($_GET);
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		if($_POST['id'] == "*"){
			$db->query("TRUNCATE TABLE ".PREFIX."help");
		}else{
			$db->query("DELETE FROM ".PREFIX."help WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		}
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.help.removed'];
	}
}elseif($_GET['do'] == "reply"){
	$id = $input->FilterText($_GET['id']);
	$db->query("UPDATE ".PREFIX."help SET picked_up = '1' WHERE id = '".$id."' LIMIT 1");
	$sql = $db->query("SELECT * FROM ".PREFIX."help WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$usql = $serverdb->query("SELECT id FROM ".PREFIX."users WHERE name = '".$input->FilterText($input->HoloText($row['username']))."' LIMIT 1");
	if($serverdb->num_rows($usql) > 0){
		$userid = $db->result($usql);
	}else{
		$userid = null;
	}
	$alert = urlencode($lang->loc['alert.message.1'].' '.$user->name.', '.$lang->loc['alert.message.2'].': "'.$row['subject'].'"'."\n\n");
	header('Location: '.PATH.'/housekeeping/alerts?do=create&type=single&help=true&userid='.$userid.'&alert='.$alert);
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."help WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	if($_GET['id'] == "all"){ $row['id'] = "*"; $row['subject'] = $lang->loc['all']; }
}

switch($_GET['do']){
case "remove":
$lang->addLocale("housekeeping.help.remove");
$icon = "help.png";
$description = $lang->loc['help.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['subject']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/help?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.help.display");
$icon = "help.png";
$description = $lang->loc['help.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="100">'.$lang->loc['subject'].'</th>
<th width="200">'.$lang->loc['message'].'</th>
<th width="50">'.$lang->loc['username'].'</th>
<th width="50">'.$lang->loc['date'].'</th>
<th width="10">'.$lang->loc['picked.up'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."help ORDER BY picked_up ASC, date DESC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
$usql = $serverdb->query("SELECT id FROM ".PREFIX."users WHERE name = '".$input->FilterText($input->HoloText($row['username']))."' LIMIT 1");
if($serverdb->num_rows($usql) > 0){
	$userid = $db->result($usql);
}else{
	$userid = null;
}
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td>'; if(!empty($userid)){ $content .= '<a href="'.PATH.'/housekeeping/help?do=reply&id='.$row['id'].'">'.$input->HoloText($row['subject']).'</a>'; }else{ $content .= $input->HoloText($row['subject']); } $content .= '</td>
<td>'; if(!empty($userid)){ $content .= '<a href="'.PATH.'/housekeeping/help?do=reply&id='.$row['id'].'">'.$input->HoloText($row['message']).'</a>'; }else{ $content .= $input->HoloText($row['message']); } $content .= '</td>
<td>'; if(!empty($userid)){ $content .= '<a href="'.PATH.'/housekeeping/help?do=reply&id='.$row['id'].'">'.$input->HoloText($row['username']).'</a>'; }else{ $content .= $input->HoloText($row['username']); } $content .= '</td>
<td>'.date('n/j/Y g:i A',$row['date']).'</td>
<td>'.$input->HoloText($row['picked_up']).'</td>
<td class="action">
<a href="'.PATH.'/housekeeping/help?do=pickup&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/accept.png" alt="'.$lang->loc['pick.up'].'" title="'.$lang->loc['pick.up'].'" /></a>';
if(!empty($userid)){ $content .= 
'<a href="'.PATH.'/housekeeping/help?do=reply&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/alerts.png" alt="'.$lang->loc['reply'].'" title="'.$lang->loc['reply'].'" /></a>';
}
$content .= 
'<a href="'.PATH.'/housekeeping/help?do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['delete.all'].'" onclick="window.location.href=\''.PATH.'/housekeeping/help?do=remove&id=all\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.help']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.help']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
<div class="text">
<?php echo $description; ?>
</div>
</td>
 <td class="page_main_right">
<div class="center">
<?php echo $content; ?>
</div>
 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>