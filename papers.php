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

require_once('./includes/core.php');
$data = new index_sql;
$lang->addLocale("landing.papers");

$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "landing";
require_once('./templates/login_header.php');

if($_GET['page'] == "disclaimer"){
	$title = $lang->loc['disclaimer'];
	$content = $settings->find("paper_disclaimer");
}else{
	$title = $lang->loc['privacy.policy'];
	$content = $settings->find("paper_privacy");
}

?>

<div id="process-content">
	        	<div id="terms" class="box-content">
<div class="tos-header"><b><?php echo $title; ?></b></div>
<div class="tos-item"><?php echo $content; ?></div>
</div>



<?php

require('./templates/login_footer.php');

?>