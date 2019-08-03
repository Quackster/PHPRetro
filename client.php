<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2009 PHPRetro. All rights reserved.
|| # http://www.PHPRetro.com
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
$lang->addLocale("client.hotel");

if(isset($_SESSION['reauthenticate']) && $_SESSION['reauthenticate'] == "true"){
	$_SESSION['page'] = $_SERVER["REQUEST_URI"];
	header("Location: ".PATH."/account/reauthenticate"); exit;
}else{
	$user = new HoloUser($user->name,$user->password,true);
	$_SESSION['user'] = $user;
}

if(isset($_GET['wide']) && $_GET['wide'] == "false"){
	$wide = false;
	$width = "720";
	$height = "540";
}else{
	$wide = true;
	$width = "960";
	$height = "540";
}

require_once('./templates/client_header.php');

$forwardid = $input->HoloText($_GET['forwardId']);
$roomid = $input->HoloText($_GET['roomId']);
$shortcut = $_GET['shortcut'];
switch($shortcut){
	case "roomomatic": $shortcut = "1"; break;
	default: unset($_GET['shortcut']); break;
}
?>
<body id="client"<?php if($wide == true){ ?> class="wide"<?php } ?>>

<div id="client-topbar" style="display:none">

  <div class="logo"><img src="<?php echo PATH; ?>/web-gallery/images/popup/popup_topbar_habbologo.gif" alt="" align="middle"/></div>
  <div class="habbocount"><div id="habboCountUpdateTarget">
<?php echo GetOnlineCount()." ".$lang->loc['members.online']; ?>
</div>
	<script language="JavaScript" type="text/javascript">
		setTimeout(function() {
			HabboCounter.init(600);
		}, 20000);
	</script>
</div>
  <div class="logout"><a href="<?php echo PATH; ?>/account/logout?origin=popup" onclick="self.close(); return false;"><?php echo $lang->loc['close.hotel']; ?></a></div>
</div>
<noscript>
  <img src="<?php echo PATH; ?>/clientlog/nojs" border="0" width="1" height="1" alt="" style="position: absolute; top:0; left: 0"/>
</noscript>

<div id="clientembed-container">
<div id="clientembed-loader" class="loader-image" style="display:none">
    <div class="loader-image-inner">
        <b class="loading-text"><?php echo $lang->loc['loading']; ?>...</b>
    </div>
</div>
<div id="clientembed">
<script type="text/javascript" language="javascript">
try {
var _shockwaveDetectionSuccessful = true;
_shockwaveDetectionSuccessful = ShockwaveInstallation.swDetectionCheck();
if (!_shockwaveDetectionSuccessful) {
    log(50);
}
if (_shockwaveDetectionSuccessful) {
  HabboClientUtils.cacheCheck();
}
} catch(e) {
    try {
		HabboClientUtils.logClientJavascriptError(e);
	} catch(e2) {}
}

	HabboClientUtils.extWrite("<object classid=\"clsid:166B1BCA-3F9C-11CF-8075-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=10,0,0,0\" id=\"Theme\" width=\"960\" height=\"540\"\>\n<param name=\"src\" value=\"<?php echo $settings->find("client_dcr"); ?>\"\>\n<param name=\"swRemote\" value=\"swSaveEnabled=\'true\' swVolume=\'true\' swRestart=\'false\' swPausePlay=\'false\' swFastForward=\'false\' swTitle=\'Themehotel\' swContextMenu=\'true\' \"\>\n<param name=\"swStretchStyle\" value=\"stage\"\>\n<param name=\"swText\" value=\"\"\>\n<param name=\"bgColor\" value=\"#000000\"\>\n   <param name=\"sw6\" value=\"client.connection.failed.url=<?php echo PATH; ?>clientutils.php?key=connection_failed;external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>\"\>\n   <param name=\"sw8\" value=\"use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?>\"\>\n   <param name=\"sw2\" value=\"connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>\"\>\n   <param name=\"sw4\" value=\"site.url=<?php echo PATH; ?>;url.prefix=<?php echo PATH; ?>\"\>\n   <param name=\"sw3\" value=\"connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>\"\>\n   <param name=\"sw1\" value=\"client.allow.cross.domain=1;client.notify.cross.domain=0\"\>\n   <param name=\"sw7\" value=\"external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>\"\>\n       <param name=\"sw5\" value=\"client.reload.url=<?php echo PATH; ?>client.php?x=reauthenticate;client.fatal.error.url=<?php echo PATH; ?>/clientutils.php?key=error\"\>\n<embed src=\"<?php echo $settings->find("client_dcr"); ?>\" bgColor=\"#000000\" width=\"960\" height=\"540\" swRemote=\"swSaveEnabled=\'true\' swVolume=\'true\' swRestart=\'false\' swPausePlay=\'false\' swFastForward=\'false\' swTitle=\'Habbo Hotel\' swContextMenu=\'true\'\" swStretchStyle=\"stage\" swText=\"\" type=\"application/x-director\" pluginspage=\"http://www.macromedia.com/shockwave/download/\" \n    sw6=\"client.connection.failed.url=<?php echo PATH; ?>clientutils.php?key=connection_failed;external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>\"  \n    sw8=\"use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?>\"  \n    sw2=\"connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>\"  \n    sw4=\"site.url=<?php echo PATH; ?>\;url.prefix=<?php echo PATH; ?>\"  \n    sw3=\"connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>\"  \n    sw1=\"client.allow.cross.domain=1;client.notify.cross.domain=0\"  \n    sw7=\"external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>\"  \n    \n    sw5=\"client.reload.url=<?php echo PATH; ?>/client.php?x=reauthenticate;client.fatal.error.url=<?php echo PATH; ?>/clientutils.php?key=error\" \></embed\>\n<noembed\>client.pluginerror.message</noembed\>\n</object\>");
</script>
<noscript>
<object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=10,0,0,0" id="Theme" width="960" height="540">
<param name="src" value="<?php echo $settings->find("client_dcr"); ?>">
<param name="swRemote" value="swSaveEnabled='true' swVolume='true' swRestart='false' swPausePlay='false' swFastForward='false' swTitle='Themehotel' swContextMenu='true' ">
<param name="swStretchStyle" value="stage">
<param name="swText" value="">
<param name="bgColor" value="#000000">
      <param name="sw6" value="client.connection.failed.url=<?php echo PATH; ?>/clientutils.php?key=connection_failed;external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>">
   <param name="sw8" value="use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?>">
   <param name="sw2" value="connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>">
   <param name="sw4" value="site.url=<?php echo PATH; ?>;url.prefix=<?php echo PATH; ?>">
   <param name="sw3" value="connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>">
   <param name="sw1" value="client.allow.cross.domain=1;client.notify.cross.domain=0">
   <param name="sw7" value="external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>">
   <param name="sw5" value="client.reload.url=<?php echo PATH; ?>/client.php?x=reauthenticate;client.fatal.error.url=<?php echo PATH; ?>clientutils.php?key=error">
<!--[if IE]>client.pluginerror.message<![endif]-->
<embed src="<?php echo $settings->find("client_dcr"); ?>" bgColor="#000000" width="960" height="540" swRemote="swSaveEnabled='true' swVolume='true' swRestart='false' swPausePlay='false' swFastForward='false' swTitle='Themehotel' swContextMenu='true'" swStretchStyle="stage" swText="" type="application/x-director" pluginspage="http://www.macromedia.com/shockwave/download/"
    sw6="client.connection.failed.url=<?php echo PATH; ?>/clientutils.php?key=connection_failed;external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>"
    sw8="use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?>"
    sw2="connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>"
    sw4="site.url=<?php echo PATH; ?>;url.prefix=<?php echo PATH; ?>"
    sw3="connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>"
    sw1="client.allow.cross.domain=1;client.notify.cross.domain=0"
    sw7="external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>"
	    sw5="client.reload.url=<?php echo PATH; ?>/client.php?x=reauthenticate;client.fatal.error.url=<?php echo PATH; ?>clientutils.php?key=error" ></embed>
<noembed>client.pluginerror.message</noembed>
</object>
</noscript>

</div>
<script type="text/javascript">
HabboClientUtils.loaderTimeout = 10 * 1000;
HabboClientUtils.showLoader(["<?php echo $lang->loc['loading']; ?>", "<?php echo $lang->loc['loading']; ?>.", "<?php echo $lang->loc['loading']; ?>..", "<?php echo $lang->loc['loading']; ?>..."]);
</script>
<?php require_once('./templates/client_footer.php');
?>