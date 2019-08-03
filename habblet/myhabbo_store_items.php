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

$category = $input->FilterText($_POST['categoryId']);
$subcategory = $input->FilterText($_POST['subCategoryId']);
}else{
$sql = $db->query("SELECT categoryid FROM ".PREFIX."homes_catalogue WHERE type = '1' ORDER BY category ASC LIMIT 1");
$category = 1;
$subcategory = $db->result($sql);
}
$lang->addLocale("homes.store.items");

if($_SESSION['page_edit'] == "home"){ $where = '> -1'; }else{ $where = '< 1'; }

$sql = $db->query("SELECT * FROM ".PREFIX."homes_catalogue WHERE categoryid = '".$subcategory."' AND type = '".$category."' AND minrank <= '".$user->user("rank")."' AND `where` ".$where." ORDER BY id DESC");
if($db->num_rows($sql) == 0){
?>
<div class="webstore-frank">
	<div class="blackbubble">
		<div class="blackbubble-body">

<p><b><?php echo $lang->loc['no.items.in.store']; ?></b></p>
<p><?php echo $lang->loc['watch.this.space']; ?></p>

		<div class="clear"></div>
		</div>
	</div>
	<div class="blackbubble-bottom">
		<div class="blackbubble-bottom-body">
			<img src="<?php echo PATH; ?>/web-gallery/images/box-scale/bubble_tail_small.gif" alt="" width="12" height="21" class="invitation-tail" />
		</div>
	</div>
	<div class="webstore-frank-image"><img src="<?php echo PATH; ?>/web-gallery/images/frank/hello.gif" alt="" width="76" height="86" /></div>
</div>
<?php } ?>
<ul id="webstore-item-list">
<?php
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
?>

	<li id="webstore-item-<?php echo $row['id']; ?>" title="<?php echo $input->HoloText($row['name'],true); ?>">
		<div class="webstore-item-preview <?php echo formatItem($row['type'],$row['data'],true); ?>">
			<div class="webstore-item-mask">
				<?php if($row['amount'] > 1){ ?><div class="webstore-item-count"><div>x<?php echo $row['amount']; ?></div></div><?php } ?>
			</div>
		</div>
	</li>
	
<?php }
if($i < 20){ $max = 20 - $i; }elseif($i > 20){ $max = fmod($i,4); $max = 4 - $max; }
$n = 0;
while($n < $max){
$n++;
?>

	<li class="webstore-item-empty"></li>

<?php } ?>
</ul>