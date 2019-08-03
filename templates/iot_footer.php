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

/*

	Please do not remove the copyright infomation below.  Doing so shows disrespct towards all HoloCMS/PHPRetro developers.
	You may remove any links though (you selfish jerk)
	
	The developers of this project do this for free with no personal gain, if you remove the copyright, you are breaking the license.
	If I find too many people doing so, then either 1) the project will be discontinued, or 2) the project will be closed-source

*/

$lang->addLocale("footer");
?>

 <div id="footer-process">
  <div id="footer-top-process" style="font-size:8px"
>&nbsp;</div>

  <div id="footer-body-process">
   <table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr><td align="center">Powered by <a href="http://www.phpretro.com/">PHPRetro</a><br /><?php echo $lang->loc['copyright.habbo']; ?></td></tr>
   </table>
  </div>
  <div id="footer-bottom-process">&nbsp;</div>
 </div>
<?php echo $settings->find("site_tracking"); ?>

</body>
</html>