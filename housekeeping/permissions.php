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

$page['dir'] = '\housekeeping';
$page['housekeeping'] = true;
@include_once('./includes/core.php');
@include_once('../includes/core.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.permissions");

$page['name'] = $lang->loc['pagename.permissions'];
$page['category'] = "dashboard";
require_once('./templates/housekeeping_header.php');
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/alert.png" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.permissions']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.permissions']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
</td>
 <td class="page_main_right">
<div class="center">
<div class="clean-error"><?php echo $lang->loc['permissions.error']; ?></div>
</div>
 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>