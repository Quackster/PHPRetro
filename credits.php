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

$page['allow_guests'] = true;
require_once('./includes/core.php');
require_once('./includes/session.php');
$lang->addLocale("credits.credits");

$page['id'] = "credits";
$page['name'] = $lang->loc['pagename.credits'];
$page['bodyid'] = "home";
$page['cat'] = "credits";
require_once('./templates/community_header.php');
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix green ">
	
							<h2 class="title">How to get Credits
							</h2>
							
						<script src="<?php echo PATH; ?>/web-gallery/static/js/credits.js" type="text/javascript"></script>
<p class="credits-countries-select">
THIS IS A SAMPLE HABBLET ONLY! PLEASE EDIT <?php PATH; ?>/credits.php TO CHANGE THE CONTENTS!
</p>
<ul id="credits-methods">
	<li id="credits-type-promo">
		<h4 class="credits-category-promo">Best Way</h4>
		<ul>
				<li class="clearfix even"><div id="method-44" class="credits-method-container">

					<div class="credits-summary" >
						<h3>Ask a Moderator</h3>
						<p>Moderators are all over the hotel. Ask one of them and they'll give you a voucher. Redeem it on the right.</p>
						
						<p class="credits-read-more" id="method-show-44" style="display: none">Read more</p>
					</div>
					<div id="method-full-44" class="credits-method-full">

							<p><b>Here's How to do this:</b><br />blablabla</p>

					</div>
					<script type="text/javascript">
					$("method-show-44").show();
					$("method-full-44").hide();
					</script>
				</div></li>
		</ul>
	</li>
	<li id="credits-type-quick_and_easy">
		<h4 class="credits-category-quick_and_easy">Other Ways</h4>
		<ul>

				<li class="clearfix odd"><div id="method-1" class="credits-method-container">
					<div class="credits-summary">
						<h3>Refer a Friend</h3>
						<p>Refer a friend to this hotel and earn some credits.</p>

						
						<p class="credits-read-more" id="method-show-1" style="display: none">Read more</p>
					</div>
					<div id="method-full-1" class="credits-method-full">
							<p><b>How to do This: </b><br /><br />Get your link on the front page and send it to your friends. When they sign up, you get credits!</p>
					</div>
					<script type="text/javascript">
					$("method-show-1").show();
					$("method-full-1").hide();
					</script>
				</div></li>
		</ul>
	</li>
	<li id="credits-type-other">
		<h4 class="credits-category-other">Tools</h4>
		<ul>

				<li class="clearfix odd"><div id="method-3" class="credits-method-container">
					<div class="credits-summary">
						<div class="credits-tools">
								<a  class="new-button" id="buy-button" href="#"><b>Reset Hand</b><i></i></a>
							
						</div>
						<h3>Reset Hand</h3>
						<p>Virtual hand too full? Click here to reset it.</p>
						
						<p class="credits-read-more" id="method-show-3" style="display: none">Read more</p>
					</div>
					<div id="method-full-3" class="credits-method-full">

							<p><b>How to Do This:</b><br /><br />Click that button above these words. Hard isn't it?</p>
					</div>
					<script type="text/javascript">
					$("method-show-3").show();
					$("method-full-3").hide();
					</script>
				</div></li>
		</ul>
	</li>
</ul>

<script type="text/javascript">
L10N.put("credits.navi.read_more", "Read more");
L10N.put("credits.navi.close_fulltext", "Close instructions");
PaymentMethodHabblet.init();
</script>
	
						
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
				
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">
	
							<h2 class="title"><?php echo $lang->loc['what.are.coins']; ?>
							</h2>

						<div id="credits-promo" class="box-content credits-info">
    <div class="credit-info-text clearfix">
        <img class="credits-image" src="<?php echo PATH; ?>/web-gallery/v2/images/credits/poor.png" alt="" width="77" height="105" />
        <p class="credits-text"><?php echo $lang->loc['desc.of.coins']; ?></p>
    </div>
    <p class="credits-text-2"><?php echo $lang->loc['desc.to.get.coins']; ?></p>
</div>
	
						
					</div>

				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php require_once('./templates/community_footer.php'); ?>
