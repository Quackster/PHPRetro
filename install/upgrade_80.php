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

$page['dir'] = '\install';
require_once('../includes/core.php');
$lang->addLocale("installer.main");
$lang->addLocale("installer.upgrade");

$_SESSION['upgrade_version'] = 80;
$version = "4.0.8";
$description = $lang->loc['page.desc'];
$title = $lang->loc['page.title'];

require_once('./install/installer_header.php');
?>
<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content">
			<div id="header" class="clearfix">
				<h1><a href="#"></a></h1>
				<ul class="stats">
					    <li class="stats-online"><span class="stats-fig"><?php echo $lang->loc['version']; ?> <?php echo $version; ?></span> <?php echo $lang->loc['upgrading']; ?></li>
				</ul>
			</div>
			<div id="process-content">
		<div id="column1" class="column">
			     		
				<div class="habblet-container ">

	        <div id="installer-column-left" >

            <div id="installer-section-left">
	            <div class="cbb clearfix gray">
	            	<div class="box-content">
	                	<div class="installer-description"><label><?php echo $description; ?></label></div>
		            </div>
	            </div>
	        </div>


        </div>
        <div id="installer-column-right">

            <div id="installer-section-right">
            <?php if(isset($error)){ ?>
            	<div class="installer-error">
                	<div class="rounded rounded-red">
                    	<?php echo $error; ?>
                	</div>
                </div>
            <?php } ?>
                <div class="rounded rounded-blue">
                    <h2 class="heading"><?php echo $title; ?></h2>

                    <fieldset id="installer-fieldset">
                    	<?php
						$lang->addLocale("installer.queries");
                    	?>
                    	<?php echo $lang->loc['fixing.client.error.log']; ?>...<br />
						<?php $db->query("ALTER TABLE ".PREFIX."client_errors CHANGE COLUMN `ip` `ip` text, CHANGE COLUMN `error_type` `error_type` text, CHANGE COLUMN `os` `os` text, CHANGE COLUMN `error_id` `error_id` text, CHANGE COLUMN `hookerror` `hookerror` text, CHANGE COLUMN `error_message` `error_message` text, CHANGE COLUMN `hookmsgb` `hookmsgb` text, CHANGE COLUMN `lastexecute` `lastexecute` text, CHANGE COLUMN `lastmessage` `lastmessage` text, CHANGE COLUMN `server_errors` `server_errors` text, CHANGE COLUMN `lastroom` `lastroom` text, CHANGE COLUMN `mus_errorcode` `mus_errorcode` text, CHANGE COLUMN `client_process_list` `client_process_list` text, CHANGE COLUMN `client_errors` `client_errors` text, CHANGE COLUMN `neterr_cast` `neterr_cast` text, CHANGE COLUMN `neterr_res` `neterr_res` text, CHANGE COLUMN `client_uptime` `client_uptime` text;"); ?>
						<?php echo $lang->loc['adding.security.log']; ?>...<br />
						<?php $db->query(
							"CREATE TABLE `".PREFIX."security_log` (
							  `id` int NOT NULL AUTO_INCREMENT,
							  `userid` int NOT NULL,
							  `ipaddress` varchar(255) NOT NULL,
							  `subject` varchar(255) NOT NULL,
							  `event` text NOT NULL,
							  `time` int(10) NOT NULL,
							  PRIMARY KEY (`id`),
							  KEY `id` (`id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
										);
						?>
						<?php echo $lang->loc['done']; ?>.
                    </fieldset>

                </div>
            </div>

            <div id="installer-buttons">
            <form method="POST" action="./upgrade.php" />
                <input type="submit" name="submit" value="<?php echo $lang->loc['continue']; ?>" class="continue" id="installer-button-continue" />
            </form>
            </div>
	    </div>
    </form>
	
						
							
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<?php require_once('./install/installer_footer.php'); ?>