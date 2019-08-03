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
$lang->addLocale("housekeeping.news");

$page['name'] = $lang->loc['pagename.news'];
$page['category'] = "tools";
require_once('./templates/housekeeping_header.php');

if(isset($_GET['do']) && $_GET['do'] == "save"){
	$row = $_POST;
	$row['header_image'] = str_replace("%path%",PATH,$row['header_image']);
	$row['images'] = str_replace("%path%",PATH,$row['images']);
	if(empty($row['title'])){ $error = $lang->loc['error.no.title']."<br />"; }
	if(empty($row['header_image'])){ $error = $lang->loc['error.no.image']."<br />"; }
	if(empty($row['author'])){ $error = $lang->loc['error.no.author']; }
	if(empty($error)){
		if(!empty($row['id'])){
			$db->query("UPDATE ".PREFIX."news SET title = '".$input->FilterText($row['title'])."', categories = '".$input->FilterText($row['categories'])."', header_image = '".$input->FilterText($row['header_image'])."', summary = '".nl2br($input->FilterText($row['summary']))."', story = '".nl2br($input->FilterText($row['story']))."', author = '".$input->FilterText($row['author'])."', images = '".$input->FilterText($row['images'])."' WHERE id = '".$input->FilterText($row['id'])."' LIMIT 1");
			$message = $lang->loc['message.article.modified'];
		}else{
			$db->query("INSERT INTO ".PREFIX."news (title,categories,header_image,summary,story,time,author,images) VALUES ('".$input->FilterText($row['title'])."','".$input->FilterText($row['categories'])."','".$input->FilterText($row['header_image'])."','".nl2br($input->FilterText($row['summary']))."','".nl2br($input->FilterText($row['story']))."','".time()."','".$input->FilterText($row['author'])."','".$input->FilterText($row['images'])."')");
			$message = $lang->loc['message.article.created'];
		}
		unset($_POST); unset($_GET);
	}else{
		$_GET['do'] = "create";
	}
}elseif($_GET['do'] == "remove"){
	if(isset($_POST['id']) && isset($_POST['remove'])){
		$db->query("DELETE FROM ".PREFIX."news WHERE id = '".$input->FilterText($_POST['id'])."' LIMIT 1");
		unset($_POST); unset($_GET);
		$message = $lang->loc['message.article.removed'];
	}
}
if((isset($_GET['id']) || isset($_POST['id'])) && empty($row)){
	$sql = $db->query("SELECT * FROM ".PREFIX."news WHERE id = '".$input->FilterText($_GET['id'])."' LIMIT 1");
	$row = $db->fetch_assoc($sql);
}elseif(empty($row)){
	$row['header_image'] = "%path%/web-gallery/images/top-story/construction.png";
	$row['author'] = $user->name;
}

switch($_GET['do']){
case "create":
$lang->addLocale("housekeeping.news.create");
$icon = "news_create.png";
$description = $lang->loc['news.create.desc'];
$content = "";
if(!empty($error)){ $content .= '<div class="clean-error">'.$error.'</div>'; }
$content .= 
'<div class="settings">
<form name="settings" action="'.PATH.'/housekeeping/news?do=save" method="POST">';
if(!empty($row['id'])){ $content .= '<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />'; }
$content .= 
'<label for="title">'.$lang->loc['title'].':</label><br />
<input type="text" name="title" value="'.$input->HoloText($row['title']).'" title="'.$lang->loc['title.desc'].'" /><br />
<label for="categories">'.$lang->loc['categories'].':</label><br />
<input type="text" name="categories" value="'.$input->HoloText($row['categories']).'" title="'.$lang->loc['categories.desc'].'" /><br />
<label for="header_image">'.$lang->loc['header.image'].':</label><br />
<input type="text" name="header_image" value="'.$input->HoloText($row['header_image']).'" title="'.$lang->loc['header.image.desc'].'" /><br />
<label for="summary">'.$lang->loc['summary'].':</label><br />
<textarea name="summary" title="'.$lang->loc['summary.desc'].'">'.$input->HoloText($row['summary'],true).'</textarea><br />
<label for="story">'.$lang->loc['story'].':</label><br />
<textarea name="story" title="'.$lang->loc['story.desc'].'">'.$input->HoloText($row['story'],true).'</textarea><br />
<label for="images">'.$lang->loc['images'].':</label><br />
<input type="text" name="images" value="'.$input->HoloText($row['images']).'" title="'.$lang->loc['images.desc'].'" /><br />
<label for="author">'.$lang->loc['author'].':</label><br />
<input type="text" name="author" value="'.$input->HoloText($row['author']).'" title="'.$lang->loc['author.desc'].'" /><br />
<div class="button"><input type="submit" name="save" value="'.$lang->loc['save'].'" /></div>
</form>
</div>';
break;
case "remove":
$lang->addLocale("housekeeping.news.remove");
$icon = "news_remove.png";
$description = $lang->loc['news.remove.desc'];
$content = 
'<div class="clean-yellow">'.$lang->loc['confirm.remove'].' "'.$input->HoloText($row['title']).'"?</div>
<form name="settings" action="'.PATH.'/housekeeping/news?do=remove" method="POST">
<input type="hidden" name="id" value="'.$input->HoloText($row['id']).'" />
<div class="button"><input type="submit" name="remove" value="'.$lang->loc['remove'].'" /></div>
</form>';
break;
default:
$lang->addLocale("housekeeping.news.display");
$icon = "news.png";
$description = $lang->loc['news.display.desc'];
$content = "";
if(isset($message) && !empty($message)){ $content .= '<div class="clean-ok">'.$message.'</div>'; }
$content .= 
'<div class="contentdisplay">
<table height="100%"><tbody>
<tr class="header">
<th width="50">'.$lang->loc['id'].'</th>
<th width="250">'.$lang->loc['title'].'</th>
<th width="150">'.$lang->loc['date'].'</th>
<th width="50">'.$lang->loc['actions'].'</th>
</tr>';
$sql = $db->query("SELECT * FROM ".PREFIX."news ORDER BY time DESC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = ' class="even"'; }else{ $even = ''; }
$content .= 
'<tr'.$even.'>
<td><a href="'.PATH.'/housekeeping/news?do=create&id='.$row['id'].'">'.$row['id'].'</a></td>
<td><a href="'.PATH.'/housekeeping/news?do=create&id='.$row['id'].'">'.$input->HoloText($row['title']).'</a></td>
<td>'.date('n/j/Y g:i A',$row['time']).'</td>
<td class="action"><a href="'.PATH.'/housekeeping/news?do=create&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/edit.png" alt="'.$lang->loc['edit'].'" title="'.$lang->loc['edit'].'" /></a><a href="'.PATH.'/housekeeping/news?do=remove&id='.$row['id'].'"><img src="'.PATH.'/housekeeping/images/icons/remove.png" alt="'.$lang->loc['remove'].'" title="'.$lang->loc['remove'].'" /></a></td>
</tr>';
}
$content .= 
'</tbody></table>
<div class="button"><input type="button" value="'.$lang->loc['new'].'" onclick="window.location.href=\''.PATH.'/housekeeping/news?do=create\'"></input></div>
</div>';
break;
}
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $icon; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.news']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.news']; ?></span>
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