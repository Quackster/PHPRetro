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
$type = $_GET['type'];

switch($type){
case "startSession":
$sql = $db->query("SELECT * FROM ".PREFIX."homes_edit WHERE pageid = '".$user->id."' AND `type` = 'user' LIMIT 1");
if($db->num_rows($sql) == 0 && $_GET['id'] == $user->id){ $db->query("INSERT INTO ".PREFIX."homes_edit (pageid,editorid,`type`,time) VALUES ('".$user->id."','".$user->id."','user','".time()."')"); }
break;
case "cancel":
$db->query("DELETE FROM ".PREFIX."homes_edit WHERE pageid = '".$user->id."' AND `type` = 'user' LIMIT 1");
$db->query("DELETE FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id AND ".PREFIX."homes.location = '-2' AND ".PREFIX."homes_catalogue.type = '2' AND ".PREFIX."homes.ownerid = '".$user->id."'");
$db->query("UPDATE ".PREFIX."homes SET x = '1', y = '1', z = '1', location = '-1', skin = 'defaultskin', variable = '' WHERE location = '-2' AND ownerid = '".$user->id."'");
unset($_SESSION['page_edit']);
break;
case "save":
$note = explode("/", $_POST['stickienotes']);
$widget = explode("/", $_POST['widgets']);
$sticker = explode("/", $_POST['stickers']);
$background = explode(":", $_POST['background']);

if(!empty($background[1])){
	$bg = $input->FilterText(str_replace("b_","",$background[1]));
	$id = $input->FilterText($background[0]);
	$db->query("UPDATE ".PREFIX."homes SET location = '0' WHERE id = '".$id."' AND ownerid = '".$user->id."' LIMIT 1");
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
			$db->query("UPDATE ".PREFIX."homes SET x = '".$x."', y = '".$y."', z = '".$z."', location = '0' WHERE id = '".$id."' AND ownerid = '".$user->id."' LIMIT 1");
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
			$db->query("UPDATE ".PREFIX."homes SET x = '".$x."', y = '".$y."', z = '".$z."', location = '0' WHERE id = '".$id."' AND ownerid = '".$user->id."' LIMIT 1");
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
			$db->query("UPDATE ".PREFIX."homes SET x = '".$x."', y = '".$y."', z = '".$z."', location = '0' WHERE id = '".$id."' AND ownerid = '".$user->id."' LIMIT 1");
		}
	}
}

$db->query("UPDATE ".PREFIX."homes SET location = '0' WHERE location = '-2' AND ownerid = '".$user->id."'");

$db->query("DELETE FROM ".PREFIX."homes_edit WHERE pageid = '".$user->id."' AND `type` = 'user' LIMIT 1");
unset($_SESSION['page_edit']);
?>
<script language="JavaScript" type="text/javascript">
waitAndGo('<?php echo PATH; ?>/home/<?php echo $user->name; ?>');
</script>
<?php
exit;
break;
}
header('Location: '.PATH.'/home/'.$user->name);
?>