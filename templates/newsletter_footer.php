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

$lang->addLocale("email.footer");
$lang->addLocale("newsletter.header.footer");
?>

</td></tr></tbody></table>

</td>

<td width="5" background="<?php echo PATH; ?>/web-gallery/newsletter/images/outline.gif"> </td> </tr>

<tr> <td width="5" background="<?php echo PATH; ?>/web-gallery/newsletter/images/outline.gif"> </td>

<td bgcolor="#47839d">

<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#47839d">

<tbody><tr> <td width="7"> </td> <td width="552" valign="bottom" height="7"><img width="552" height="7" src="<?php echo PATH; ?>/web-gallery/newsletter/images/disclaimer_top.gif" /></td> <td width="7"> </td> </tr>

<tr> <td width="7"> </td> <td width="552" bgcolor="#0a4362">

<p align="center" style="font-family: Verdana; color: white; font-size: 9px;">

<?php echo $lang->loc['sent.by']; ?> (<a style="color: white; font-size: 10px;" target="_blank" href="<?php echo PATH; ?>"><?php echo PATH; ?></a>). <?php echo $lang->loc['not.spam']; ?>

</p>

</td> <td width="7"> </td> </tr>

<tr> <td width="7"> </td> <td width="552" valign="top" height="7"><img width="552" height="7" src="<?php echo PATH; ?>/web-gallery/newsletter/images/disclaimer_bottom.gif" /></td> <td width="7"> </td> </tr>

<tr> <td style="padding-top: 5px;" colspan="4">

<p align="center" style="background-color: rgb(71, 131, 157); color: white; font-family: Verdana; font-size: 9px; font-weight: bold;"><?php echo $lang->loc['replies.not.processed']; ?></p>

<p align="center" style="background-color: rgb(71, 131, 157); color: white; font-family: verdana; font-size: 9px;"> <a style="color: white; font-size: 10px;" target="_blank" href="<?php echo PATH; ?>"><?php echo PATH; ?></a>
<br /><?php echo $lang->loc['copyright']; ?></p>

</td></tr>

</tbody></table>

</td>

<td width="5" background="<?php echo PATH; ?>/web-gallery/newsletter/images/outline.gif"> </td>

</tr><tr><td width="576" valign="top" height="12" background="<?php echo PATH; ?>/web-gallery/newsletter/images/email_bottom_trans.gif" colspan="4"> </td></tr>

</tbody></table>