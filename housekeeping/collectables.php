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
$lang->addLocale("housekeeping.collectables");

$page['name'] = $lang->loc['pagename.collectables'];
$page['category'] = "tools";

if(isset($_POST['search'])){
	$sql = $data->select6($input->FilterText($_POST['query']));
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"; $i = 0;
	while($row = $db->fetch_row($sql)){
		if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
		$search_results .= "<tr id=\"".$even."\"><td><a href=\"".PATH."/housekeeping/collectables?do=create&furniid=".$row[0]."\">".$row[1]."</a></td><td class=\"selectid\">".$row[0]."</td></tr>\n";
		$i++;
	}
	$search_results .= "</tr></table>";
}else{
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr><td><b>".$lang->loc['search.desc']."</b></td></tr></table>";
}

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	$row['image_small'] = str_replace("%path%",PATH,$row['image_small']);
	$row['image_large'] = str_replace("%path%",PATH,$row['image_large']);
	$year = $row['year'];
	$selected[(int) $row['month']] = ' selected="true"';
	$row['date'] = mktime(0,0,0,$row['month'],1,$row['year']);
	if(empty($row['furni_id'])){ $error = $lang->loc['error.no.furni_id']."<br />"; }
	if(empty($row['month'])){ $error = $lang->loc['error.no.month']."<br />"; }
	if(empty($row['year'])){ $error = $lang->loc['error.no.year']; }
	if(empty($error)){
		if(!empty($row['id'])){
			$db->query("UPDATE ".PREFIX."collectables SET image_small = '".$input->FilterText($row['image_small'])."', image_large = '".$input->FilterText($row['image_large'])."', furni_id = '".$input->FilterText($row['furni_id'])."', date = '".$input->FilterText($row['date'])."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
			$message = $lang->loc['message.collectable.modified'];
		}else{
			$db->query("INSERT INTO ".PREFIX."collectables (image_small,image_large,furni_id,date) VALUES ('".$input->FilterText($row['image_small'])."','".$input->FilterText($row['image_large'])."','".$input->FilterText($row['furni_id'])."','".$input->FilterText($row['date'])."')");
			$message = $lang->loc['message.collectable.created'];
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$db->query("DELETE FROM ".PREFIX."collectables WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.collectable.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."collectables WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$year = date('Y',$row['date']);
	$selected[(int) date('n',$row['date'])] = ' selected="true"';
}elseif(empty($row)){
	$row['image_small'] = "%path%/web-gallery/images/furni/small/";
	$row['image_large'] = "%path%/web-gallery/images/furni/large/";
	$row['furni_id'] = $_GET['furniid'];
	$year = date('Y');
	$selected[(int) date('n')] = ' selected="true"';
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.collectables.create");
$icon = "collectables_create.png";
$description = $lang->loc['collectables.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/collectables?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$months = explode("|",$lang->loc['list.months']);
$content .= 
'<label for="furni_id">'.$lang->loc['furni.id'].':</label><br />
<input type="text" name="furni_id" value="'.$input->HoloText($row['furni_id']).'" title="'.$lang->loc['furni.id.desc'].'" /><br />
<label for="image_small">'.$lang->loc['small.image'].':</label><br />
<input type="text" name="image_small" value="'.$input->HoloText($row['image_small']).'" title="'.$lang->loc['small.image.desc'].'" /><br />
<label for="image_large">'.$lang->loc['large.image'].':</label><br />
<input type="text" name="image_large" value="'.$input->HoloText($row['image_large']).'" title="'.$lang->loc['large.image.desc'].'" /><br />
<label for="month">'.$lang->loc['month'].':</label><br />
<select name="month" title="'.$lang->loc['month.desc'].'"><option value="1"'.$selected[1].'>'.$months[0].'</option><option value="2"'.$selected[2].'>'.$months[1].'</option><option value="3"'.$selected[3].'>'.$months[2].'</option><option value="4"'.$selected[4].'>'.$months[3].'</option><option value="5"'.$selected[5].'>'.$months[4].'</option><option value="6"'.$selected[6].'>'.$months[5].'</option><option value="7"'.$selected[7].'>'.$months[6].'</option><option value="8"'.$selected[8].'>'.$months[7].'</option><option value="9"'.$selected[9].'>'.$months[8].'</option><option value="10"'.$selected[10].'>'.$months[9].'</option><option value="11"'.$selected[11].'>'.$months[10].'</option><option value="12"'.$selected[12].'>'.$months[11].'</option></select><br />
<label for="year">'.$lang->loc['year'].':</label><br />
<input type="text" name="year" value="'.$year.'" title = "'.$lang->loc['year.desc'].'" /><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
break;
case "remove":
$lang->addLocale("housekeeping.collectables.remove");
$icon = "collectables_remove.png";
$description = $lang->loc['collectables.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.date('F Y',$row['date']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/collectables?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.collectables.display");
$icon = "collectables.png";
$description = $lang->loc['collectables.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['image'].'</th>
<th width="250">'.$lang->loc['name'].'</th>
<th width="150">'.$lang->loc['date'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $data->select5();
$i = 0;
while($row = $db->fetch_row($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/collectables?do=create&id='.$row[0].'"><img src="'.str_replace('%path%',PATH,$row[1]).'" /></a></td>
<td><a href="'.PATH.'/housekeeping/collectables?do=create&id='.$row[0].'">'.$input->HoloText($row[4]).'</a></td>
<td>'.date('F Y',$row[3]).'</td>
<td class="action"><a href="'.PATH.'/housekeeping/collectables?do=create&id='.$row[0].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/collectables?do=remove&id='.$row[0].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/collectables?do=create\'"></input></div>
</div>';
break;
}

$page['scrollbar'] = true;
require_once('./templates/housekeeping_header.php');
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.collectables']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.collectables']; ?></span>
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
<form name="furni_search" action="<?php echo PATH; ?>/housekeeping/collectables" method="POST">
<div class="hr"></div>
 <div class="text">
 <p><?php echo $lang->loc['search.instructions']; ?></p>
 </div>
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