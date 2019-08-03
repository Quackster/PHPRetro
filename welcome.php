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
$data = new welcome_sql;
$lang->addLocale("community.welcome");

$page['id'] = "welcome";
$page['name'] = $lang->loc['pagename.welcome'];
$page['bodyid'] = "welcome";
$page['cat'] = "home";
require_once('./templates/community_header.php');
?>

<div id="container">
	<div id="content" style="position: relative" class="clearfix">
<?php /* NO NOOB GIFTS
    <div id="column1" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix lightgreen ">

							<h2 class="title"><?php echo $lang->loc['choose.room.title']; ?>
							</h2>
						<div id="roomselection-welcome-intro" class="box-content">
    <?php echo $lang->loc['choose.room']; ?>
</div>
<ul class="roomselection-welcome clearfix">
	<li class="odd">
	<a class="roomselection-select new-button" href="client?createRoom=0" target="client" onclick="return RoomSelectionHabblet.create(this, 0);"><b><?php echo $lang->loc['select']; ?></b><i></i></a>
	</li>
	<li class="even">
	<a class="roomselection-select new-button" href="client?createRoom=1" target="client" onclick="return RoomSelectionHabblet.create(this, 1);"><b><?php echo $lang->loc['select']; ?></b><i></i></a>
	</li>
	<li class="odd">
	<a class="roomselection-select new-button" href="client?createRoom=2" target="client" onclick="return RoomSelectionHabblet.create(this, 2);"><b><?php echo $lang->loc['select']; ?></b><i></i></a>
	</li>
	<li class="even">
	<a class="roomselection-select new-button" href="client?createRoom=3" target="client" onclick="return RoomSelectionHabblet.create(this, 3);"><b><?php echo $lang->loc['select']; ?></b><i></i></a>
	</li>
	<li class="odd">
	<a class="roomselection-select new-button" href="client?createRoom=4" target="client" onclick="return RoomSelectionHabblet.create(this, 4);"><b><?php echo $lang->loc['select']; ?></b><i></i></a>
	</li>
	<li class="even">
	<a class="roomselection-select new-button" href="client?createRoom=5" target="client" onclick="return RoomSelectionHabblet.create(this, 5);"><b><?php echo $lang->loc['select']; ?></b><i></i></a>
	</li>
</ul>



					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
*/ ?>
<div id="column2" class="column">
				<div class="habblet-container ">

						<div class="cbb clearfix lightgreen">

<div class="welcome-intro clearfix">
	<img alt="<?php echo $user->name; ?>" src="<?php echo $user->avatarURL("self","b,3,3,srp,1,667"); ?>
" width="64" height="110" class="welcome-habbo" />
    <div id="welcome-intro-welcome-user"  ><?php echo $lang->loc['welcome']." ".$user->name."!"; ?></div>
    <div id="welcome-intro-welcome-party" class="box-content"><?php echo $settings->find("site_welcome_text"); ?></div>
    </div>
</div>

</div>	
					
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

	<?php
	if($_SESSION['referral'] != ""){
	if($user->IsUserOnline($_SESSION['referral']) == true){ $online = "online"; }else{ $online = "offline"; }
	?>
				<div class="habblet-container ">		
						<div class="cbb clearfix white ">
	
							<h2 class="title"><?php echo $lang->loc['welcome']; ?>
							</h2>
						<div id="inviter-info-habblet">
        <p><span class="text"><?php echo $lang->loc['your.friend']." ".$serverdb->result($data->select1($_SESSION['referral']), 0)." ".$lang->loc['is.waiting']; ?><em class="<?php echo $online; ?>"></em></span><span class="bottom"></span></p>
        <img alt="<?php echo $serverdb->result($data->select1($_SESSION['referral']), 0); ?>" title="<?php echo $serverdb->result($data->select1($_SESSION['referral']), 0); ?>" src="<?php echo $user->avatarURL($serverdb->result($data->select1($_SESSION['referral']), 0, 1),"b,4,4,sml,1,0"); ?>" />

        <div style="clear: left; text-align: center; padding-top: 10px; font-size: 10px"><?php echo $lang->loc['find.on.friendlist']; ?></div>    
    </div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 
	<?php } ?>
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix green ">
	
							<h2 class="title">Got Shockwave?
							</h2>
						<div class="welcome-shockwave clearfix box-content">
    <div id="welcome-shockwave-text"><?php echo $lang->loc['first.time']; ?></div>
    <div id="welcome-shockwave-logo"><img src="<?php echo PATH; ?>/web-gallery/v2/images/welcome/shockwave.gif" alt="shockwave" /></div>
</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php require_once('./templates/community_footer.php'); ?>