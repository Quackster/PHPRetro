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

$page['bypass_user_check'] = true;
session_start();
if(!empty($_GET['installed'])){
	if(!file_exists('../includes/config.php')){
		require_once('./install_classes.php');
		$lang = new HoloLocaleInstaller;
		$lang->addLocale("installer.messages");
	}else{
		$page['dir'] = '\install';
		$page['old'] = getcwd();
		require_once('../includes/core.php');
		$lang->addLocale("installer.messages");
		chdir($page['old']);
	}
	$_SESSION = array(); @session_destroy();
	
	switch($_GET['installed']){
	default:
		$title = $lang->loc['success'];
		$color = "rounded rounded-green";
		$message = $lang->loc['installed.message'];
		break;
	case "upgraded":
		$title = $lang->loc['success'];
		$color = "rounded rounded-green";
		$message = $lang->loc['upgraded.message'];
		break;
	}
}elseif(file_exists('../includes/config.php') && $_GET['bypass'] != "true"){
	$page['dir'] = '\install';
	$page['old'] = getcwd();
	require_once('../includes/core.php');
	$lang->addLocale("installer.messages");
	
	$version = unserialize($settings->find("version"));
	$new_version = version();
	if((int) $new_version['revision'] > (int) $version['revision']){
		$_SESSION['from_version'] = $version;
		$_SESSION['to_version'] = $new_version;
		$_SESSION['install_started'] = true;
		$n = $version['revision'];
		while($n <= $new_version['revision']){
		 $n++;
		 if(file_exists('./install/upgrade_'.$n.'.php')){
		 	header('Location: '.PATH.'/install/upgrade_'.$n.'.php');
		 	exit; break;
		 }
		}
		$title = $lang->loc['error'];
		$color = "rounded rounded-red";
		$message = $lang->loc['error.no.upgrades'];
	}elseif($new_version['revision'] == $version['revision']){
		$title = $lang->loc['error'];
		$color = "rounded rounded-red";
		$message = $lang->loc['error.delete.installer'];
	}else{
		$title = $lang->loc['error'];
		$color = "rounded rounded-red";
		$message = $lang->loc['error.version.lower'];
	}
	chdir($page['old']);
}elseif(file_exists('../config.php')){
	$_SESSION['install_started'] = true;
	header('Location: ./migrate.php'); exit;
}else{
	$_SESSION['install_started'] = true;
	header('Location: ./install.php'); exit;
}

require_once('./installer_header.php');
?>
<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content">
			<div id="header" class="clearfix">
				<h1><a href="#"></a></h1>
				<ul class="stats">
					    <li class="stats-online"><span class="stats-fig"><?php echo $title; ?></span></li>
				</ul>
			</div>
		<div id="column1" class="column">
			     		
				<div class="habblet-container ">		

	        <div id="installer-column-left" >

            <div id="installer-section-left">
	        </div>


        </div>
        <div id="installer-column-right">

            <div id="installer-section-right">
            	<div class="installer-error">
                	<div class="<?php echo $color; ?>">
                    	<?php echo $message; ?>
                	</div>
                </div>
            </div>
	    </div>
    </form>
	
						
							
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<?php require_once('./installer_footer.php'); ?>