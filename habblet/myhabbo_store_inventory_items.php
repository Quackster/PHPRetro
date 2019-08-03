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

$type = $input->FilterText($_POST['type']);
switch($type){
	case "stickers": $type = 1; break;
	case "backgrounds": $type = 4; break;
	case "widgets": $type = 2; break;
	case "notes": $type = 3; break;
}
}
$lang->addLocale("homes.store.inventory.items");

if($_SESSION['page_edit'] == "home"){ $where = '> -1'; $widgetsql = "ownerid = '".$user->id."'"; }else{ $where = '< 1'; $widgetsql = "(location = '".$_SESSION['page_edit']."' OR location = '-".$_SESSION['page_edit']."')"; }

$i = 0;
if($type == 2){
$sql = $db->query("SELECT `id`,`data`,`name`,`desc` FROM ".PREFIX."homes_catalogue WHERE type = '2' AND `where` ".$where." AND minrank <= '".$user->user("rank")."' ORDER BY id DESC");
?>
<ul id="inventory-item-list">
<?php
while($row = $db->fetch_row($sql)){
$count = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."homes WHERE itemid = '".$row[0]."' AND ".$widgetsql));
?>

	<li id="inventory-item-p-<?php echo $row[0]; ?>" title="<?php echo $input->HoloText($row[2]); ?>" class="webstore-widget-item <?php if($count != 0){ ?>webstore-widget-disabled<?php } ?>">
		<div class="webstore-item-preview <?php echo formatItem($type,$row[1],true); ?>" >
			<div class="webstore-item-mask">
				
			</div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $input->HoloText($row[2]); ?></h3>
			<p><?php echo $input->HoloText($row[3]); ?></p>
		</div>
	</li>

<?php
}
?>
</ul>
<?php
}else{
if($type != 4){ $sqladdon = "AND ".PREFIX."homes.location = '-1' "; }
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes_catalogue.name,COUNT(".PREFIX."homes.id) AS count FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.ownerid = '".$user->id."' AND ".PREFIX."homes_catalogue.type = '".$type."' ".$sqladdon." AND ".PREFIX."homes_catalogue.where ".$where." AND ".PREFIX."homes_catalogue.id = ".PREFIX."homes.itemid GROUP BY ".PREFIX."homes_catalogue.data ORDER BY ".PREFIX."homes.id DESC");
if($db->num_rows($sql) == 0){
?>
<div class="webstore-frank">
	<div class="blackbubble">
		<div class="blackbubble-body">

<p><b><?php echo $lang->loc['inventory.empty']; ?></b></p>
<p><?php echo $lang->loc['how.to.purchase.items']; ?></p>

		<div class="clear"></div>
		</div>
	</div>
	<div class="blackbubble-bottom">
		<div class="blackbubble-bottom-body">
			<img src="<?php echo PATH; ?>/web-gallery/images/box-scale/bubble_tail_small.gif" alt="" width="12" height="21" class="invitation-tail" />
		</div>
	</div>
	<div class="webstore-frank-image"><img src="<?php echo PATH; ?>/web-gallery/images/frank/sorry.gif" alt="" width="57" height="88" /></div>
</div>
<?php
}
?>
<ul id="inventory-item-list">
<?php
while($row = $db->fetch_row($sql)){
$i++;
?>

	<li id="inventory-item-<?php echo $row[0]; ?>" title="<?php echo $input->HoloText($row[2],true); ?>"
		title="<?php echo $input->HoloText($row[2]); ?>">
		<div class="webstore-item-preview <?php echo formatItem($type,$row[1],true); ?>">
			<div class="webstore-item-mask">
				<?php if($row[3] > 1){ ?><div class="webstore-item-count"><div>x<?php echo $row[3]; ?></div></div><?php } ?>
			</div>
		</div>
	</li>
	
<?php }
if($i < 20){ $max = 20 - $i; }elseif($i > 20){ $max = mod($i / 4); }
$n = 0;
while($n < $max){
$n++;
?>

	<li class="webstore-item-empty"></li>

<?php } ?>
</ul>
<?php } ?>