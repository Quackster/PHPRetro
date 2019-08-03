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
$lang->addLocale("housekeeping.vouchers");
$data = new housekeeping_sql;

$page['name'] = $lang->loc['pagename.vouchers'];
$page['category'] = "tools";
require_once('./templates/housekeeping_header.php');

if(isset($_POST['search'])){
	$sql = $data->select6($input->FilterText($_POST['query']));
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"; $i = 0;
	while($row = $db->fetch_row($sql)){
		if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
		$search_results .= "<tr id=\"".$even."\"><td><a href=\"".PATH."/housekeeping/vouchers?do=create&furniid=".$row[0]."\">".$row[1]."</a></td><td class=\"selectid\">".$row[0]."</td></tr>\n";
		$i++;
	}
	$search_results .= "</tr></table>";
}else{
	$search_results = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr><td><b>".$lang->loc['search.desc']."</b></td></tr></table>";
}

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	$correct = $input->stringToURL($row['voucher'],false);
	if($row['type'] == "1"){ $row['type_s'] = "credits"; $selected[1] = ' selected="true"'; }else{ $row['type_s'] = "item"; $selected[0] = ' selected="true"'; }
	if(empty($row['voucher']) || strlen($row['voucher']) > 50 || $row['voucher'] != $correct){ $error = $lang->loc['error.invalid.voucher']."<br />"; }
	if($serverdb->num_rows($data->select10($row['voucher'])) > 0){ $error = $lang->loc['error.duplicate.voucher']."<br />"; }
	if(empty($row['value'])){ $error = $lang->loc['error.no.value']; }
	if(empty($error)){
		if(!empty($row['id'])){
			$data->update1($row['id'],$row['voucher'],$row['type_s'],$row['value']);
			$message = $lang->loc['message.voucher.modified'];
		}else{
			$data->insert1($row['voucher'],$row['type_s'],$row['value']);
			$message = $lang->loc['message.voucher.created'];
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$data->delete1($input->FilterText($_POST['id']));
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.voucher.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $data->select10($input->FilterText($_GET['id']));
	$row = $serverdb->fetch_row($sql);
	$row['id'] = $row[0];
	$row['voucher'] = $row[0];
	$row['type'] = $row[1];
	$row['value'] = $row[2];
	if($row['type'] == "1"){ $selected[1] = ' selected="true"'; }else{ $selected[0] = ' selected="true"'; }
}elseif(empty($row)){
	if(!empty($_GET['furniid'])){
		$selected[0] = ' selected="true"';
		$row['value'] = $input->HoloText($_GET['furniid']);
	}else{
		$selected[1] = ' selected="true"';
		$row['value'] = "1000";
	}
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.vouchers.create");
$icon = "vouchers_create.png";
$description = $lang->loc['vouchers.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/vouchers?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="voucher">'.$lang->loc['voucher'].':</label><br />
<input type="text" name="voucher" value="'.$input->HoloText($row['voucher']).'" title="'.$lang->loc['voucher.desc'].'" /><br />
<label for="type">'.$lang->loc['type'].':</label><br />
<select name="type" title="'.$lang->loc['type.desc'].'"><option value="0"'.$selected[0].'>'.$lang->loc['item'].'<option value="1"'.$selected[1].'>'.$lang->loc['credits'].'</option></select><br />
<label for="value">'.$lang->loc['value'].':</label><br />
<input type="text" name="value" value="'.$input->HoloText($row['value']).'" title="'.$lang->loc['value.desc'].'" /><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
break;
case "remove":
$lang->addLocale("housekeeping.vouchers.remove");
$icon = "vouchers_remove.png";
$description = $lang->loc['vouchers.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['voucher']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/vouchers?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.vouchers.display");
$icon = "vouchers.png";
$description = $lang->loc['vouchers.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['type'].'</th>
<th width="250">'.$lang->loc['voucher'].'</th>
<th width="150">'.$lang->loc['data'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $data->select9();
$i = 0;
while($row = $serverdb->fetch_row($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/vouchers?do=create&id='.$row[0].'">'.$row[1].'</a></td>
<td><a href="'.PATH.'/housekeeping/vouchers?do=create&id='.$row[0].'">'.$row[0].'</a></td>
<td><a href="'.PATH.'/housekeeping/vouchers?do=create&id='.$row[0].'">'.$row[2].'</a></td>
<td class="action"><a href="'.PATH.'/housekeeping/vouchers?do=create&id='.$row[0].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/vouchers?do=remove&id='.$row[0].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/vouchers?do=create\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.vouchers']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.vouchers']; ?></span>
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
<form name="furni_search" action="<?php echo PATH; ?>/housekeeping/vouchers" method="POST">
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