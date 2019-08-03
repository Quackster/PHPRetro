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
$id = $input->FilterText($_POST['groupId']);
$targets = explode(",", $_POST['targetIds']);
$data = new home_sql;

$lang->addLocale("groups.members.batch");
$lang->addLocale("ajax.buttons");
?>
<p>
<?php echo $lang->loc['sure.give.rights']; ?> <?php echo count($targets); ?> <?php echo $lang->loc['members']; ?>
</p>

<p>
<a href="#" class="new-button" id="group-action-cancel"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
<a href="#" class="new-button" id="group-action-ok"><b><?php echo $lang->loc['ok']; ?></b><i></i></a>
</p>

<div class="clear"></div>