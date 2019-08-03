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
$lang->addLocale("credits.club");

$page['id'] = "club";
$page['name'] = $lang->loc['pagename.club'];
$page['bodyid'] = "home";
$page['cat'] = "credits";
require_once('./templates/community_header.php');
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">

				<div class="habblet-container ">		
						<div class="cbb clearfix hcred ">
	
							<h2 class="title"><?php echo $lang->loc['club.title']; ?>
							</h2>
						<div id ="habboclub-products">
    <div id="habboclub-clothes-container">
        <div class="habboclub-extra-image"></div>
        <div class="habboclub-clothes-image"></div>
    </div>

    <div class="clearfix"></div>
    <div id="habboclub-furniture-container">
        <div class="habboclub-furniture-image"></div>
    </div>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix lightbrown ">

	
							<h2 class="title"><?php echo $lang->loc['benefits']; ?>
							</h2>
						<div id="habboclub-info" class="box-content">
    <p><?php echo $lang->loc['club.desc'][0]; ?></p>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][1]; ?></h3>
    <p class="content habboclub-clothing"><?php echo $lang->loc['club.desc'][2]; ?>
        <br /><br /><a href="<?php echo PATH; ?>/credits/club/tryout"><?php echo $lang->loc['try.out.club']; ?></a>

    </p>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][3]; ?></h3>
    <p class="content habboclub-furni"><?php echo $lang->loc['club.desc'][4]; ?></p>        
    <p class="content"><?php echo $lang->loc['club.desc'][5]; ?></p>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][6]; ?></h3>
    <p class="content"><?php echo $lang->loc['club.desc'][7]; ?></p>
    <p class="habboclub-room" />

    <h3 class="heading"><?php echo $lang->loc['club.desc'][8]; ?></h3>
    <p class="content"><?php echo $lang->loc['club.desc'][9]; ?></p>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][10]; ?></h3>
    <p class="content"><?php echo $lang->loc['club.desc'][11]; ?></p>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][12]; ?></h3>
    <p class="content habboclub-communicator"><?php echo $lang->loc['club.desc'][13]; ?></p>

    <h3 class="heading"><?php echo $lang->loc['club.desc'][14]; ?></h3>
    <p class="content habboclub-commands right"><?php echo $lang->loc['club.desc'][15]; ?></p>
    <br />
    <p><?php echo $lang->loc['club.desc'][16]; ?></p>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div id="column2" class="column">
			     		
<?php $lang->addLocale("club.status"); ?>
				<div class="habblet-container ">		
						<div class="cbb clearfix hcred ">
	
							<h2 class="title"><?php echo $lang->loc['my.membership']; ?>
							</h2>
							
<?php if($user->id == "0"){ ?>
						<div id="hc-habblet" class='box-content'>
<?php echo $lang->loc['please.sign.in.club']; ?>
</div>
<?php }else{ ?>

						<script src="<?php echo PATH; ?>/web-gallery/static/js/habboclub.js" type="text/javascript"></script>
<div id="hc-habblet">
    <div id="hc-membership-info" class="box-content">
<p>
<?php if(!$user->IsHCMember("self")){ echo $lang->loc['not.a.member']; }else{ echo $lang->loc['you.have']." ".$user->HCDaysLeft("self")." ".$lang->loc['club.days.left']; } ?>

</p>
<?php /* DISABLD
<p>
<?php echo $lang->loc['have.been.member']." ".$user->user("total_club_months")." ".$lang->loc['months']; ?>
</p>
*/ ?>
    </div>
    <div id="hc-buy-container" class="box-content">
        <div id="hc-buy-buttons" class="hc-buy-buttons rounded rounded-hcred">
            <form class="subscribe-form" method="post">
                <input type="hidden" id="settings-figure" name="figureData" value="">
                <input type="hidden" id="settings-gender" name="newGender" value="">
                <table width="100%">
<?php if($user->user("credits") < 20){ ?>
                  <p class="credits-notice"><?php echo $lang->loc['you.need.coins']; ?>:</p>
                  <p class="credits-notice"><?php echo $lang->loc['club.starts.at']; ?> 20 <?php echo $lang->loc['coins']; ?></p>                  
                  <a class="new-button fill" href="<?php echo PATH; ?>/credits"><b><?php echo $lang->loc['purchase.coins']; ?></b><i></i></a>
<?php }else{ ?>
                    <tr>
                        <td>
		                    <a class="new-button fill" id="subscribe1" href="#" onclick='habboclub.buttonClick(1, "<?php echo $lang->loc['CLUB']; ?>"); return false;'><b style="padding-left: 3px; padding-right: 3px;"><?php echo $lang->loc['buy']; ?> 1 <?php echo $lang->loc['months']; ?></b><i></i></a>
                        </td>
                        <td width="45%"><?php echo $lang->loc['purchase']; ?> 31 <?php echo $lang->loc['days']; ?><br/> 20 <?php echo $lang->loc['coins']; ?></td>
                    </tr>
                    <tr>

                        <td>
		                    <a class="new-button fill" id="subscribe2" href="#" onclick='habboclub.buttonClick(2, "<?php echo $lang->loc['CLUB']; ?>"); return false;'><b style="padding-left: 3px; padding-right: 3px;"><?php echo $lang->loc['buy']; ?> 3 <?php echo $lang->loc['months']; ?></b><i></i></a>
                        </td>
                        <td width="45%"><?php echo $lang->loc['purchase']; ?> 93 <?php echo $lang->loc['days']; ?><br/> 50 <?php echo $lang->loc['coins']; ?></td>
                    </tr>
                    <tr>
                        <td>

		                    <a class="new-button fill" id="subscribe3" href="#" onclick='habboclub.buttonClick(3, "<?php echo $lang->loc['CLUB']; ?>"); return false;'><b style="padding-left: 3px; padding-right: 3px;"><?php echo $lang->loc['buy']; ?> 6 <?php echo $lang->loc['months']; ?></b><i></i></a>
                        </td>
                        <td width="45%"><?php echo $lang->loc['purchase']; ?> 186 <?php echo $lang->loc['days']; ?><br/> 80 <?php echo $lang->loc['coins']; ?></td>
                    </tr>
<?php } ?>
                </table>
            </form>
        </div>

    </div>
</div>
<?php } ?>
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php /* DISABLED
				<div class="habblet-container ">		
						<div class="cbb clearfix lightbrown ">
	
							<h2 class="title"><?php echo $lang->loc['monthy.gifts']; ?>
							</h2>
<?php
$page['bypass'] = true;
$month = 0;
$catalogpage = 0;
require_once('./habblet/ajax_habboclub_gift.php');
?>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>	
*/ ?>				

</div>
<?php require_once('templates/community_footer.php'); ?>