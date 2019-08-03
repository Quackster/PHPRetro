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
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;
$lang->addLocale("groups.settings.save");
$lang->addLocale("ajax.buttons");

$name = $input->FilterText($_POST['name']);
$description = $input->FilterText($_POST['description']);
$id = $input->FilterText($_POST['groupId']);
$type = $input->FilterText($_POST['type']);
$url = $input->FilterText($_POST['url']);
$forumType = $input->FilterText($_POST['forumType']);
$newTopicPermission = $input->FilterText($_POST['newTopicPermission']);
$roomId = $input->FilterText($_POST['roomId']);

$grouprow = $db->fetch_row($data->select14($id));
$memberrow = $serverdb->fetch_row($data->select15($user->id,$grouprow[0]));

if($memberrow[2] != 3){ $error = true; }
if($grouprow[10] != "" && $grouprow[10] != $url){ $error = true; }
if($grouprow[5] != $type && $grouprow[5] == 3){ $error = true; }
$url_correct = $input->stringToURL($url,false,false);
if($url != $url_correct){ $url = ""; }
if($serverdb->num_rows($data->select18($url)) > 0){ $url = ""; }
$url = strtolower($url);

if($error != true && strlen($name) < 31 && strlen($description) < 256 && strlen($url) < 31 && (is_numeric($type) && ($type > -1 && $type < 4)) && (is_numeric($forumType) && ($forumType > -1 && $forumType < 2)) && (is_numeric($newTopicPermission) && ($newTopicPermission > -1 && $newTopicPermission < 3))){
	$data->update3($id,$name,$description,$type,$url,$forumType,$newTopicPermission,$roomId);
}
?>
<?php echo $lang->loc['saved.successful']; ?>

<p>
<a href="<?php echo groupURL($input->HoloText($id)); ?>" class="new-button"><b><?php echo $lang->loc['done']; ?></b><i></i></a>
</p>

<div class="clear"></div>