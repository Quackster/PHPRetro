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

$revision = $_SESSION['upgrade_version'];
if((int) $_SESSION['to_version']['revision'] > (int) $revision){
	$n = $revision;
	while($n <= $_SESSION['to_version']['revision']){
	 $n++;
	 if(file_exists('./install/upgrade_'.$n.'.php')){
		header('Location: '.PATH.'/install/upgrade_'.$n.'.php');
		exit; break;
	 }
	}
}
$db->query("UPDATE ".PREFIX."settings SET value = '".serialize(version())."' WHERE id = 'version' LIMIT 1");
$settings->generateCache();
header('Location: '.PATH.'/install/?installed=upgraded');
?>