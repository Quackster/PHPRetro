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

if($page['bypass'] != true){
$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new me_sql;

$category = $input->FilterText($_POST['eventTypeId']);
if(!is_numeric($category)){ $category = 1; }
if($category < 1 || $category > 11){ $category = 1; }
}else{
$category = 1;
}
$lang->addLocale("events.loadevents");

?>
<ul class="habblet-list">
<?php
$sql = $data->select19($category);
while ($row = $db->fetch_row($sql)) {
	foreach ($row as &$value) {
		$value = $input->HoloText($value);
	}
	$roomrow = $serverdb->fetch_row($data->select13($row[4]));
	$i++;

	if($input->IsEven($i)){
		$even = "odd";
	} else {
		$even = "even";
	}
	
	if($roomrow[1] == 0){ $roomrow[1] = 1; }
	$room[$i] = ($roomrow[0] / $roomrow[1]) * 100;
	
	if($room[$i] == 99 || $room[$i] > 99){
		$room_fill = 5;
	} elseif($room[$i] > 65){
		$room_fill = 4;
	} elseif($room[$i] > 32){
		$room_fill = 3;
	} elseif($room[$i] > 0){
		$room_fill = 2;
	} elseif($room[$i] < 1){
		$room_fill = 1;
	}

	printf("<li class=\"%s room-occupancy-%s\" roomid=\"%s\">
<div title=\"".$lang->loc['go.to.room']."\">
	<span class=\"event-name\"><a href=\"".PATH."/client?forwardId=2&amp;roomId=%s\" onclick=\"HabboClient.roomForward(this, '%s', 'private'); return false;\">%s</a></span>
	<span class=\"event-owner\"> by <a href=\"".PATH."/home/%s\">%s</a></span>
	<p>%s (<span class=\"event-date\">%s</span>)</p>
</div>
</li>", $even, $room_fill, $row[4], $row[4], $row[4], $input->HoloText($row[1]), $roomrow[2], $roomrow[2], $input->HoloText($row[2]), $row[6]);
}
?>
</ul>