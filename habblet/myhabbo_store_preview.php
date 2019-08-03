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

if($page['bypass'] != true){
$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');

$productid = $input->FilterText($_POST['productId']);
$subcategory = $input->FilterText($_POST['subCategoryId']);

$sql = $db->query("SELECT * FROM ".PREFIX."homes_catalogue WHERE id = '".$productid."' LIMIT 1");
$row = $db->fetch_assoc($sql);
if($row['type'] == 4){ $bg = '"bgCssClass":"'.formatItem($row['type'],$row['data'],false).'",'; }

header('X-JSON: [{'.$bg.'"itemCount":'.$row['amount'].',"previewCssClass":"'.formatItem($row['type'],$row['data'],true).'","titleKey":"'.$input->HoloText($row['name']).'"}]');
}else{
$sql = $db->query("SELECT * FROM ".PREFIX."homes_catalogue WHERE id = '".$productid."' LIMIT 1");
$row = $db->fetch_assoc($sql);
}
$lang->addLocale("homes.store.preview");

if(($user->user("credits") - $row['price']) < 0){ $credits['not_enough'] = true; }
?>
<h4 title=""></h4>

<div id="webstore-preview-box"></div>

<div id="webstore-preview-price">
<?php echo $lang->loc['price']; ?>:<br /><b>
	<?php echo $row['price']; ?> <?php echo $lang->loc['credit']; ?>
	
</b>
</div>

<div id="webstore-preview-purse">
<?php echo $lang->loc['you.have']; ?>:<br /><b><?php echo $user->user("credits"); ?> <?php echo $lang->loc['credit']; ?></b><br />
<?php if($credits['not_enough'] == true){ ?><span class="webstore-preview-error"><?php echo $lang->loc['not.enough.credits']; ?></span><br /><?php } ?>
<a href="<?php echo PATH; ?>/credits" target=_blank><?php echo $lang->loc['get.credits']; ?></a>
</div>

<div id="webstore-preview-purchase" class="clearfix">
	<div class="clearfix">
		<?php if($credits['not_enough'] == true){ ?><a href="#" class="new-button disabled-button" disabled="disabled" id="webstore-purchase-disabled"><?php }else{ ?><a href="#" class="new-button" id="webstore-purchase"><?php } ?><b><?php echo $lang->loc['purchase']; ?></b><i></i></a>
	</div>
</div>

<span id="webstore-preview-bg-text" style="display: none"><?php echo $lang->loc['preview']; ?></span>