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
$data = new me_sql;
$lang->addLocale("minimail.report.confirm");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['messageId']);

$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE id = '".$id."' LIMIT 1");
$row = $db->fetch_assoc($sql);

if($row['senderid'] == $user->id){
	$error = 1;
	$message = $lang->loc['report.error.1'];
}

if($error == 1){
?>
<ul class="error">
	<li><?php echo $message; ?></li>
</ul>

<p>
<a href="#" class="new-button cancel-report"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
</p>
<?php
} else {
?>
<p>
<?php echo $lang->loc['report.1']; ?> <b><?php echo $row['subject']; ?></b> <?php echo $lang->loc['report.2']; ?> <b><?php echo $serverdb->result($data->select6($row['senderid'])); ?></b> <?php echo $lang->loc['report.3']; ?>
</p>

<p>
<a href="#" class="new-button cancel-report"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
<a href="#" class="new-button send-report"><b><?php echo $lang->loc['send.report']; ?></b><i></i></a>
</p>
<?php } ?>