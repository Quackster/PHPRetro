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
$lang->addLocale("client.hotel");
$page['name'] = $lang->loc['page.error'];

$page['no_client_js'] = true;
require_once('./templates/client_header.php');

foreach ($_GET as &$value) {
    $value = $input->FilterText($value);
}
$key = $_GET['key'];
?>
<body id="popup" class="process-template client_error">
<div id="container">
    <div id="content">

	    <div id="process-content" class="centered-client-error">
	       	<div id="column1" class="column">

<?php 
switch($key){
case "install_shockwave":
$lang->addLocale("client.noshockwave");
?>
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">
	
							<h2 class="title"><?php echo $lang->loc['shockwave.detection']; ?>
							</h2>
						<div class="box-content">
    <div>
       <p><?php echo $lang->loc['you.need'][0]; ?> <b><?php echo $lang->loc['you.need'][1]; ?></b>.</p>

       <p><?php echo $lang->loc['you.need'][2]; ?> <b><?php echo $lang->loc['you.need'][3]; ?></b> <?php echo $lang->loc['you.need'][4]; ?>.</p>       
    </div>
    <div id="swdetection"></div>
    <div class="install-shockwave">
        <div id="shockwave-install-button">
            <div class="shockwave-icon">
	            <a class="new-button" href="#" id="install-shockwave-link"><b><?php echo $lang->loc['install.now']; ?></b><i></i></a>

            </div>
        </div>
        <div id="shockwave-install-progressbar">
            <div class="shockwave-icon progressbar"><span class="install-label"><?php echo $lang->loc['installing']; ?></span><img src="<?php echo PATH; ?>/web-gallery/images/progress_bar_blue.gif" alt="" width="100" height="20" /></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    ShockwaveInstallation.detectionFile = '<?php echo PATH; ?>/web-gallery/shockwave/detect_shockwave.dcr';
    ShockwaveInstallation.cabVersion = '10,0,0,0';
    ShockwaveInstallation.clientURL = '<?php echo PATH; ?>/client';
    ShockwaveInstallation.init();
	    ShockwaveInstallation.playerVersion = '11';    
    Event.observe("install-shockwave-link", "click", function(e) {Event.stop(e); ShockwaveInstallation.startSwInstallation(); return false;});
    $('column1').setStyle({width : '660px'});
</script>

<script type="text/javascript">
  document.observe("dom:loaded", function() {
    ClientMessageHandler.googleEvent("client_error", "shockwave_install");
  });
</script>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
<?php
break;
case "upgrade_shockwave":
$lang->addLocale("client.oldshockwave");
?>
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">
	
							<h2 class="title"><?php echo $lang->loc['shockwave.detection']; ?>
							</h2>
						<div class="box-content">
    <p><?php echo $lang->loc['old.version'][0]; ?> <b><?php echo $lang->loc['you.need'][1] ?></b> <?php echo $lang->loc['old.version'][1]; ?></p>    
    <ul>

    <li class="client_error"><span><?php echo $lang->loc['old.version'][2]; ?></span></li>
    <li class="client_error"><span><?php echo $lang->loc['old.version'][3]; ?></span></li>
    <li class="client_error"><span><?php echo $lang->loc['old.version'][4]; ?></span></li>    
    </ul>
</div>

<script type="text/javascript">
  document.observe("dom:loaded", function() {
    ClientMessageHandler.googleEvent("client_error", "shockwave_upgrade");
  });
</script>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
<?php
break;
case "error":
$lang->addLocale("client.connectionfailed");
if($settings->find("client_log_errors") == "1"){
$db->query("INSERT INTO ".PREFIX."client_errors (ip,userid,error_type,os,error_id,hookerror,error_message,hookmsgb,lastexecute,lastmessage,server_errors,lastroom,mus_errorcode,client_process_list,client_errors,neterr_cast,neterr_res,client_uptime) VALUES 
('".$_SERVER["REMOTE_ADDR"]."','".$user->id."','".$_GET['error']."','".$_GET['os']."','".$_GET['error_id']."','".$_GET['hookerror']."','".$_GET['hookmsga']."','".$_GET['hookmsgb']."','".$_GET['lastexecute']."','".$_GET['lastmessage']."','".$_GET['server_errors']."','".$_GET['lastroom']."','".$_GET['mus_errorcode']."','".$_GET['client_process_list']."','".$_GET['client_errors']."','".$_GET['neterr_cast']."','".$_GET['neterr_res']."','".$_GET['client_uptime']."')");
}
?>
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">
	
							<h2 class="title"><?php echo $lang->loc['oops']; ?>
							</h2>
						<div class="box-content">
    <div class="info-client_error-text">
       <p><?php echo $lang->loc['oops.desc']; ?></p>

       <p><?php echo $lang->loc['reopen']; ?> <a onclick="openOrFocusHabbo(this); return false;" target="client" href="<?php echo PATH; ?>/client"><?php echo $lang->loc['hotel']; ?></a> <?php echo $lang->loc['to.continue']; ?></p>
    </div>
    <div class="retry-enter-hotel">
    <div class="hotel-open">
        <a id="enter-hotel-open-image" class="open" href="<?php echo PATH; ?>/client" target="client" onclick="HabboClient.openOrFocus(this); return false;">
        <div class="hotel-open-image-splash"></div>
        <div class="hotel-image hotel-open-image"></div>

        </a>
        <div class="hotel-open-button-content">
           <a class="open" href="<?php echo PATH; ?>/client" target="client" onclick="HabboClient.openOrFocus(this); return false;"><?php echo $lang->loc['enter']; ?></a>
            <span class="open"></span>
        </div>
    </div>
    </div>
<script type="text/javascript">
document.observe("dom:loaded", function() {
    var titles = $$("h2.title");
    if (titles.length > 0) {
        Element.insert(titles[0], "(#<?php echo $input->HoloText($_GET['error_id']); ?>) ");
    }
});
</script>

</div>


<script type="text/javascript">
  document.observe("dom:loaded", function() {
    ClientMessageHandler.googleEvent("client_error", "unknown");
  });
</script>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
<?php
break;
default:
$lang->addLocale("client.connectionfailed");
?>
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">
	
							<h2 class="title"><?php echo $lang->loc['connection.failed']; ?>
							</h2>
						<div class="box-content">
    <p><?php echo $lang->loc['connection.failed.info']; ?>
 <?php echo $lang->loc['ip']; ?>: <?php echo $settings->find("hotel_ip"); ?>, <?php echo $lang->loc['port']; ?>: <?php echo $settings->find("hotel_port"); ?></p>   
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
<?php
break;
}
?>
			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
<div id="column2" class="column">
</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
		</div>
    </div>
</div>
<?php require_once('./templates/client_footer.php'); ?>