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
$lang->addLocale("maintenance");

if($settings->find("site_closed") == "0"){
	header("Location: ".PATH."/"); exit;
}

if($settings->find("maintenance_style") == "1"){
	require("./maintenance_new.php"); exit;
}

require_once('./templates/maintenance_header.php');

?>
<div id="page-container">
	<div id="header-container">
	</div>
	<div id="maintenance-container">
		<div id="content-container">
			<div id="inner-container">

			<div id="left_col">

			<!-- bubble -->

			<div class="bubble">
				<div class="bubble-body">
					<img src="<?php echo PATH; ?>/web-gallery/maintenance/alert_triangle.gif" width="30" height="29" alt="" border="0" align="left" class="triangle" />
					<b><?php echo $lang->loc['text.1']; ?></b>
					<div class="clear"></div>
				</div>
			</div>
			<div class="bubble-bottom">

				<div class="bubble-bottom-body">
					<img src="<?php echo PATH; ?>/web-gallery/maintenance/bubble_tail_left.gif" alt="" width="22" height="31" />
				</div>
			</div>
			<!-- \bubble -->

			<img src="<?php echo PATH; ?>/web-gallery/maintenance/frank_habbo_down.gif" width="57" height="87" alt="" border="0" />

			</div>

			<div id="right_col">

			<!-- bubble -->
			<div class="bubble">
				<div class="bubble-body">
					<?php echo $lang->loc['text.2']; ?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="bubble-bottom">

				<div class="bubble-bottom-body">
					<img src="<?php echo PATH; ?>/web-gallery/maintenance/bubble_tail_left.gif" alt="" width="22" height="31" />
				</div>
			</div>
			<!-- \bubble -->

			<img src="<?php echo PATH; ?>/web-gallery/maintenance/workman_habbo_down.gif" width="125" height="118" alt="" border="0" />

			</div>

			</div>
		</div>
	</div>

<?php require_once('./templates/maintenance_footer.php'); ?>