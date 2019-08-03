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
$page['rank'] = 5;
require_once('../includes/core.php');
require_once('./includes/hksession.php');
$data = new housekeeping_sql;
$lang->addLocale("housekeeping.updates");

$version = version();
$update = @file_get_contents('http://www.phpretro.com/system/version_check.php?version='.$version['version'].".".$version['revision'].'&stable='.$version['stable']);
$update = @unserialize($update);

if(empty($update)){
	$content = '<div class="clean-ok">'.$lang->loc['no.updates'].'</div>';
}else{
	$content = 
	'<div class="clean-ok">'.$lang->loc['new.version'].'</div>
	<p><strong>'.$lang->loc['latest.version'].':</strong> '.$update[0]['build'].' '.$update[0]['stable'].'<br />
	<a href="http://www.phpretro.com/downloads?version='.$update[0]['buildstring'].'">'.$lang->loc['download.now'].'</a><br /><br />
	<strong>'.$lang->loc['changelog'].':</strong>';
	foreach($update as $build){
		$content .= 
		'<div class="clean-gray">
		<strong>'.$lang->loc['version'].' '.$build['build'].' '.$build['stable'].'</strong><br />
		'.nl2br($build['message']).'
		</div>';
	}
}

$page['name'] = $lang->loc['pagename.updates'];
$page['category'] = "home";
require_once('./templates/housekeeping_header.php');
?>
<div class="page_title">
 <img src="<?php echo PATH; ?>/housekeeping/images/icons/updates.png" class="pticon">
 <span class="page_name_shadow"><?php echo $lang->loc['pagename.updates']; ?></span>

 <span class="page_name"><?php echo $lang->loc['pagename.updates']; ?></span>
</div>
<div class="page_main">

<table border="0" cellpadding="0" cellspacing="0" height="100%">
<tbody>
<tr height="100%" />
<td class="page_main_left">
<div class="left_date"><?php echo date('l F j, Y | g:iA'); ?></div>
<div class="hr"></div>
<div class="text">
<p><?php echo $lang->loc['updates.desc']; ?></p>
</div>
</td>
 <td class="page_main_right">
<div class="center">
<?php echo $content; ?>
</div>
 </td>
</tr>
</tbody>
</table>

</div>
<?php require_once('./templates/housekeeping_footer.php'); ?>