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
$data = new credits_sql;
$lang->addLocale("redeem.voucher");

$credits = $user->user("credits"); 
$voucher = $input->FilterText($_POST['voucherCode']); 

$sql = $data->select5($voucher);

if($db->num_rows($sql) > 0){ 
    $row = $db->fetch_row($sql); 
    if($row[0] == "credits"){
		$resultcode = "green";
		$credits = $credits + $row[1]; 
		$data->update1($user->id,$credits);
		$data->delete1($voucher);
		$user->refresh();
		$db->query("INSERT INTO ".PREFIX."transactions (time,amount,descr,userid) VALUES ('".time()."', '".$row[1]."', 'Credit voucher redeem', '".$user->id."');");
		$result = $lang->loc['redeemed.1']." ".$row[1]." ".$lang->loc['redeemed.2'];
		@SendMUSData('UPRC' . $user->id);
	}else{
		$resultcode = "green";
		$data->insert1($user->id,$row[1]);
		$data->delete1($voucher);
		$user->refresh();
		$db->query("INSERT INTO ".PREFIX."transactions (time,amount,descr,userid) VALUES ('".time()."', '0', 'Furniture voucher redeem', '".$user->id."');");
		$result = $lang->loc['redeemed.1']." ".$lang->loc['redeemed.3'];
		@SendMUSData('UPRH' . $user->id);
	}
} else { 
    $resultcode = "red"; 
    $result = $lang->loc['redeem.error']; 
}
?>
<ul>

    <li class="even icon-purse">
        <div><?php echo $lang->loc['you.have']; ?>:</div>
        <span class="purse-balance-amount"><?php echo $credits." ".$lang->loc['coins']; ?></span>
        <div class="purse-tx"><a href="<?php echo PATH; ?>/credits/history"><?php echo $lang->loc['transactions']; ?></a></div>
    </li>

    <li class="odd">
        <div class="box-content">

            <div><?php echo $lang->loc['enter.voucher']; ?>:</div>
            <input type="text" name="voucherCode" value="" id="purse-habblet-redeemcode-string" class="redeemcode" />
            <a href="#" id="purse-redeemcode-button" class="new-button purse-icon" style="float:left"><b><span></span><?php echo $lang->loc['redeem']; ?></b><i></i></a>
        </div>
    </li>
</ul>
<ul>
<div id="purse-redeem-result">
        <div class="redeem-error"> 
            <div class="rounded rounded-<?php echo $resultcode; ?>"> 
                <?php echo $result; ?>
            </div> 
        </div>
</div>