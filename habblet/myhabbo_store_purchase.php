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
$data = new home_sql;
$lang->addLocale("homes.store.purchase");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['selectedId']);
$task = $input->FilterText($_POST['task']);

$sql = $db->query("SELECT id,amount,price,minrank,`where`,data FROM ".PREFIX."homes_catalogue WHERE id = '".$id."' LIMIT 1");
$row = $db->fetch_assoc($sql);
if($user->user("rank") < $row['minrank']){ $error = $lang->loc['purchase.error.1']; }
if($_SESSION['page_edit'] == "home" && $row['where'] == -1){ $error = $lang->loc['purchase.error.1']; }
if($_SESSION['page_edit'] != "home" && $row['where'] == 1){ $error = $lang->loc['purchase.error.1']; }
$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id AND ".PREFIX."homes_catalogue.data = '".$row['data']."' AND (".PREFIX."homes_catalogue.type = '4' OR ".PREFIX."homes_catalogue.type = '2') AND ".PREFIX."homes.ownerid = '".$user->id."'");
if($db->result($sql) > 0){ $error = $lang->loc['purchase.error.2']; }
if(($user->user("credits") - $row['price']) < 0){ $error = $lang->loc['purchase.error.3']; }
if(isset($error)){
?>
<p>
<?php echo $error; ?><br />
</p>

<p>
<a href="#" class="new-button" id="webstore-confirm-cancel"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
</p>

<div class="clear"></div>
<?php
exit;
}else{
$i = 0;
while($i < $row['amount']){
$i++;
$db->query("INSERT INTO ".PREFIX."homes (ownerid,itemid,location) VALUES ('".$user->id."','".$row['id']."','-1')");
}
$credits = $user->user("credits") - $row['price'];
$data->update1($user->id,$credits);
$user->refresh();
@SendMUSData('UPRC' . $user->id);
echo "OK";
}
?>