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
$lang->addLocale("housekeeping.campaigns");

$page['name'] = $lang->loc['pagename.campaigns'];
$page['category'] = "tools";
require_once('./templates/housekeeping_header.php');

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	$row['image'] = str_replace("%path%",PATH,$row['image']);
	$row['url'] = str_replace("%path%",PATH,$row['url']);
	$selected[(int) $row['visible']] = ' checked="true"';
	if(empty($row['order'])){ $error = $lang->loc['error.no.order']."<br />"; }
	if(!isset($row['visible'])){ $error = $lang->loc['error.no.status']."<br />"; }
	if(empty($row['image'])){ $error = $lang->loc['error.no.image']; }
	if(empty($error)){
		if(!empty($row['id'])){
			$db->query("UPDATE ".PREFIX."campaigns SET id = '".$input->FilterText($row['order'])."', url = '".$input->FilterText($row['url'])."', image = '".$input->FilterText($row['image'])."', name = '".$input->FilterText($row['name'])."', `desc` = '".nl2br($input->FilterText($row['desc']))."', visible = '".$input->FilterText($row['visible'])."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
			$message = $lang->loc['message.campaign.modified'];
		}else{
			$db->query("INSERT INTO ".PREFIX."campaigns (id,url,image,name,`desc`,visible) VALUES ('".$input->FilterText($row['order'])."','".$input->FilterText($row['url'])."','".$input->FilterText($row['image'])."','".$input->FilterText($row['name'])."','".nl2br($input->FilterText($row['desc']))."','".$input->FilterText($row['visible'])."')");
			$message = $lang->loc['message.campaign.created'];
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$db->query("DELETE FROM ".PREFIX."campaigns WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.campaign.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."campaigns WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$selected[(int) $row['visible']] = ' checked="true"';
	$row['order'] = $row['id'];
}elseif(empty($row)){
	$row['order'] = (int) $db->result($db->query("SELECT MAX(id) FROM ".PREFIX."campaigns LIMIT 1")) + 1;
	$row['visible'] = "1";
	$selected[1] = ' checked="true"';
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.campaigns.create");
$icon = "campaigns_create.png";
$description = $lang->loc['campaigns.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/campaigns?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="order">'.$lang->loc['order'].':</label><br />
<input type="text" name="order" value="'.$input->HoloText($row['order']).'" title="'.$lang->loc['order.desc'].'" /><br />
<label for="visible">'.$lang->loc['status'].':</label><br />
<input type="radio" class="radio" name="visible" value="1"'.$selected[1].' title="'.$lang->loc['status.desc'].'">'.$lang->loc['on'].'</input> <input type="radio" class="radio" name="visible" value="0"'.$selected[0].' title="'.$lang->loc['status.desc'].'">'.$lang->loc['off'].'</input><br />
<label for="name">'.$lang->loc['name'].':</label><br />
<input type="text" name="name" value="'.$input->HoloText($row['name']).'" title="'.$lang->loc['name.desc'].'" /><br />
<label for="desc">'.$lang->loc['desc'].':</label><br />
<input type="text" name="desc" value="'.$input->HoloText($row['desc']).'" title="'.$lang->loc['desc.desc'].'" /><br />
<label for="image">'.$lang->loc['image'].':</label><br />
<input type="text" name="image" value="'.$input->HoloText($row['image']).'" title="'.$lang->loc['image.desc'].'" /><br />
<label for="url">'.$lang->loc['url'].':</label><br />
<input type="text" name="url" value="'.$input->HoloText($row['url']).'" title="'.$lang->loc['url.desc'].'" /><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
break;
case "remove":
$lang->addLocale("housekeeping.campaigns.remove");
$icon = "campaigns_remove.png";
$description = $lang->loc['campaigns.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['name']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/campaigns?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.campaigns.display");
$icon = "campaigns.png";
$description = $lang->loc['campaigns.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['order'].'</th>
<th width="250">'.$lang->loc['name'].'</th>
<th width="150">'.$lang->loc['status'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."campaigns ORDER BY id ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/campaigns?do=create&id='.$row['id'].'">'.$row['id'].'</a></td>
<td><a href="'.PATH.'/housekeeping/campaigns?do=create&id='.$row['id'].'">'.$row['name'].'</a></td>';
$content .= '<td>'.$row['visible'].'</td>
<td class="action"><a href="'.PATH.'/housekeeping/campaigns?do=create&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/campaigns?do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/campaigns?do=create\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.campaigns']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.campaigns']; ?></span>
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