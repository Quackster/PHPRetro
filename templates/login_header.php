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

if (!defined("IN_HOLOCMS")) { header("Location: ".PATH."/"); exit; }
$lang->addLocale("landing.header");
$version = version();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo SHORTNAME; ?>: <?php echo $page['name']; ?> </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
    <link rel="shortcut icon" href="<?php echo PATH; ?>/web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="alternate" type="application/rss+xml" title="<?php echo SHORTNAME; ?>: <?php echo $lang->loc['rss']; ?>" href="<?php echo PATH; ?>/articles/rss.xml" />

<?php if($page['new_landing'] == true){ ?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/landing.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/local/com.css" type="text/css" />

<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/frontpage.css" type="text/css" />
<style type="text/css">
body {background-color: }
</style>
<?php }else{ ?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
<?php if($page['bodyid'] == "intermediate"){ ?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/common.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/fullcontent.js" type="text/javascript"></script>
<?php }else{ ?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/landing.js" type="text/javascript"></script>
<?php } ?>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/local/com.css" type="text/css" />

<script src="<?php echo PATH; ?>/web-gallery/js/local/com.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/process.css" type="text/css" />
<?php } ?>

<script type="text/javascript">
document.habboLoggedIn = false;
var habboName = null;
var ad_keywords = "";
var habboReqPath = "<?php echo PATH; ?>";
var habboStaticFilePath = "<?php echo PATH; ?>/web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo PATH; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") { HabboClient.windowName = "client"; }

</script>

<?php switch($page['bodyid']){
case "logout": ?>
<script language="JavaScript" type="text/javascript">
	document.logoutPage = true;
	</script>
<?php 
break;
case "intermediate": 
?>
<script type="text/javascript">
        var timeoutID = null;
        function timedRedirect()
        {
           timeoutID=setTimeout("location.href='<?php echo PATH; ?>/me'",30000);
        }
        function onClientOpen(f)
        {
           if (timeoutID != null) {
               clearTimeout(timeoutID);
           }
           HabboClient.openOrFocus(f);
           return false;
        }
      </script>
<?php 
break;
} ?>

<meta name="description" content="<?php echo $settings->find("site_description"); ?>" />
<meta name="keywords" content="<?php echo $settings->find("site_keywords"); ?>" />

<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/ie6.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(<?php echo PATH; ?>/web-gallery/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="PHPRetro <?php echo $version['version']." ".$version['status']; ?>" />
</head>
<body <?php if($page['bodyid'] != ""){ ?>id="<?php echo $page['bodyid']; ?>"<?php } ?><?php if($page['new_landing'] != true){ ?> class="process-template"<?php } ?>>

<?php if($page['new_landing'] != true){ ?>
<div id="overlay"></div>

<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content">

			<div id="header" class="clearfix">
				<h1><a href="<?php echo PATH; ?>/"></a></h1>
				<ul class="stats">
					    <li class="stats-online"><span class="stats-fig"><?php echo GetOnlineCount(); ?></span> <?php echo $lang->loc['users.online.now']; ?></li>
					    <li class="stats-visited"><img src="<?php echo PATH; ?>/web-gallery/v2/images/<?php echo HotelStatus(); ?>.gif" alt="<?php echo HotelStatus(); ?>" border="0"></li>
				</ul>

			</div>
			<div id="process-content">
<?php } ?>