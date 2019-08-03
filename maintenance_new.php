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

$page['id'] = "maintenance";
require_once('./includes/core.php');
$lang->addLocale("maintenance.new");

if($settings->find("site_closed") == "0"){
	header("Location: ".PATH."/"); exit;
}

require_once('./templates/maintenance_new_header.php');

?>
<div id="container">
	<div id="content">
		<div id="header" class="clearfix">
			<h1><span></span></h1>
		</div>
		<div id="process-content">

<div class="fireman">

<h1><?php echo $lang->loc['maintenance.break']; ?></h1>

<p>
<?php echo $lang->loc['maintenance.desc']; ?>
</p>

</div>

<?php if($settings->find("maintenance_twitter") != ""){ ?>
<div class="tweet-container">

<h2><?php echo $lang->loc['twitter.title']; ?></h2>

<div class="tweet"></div>

</div>
<?php } ?>
<?php require_once('./templates/maintenance_new_footer.php'); ?>