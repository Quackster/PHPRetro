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
$lang->addLocale("homes.widget.rating");

$ownerid = $input->FilterText($_GET['ownerId']);
$widgetid = $input->FilterText($_GET['ratingId']);

if($ownerid == $user->id){
	$db->query("DELETE FROM ".PREFIX."ratings WHERE userid = '".$ownerid."'");
}
?>
<script type="text/javascript">	
	var ratingWidget;
	 
		ratingWidget = new RatingWidget(<?php echo $input->HoloText($ownerid); ?>, <?php echo $input->HoloText($widgetid); ?>);
	 
</script><div class="rating-average">
		<b><?php echo $lang->loc['average.rating']; ?>: 0</b><br/>
	<div id="rating-stars" class="rating-stars" >
				<ul id="rating-unit_ul1" class="rating-unit-rating">
				<li class="rating-current-rating" style="width:0px;" />
	
			</ul>	
	</div>
	0 <?php echo $lang->loc['votes.total']; ?>
	
	<br/>
	(0 <?php echo $lang->loc['high.votes.total']; ?>)
</div>