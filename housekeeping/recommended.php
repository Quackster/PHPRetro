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
$lang->addLocale("housekeeping.recommended");

$page['name'] = $lang->loc['pagename.recommended'];
$page['category'] = "tools";

if(isset($_POST['search'])){
	$sql = $data->select7($input->FilterText($_POST['query']));
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"; $i = 0;
	while($row = $db->fetch_row($sql)){
		if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
		$search_results .= "<tr id=\"".$even."\"><td><a href=\"".PATH."/housekeeping/recommended?do=create&recid=".$row[0]."\">".$row[1]."</a></td><td class=\"selectid\">".$row[0]."</td></tr>\n";
		$i++;
	}
	$search_results .= "</tr></table>";
}else{
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr><td><b>".$lang->loc['search.desc']."</b></td></tr></table>";
}

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	$sponsored[(int) $row['sponsered']] = ' selected="true"';
	$selected[$row['type']] = ' selected="true"';
	if(!is_numeric($row['rec_id']) && $row['type'] == "room"){ $error = $lang->loc['error.invalid.roomid']."<br />"; }
	if(!is_numeric($row['rec_id']) && $row['type'] == "group"){ $temp = $db->fetch_row($data->select8($input->FilterText($row['rec_id']))); $row['rec_id'] = $temp[0]; }
	if(empty($row['rec_id'])){ $error = $lang->loc['error.no.recid']."<br />"; }
	if($row['type'] == "room" && $row['sponsered'] != "0"){ $error = $lang->loc['error.invalid.location']; }
	if(empty($error)){
		if(!empty($row['id'])){
			$db->query("UPDATE ".PREFIX."recommended SET rec_id = '".$input->FilterText($row['rec_id'])."', type = '".$input->FilterText($row['type'])."', sponsered = '".$input->FilterText($row['sponsered'])."' LIMIT 1");
			$message = $lang->loc['message.recommended.modified'];
		}else{
			$db->query("INSERT INTO ".PREFIX."recommended (rec_id,type,sponsered) VALUES ('".$input->FilterText($row['rec_id'])."','".$input->FilterText($row['type'])."','".$input->FilterText($row['sponsered'])."')");
			$message = $lang->loc['message.recommended.created'];
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$db->query("DELETE FROM ".PREFIX."recommended WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.recommended.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."recommended WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$sponsored[(int) $row['sponsered']] = ' selected="true"';
	$selected[$row['type']] = ' selected="true"';
}elseif(empty($row)){
	$row['rec_id'] = $input->HoloText($_GET['recid']);
	if(!empty($_GET['recid'])){ $selected['room'] = ' selected="true"'; }else{ $selected['group'] = ' selected="true"'; }
	$sponsored[0] = ' selected="true"';
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.recommended.create");
$icon = "recommended_create.png";
$description = $lang->loc['recommended.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/recommended?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$months = explode("|",$lang->loc['list.months']);
$content .= 
'<label for="rec_id">'.$lang->loc['rec.id'].':</label><br />
<input type="text" name="rec_id" value="'.$input->HoloText($row['rec_id']).'" title="'.$lang->loc['rec.id.desc'].'" /><br />
<label for="type">'.$lang->loc['type'].':</label><br />
<select name="type" title="'.$lang->loc['type.desc'].'"><option value="group"'.$selected['group'].'>'.$lang->loc['group'].'</option><option value="room"'.$selected['room'].'>'.$lang->loc['room'].'</option></select><br />
<label for="sponsered">'.$lang->loc['sponsered'].':</label><br />
<select name="sponsered" title="'.$lang->loc['sponsered.desc'].'"><option value="0"'.$sponsored[0].'>'.$lang->loc['staff.picks'].'</option><option value="1"'.$sponsored[1].'>'.$lang->loc['recommedned'].'</option></select><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
break;
case "remove":
$lang->addLocale("housekeeping.recommended.remove");
$icon = "recommended_remove.png";
$description = $lang->loc['recommended.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$row['rec_id'].'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/recommended?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.recommended.display");
$icon = "recommended.png";
$description = $lang->loc['recommended.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['recommended.id'].'</th>
<th width="250">'.$lang->loc['type'].'</th>
<th width="150">'.$lang->loc['sponsored'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."recommended ORDER BY sponsered ASC, id ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/recommended?do=create&id='.$row['id'].'">'.$input->HoloText($row['rec_id']).'</a></td>
<td><a href="'.PATH.'/housekeeping/recommended?do=create&id='.$row['id'].'">'.$input->HoloText($row['type']).'</a></td>
<td><a href="'.PATH.'/housekeeping/recommended?do=create&id='.$row['id'].'">'.$input->HoloText($row['sponsered']).'</a></td>
<td class="action"><a href="'.PATH.'/housekeeping/recommended?do=create&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/recommended?do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/recommended?do=create\'"></input></div>
</div>';
break;
}

$page['scrollbar'] = true;
require_once('./templates/housekeeping_header.php');
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.recommended']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.recommended']; ?></span>
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
<form name="furni_search" action="<?php echo PATH; ?>/housekeeping/recommended" method="POST">
<div class="hr"></div>
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