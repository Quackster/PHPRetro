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

$type = $_GET['type'];

$page['rank'] = $type == "mass" ? 7 : 6;

require_once('../includes/core.php');
require_once('./includes/hksession.php');
$lang->addLocale("housekeeping.alerts");

$page['name'] = $lang->loc['pagename.alerts'];
$page['category'] = "users";
require_once('./templates/housekeeping_header.php');

if(isset($_POST['search'])){
	$sql = $serverdb->query("SELECT id,name FROM ".PREFIX."users WHERE name LIKE '%".$input->FilterText($_POST['query'])."%' LIMIT 50");
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"; $i = 0;
	while($row = $db->fetch_row($sql)){
		if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
		$search_results .= "<tr id=\"".$even."\"><td><a href=\"".PATH."/housekeeping/alerts?type=single&do=create&userid=".$row[0]."\">".$row[1]."</a></td><td class=\"selectid\">".$row[0]."</td></tr>\n";
		$i++;
	}
	$search_results .= "</tr></table>";
}else{
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr><td><b>".$lang->loc['search.desc']."</b></td></tr></table>";
}

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	if($type == "single" && empty($row['userid'])){ $error = $lang->loc['error.no.userid']; }
	if(!empty($row['alert'])){ $error = $lang->loc['error.no.alert']; }
	if(empty($_POST['hotel']) && empty($_POST['site'])){ $error = $lang->loc['error.no.where']; }
	if(empty($error)){
		if($row['site'] == "1"){
			if(!empty($row['id'])){
				if($type == "single"){
					$db->query("UPDATE ".PREFIX."alerts SET alert = '".$input->FilterText($row['alert'])."', time = '".time()."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
				}else{
					$orginal = @$db->result($db->query("SELECT alert FROM ".PREFIX."alerts WHERE id = '".$row['id']."' LIMIT 1"));
					$db->query("UPDATE ".PREFIX."alerts SET alert = '".$input->FilterText($row['alert'])."', time = '".time()."' WHERE alert = '".$orginal."' AND type = '0'");
				}
				$message = $lang->loc['message.alert.modified'];
			}else{
				if($type == "single"){
					$db->query("INSERT INTO ".PREFIX."alerts (userid,alert,type,time) VALUES ('".$input->FilterText($row['userid'])."','".$input->FilterText($row['alert'])."','2','".time()."')");
				}else{
					@set_time_limit(0);
					$sql = $db->query("SELECT id FROM ".PREFIX."users");
					while($urow = $db->fetch_row($sql)){
						$db->query("INSERT INTO ".PREFIX."alerts (userid,alert,type,time) VALUES ('".$input->FilterText($urow[0])."','".$input->FilterText($row['alert'])."','0','".time()."')");
					}
				}
				$message = $lang->loc['message.alert.created'];
			}
		}
		if($row['hotel'] == "1"){
			if($type == "single"){
				@SendMUSData('HKMW'.$row['userid'].chr(2).$row['alert']);
			}else{
				@set_time_limit(0);
				$sql = $db->query("SELECT id FROM ".PREFIX."users");
				while($urow = $db->fetch_row($sql)){
					@SendMUSData('HKTM'.$urow[0].chr(2).$row['alert']);
				}
			}
		}
		if($row['help'] == "true"){ header('Location: '.PATH.'/housekeeping/help'); }
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		if($type == "single"){
			$db->query("DELETE FROM ".PREFIX."alerts WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		}else{
			$orginal = @$db->result($db->query("SELECT alert FROM ".PREFIX."alerts WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1"));
			$db->query("DELETE FROM ".PREFIX."alerts WHERE alert = '".$orginal."' AND type = '0'");
		}
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.alert.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."alerts WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$checked[0] = ' checked="true"';
}elseif(empty($row)){
	if(!empty($_GET['userid'])){ $row['userid'] = $input->HoloText($_GET['userid']); }
	if(!empty($_GET['alert'])){ $row['alert'] = $input->HoloText(urldecode($_GET['alert'])); }
	$checked[0] = ' checked="true"';
	$checked[1] = ' checked="true"';
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.alerts.create");
$icon = "alerts.png";
if($type == "single"){
$description = $lang->loc['alerts.create.single.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/alerts?type=single&do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
if($_GET['help'] == "true"){ $content .= '<input type="hidden" name="help" value="true" />'; }
$content .= 
'<label for="userid">'.$lang->loc['userid'].':</label><br />
<input type="text" name="userid" value="'.$input->HoloText($row['userid']).'" title="'.$lang->loc['userid.desc'].'" /><br />
<label for="alert">'.$lang->loc['alert'].':</label><br />
<textarea name="alert" title="'.$lang->loc['alert.desc'].'">'.$input->HoloText($row['alert'],true).'</textarea><br />
<label for="where">'.$lang->loc['where'].':</label><br />
<input type="checkbox" name="site" value="1"'.$checked[0].' title="'.$lang->loc['where.desc'].'" />'.$lang->loc['site'].'&nbsp;&nbsp;<input type="checkbox" name="hotel" value="1"'.$checked[1].' title="'.$lang->loc['where.desc'].'" />'.$lang->loc['hotel'].'<br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
}else{
$description = $lang->loc['alerts.create.mass.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/alerts?type=mass&do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="alert">'.$lang->loc['alert'].':</label><br />
<textarea name="alert" title="'.$lang->loc['alert.desc'].'">'.$input->HoloText($row['alert']).'</textarea><br />
<label for="where">'.$lang->loc['where'].':</label><br />
<input type="checkbox" name="site" value="1"'.$checked[0].' title="'.$lang->loc['where.desc'].'" />'.$lang->loc['site'].'&nbsp;&nbsp;<input type="checkbox" name="hotel" value="1"'.$checked[1].' title="'.$lang->loc['where.desc'].'" />'.$lang->loc['hotel'].'<br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
}
break;
case "remove":
$lang->addLocale("housekeeping.alerts.remove");
$icon = "alerts.png";
$description = $lang->loc['alerts.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['alert']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/alerts?type='.$input->FilterText($_GET['type']).'&do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.alerts.display");
$icon = "alerts.png";
$description = $lang->loc['alerts.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="350">'.$lang->loc['alert'].'</th>
<th width="50">'.$lang->loc['userid'].'</th>
<th width="50">'.$lang->loc['date'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."alerts WHERE type = '0' GROUP BY alert ORDER BY time DESC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td>'.$input->HoloText($row['alert']).'</a></td>
<td><a href="'.PATH.'/housekeeping/alerts?type=mass&do=create&id='.$row['id'].'">'.$lang->loc['mass'].'</a></td>
<td>'.date('n/j/Y g:i A',$row['time']).'</td>
<td class="action"><a href="'.PATH.'/housekeeping/alerts?type=mass&do=create&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/alerts?type=mass&do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$sql = $db->query("SELECT * FROM ".PREFIX."alerts WHERE type > '0' ORDER BY time DESC");
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td>'.$input->HoloText($row['alert']).'</a></td>
<td><a href="'.PATH.'/housekeeping/alerts?type=single&do=create&id='.$row['id'].'">'.$row['id'].'</a></td>
<td>'.date('n/j/Y g:i A',$row['time']).'</td>
<td class="action"><a href="'.PATH.'/housekeeping/alerts?type=single&do=create&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/alerts?type=single&do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new.mass'].'" onclick="window.location.href=\''.PATH.'/housekeeping/alerts?type=mass&do=create\'"></input></div>
<div class="button"><input type="button" value="'.$lang->loc['new.single'].'" onclick="window.location.href=\''.PATH.'/housekeeping/alerts?type=single&do=create\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.alerts']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.alerts']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
<div class="text">
 <p><?php echo $description; ?></p>
 </div>
<form name="users_search" action="<?php echo PATH; ?>/housekeeping/alerts" method="POST">
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
<?php echo $content; ?>
</div>
 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>