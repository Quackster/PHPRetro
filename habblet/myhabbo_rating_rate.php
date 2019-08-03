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
$lang->addLocale("homes.widget.rating");

$ownerid = $input->FilterText($_GET['ownerId']);
$widgetid = $input->FilterText($_GET['ratingId']);
$rate = $input->FilterText($_GET['givenRate']);
}

if(is_numeric($ownerid) && is_numeric($widgetid) && is_numeric($rate)){
	$myvote = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."ratings WHERE raterid = '".$user->id."' AND userid = '".$ownerid."'"));
	if($myvote < 1 && $ownerid != $user->id && $rate > 0 && $rate < 6){
		$db->query("INSERT INTO ".PREFIX."ratings (userid,rating,raterid) VALUES ('".$ownerid."','".$rate."','".$user->id."')");
	}
}

$totalvotes = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."ratings WHERE userid = '".$ownerid."'"));
$highvotes = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."ratings WHERE userid = '".$ownerid."' AND rating > 3"));
$votestally = $db->result($db->query("SELECT SUM(rating) FROM ".PREFIX."ratings WHERE userid = '".$ownerid."'"));

$x = $totalvotes;
if($x == 0){ $x = 1; }
$average = round($votestally / $x, 1);
$px = ceil(($average * 150) / 5);
?>
<script type="text/javascript">	
	var ratingWidget;
	 
		ratingWidget = new RatingWidget(<?php echo $input->HoloText($ownerid); ?>, <?php echo $input->HoloText($widgetid); ?>);
	 
</script><div class="rating-average">
		<b><?php echo $lang->loc['average.rating']; ?>: <?php echo $average; ?></b><br/>
	<div id="rating-stars" class="rating-stars" >
				<ul id="rating-unit_ul1" class="rating-unit-rating">
				<li class="rating-current-rating" style="width:<?php echo $px; ?>px;" />
	
			</ul>	
	</div>
	<?php echo $totalvotes; ?> <?php echo $lang->loc['votes.total']; ?>
	
	<br/>
	(<?php echo $highvotes; ?> <?php echo $lang->loc['high.votes.total']; ?>)
</div>