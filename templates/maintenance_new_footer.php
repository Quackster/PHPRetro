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

<div id="footer">
<?php /*@@* DO NOT EDIT OR REMOVE THE LINE BELOW WHATSOEVER! *@@ You ARE allowed to remove the links though*/ ?>
<p class="copyright">Powered by <a href="http://www.phpretro.com/">PHPRetro</a> &copy 2009 <a href="http://www.yifanlu.com/">Yifan Lu</a>, Based on HoloCMS By <a href="http://www.meth0d.org">Meth0d</a><br /><?php echo $lang->loc['copyright.habbo']; ?></p>
<?php /*@@* DO NOT EDIT OR REMOVE THE LINE BELOW WHATSOEVER! *@@ You ARE allowed to remove the links though*/ ?>
</div>

		</div>
	</div>
</div>

<?php echo $settings->find("site_tracking"); ?>

<?php if($settings->find("maintenance_twitter") != ""){ ?>
<script type='text/javascript'>
$(document).ready(function(){
  $(".tweet").tweet({
    username: "<?php echo $settings->find("maintenance_twitter"); ?>",
    count: 5
  });
});
</script>
<?php } ?>

</body>
</html>