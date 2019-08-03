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

$version = version();
$lang->addLocale("housekeeping.header");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>PHPRetro Housekeeping: <?php echo $page['name']; ?></title>
    <link rel="shortcut icon" href="<?php echo PATH; ?>/housekeeping/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="stylesheet" href="<?php echo PATH; ?>/housekeeping/images/styles/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo PATH; ?>/housekeeping/images/styles/boxes.css" type="text/css">
<?php if($page['scrollbar'] == true){ ?>
<script type="text/javascript" src="<?php echo PATH; ?>/housekeeping/images/js/jsScroller.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/housekeeping/images/js/jsScrollbar.js"></script>
<script type="text/javascript">
var scroller  = null;
var scrollbar = null;
</script>
<?php } ?>
<?php if($page['second_scrollbar'] == true){ ?>
<script type="text/javascript" src="<?php echo PATH; ?>/housekeeping/images/js/jsScroller2.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>/housekeeping/images/js/jsScrollbar2.js"></script>
<script type="text/javascript">
var scroller2  = null;
var scrollbar2 = null;
</script>
<?php } ?>
<script type="text/javascript">
window.onload = function(){
<?php if($page['scrollbar'] == true){ ?>
 scroller  = new jsScroller(document.getElementById("listview"), 244, 96);
 scrollbar = new jsScrollbar (document.getElementById("Scrollbar-Container"), scroller, false);
<?php } ?>
<?php if($page['second_scrollbar'] == true){ ?>
 scroller2  = new jsScroller2(document.getElementById("listview2"), 244, 96);
 scrollbar2 = new jsScrollbar2 (document.getElementById("Scrollbar2-Container"), scroller2, false);
<?php } ?>
};
</script>

<meta name="build" content="PHPRetro <?php echo $version['version']." ".$version['stable']; ?>" />
</head>
<body>

<div class="panel">

<div class="header_left">&nbsp;<br />&nbsp;<br />&nbsp;<br /><a href="http://www.phpretro.com/"><img src="<?php echo PATH; ?>/housekeeping/images/header_logo.png" alt="PHPRetro"></a></div>
<div class="header_right"><img src="<?php echo PATH; ?>/housekeeping/images/header_tm1.gif"></div>

<div class="panel_title">
<span class="text">PHPRetro <?php echo $version['major'].".".$version['minor']; ?> <?php echo $lang->loc['housekeeping']; ?></span>
<div class="close_button"><a href="<?php echo PATH; ?>/housekeeping/logout"><img src="<?php echo PATH; ?>/housekeeping/images/button_close.gif" alt="<?php echo $lang->loc['logout']; ?>"></a></div>
</div>

<?php if($page['category'] != "login"){ ?>
<div class="panel_header">

	<ul <?php if($page['category'] == "dashboard"){ ?>class="selected" <?php } ?>id="item">
	<li class="top"><div style="text-align:center"><a href="#"><?php echo $lang->loc['dashboard']; ?></a></div></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/dashboard"><?php echo $lang->loc['home']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/updates"><?php echo $lang->loc['updates']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/logs"><?php echo $lang->loc['logs']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/about"><?php echo $lang->loc['about']; ?></a></li>
	</ul>
	<div class="border"></div>

	<ul <?php if($page['category'] == "settings"){ ?>class="selected" <?php } ?>id="item">
	<li class="top"><div style="text-align:center"><a href="#"><?php echo $lang->loc['settings']; ?></a></div></li>
	<?php $sql = $db->query("SELECT id,name FROM ".PREFIX."settings_pages ORDER BY `order` ASC");
	while($row = $db->fetch_row($sql)){ echo "<li class=\"item\"><a href=\"".PATH."/housekeeping/settings/".$row[0]."\">".$row[1]."</a></li>\n"; }
	?>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/cache"><?php echo $lang->loc['cache']; ?></a></li>
	</ul>
	<div class="border"></div>

	<ul <?php if($page['category'] == "tools"){ ?>class="selected" <?php } ?>id="item">
	<li class="top"><div style="text-align:center"><a href="#"><?php echo $lang->loc['tools']; ?></a></div></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/banners"><?php echo $lang->loc['banners']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/campaigns"><?php echo $lang->loc['campaigns']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/catalogue"><?php echo $lang->loc['catalogue']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/collectables"><?php echo $lang->loc['collectables']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/faq"><?php echo $lang->loc['faq']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/news"><?php echo $lang->loc['news']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/newsletter"><?php echo $lang->loc['newsletter']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/recommended"><?php echo $lang->loc['recommended']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/vouchers"><?php echo $lang->loc['vouchers']; ?></a></li>
	</ul>
	<div class="border"></div>

	<ul <?php if($page['category'] == "users"){ ?>class="selected" <?php } ?>id="item">
	<li class="top"><div style="text-align:center"><a href="#"><?php echo $lang->loc['users']; ?></a></div></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/users"><?php echo $lang->loc['users']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/bans"><?php echo $lang->loc['bans']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/alerts"><?php echo $lang->loc['alerts']; ?></a></li>
	<li class="item"><a href="<?php echo PATH; ?>/housekeeping/help"><?php echo $lang->loc['help']; ?></a></li>
	</ul>
	<div class="border"></div>
</div>
<div class="clear"></div>
<?php } ?>


<div class="topborder"></div>
