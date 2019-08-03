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
$lang->addLocale("housekeeping.catalogue");

$page['name'] = $lang->loc['pagename.catalogue'];
$page['category'] = "tools";
require_once('./templates/housekeeping_header.php');

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	if(empty($row['data'])){ $error = $lang->loc['error.no.data']."<br />"; }
	if(empty($row['price']) || !is_numeric($row['price'])){ $error = $lang->loc['invalid.price']."<br />"; }
	if(empty($row['amount']) || !is_numeric($row['amount'])){ $error = $lang->loc['invalid.amount']."<br />"; }
	if(empty($row['minrank']) || !is_numeric($row['minrank'])){ $error = $lang->loc['invalid.minrank']."<br />"; }
	if($row['categoryid'] == "new"){
		if(empty($row['new_category'])){
			$error = $lang->loc['invalid.new.category'];
		}else{
			$id = (int) $db->result($db->query("SELECT MAX(id) FROM ".PREFIX."homes_catalogue LIMIT 1"));
			$row['categoryid'] = $id + 1;
			$row['category'] = $row['new_category'];
		}
	}else{
		$category = explode(",",$row['categoryid'],2);
		$row['categoryid'] = $category[0];
		$row['category'] = $category[1];
	}
	if(empty($error)){
		if(!empty($row['id'])){
			$db->query("UPDATE ".PREFIX."homes_catalogue SET name = '".$input->FilterText($row['name'])."', `desc` = '".$input->FilterText($row['desc'])."', `type` = '".$input->FilterText($row['type'])."', `data` = '".$input->FilterText($row['data'])."', price = '".$input->FilterText($row['price'])."', amount = '".$input->FilterText($row['amount'])."', category = '".$input->FilterText($row['category'])."', categoryid = '".$input->FilterText($row['categoryid'])."', minrank = '".$input->FilterText($row['minrank'])."', `where` = '".$input->FilterText($row['where'])."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
			$message = $lang->loc['message.item.modified'];
		}else{
			$db->query("INSERT INTO ".PREFIX."homes_catalogue (name,`desc`,`type`,`data`,price,amount,category,categoryid,minrank,`where`) VALUES ('".$input->FilterText($row['name'])."','".$input->FilterText($row['desc'])."','".$input->FilterText($row['type'])."','".$input->FilterText($row['data'])."','".$input->FilterText($row['price'])."','".$input->FilterText($row['amount'])."','".$input->FilterText($row['category'])."','".$input->FilterText($row['categoryid'])."','".$input->FilterText($row['minrank'])."','".$input->FilterText($row['where'])."')");
			$message = $lang->loc['message.item.created'];
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$db->query("DELETE FROM ".PREFIX."homes_catalogue WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.item.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."homes_catalogue WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$typeselected[(int) $row['type']] = ' selected="true"';
	$whereselected[(int) $row['where']] = ' selected="true"';
}elseif(empty($row)){
	$typeselected[1] = ' selected="true"';
	$whereselected[0] = ' selected="true"';
	$row['price'] = "2";
	$row['amount'] = "1";
	$row['minrank'] = "1";
	$row['categoryid'] = "new";
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.catalogue.create");
$icon = "catalogue_create.png";
$description = $lang->loc['catalogue.create.desc'];
if(!empty($row['new_category'])){ $newselected = ' selected="true"'; }
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/catalogue?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="name">'.$lang->loc['name'].':</label><br />
<input type="text" name="name" value="'.$input->HoloText($row['name']).'" title="'.$lang->loc['name.desc'].'" /><br />
<label for="desc">'.$lang->loc['description'].':</label><br />
<input type="text" name="desc" value="'.$input->HoloText($row['desc']).'" title="'.$lang->loc['description.desc'].'" /><br />
<label for="type">'.$lang->loc['type'].':</label><br />
<select name="type" title="'.$lang->loc['type.desc'].'"><option value="1"'.$typeselected[1].'>'.$lang->loc['sticker'].'</option><option value="4"'.$typeselected[4].'>'.$lang->loc['background'].'</option></select><br />
<label for="data">'.$lang->loc['data'].':</label><br />
<input type="text" name="data" value="'.$input->HoloText($row['data']).'" title="'.$lang->loc['data.desc'].'" /><br />
<label for="price">'.$lang->loc['price'].':</label><br />
<input type="text" name="price" value="'.$input->HoloText($row['price']).'" title="'.$lang->loc['price.desc'].'" /><br />
<label for="amount">'.$lang->loc['amount'].':</label><br />
<input type="text" name="amount" value="'.$input->HoloText($row['amount']).'" title="'.$lang->loc['amount.desc'].'" /><br />
<label for="minrank">'.$lang->loc['minrank'].':</label><br />
<input type="text" name="minrank" value="'.$input->HoloText($row['minrank']).'" title="'.$lang->loc['minrank.desc'].'" /><br />
<label for="where">'.$lang->loc['where'].':</label><br />
<select name="where" title="'.$lang->loc['where.desc'].'"><option value="-1"'.$whereselected[-1].'>'.$lang->loc['groups.only'].'</option><option value="0"'.$whereselected[0].'>'.$lang->loc['anywhere'].'</option><option value="1"'.$whereselected[1].'>'.$lang->loc['homes.only'].'</option></select><br />
<h2>'.$lang->loc['category'].'</h2>
<label for="categoryid">'.$lang->loc['category'].':</label><br />
<select name="categoryid" title="'.$lang->loc['category.desc'].'"><option value="new"'.$newselected.'>'.$lang->loc['new'].'</option>';
$sql = $db->query("SELECT categoryid,category FROM ".PREFIX."homes_catalogue WHERE type = '1' OR type = '4' GROUP BY categoryid ORDER BY category ASC");
while($row2 = $db->fetch_assoc($sql)){
if($row['categoryid'] == $row2['categoryid']){ $selected = ' selected="true"'; }
if($row['type'] == "1"){ $type = $lang->loc['sticker'].": "; }else{ $type = $lang->loc['background'].": "; }
$content .= '<option value="'.$row2['categoryid'].','.$row2['category'].'"'.$selected.'>'.$type.$row2['category'].'</option>';
}
$content .= 
'</select><br />
<label for="new_category">'.$lang->loc['new.category'].':</label><br />
<input type="text" name="new_category" value="'.$input->HoloText($row['new_category']).'" title="'.$lang->loc['new.category.desc'].'" /><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
break;
case "remove":
$lang->addLocale("housekeeping.catalogue.remove");
$icon = "catalogue_remove.png";
$description = $lang->loc['catalogue.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['name']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/catalogue?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.catalogue.display");
$icon = "catalogue.png";
$description = $lang->loc['catalogue.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="100">'.$lang->loc['type'].'</th>
<th width="150">'.$lang->loc['name'].'</th>
<th width="100">'.$lang->loc['data'].'</th>
<th width="100">'.$lang->loc['category'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."homes_catalogue WHERE type = '1' OR type = '4' ORDER BY type ASC, categoryid ASC, name ASC, data ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
if($row['type'] == "1"){ $type = $lang->loc['sticker']; }else{ $type = $lang->loc['background']; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/catalogue?do=create&id='.$row['id'].'">'.$type.'</a></td>
<td><a href="'.PATH.'/housekeeping/catalogue?do=create&id='.$row['id'].'">'.$input->HoloText($row['name']).'</a></td>
<td><a href="'.PATH.'/housekeeping/catalogue?do=create&id='.$row['id'].'">'.$input->HoloText($row['data']).'</a></td>
<td><a href="'.PATH.'/housekeeping/catalogue?do=create&id='.$row['id'].'">'.$input->HoloText($row['category']).'</a></td>
<td class="action"><a href="'.PATH.'/housekeeping/catalogue?do=create&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/catalogue?do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/catalogue?do=create\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.catalogue']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.catalogue']; ?></span>
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