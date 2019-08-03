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
$data = new group_purchase_sql;
$lang->addLocale("group.purchasegroup");

$name = $input->FilterText($_POST['name']);
$desc = $input->FilterText($_POST['description']);

if(empty($name) || empty($desc)){
	echo "<p>\n".$lang->loc['buy.group.error.1']."\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>".$lang->loc['back']."</b><i></i></a>\n</p>"; exit;
} else {
	if(strlen($name) > 30){
		echo "<p>\n".$lang->loc['buy.group.error.2']."\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>".$lang->loc['back']."</b><i></i></a>\n</p>"; exit;
	} elseif(strlen($desc) > 255){
		echo "<p>\n".$lang->loc['buy.group.error.3']."\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>".$lang->loc['back']."</b><i></i></a>\n</p>"; exit;
	} elseif($serverdb->result($data->select1($name), 0) > 0){
		echo "<p>\n".$lang->loc['buy.group.error.4']."\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>".$lang->loc['back']."</b><i></i></a>\n</p>"; exit;
	} elseif($user->user("credits") < 10){
		echo "<p>\n".$lang->loc['buy.group.error.5']."\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>".$lang->loc['back']."</b><i></i></a>\n</p>"; exit;
	} else {
		$data->insert1($name, $desc, $user->id, date('M n, Y'));
		$id = $serverdb->result($data->select2($user->id, $name), 0);
		$data->insert2($user->id, $id);
		$user->refresh();
		$db->query("INSERT INTO ".PREFIX."transactions (userid,descr,time,amount) VALUES ('".$user->id."','Group purchase','".time()."','-10')");
		@SendMUSData('UPRC' . $user->id);
	}
}
?>
<div id="group-logo">
   <img src="<?php echo PATH; ?>/web-gallery/images/groups/group_icon.gif" alt="" width="46" height="46" />
</div>

<p id="purchase-result-success">
<?php echo $lang->loc['congrats.new.owner']; ?> <b><?php echo $input->HoloText($name); ?></b>
</p>

<p>

<div class="new-buttons clearfix">
	<a class="new-button" id="group-purchase-cancel-button" href="#" onclick="GroupPurchase.close(); return false;"><b><?php echo $lang->loc['later']; ?></b><i></i></a>	
	<a class="new-button" href="<?php echo groupURL($id); ?>"><b><?php echo $lang->loc['go.to.page']; ?></b><i></i></a>
</div>

</p>

<script language="JavaScript" type="text/javascript">
	updateHabboCreditAmounts('<?php echo $user->user("credits") - 20; ?>');
</script>