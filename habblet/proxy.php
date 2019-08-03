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
$page['allow_guests'] = true;
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new me_sql;

$hid = $input->FilterText($_GET['hid']);
$first = $input->FilterText($_GET['first']);
?>
<?php 
switch($hid){
case "h120":
$data = new community_sql;
$lang->addLocale("events.loadevents"); ?>
<head>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/rooms.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/rooms.js" type="text/javascript"></script>
</head>
<div id="rooms-habblet-list-container-h120" class="recommendedrooms-lite-habblet-list-container">
        <ul class="habblet-list">

<?php
$i = 0;
$sql = $data->select2(5,0);

while ($row = $db->fetch_row($sql)) {
	$i++;
	if($input->IsEven($i)){
		$even = "odd";
	} else {
		$even = "even";
	}
	if($row[4] == 0){ $row[4] = 1; }
	$count[$i] = ($row[4] / $row[5]) * 100;
	if($count[$i] == 99 || $count[$i] > 99){
		$room_fill = 5;
	} elseif($count[$i] > 65){
		$room_fill = 4;
	} elseif($count[$i] > 32){
		$room_fill = 3;
	} elseif($count[$i] > 0){
		$room_fill = 2;
	} elseif($count[$i] < 1){
		$room_fill = 1;
	}
	
	if($row[6] != "1"){ $row[3] = ""; }

printf("<li class=\"%s\">
    <span class=\"clearfix enter-room-link room-occupancy-%s\" title=\"".$lang->loc['go.to.room']."\" roomid=\"%s\">
	    <span class=\"room-enter\">".$lang->loc['enter']."</span>
	    <span class=\"room-name\">%s</span>
	    <span class=\"room-description\">%s</span>
		<span class=\"room-owner\">".$lang->loc['owner'].": <a href=\"".PATH."/home/%s\">%s</a></span>
    </span>
</li>\n", $even, $room_fill, $row[1], $input->unicodeToImage($input->HoloText($row[1])), $input->unicodeToImage($input->HoloText($row[1])), $row[3], $row[3]);
}
?>

        </ul>
            <div id="room-more-data-h120" style="display: none">
                <ul class="habblet-list room-more-data">

<?php
$i = 0;
$sql = $data->select2(15,5);

while ($row = $db->fetch_row($sql)) {
	$i++;
	if($input->IsEven($i)){
		$even = "odd";
	} else {
		$even = "even";
	}
	if($row[4] == 0){ $row[4] = 1; }
	$count[$i] = ($row[4] / $row[5]) * 100;
	if($count[$i] == 99 || $count[$i] > 99){
		$room_fill = 5;
	} elseif($count[$i] > 65){
		$room_fill = 4;
	} elseif($count[$i] > 32){
		$room_fill = 3;
	} elseif($count[$i] > 0){
		$room_fill = 2;
	} elseif($count[$i] < 1){
		$room_fill = 1;
	}
	
	if($row[6] != "1"){ $row[3] = ""; }

printf("<li class=\"%s\">
    <span class=\"clearfix enter-room-link room-occupancy-%s\" title=\"".$lang->loc['go.to.room']."\" roomid=\"%s\">
	    <span class=\"room-enter\">".$lang->loc['enter']."</span>
	    <span class=\"room-name\">%s</span>
	    <span class=\"room-description\">%s</span>
		<span class=\"room-owner\">".$lang->loc['owner'].": <a href=\"".PATH."/home/%s\">%s</a></span>
    </span>
</li>\n", $even, $room_fill, $row[1], $input->HoloText($row[1]), $input->HoloText($row[1]), $row[3], $row[3]);
}
?>

                </ul>
            </div>
            <div class="clearfix">
                <a href="#" class="room-toggle-more-data" id="room-toggle-more-data-h120"><?php echo $lang->loc['show.more.rooms']; ?></a>
            </div>
</div>
<script type="text/javascript">
L10N.put("show.more", "<?php echo $lang->loc['show.more.rooms']; ?>");
L10N.put("show.less", "<?php echo $lang->loc['show.less.rooms']; ?>");
var roomListHabblet_h120 = new RoomListHabblet("rooms-habblet-list-container-h120", "room-toggle-more-data-h120", "room-more-data-h120");
</script>
<?php
break;
case "h122": 
$lang->addLocale("groupswidget.ajax"); ?>
<head>
<script src="<?php echo PATH; ?>/web-gallery/static/js/moredata.js" type="text/javascript"></script>
</head>
<div id="hotgroups-habblet-list-container" class="habblet-list-container groups-list">
    <ul class="habblet-list two-cols clearfix">
<?php
$i = 0;
$j = 1;
$sql = $data->select17(10);

while ($row = $db->fetch_row($sql)) {
	$i++;
	if($input->IsEven($i)){
		$left = "right";
	} else {
		$left = "left";
		$j++;
	}
	if($input->IsEven($j)){
		$even = "even";
	} else {
		$even = "odd";
	}
	printf("<li class=\"%s %s\" style=\"background-image: url(".PATH."/habbo-imaging/badge/%s.gif)\">
			<a class=\"item\" href=\"".PATH."/groups/%s/id\"><span class=\"index\">%s.</span> %s</a>
		</li>\n", $even, $left, $row[2], $row[0], $i, $input->HoloText($row[1]));
}
?>
</ul>
    <div id="hotgroups-list-hidden-h122" style="display: none">
    <ul class="habblet-list two-cols clearfix">
<?php
$i = 10;
$j = 1;
$sql = $data->select17(40,10);

while ($row = $db->fetch_row($sql)) {
	$i++;
	if($input->IsEven($i)){
		$left = "left";
	} else {
		$left = "right";
		$j++;
	}
	if($input->IsEven($j)){
		$even = "odd";
	} else {
		$even = "even";
	}
	printf("<li class=\"%s %s\" style=\"background-image: url(".PATH."/habbo-imaging/badge/%s.gif)\">
			<a class=\"item\" href=\"".PATH."/groups/%s/id\"><span class=\"index\">%s.</span> %s</a>
		</li>\n", $even, $left, $row[2], $row[0], $i, $input->HoloText($row[1]));
}
?>
</ul>
</div>
    <div class="clearfix">
        <a href="#" class="hotgroups-toggle-more-data secondary" id="hotgroups-toggle-more-data-h122"><?php echo $lang->loc['show.more.groups']; ?></a>
    </div>
<script type="text/javascript">
L10N.put("show.more.groups", "<?php echo $lang->loc['show.more.groups']; ?>");
L10N.put("show.less.groups", "<?php echo $lang->loc['show.less.groups']; ?>");
var hotGroupsMoreDataHelper = new MoreDataHelper("hotgroups-toggle-more-data-h122", "hotgroups-list-hidden-h122","groups");
</script>
</div>
<?php
break;
case "h21": ?>

<div id="staffpicks-rooms-habblet-list-container" class="habblet-list-container groups-list">
    <ul class="habblet-list">
<?php
$i = 0;
$sql = $data->select16();

while ($row = $db->fetch_row($sql)) {
        $i++;
        if($input->IsEven($i)){
            $even = "odd";
        } else {
            $even = "even";
        }
        if($row[4] == 0){ $row[4] = 1; }
        $data2[$i] = ($row[4] / $row[5]) * 100;
        if($data2[$i] == 99 || $data2[$i] > 99){
            $room_fill = 5;
        } elseif($data2[$i] > 65){
            $room_fill = 4;
        } elseif($data2[$i] > 32){
            $room_fill = 3;
        } elseif($data2[$i] > 0){
            $room_fill = 2;
        } elseif($data2[$i] < 1){
            $room_fill = 1;
        }
		if($row[6] != "1"){ $row[3] = ""; }
?>

        <li class="<?php echo $even; ?> room-occupancy-<?php echo $room_fill; ?>" roomid="<?php echo $row[0]; ?>">
            <div>
                <span class="room-name"><a href="<?php echo PATH; ?>/client?forwardId=2&amp;roomId=<?php echo $row[0]; ?>" onclick="HabboClient.roomForward(this, '<?php echo $row[0]; ?>', 'private'); return false;" target="client"><?php echo $row[1]; ?></a></span>
                <?php if($row[3] != ""){ ?><span class="room-owner"><a href="<?php echo PATH; ?>/home/<?php echo $row[3]; ?>"><?php echo $input->HoloText($row[3]); ?></a></span><?php } ?>
                
				<p><?php echo $row[2]; ?></p>
            </div>
        </li>
<?php $i++; } ?>
    </ul>
</div>

<?php
break;
case "h24":
$lang->addLocale("ajax.tags");
?>

<div class="habblet box-content">

<?php
$sql = $db->query("SELECT tag, COUNT(id) AS quantity FROM ".PREFIX."tags GROUP BY tag ORDER BY quantity DESC LIMIT 20");
if($db->num_rows($sql) < 1){ echo $lang->loc['no.tags']; }else{
echo "	    <ul class=\"tag-list\">";
	for($i=0;($array[$i] = @    $db->fetch_array($sql,1))!="";$i++)
        {
            $row[] = $array[$i];
        }
	sort($row);
	$i = -1;
	while($i <> $db->num_rows($sql)){
		$i++;
		$tag = $row[$i]['tag'];
		$count = $row[$i]['quantity'];
		$tags[$tag] = $count;
	}
		
		$max_qty = max(array_values($tags));
		$min_qty = min(array_values($tags));
		$spread = $max_qty - $min_qty;

		if($spread == 0){ $spread = 1; }

		$step = (200 - 100)/($spread);

		foreach($tags as $key => $value){
		    $size = 100 + (($value - $min_qty) * $step);
		    $size = ceil($size);
		    echo "<li><a href=\"".PATH."/tag/".strtolower($input->HoloText($key))."\" class=\"tag\" style=\"font-size:".$size."%\">".trim(strtolower($key))."</a> </li>\n";
		}

echo "</ul>";
}
?>
    <div class="tag-search-form">
<form name="tag_search_form" action="<?php echo PATH; ?>/tag/search" class="search-box">
    <input type="text" name="tag" id="search_query" value="" class="search-box-query" style="float: left"/>
	<a onclick="$(this).up('form').submit(); return false;" href="#" class="new-button search-icon" style="float: left"><b><span></span></b><i></i></a>	
</form>    </div>
</div>


<?php
break;
case "groups":
$lang->addLocale("widget.groups"); ?>
   <div id="groups-habblet-list-container" class="habblet-list-container groups-list">

<?php
echo "\n    <ul class=\"habblet-list two-cols clearfix\">";
$sql = $data->select17(10);
$i = 0;
while($row = $db->fetch_row($sql)){
$i++;

if($input->IsEven($i)){
	$pos = "right";
	$rights++;
} else {
	$pos = "left";
	$lefts++;
}

if($input->IsEven($lefts)){
	$oddeven = "odd";
} else {
	$oddeven = "even";
}

echo "            <li class=\"".$oddeven." ".$pos."\" style=\"background-image: url(".PATH."/habbo-imaging/badge/".$row[2].".gif)\">\n		<a class=\"item\" href=\"".groupURL($row[0])."\">".$input->HoloText($row[1])."</a>\n            </li>\n\n";
}

$rights_should_be = $lefts;
if($rights !== $rights_should_be){
	echo "<li class=\"".$oddeven." right\"><div class=\"item\">&nbsp;</div></li>";
}

echo "\n    </ul>";
?>

		<div class="habblet-button-row clearfix"><a class="new-button" id="purchase-group-button" href="#"><b><?php echo $lang->loc['buy.group']; ?></b><i></i></a></div>
    </div>

    <div id="groups-habblet-group-purchase-button" class="habblet-list-container"></div>

<script type="text/javascript">
    $("purchase-group-button").observe("click", function(e) { Event.stop(e); GroupPurchase.open(); });
</script>





    </div>
<?php } ?>