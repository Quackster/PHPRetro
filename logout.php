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
$lang->addLocale("landing.logout");

$user->destroy();
$reason = $_GET['reason'];

$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "landing";

require_once('./templates/login_header.php');
?>

<div id="process-content">
<?php if($reason == ""){ ?>
	        	<div class="action-confirmation flash-message">
	<div class="rounded">
		<div class="rounded-done"><?php echo $lang->loc['logout.success.1']; ?></div>
	</div>

</div>
<?php }else{
switch($reason){
	case "banned":
		$reason = $lang->loc['logout.error.1'];
		break;
	case "concurrentlogin":
		$reason = $lang->loc['logout.error.2'];
		break;
	default:
		header("Location: ".PATH."/account/logout_ok");
		break;
}
?>
	        	<div class="action-error flash-message">
	<div class="rounded">
		<div class="rounded-done"><?php echo $reason; ?></div>
	</div>

</div>
<?php } ?>

<div style="text-align: center">
	
	<div style="width:100px; margin: 10px auto"><a href="<?php echo PATH; ?>/" id="logout-ok" class="new-button fill"><b><?php echo $lang->loc['ok']; ?></b><i></i></a></div>

<div id="column1" class="column">              
</div>
<div id="column2" class="column">
</div>

</div>

<?php require('./templates/login_footer.php'); ?>