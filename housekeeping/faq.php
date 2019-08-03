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
$lang->addLocale("housekeeping.faq");

$page['name'] = $lang->loc['pagename.faq'];
$page['category'] = "tools";
require_once('./templates/housekeeping_header.php');

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	if(empty($row['title'])){ $error = $lang->loc['error.no.title']; }
	if(empty($error)){
		if(!empty($row['id'])){
			if($_GET['type'] == "cat"){
			$db->query("UPDATE ".PREFIX."faq SET title = '".$input->FilterText($row['title'])."', show_in_footer = '".$input->FilterText($row['show_in_footer'])."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
			$message = $lang->loc['message.cat.modified'];
			}else{
			$db->query("UPDATE ".PREFIX."faq SET title = '".$input->FilterText($row['title'])."', show_in_footer = '".$input->FilterText($row['show_in_footer'])."', catid = '".$input->FilterText($row['catid'])."', content = '".nl2br($input->FilterText($row['content'],true))."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
			$message = $lang->loc['message.item.modified'];
			}
		}else{
			if($_GET['type'] == "cat"){
			$db->query("INSERT INTO ".PREFIX."faq (type,catid,title,content,show_in_footer) VALUES ('cat','0','".$input->FilterText($row['title'])."','','".$input->FilterText($row['show_in_footer'])."')");
			$message = $lang->loc['message.cat.created'];
			}else{
			$db->query("INSERT INTO ".PREFIX."faq (type,catid,title,content,show_in_footer) VALUES ('item','".$input->FilterText($row['catid'])."','".$input->FilterText($row['title'])."','".nl2br($input->FilterText($row['content'],true))."','".$input->FilterText($row['show_in_footer'])."')");
			$message = $lang->loc['message.item.created'];
			}
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$db->query("DELETE FROM ".PREFIX."faq WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		$message = $lang->loc['message.removed'];
		unset($_POST); unset($_GET);
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."faq WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$selected[(int) $row['show_in_footer']] = ' checked="true"';
}elseif(empty($row)){
	$row['show_in_footer'] = "0";
	$selected[0] = ' checked="true"';
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.faq.create");
$icon = "faq.png";
$description = $lang->loc['faq.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
if($_GET['type'] == "cat"){
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/faq?do=save&type=cat" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="title">'.$lang->loc['title'].':</label><br />
<input type="text" name="title" value="'.$input->HoloText($row['title']).'" title="'.$lang->loc['title.desc'].'" /><br />
<label for="show_in_footer">'.$lang->loc['show.in.footer'].':</label><br />
<input type="radio" class="radio" name="show_in_footer" title="'.$lang->loc['show.in.footer.desc'].'" value="0"'.$selected[0].'>'.$lang->loc['no'].'</input><input type="radio" class="radio" name="show_in_footer" title="'.$lang->loc['show.in.footer.desc'].'" value="1"'.$selected[1].'>'.$lang->loc['yes'].'</select><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
}else{
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/faq?do=save&type=item" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="catid">'.$lang->loc['catid'].':</label><br />
<input type="text" name="catid" value="'.$input->HoloText($row['catid']).'" title="'.$lang->loc['catid.desc'].'" /><br />
<label for="title">'.$lang->loc['title'].':</label><br />
<input type="text" name="title" value="'.$input->HoloText($row['title']).'" title="'.$lang->loc['title.desc'].'" /><br />
<label for="content">'.$lang->loc['content'].':</label><br />
<textarea name="content" title="'.$lang->loc['content.desc'].'">'.$input->HoloText($row['content'],true).'</textarea><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
}
break;
case "remove":
$lang->addLocale("housekeeping.faq.remove");
$icon = "faq.png";
$description = $lang->loc['faq.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['title']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/faq?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.faq.display");
$icon = "faq.png";
$description = $lang->loc['faq.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<h2>'.$lang->loc['categories'].'</h2>
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['id'].'</th>
<th width="400">'.$lang->loc['name'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."faq WHERE type = 'cat' ORDER BY id ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/faq?do=create&type=cat&id='.$row['id'].'">'.$row['id'].'</a></td>
<td><a href="'.PATH.'/housekeeping/faq?do=create&type=cat&id='.$row['id'].'">'.$row['title'].'</a></td>
<td class="action"><a href="'.PATH.'/housekeeping/faq?do=create&type=cat&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/faq?do=remove&type=cat&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/faq?do=create&type=cat\'"></input></div>
<h2>'.$lang->loc['items'].'</h2>
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['category'].'</th>
<th width="400">'.$lang->loc['title'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."faq WHERE type = 'item' ORDER BY catid ASC, id ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/faq?do=create&type=item&id='.$row['id'].'">'.$row['catid'].'</a></td>
<td><a href="'.PATH.'/housekeeping/faq?do=create&type=item&id='.$row['id'].'">'.$input->HoloText($row['title']).'</a></td>
<td class="action"><a href="'.PATH.'/housekeeping/faq?do=create&type=item&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/faq?do=remove&type=item&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/faq?do=create&type=item\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.faq']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.faq']; ?></span>
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