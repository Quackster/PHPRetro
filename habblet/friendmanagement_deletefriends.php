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
$data = new profile_sql;

$pagesize = $_POST['pageSize'];

if(isset($_POST['friendList'])){
	$friends = $_POST['friendList'];
    foreach($friends as $id){
		$id = $input->FilterText($id);
        $data->delete1($id,$user->id);
    }
}elseif(isset($_POST['friendId'])){
	$id = $input->FilterText($_POST['friendId']);
    $data->delete1($id,$user->id);
} else{
	echo "Unknown error!";
}

$page['bypass'] = true;
$page = 1;
$pagesize = 30;
$search = "";
require_once('./habblet/friendmanagement_viewcategory.php');
?>