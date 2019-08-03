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
$lang->addLocale("housekeeping.banners");

$page['name'] = $lang->loc['pagename.banners'];
$page['category'] = "tools";
require_once('./templates/housekeeping_header.php');

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	$row['banner'] = str_replace("%path%",PATH,$row['banner']);
	$row['url'] = str_replace("%path%",PATH,$row['url']);
	$selected[(int) $row['status']] = ' checked="true"';
	if(!empty($row['html'])){ $row['advanced'] = "1"; }
	if(empty($row['order'])){ $error = $lang->loc['error.no.order']."<br />"; }
	if(!isset($row['status'])){ $error = $lang->loc['error.no.status']."<br />"; }
	if(empty($row['text']) && empty($row['banner']) && empty($row['html'])){ $error = $lang->loc['error.no.data']; }
	if(empty($error)){
		if(!empty($row['id'])){
			$db->query("UPDATE ".PREFIX."banners SET id = '".$input->FilterText($row['order'])."', text = '".$input->FilterText($row['text'], true)."', banner = '".$input->FilterText($row['banner'], true)."', url = '".$input->FilterText($row['url'])."', status = '".$input->FilterText($row['status'])."', advanced = '".$input->FilterText($row['advanced'])."', html = '".$input->FilterText($row['html'], true)."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
			$message = $lang->loc['message.banner.modified'];
		}else{
			$db->query("INSERT INTO ".PREFIX."banners (id,text,banner,url,status,advanced,html) VALUES ('".$input->FilterText($row['order'])."','".$input->FilterText($row['text'], true)."','".$input->FilterText($row['banner'], true)."','".$input->FilterText($row['url'])."','".$input->FilterText($row['status'])."','".$input->FilterText($row['advanced'])."','".$input->FilterText($row['html'],true)."')");
			$message = $lang->loc['message.banner.created'];
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$db->query("DELETE FROM ".PREFIX."banners WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.banner.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."banners WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$selected[(int) $row['status']] = ' checked="true"';
	$row['order'] = $row['id'];
}elseif(empty($row)){
	$row['order'] = (int) $db->result($db->query("SELECT MAX(id) FROM ".PREFIX."banners LIMIT 1")) + 1;
	$row['status'] = "1";
	$selected[1] = ' checked="true"';
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.banners.create");
$icon = "banners_create.png";
$description = $lang->loc['banners.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/banners?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="order">'.$lang->loc['order'].':</label><br />
<input type="text" name="order" value="'.$input->HoloText($row['order']).'" title="'.$lang->loc['order.desc'].'" /><br />
<label for="status">'.$lang->loc['status'].':</label><br />
<input type="radio" class="radio" name="status" value="1"'.$selected[1].' title="'.$lang->loc['status.desc'].'">'.$lang->loc['on'].'</input> <input type="radio" class="radio" name="status" value="0"'.$selected[0].' title="'.$lang->loc['status.desc'].'">'.$lang->loc['off'].'</input><br />
<h1>'.$lang->loc['express'].'</h1>
<label for="text">'.$lang->loc['text'].':</label><br />
<input type="text" name="text" value="'.$input->HoloText($row['text']).'" title="'.$lang->loc['text.desc'].'" /><br />
<label for="banner">'.$lang->loc['banner'].':</label><br />
<input type="text" name="banner" value="'.$input->HoloText($row['banner']).'" title="'.$lang->loc['banner.desc'].'" /><br />
<label for="url">'.$lang->loc['url'].':</label><br />
<input type="text" name="url" value="'.$input->HoloText($row['url']).'" title="'.$lang->loc['url.desc'].'" /><br />
<h1>'.$lang->loc['advanced'].'</h1>
<label for="html">'.$lang->loc['html'].':</label><br />
<textarea name="html" title="'.$lang->loc['html.desc'].'">'.$input->HoloText($row['html'],true).'</textarea><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
break;
case "remove":
$lang->addLocale("housekeeping.banners.remove");
$icon = "banners_remove.png";
$description = $lang->loc['banners.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['id']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/banners?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.banners.display");
$icon = "banners.png";
$description = $lang->loc['banners.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['order'].'</th>
<th width="250">'.$lang->loc['data'].'</th>
<th width="150">'.$lang->loc['status'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."banners ORDER BY id ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/banners?do=create&id='.$row['id'].'">'.$row['id'].'</a></td>
<td><a href="'.PATH.'/housekeeping/banners?do=create&id='.$row['id'].'">'; if($row['advanced'] == "1"){ $content .= "HTML"; }else{ $content .= $input->HoloText($row['banner']); } $content .= '</a></td>';
$content .= '<td>'.$row['status'].'</td>
<td class="action"><a href="'.PATH.'/housekeeping/banners?do=create&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/banners?do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/banners?do=create\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.banners']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.banners']; ?></span>
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