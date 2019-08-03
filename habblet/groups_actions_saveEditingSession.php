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

$page['dir'] = '\habblet';
$page['no_ajax'] = true;
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;

$groupid = $_SESSION['page_edit'];
$note = explode("/", $_POST['stickienotes']);
$widget = explode("/", $_POST['widgets']);
$sticker = explode("/", $_POST['stickers']);
$background = explode(":", $_POST['background']);

if(!empty($background[1])){
	$bg = $input->FilterText(str_replace("b_","",$background[1]));
	$id = $input->FilterText($background[0]);
	$db->query("UPDATE ".PREFIX."homes SET location = '".$groupid."' WHERE id = '".$id."' LIMIT 1");
}

foreach($sticker as $raw){
	$bits = explode(":", $raw);
	$id = $input->FilterText($bits[0]);
	$data = $input->FilterText($bits[1]);
	if(!empty($data) && !empty($id) && is_numeric($id)){
		$coordinates = explode(",", $data);
		$x = $coordinates[0];
		$y = $coordinates[1];
		$z = $coordinates[2];
		if(is_numeric($x) && is_numeric($y) && is_numeric($z)){;
			$db->query("UPDATE ".PREFIX."homes SET x = '".$x."', y = '".$y."', z = '".$z."', location = '".$groupid."' WHERE id = '".$id."' LIMIT 1");
		}
	}
}

foreach($note as $raw){
	$bits = explode(":", $raw);
	$id = $bits[0];
	$data = $input->FilterText($bits[1]);
	if(!empty($data) && !empty($id) && is_numeric($id)){
		$coordinates = explode(",", $data);
		$x = $coordinates[0];
		$y = $coordinates[1];
		$z = $coordinates[2];
		if(is_numeric($x) && is_numeric($y) && is_numeric($z)){
			$db->query("UPDATE ".PREFIX."homes SET x = '".$x."', y = '".$y."', z = '".$z."', location = '".$groupid."' WHERE id = '".$id."' LIMIT 1");
		}
	}
}

foreach($widget as $raw){
	$bits = explode(":", $raw);
	$id = $bits[0];
	$data = $input->FilterText($bits[1]);
	if(!empty($data) && !empty($id) && is_numeric($id)){
		$coordinates = explode(",", $data);
		$x = $coordinates[0];
		$y = $coordinates[1];
		$z = $coordinates[2];
		if(is_numeric($x) && is_numeric($y) && is_numeric($z)){
			$db->query("UPDATE ".PREFIX."homes SET x = '".$x."', y = '".$y."', z = '".$z."', location = '".$groupid."' WHERE id = '".$id."' LIMIT 1");
		}
	}
}

$db->query("UPDATE ".PREFIX."homes SET location = '".$groupid."' WHERE location = '-".$groupid."'");

$db->query("DELETE FROM ".PREFIX."homes_edit WHERE pageid = '".$groupid."' AND editorid = '".$user->id."' AND `type` = 'group' LIMIT 1");
unset($_SESSION['page_edit']);
?>
<script language="JavaScript" type="text/javascript">
waitAndGo('<?php echo groupURL($groupid); ?>');
</script>