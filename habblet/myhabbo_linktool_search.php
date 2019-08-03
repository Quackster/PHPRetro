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
$data = new home_sql;
$lang->addLocale("linktool");

$query = $input->FilterText($_GET['query']);
$scope = $_GET['scope'];

$sql = $data->select3($query,$scope);

switch($scope){
	case 1: $type = "habbo"; break;
	case 2: $type = "room"; break;
	case 3: $type = "group"; break;
}
?>
<ul>
	<li><?php echo $lang->loc['linktool.add']; ?></li>
<?php while($row = $db->fetch_row($sql)){ ?>

    <li><a href="#" class="linktool-result" type="<?php echo $type; ?>" 
    	value="<?php echo $input->HoloText($row[0]); ?>" title="<?php echo $input->HoloText($row[1]); ?>"><?php echo $input->HoloText($row[1]); ?></a></li>

<?php } ?>
</ul>