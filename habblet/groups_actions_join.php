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
$lang->addLocale("groups.requests.join");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['groupId']);

$memberrow = $db->fetch_row($data->select15($user->id,$id));
$grouprow = $db->fetch_row($data->select14($id));

$count = $serverdb->num_rows($data->select16($id));
$count = $count + $serverdb->num_rows($data->select16($id,"",0,0,1));

if($memberrow[2] != ""){ $error = true; $message = $lang->loc['already.member']; }
if($grouprow[5] != 3 && $count > 5000){ $error = true; $message = $lang->loc['group.limit.reached']; }
if($error != true){
	if($grouprow[5] == 1){ $pending = 1; $rank = 0; $message = $lang->loc['membership.request.sent']; }else{ $pending = 0; $rank = 1; $message = $lang->loc['joined.group']; }
	if($grouprow[5] != 2){ $data->insert2($user->id,$id,$pending,$rank); }
}
?>
<p>
<?php echo $message; ?>
</p>

<p>
<a href="#" class="new-button" id="group-action-ok"><b><?php echo $lang->loc['ok']; ?></b><i></i></a>
</p>

<div class="clear"></div>