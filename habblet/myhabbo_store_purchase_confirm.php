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
$lang->addLocale("homes.store.purchase.confirm");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['productId']);
$subcategory = $input->FilterText($_POST['subCategoryId']);

$sql = $db->query("SELECT type,data FROM ".PREFIX."homes_catalogue WHERE id = '".$id."' LIMIT 1");
$row = $db->fetch_assoc($sql);
?>

<div class="webstore-item-preview <?php echo formatItem($row['type'],$row['data'],true); ?>
	>
	<div class="webstore-item-mask">
		
	</div>
</div>

<p>
<?php echo $lang->loc['store.purchase.confirm']; ?>
</p>

<p class="new-buttons">
<a href="#" class="new-button" id="webstore-confirm-cancel"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
<a href="#" class="new-button" id="webstore-confirm-submit"><b><?php echo $lang->loc['continue']; ?></b><i></i></a>
</p>

<div class="clear"></div>