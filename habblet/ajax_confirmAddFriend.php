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
$lang->addLocale("searchhabbos.confirmaddfriend");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['accountId']);
?>
<p>
<?php echo $lang->loc['confirm.add']." ".$serverdb->result($data->select6($id), 0)." ".$lang->loc['to.friend.list']; ?>
</p>

<p>
<a href="#" class="new-button done"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
<a href="#" class="new-button add-continue"><b><?php echo $lang->loc['continue']; ?></b><i></i></a></p>