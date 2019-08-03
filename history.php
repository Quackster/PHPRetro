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

require_once('./includes/core.php');
require_once('./includes/session.php');
$lang->addLocale("credits.transactions");

$page['id'] = "credits";
$page['name'] = $lang->loc['pagename.credits'];
$page['bodyid'] = "home";
$page['cat'] = "credits";
require_once('./templates/community_header.php');

$period = $_GET['period'];
if(!isset($_GET['period']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['period'])){ $period = date('Y-m-01'); }
$period = explode("-",$period);
$time['current'] = mktime(0,0,0,$period[1],$period[2],$period[0]);
$period = explode("-",date('Y-m-01')); 
$time['this_month'] = mktime(0,0,0,$period[1],$period[2],$period[0]);
$time['last_month'] = strtotime("-1 Month",$time['current']);
$time['next_month'] = strtotime("+1 Month",$time['current']);
if($time['current'] > $time['this_month']){ $time['current'] = $time['this_month']; }
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">

    <div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix brown ">
	
							<h2 class="title"><?php echo $lang->loc['account.transactions']; ?>
							</h2>
						<div id="tx-log">

<div class="box-content">
<?php echo $lang->loc['transactions.desc']; ?>
</div>

<ul class="tx-navi">
		<li class="next"<?php if($time['current'] != $time['this_month']){ ?> id="tx-navi-<?php echo date('Y-m-01',$time['next_month']); ?>" title="<?php echo date('F Y',$time['next_month']); ?>"><a href="<?php echo PATH; ?>/credits/history?period=<?php echo date('Y-m-01',$time['next_month']); ?>"><?php echo $lang->loc['next']; ?> &raquo</a><?php }else{ echo ">".$lang->loc['next']." &raquo"; } ?></li>

		<li class="prev" id="tx-navi-<?php echo date('Y-m-01',$time['last_month']); ?>" title="<?php echo date('F Y',$time['last_month']); ?>"><a href="<?php echo PATH; ?>/credits/history?period=<?php echo date('Y-m-01',$time['last_month']); ?>">&laquo <?php echo $lang->loc['previous']; ?></a></li>
	<li class="now"><?php echo date('F Y',$time['current']); ?></li>
</ul>

<p class="last">
<?php
$sql = $db->query("SELECT * FROM ".PREFIX."transactions WHERE (time > '".$time['current']."' AND time < '".$time['next_month']."') AND userid = '".$user->id."' ORDER BY time DESC");
if($db->num_rows($sql) > 0){
?>
<table class="tx-history">
<thead>
	<tr>
		<th class="tx-date"><?php echo $lang->loc['date']; ?></th>
		<th class="tx-amount"><?php echo $lang->loc['activity']; ?></th>
		<th class="tx-description"><?php echo $lang->loc['description']; ?></th>
	</tr>
</thead>
<tbody>
<?php
$i = 0;
while($row = $db->fetch_assoc($sql)){
	$i++;
	if($input->IsEven($i)){ $even = "even"; } else { $even = "odd"; }
	printf("	<tr class=\"%s\">
		<td class=\"tx-date\">%s</td>
		<td class=\"tx-amount\">%s</td>
		<td class=\"tx-description\">%s</td>
	</tr>",$even,date('n/j/Y g:i A',$row['time']),$row['amount'],$row['descr']);
}
?>
</tbody>
</table>
<?php }else{ ?>
<?php echo $lang->loc['not.found.records']; ?>
<?php } ?>
</p>

</div>
	
						
					</div>
				</div>

				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<div id="column2" class="column">
<?php $lang->addLocale("redeem.voucher"); ?>

				<div class="habblet-container ">		
						<div class="cbb clearfix brown ">
	
							<h2 class="title"><?php echo $lang->loc['your.purse']; ?>
							</h2>
						<div id="purse-habblet">
<?php if($user->id > 0){ ?>
	<form method="post" action="<?php echo PATH; ?>/credits" id="voucher-form">

<ul>
    <li class="even icon-purse">
        <div><?php echo $lang->loc['you.have']; ?>:</div>
        <span class="purse-balance-amount"><?php echo $user->user("credits")." ".$lang->loc['coins'];?></span>
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
<div id="purse-redeem-result">
</div>	</form>
<?php }else{ ?>
<div class="box-content"><?php echo $lang->loc['need.logon.purse']; ?></div>
<?php } ?>
</div>

<script type="text/javascript">
	new PurseHabblet();
</script>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php require_once('templates/community_footer.php'); ?>
