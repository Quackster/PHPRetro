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

/*

	Please do not remove the copyright infomation below.  Doing so shows disrespct towards all HoloCMS/PHPRetro developers.
	You may remove any links though (you selfish jerk)
	
	The developers of this project do this for free with no personal gain, if you remove the copyright, you are breaking the license.
	If I find too many people doing so, then either 1) the project will be discontinued, or 2) the project will be closed-source

*/

$lang->addLocale("footer");
?>

<div class="page_footer">
<div class="buttons">

<input type="button" class="footer_button" value="<?php echo $lang->loc['link.homepage']; ?>" onclick="window.location.href='<?php echo PATH; ?>/'"></input>
</div>
</div>
<?php /*@@* DO NOT EDIT OR REMOVE THE LINE BELOW WHATSOEVER! *@@ You ARE allowed to remove the links though*/ ?>
<div class="copylight">Powered by <a href="http://www.phpretro.com/">PHPRetro</a><br />Housekeeping design &copy; 2009 <a href="http://www.ukumo.com/">xsixteen</a>, <a href="http://pixelarts.habbohack.servegame.org">Tsuka</a><br /><?php echo $lang->loc['copyright.habbo']; ?></div>
<?php /*@@* DO NOT EDIT OR REMOVE THE LINE ABOVE WHATSOEVER! *@@ You ARE allowed to remove the links though*/ ?>
</div>

<?php echo $settings->find("site_tracking"); ?>

</body>
</html>