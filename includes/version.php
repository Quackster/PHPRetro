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

function version() {
	$holocms['major'] = "4";
	$holocms['minor'] = "0";
	$holocms['build'] = "10";
	$holocms['revision'] = "85";
	$holocms['version'] = $holocms['major'].".".$holocms['minor'].".".$holocms['build'];
	$holocms['stable'] = "unstable";
	$holocms['status'] = "BETA";
	$holocms['date'] = "October 4, 2009 11:13AM BST";
	return $holocms;
}
?>