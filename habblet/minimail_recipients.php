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

$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new me_sql;

$output = "[";
$sql = $data->select7($user->id);

while ($row = $db->fetch_row($sql)) {
	if($row[1] == $user->id){
		$sql2 = $data->select6($row[0]);
	} else {
		$sql2 = $data->select6($row[1]);
	}

	$row = $db->fetch_row($sql2);

	$name = $row[0];
	$id = $row[1];

	$output .= "{\"id\":".$id.",\"name\":\"".$name."\"},";
}
$output = substr_replace($output,"",-1);
$output .= "]";
?>
/*-secure-
<?php echo $output; ?>
 */