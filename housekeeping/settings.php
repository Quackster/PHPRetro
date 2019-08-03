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
$page['rank'] = 7;
require_once('../includes/core.php');
require_once('./includes/hksession.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.settings");

$sql = $db->query("SELECT * FROM ".PREFIX."settings_pages WHERE id = '".$input->FilterText($_GET['page'])."' LIMIT 1");

if(!isset($_GET['page']) || $db->num_rows($sql) < 1){
	header("HTTP/1.0 404 Not Found");
	require_once('./error.php');
	exit;
}else{
	$pagerow = $db->fetch_assoc($sql);
}

$page['name'] = $pagerow['name'];
$page['category'] = "settings";
require_once('./templates/housekeeping_header.php');
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/<?php echo $pagerow['icon']; ?>" class="pticon">
 <span class="page_name_shadow"><?php echo $pagerow['name']; ?></span>

 <span class="page_name"><?php echo $pagerow['name']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%">
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
<div class="text">
<?php echo $pagerow['description']; ?>
</div>
</td>
 <td class="page_main_right">
<div class="center">
<?php
if(isset($_POST['save'])){
	foreach($_POST as $key => $value){
		$value = $input->FilterText($value);
		$db->query("UPDATE ".PREFIX."settings SET value = '".$value."' WHERE id = '".$key."' LIMIT 1");
	}
	$settings->generateCache();
?>
	<div class="clean-ok">Settings saved.</div>
<?php } ?>
<div class="settings">
<form name="settings" action="<?php echo PATH; ?>/housekeeping/settings/<?php echo $pagerow['id']; ?>" method="POST">
<?php
$sql = $db->query("SELECT category FROM ".PREFIX."settings WHERE page = '".$pagerow['id']."' GROUP BY category ORDER BY `order` ASC");
while($row = $db->fetch_assoc($sql)){
	echo "<h1>".$row['category']."</h1>\n";
	$sql2 = $db->query("SELECT * FROM ".PREFIX."settings WHERE category = '".$row['category']."' AND page = '".$pagerow['id']."' ORDER BY `order` ASC");
	while($row2 = $db->fetch_assoc($sql2)){
		echo "<label for=\"".$row2['id']."\">".$row2['label'].":</label><br />\n";
		switch($row2['type']){
			case "textbox":
				echo '<input type="text" name="'.$row2['id'].'" id="'.$row2['id'].'" value="'.$input->HoloText($row2['value'],true).'" title="'.$input->HoloText($row2['description'],true).'"></input><br />'; echo "\n";
				break;
			case "radiobuttons":
				$values = explode(";",$row2['values']);
				foreach($values as $value){
					$value = explode(",",$value);
					if($value[0] == $row2['value']){ $value[2] = " checked=\"true\""; }
					echo '<input type="radio" class="radio" name="'.$row2['id'].'" id="'.$row2['id'].'" value="'.$value[0].'"'.$value[2].' title="'.$input->HoloText($row2['description'],true).'">'.$value[1].'</input> ';
				}
				echo "<br />\n";
				break;
			case "selectbox":
				echo "<select name=\"".$row2['id']."\" title=\"".$input->HoloText($row2['description'],true)."\">";
				$values = explode(";",$row2['values']);
				foreach($values as $value){
					$value = explode(",",$value);
					if($value[0] == $row2['value']){ $value[2] = " selected=\"true\""; }
					echo '<option value="'.$value[0].'"'.$value[2].'>'.$value[1].'</option>';
				}
				echo "</select><br />\n";
				break;
			case "textarea":
				echo '<textarea name="'.$row2['id'].'" title="'.$input->HoloText($row2['description'],true).'">'.$input->HoloText($row2['value'],true).'</textarea><br />';
				break;
		}
	}
}
?>
<div class="button"><input type="submit" name="save" value="<?php echo $lang->loc['save']; ?>" /></div>
</form>
</div>
</div>
</td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>