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

// THIS PAGE MUST NOT BE TRANSLATED

$page['dir'] = '\housekeeping';
$page['housekeeping'] = true;
$page['rank'] = 5;
require_once('../includes/core.php');
require_once('./includes/hksession.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.about");

$page['name'] = $lang->loc['pagename.about'];
$page['category'] = "dashboard";
require_once('./templates/housekeeping_header.php');
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/about.png" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.about']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.about']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
<div class="loginuser"><strong>PHPRetro Version <?php echo $version['version']." ".$version['status']." ".$version['stable']; ?></strong></div>
<div class="hr"></div>
<div class="text">
Revision: <?php echo $version['revision']; ?><br />
Build: <?php echo $version['date']; ?><br /><br />
PHPRetro is, always has been, and always will be, free software. <strong>If you paid for this software, please report the seller to us at <i>yifanlu (at) phpretro.com</i> and demand your money back.</strong> 
To help keep the developer happy and allow him to buy a pizza every now and then, you can make a donation. 
This is completely optional, and if you decide not to donate, you won't miss out on any advantages, besides the developer's gratitude. 
All donations are processed by PayPal.<br /><br />
<div class="paypal">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>
</div>
</td>
 <td class="page_main_right">

<table>
<tr>
<td class="left" valign="top">
 <div class="text">
<h1>Coders</h1>
<div class="credits">
<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tr><td width="25%"><strong><a href="http://www.yifanlu.com/">Yifan Lu</a></strong></td><td width="75%">Main coder</td></tr>
<tr><td width="25%"><strong><a href="http://www.meth0d.org/">Meth0d</a></strong></td><td width="75%">Orginial HoloCMS coder, PHPRetro uses parts from HoloCMS</td></tr>
<tr><td width="25%"><strong><a href="">Kreechin</a>*</strong></td><td width="75%">Badge script</td></tr>
<tr><td width="25%"><strong><a href="http://www.ejeliot.com/">Edward Eliot</a>*</strong></td><td width="75%">PHPCaptcha captcha script.</td></tr>
</table>
 </div><br />
<h1>Designers</h1>
<div class="credits">
<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tr><td width="25%"><strong><a href="http://www.sulake.com/">Sulake</a>*</strong></td><td width="75%">All images, CSS styles, JavaScript, and content are created and copyrighted by Sulake Ltd.</td></tr>
<tr><td width="25%"><strong><a href="http://pixelarts.habbohack.servegame.org/">Tsuka</a>*</strong></td><td width="75%">Housekeeping designer</td></tr>
<tr><td width="25%"><strong><a href="http://www.ukumo.com/">xsixteen</a>*</strong></td><td width="75%">Housekeeping co-designer</td></tr>
<tr><td width="25%"><strong><a href="http://pixelspread.com/blog/289/css-drop-down-menu">Pixelspread</a>*</strong></td><td width="75%">CSS dropdown menu used in housekeeping</td></tr>
<tr><td width="25%"><strong><a href="http://woork.blogspot.com/2008/03/css-message-box-collection.html">Antonio Lupetti</a>*</strong></td><td width="75%">CSS message boxes used in housekeeping</td></tr>
<tr><td width="25%"><strong><a href="http://www.famfamfam.com/lab/icons/silk/">FamFamFam</a>*</strong></td><td width="75%">Silk icons used in housekeeping headers</td></tr>
</table>
 </div><br />
<h1>Beta Testers</h1>
<div class="credits">
<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tr><td width="25%"><strong><a href="http://www.ragezone.com/">RaGEZONE</a>*</strong></td><td width="75%">.::d::.; england; iJames; Meth0d; TheAJ; Suzushima; kreechin</td></tr>
<tr><td width="25%"><strong><a href="http://www.otaku-studios.com/">Otaku-Studios</a>*</strong></td><td width="75%">0ni; MyChemicalSelf</td></tr>
<tr><td width="25%"><strong><a href="http://www.hybridcore.net/">HybridCore</a>*</strong></td><td width="75%">Mir; Ethicks</td></tr>
<tr><td width="25%"><strong><a href="#">Others</a>*</strong></td><td width="75%">Abymor</td></tr>
</table>
 </div><br />
<h1>Special Thanks</h1>
<div class="credits">
<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tr><td width="25%"><strong><a href="#">.::d::. & england</a></strong></td><td width="75%">For providing me with HC and Groups to log and code.</td></tr>
<tr><td width="25%"><strong><a href="#">sisija</a></strong></td><td width="75%">Advice and some help</td></tr>
<tr><td width="25%"><strong><a href="#">Meth0d</a></strong></td><td width="75%">Creating HoloCMS, the basis of PHPRetro</td></tr>
</table>
 </div>
 </td>
 <td class="right" valign="top">
 <div class="text">
<h1>Help</h1>
<div class="credits">
<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tr><td width="25%"><strong><a href="http://www.phpretro.com/">Offical Site</a></strong></td><td width="75%">Latest news and updates on the project.</td></tr>
<tr><td width="25%"><strong><a href="http://wiki.phpretro.com/">PHPRetro Wiki</a></strong></td><td width="75%">FAQs, guides, help, and support for PHPRetro. Developers may also find documentation here.</td></tr>
<tr><td width="25%"><strong><a href="http://code.google.com/p/phpretro/">Google Codes</a></strong></td><td width="75%">Download the latest version of PHPRetro and submit any bugs you find and/or suggestions you may have.</td></tr>
<tr><td width="25%"><strong><a href="http://twitter.com/phpretro/">Twitter</a></strong></td><td width="75%">Follow us on Twitter for latest development and project updates.</td></tr>
</table>
 </div><br />
<h1>License</h1>
<p>This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
<br /><br />
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
<br /><br />
You should have received a copy of the GNU General Public License
along with this program.  If not, see <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.</p><br />
<h4>* Represents people/groups that are not affiliated with the PHPRetro project.</h4>
 </div>
 </td>
</tr>
</table>
</div>
 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>