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
$version = version();
$lang->addLocale("landing.header");
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
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/common.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/habboclient.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/habboclient.js" type="text/javascript"></script>

<script type="text/javascript">
document.habboLoggedIn = true;
var habboName = "<?php echo $user->name; ?>";
var ad_keywords = "";
var habboReqPath = "<?php echo PATH; ?>";
var habboStaticFilePath = "<?php echo PATH; ?>/web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>/habbo-imaging/";
var habboPartner = "";
window.name = "client";
if (typeof HabboClient != "undefined") { HabboClient.windowName = "client"; }

</script>

<?php if($page['no_client_js'] != true){ ?>
<script type="text/javascript">
var habboClient = true;
HabboClientUtils.init({remoteCallsEnabled : true, taggingGameEnabled : false});
ffec.c("chrome://havvocmini/content/HavvocIcon.PNG");
log(4);
</script>
<?php } ?>

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
