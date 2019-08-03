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

if($empty != true){
$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');
$lang->addLocale("homes.store");
$lang->addLocale("ajax.buttons");

$category = $input->FilterText($_POST['categoryId']);
$subcategory = $input->FilterText($_POST['subCategoryId']);

if(!isset($_POST['categoryId'])){ $category = 1; }
if(!isset($_POST['subCategoryId'])){ $subcategory = -1; }

if($_SESSION['page_edit'] == "home"){ $where = '> -1'; }else{ $where = '< 1'; }

$firstcategory = $db->result($db->query("SELECT category FROM ".PREFIX."homes_catalogue WHERE `where` ".$where." AND minrank <= '".$user->user("rank")."' AND type = '1' ORDER BY category ASC LIMIT 1"));
$sql = $db->query("SELECT amount,data,id FROM ".PREFIX."homes_catalogue WHERE type = '1' AND minrank <= '".$user->user("rank")."' AND `where` ".$where." AND category = '".$firstcategory."' ORDER BY id DESC LIMIT 1");
$first = $db->fetch_assoc($sql);
if($first['data'] != ""){ header('X-JSON: [["'.$lang->loc['inventory'].'","'.$lang->loc['web.store'].'"],[{"itemCount":'.$first['amount'].',"previewCssClass":"'.formatItem(1,$first['data'],true).'","titleKey":""}]]'); }else{ header('X-JSON: [["'.$lang->loc['inventory'].'","'.$lang->loc['web.store'].'"],[]]'); }
}else{
$lang->addLocale("homes.store");
}
?>
<div style="position: relative;">
<div id="webstore-categories-container">
	<h4><?php echo $lang->loc['categories']; ?>:</h4>
	<div id="webstore-categories">
<ul class="purchase-main-category">
		<li id="maincategory-1-stickers" class="selected-main-category webstore-selected-main">
			<div><?php echo $lang->loc['stickers']; ?></div>
			<ul class="purchase-subcategory-list" id="main-category-items-1">
<?php
$sql = $db->query("SELECT categoryid,category FROM ".PREFIX."homes_catalogue WHERE type = '1' AND minrank <= '".$user->user("rank")."' AND `where` ".$where." GROUP BY categoryid ORDER BY category ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
?>

				<li id="subcategory-1-<?php echo $row['categoryid']; ?>-stickers" class="subcategory<?php if($subcategory == $row['categoryid'] || $i == 0){ ?>-selected<?php } ?>">
					<div><?php echo $input->HoloText($row['category'],true); ?></div>
				</li>

<?php $i++; } ?>
			</ul>
		</li>
		<li id="maincategory-4-backgrounds" class="main-category">
			<div><?php echo $lang->loc['backgrounds']; ?></div>
			<ul class="purchase-subcategory-list" id="main-category-items-4">
<?php
$sql = $db->query("SELECT categoryid,category FROM ".PREFIX."homes_catalogue WHERE type = '4' AND minrank <= '".$user->user("rank")."' AND `where` ".$where." GROUP BY categoryid ORDER BY category ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
?>

				<li id="subcategory-4-<?php echo $row['categoryid']; ?>-backgrounds" class="subcategory<?php if($subcategory == $row['categoryid']){ ?>-selected<?php } ?>">
					<div><?php echo $input->HoloText($row['category'],true); ?></div>
				</li>

<?php $i++; } ?>
			</ul>
		</li>
		<li id="maincategory-3-stickie_notes" class="main-category-no-subcategories">
			<div><?php echo $lang->loc['notes']; ?></div>
			<ul class="purchase-subcategory-list" id="main-category-items-3">
<?php
$sql = $db->query("SELECT categoryid,category FROM ".PREFIX."homes_catalogue WHERE type = '3' AND minrank <= '".$user->user("rank")."' AND `where` ".$where." GROUP BY categoryid ORDER BY category ASC");
$i = 0;
while($row = $db->fetch_assoc($sql)){
?>

				<li id="subcategory-3-<?php echo $row['categoryid']; ?>-stickie_notes" class="subcategory<?php if($subcategory == $row['categoryid']){ ?>-selected<?php } ?>">
					<div><?php echo $input->HoloText($row['category'],true); ?></div>
				</li>

<?php $i++; } ?>
			</ul>
		</li>
</ul>

	</div>
</div>

<?php if($empty != true){ ?>

<div id="webstore-content-container">
	<div id="webstore-items-container">
		<h4><?php echo $lang->loc['select.item.by.clicking'] ?></h4>
		<div id="webstore-items">
		<?php
		$page['bypass'] = true;
		require_once('./habblet/myhabbo_store_items.php');
		?>
		</div>
	</div>
	<div id="webstore-preview-container">
		<div id="webstore-preview-default"></div>
		<div id="webstore-preview">
		
		<?php
		$page['bypass'] = true;
		$productid = $first['id'];
		require_once('./habblet/myhabbo_store_preview.php');
		?>
		
</div>
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
		<div id="inventory-items"><ul id="inventory-item-list">
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
	<div id="inventory-preview-container">
		<div id="inventory-preview-default"></div>
		<div id="inventory-preview"><h4>&nbsp;</h4>

<div id="inventory-preview-box"></div>

<div id="inventory-preview-place" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place"><b><?php echo $lang->loc['place']; ?></b><i></i></a>
	</div>
</div>

</div>
	</div>
</div>

<div id="webstore-close-container">
	<div class="clearfix"><a href="#" id="webstore-close" class="new-button"><b><?php echo $lang->loc['close']; ?></b><i></i></a></div>
</div>
</div>
<?php } ?>