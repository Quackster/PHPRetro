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
$lang->addLocale("homes.store");
$lang->addLocale("ajax.buttons");

$type = $input->FilterText($_POST['type']);

if(!isset($_POST['type'])){ $type = "stickers"; }

if($_SESSION['page_edit'] == "home"){ $where = '> -1'; }else{ $where = '< 1'; }

$sql = $db->query("SELECT ".PREFIX."homes_catalogue.data,".PREFIX."homes_catalogue.name,".PREFIX."homes.id FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.ownerid = '".$user->id."' AND ".PREFIX."homes_catalogue.type = '1' AND ".PREFIX."homes.location = '-1' AND ".PREFIX."homes_catalogue.id = ".PREFIX."homes.itemid GROUP BY ".PREFIX."homes.itemid AND ".PREFIX."homes_catalogue.where ".$where." ORDER BY ".PREFIX."homes.id DESC LIMIT 1");
$first = $db->fetch_row($sql);
if($first[0] != ""){ header('X-JSON: [["'.$lang->loc['inventory'].'","'.$lang->loc['web.store'].'"],["'.formatItem(1,$first[0],true).'","'.formatItem(0,$first[0],false).'","'.$input->HoloText($first[1]).'","'.$lang->loc['stickers'].'",null,1]]'); }else{ header('X-JSON: [["'.$lang->loc['inventory'].'","'.$lang->loc['web.store'].'"],[]]'); }

switch($type){
	case "stickers": $type = 1; break;
	case "backgrounds": $type = 4; break;
	case "widgets": $type = 2; break;
	case "notes": $type = 3; break;
}

$empty = true;
$first['id'] = -1;
require_once('./habblet/myhabbo_store_main.php');
?>
<div id="webstore-content-container">
	<div id="webstore-items-container">
		<h4><?php echo $lang->loc['select.item.by.clicking']; ?></h4>
		<div id="webstore-items"><ul id="webstore-item-list">
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
</ul></div>
	</div>
	<div id="webstore-preview-container">
		<div id="webstore-preview-default"></div>
		<div id="webstore-preview"></div>
	</div>
</div>

<div id="inventory-categories-container">
	<h4><?php echo $lang->loc['categories']; ?>:</h4>
	<div id="inventory-categories">
<ul class="purchase-main-category">
	<li id="inv-cat-stickers" class="selected-main-category-no-subcategories">
		<div><?php echo $lang->loc['stickers']; ?></div>
	</li>
	<li id="inv-cat-backgrounds" class="main-category-no-subcategories">
		<div><?php echo $lang->loc['backgrounds']; ?></div>
	</li>
	<li id="inv-cat-widgets" class="main-category-no-subcategories">
		<div><?php echo $lang->loc['widgets']; ?></div>
	</li>
	<li id="inv-cat-notes" class="main-category-no-subcategories">
		<div><?php echo $lang->loc['notes']; ?></div>
	</li>
</ul>

	</div>
</div>

<div id="inventory-content-container">
	<div id="inventory-items-container">
		<h4><?php echo $lang->loc['select.item.by.clicking']; ?></h4>
		<div id="inventory-items">
		<?php
		$page['bypass'] = true;
		require_once('./habblet/myhabbo_store_inventory_items.php');
		?>
		</div>
	</div>
	<div id="inventory-preview-container">
		<div id="inventory-preview-default"></div>
		<div id="inventory-preview">
		<?php
		$page['bypass'] = true;
		$id = $first[2];
		$type = 1;
		require_once('./habblet/myhabbo_store_inventory_preview.php');
		?>

</div>
	</div>
</div>

<div id="webstore-close-container">
	<div class="clearfix"><a href="#" id="webstore-close" class="new-button"><b><?php echo $lang->loc['close']; ?></b><i></i></a></div>
</div>
</div>