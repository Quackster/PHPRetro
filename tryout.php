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
$lang->addLocale("credits.testwardrobe");

$page['id'] = "tryout";
$page['name'] = $lang->loc['pagename.club'];
$page['bodyid'] = "home";
$page['cat'] = "credits";
require_once('./templates/community_header.php');
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">

				<div class="habblet-container ">		
						<div class="cbb clearfix red ">
	
							<h2 class="title"><?php echo $lang->loc['test.wardrobe']; ?>
							</h2>
						<div id="habboclub-tryout" class="box-content">

    <div class="rounded rounded-lightbrown clearfix">
       <p class="habboclub-logo heading"><?php echo $lang->loc['test.club'][0]; ?><br /><br /><?php echo $lang->loc['test.club'][1]; ?> <a href="<?php echo PATH; ?>/profile"><?php echo $lang->loc['test.club'][2]; ?>.</a></p>
    </div>

    <div id="flashcontent">
        <?php echo $lang->loc['no.flash']; ?>: <a target="_blank" href="http://www.adobe.com/go/getflashplayer" >http://www.adobe.com/go/getflashplayer</a>
    </div>    
</div>

<script type="text/javascript" language="JavaScript">
    var swfobj = new SWFObject("<?php echo PATH; ?>/flash/HabboRegistration.swf", "habboreg", "435", "400", "8");
    swfobj.addParam("base", "<?php echo PATH; ?>/flash/");
    swfobj.addParam("wmode", "opaque");
    swfobj.addParam("AllowScriptAccess", "always");
    swfobj.addVariable("figuredata_url", "<?php echo PATH; ?>/xml/figuredata.xml");
    swfobj.addVariable("draworder_url", "<?php echo PATH; ?>/xml/draworder.xml");
    swfobj.addVariable("localization_url", "<?php echo PATH; ?>/xml/figure_editor.xml");
    swfobj.addVariable("habbos_url", "<?php echo PATH; ?>/xml/promo_habbos_v2.xml");
    swfobj.addVariable("figure", "<?php echo $user->user("figure"); ?>");
    swfobj.addVariable("gender", "<?php echo $user->user("sex"); ?>");
    swfobj.addVariable("showClubSelections", "1");
    if (deconcept.SWFObjectUtil.getPlayerVersion()["major"] >= 8) {
	    $("flashcontent").setStyle({ textAlign: "center", "marginTop" : "10px" });
	    swfobj.write("flashcontent");	    
    }
</script>
	
						
							
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

				<div class="habblet-container ">		
						<div class="cbb clearfix lightbrown ">
	
							<h2 class="title"><?php echo $lang->loc['what.is.club']; ?>
							</h2>

						<div id="habboclub-info" class="box-content">
    <p><?php echo $lang->loc['club.desc'][0]; ?></p>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][1]; ?></h3>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][3]; ?></h3>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][6]; ?></h3>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][8]; ?></h3>

    <h3 class="heading"><?php echo $lang->loc['club.desc'][10]; ?></h3>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][12]; ?></h3>
    <h3 class="heading"><?php echo $lang->loc['club.desc'][14]; ?></h3>
    <p class="read-more"><a href="<?php echo PATH; ?>/credits/club"><?php echo $lang->loc['read.more']; ?> &raquo;</a></p>
</div>
	
						
					</div>
				</div>

				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<?php require_once('templates/community_footer.php'); ?>