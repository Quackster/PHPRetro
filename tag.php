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

$page['allow_guests'] = true;
require_once('./includes/core.php');
require_once('./includes/session.php');
$data = new community_sql;
$lang->addLocale("community.tags");

$page['id'] = "tags";
$page['name'] = $lang->loc['pagename.tags'];
$page['bodyid'] = "tags";
$page['cat'] = "community";

require_once('./templates/community_header.php');

$search = $input->FilterText($_GET['tag']);
$pagenum = $_GET['pageNumber'];
if(!isset($_GET['pageNumber']) || $pagenum < 1){ $pagenum = 1; }
$correct = $input->stringToURL($input->HoloText($search));
if(strlen($search) > 20 || strlen($search) < 1 || $search != $correct){ $search = ""; }
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">
	
							<h2 class="title"><?php echo $lang->loc['popular.tags']; ?>
							</h2>
						<div id="tag-related-habblet-container" class="habblet box-contents">

<?php
$lang->addLocale("ajax.tags");
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
</div>
	
						
					</div>

				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">
	
							<h2 class="title"><?php echo $lang->loc['tag.fight']; ?>
							</h2>
						<div id="tag-fight-habblet-container">
<div class="fight-process" id="fight-process"><?php echo $lang->loc['fight.start']; ?></div>
<div id="fightForm" class="fight-form">
    <div class="tag-field-container"><?php echo $lang->loc['first.tag']; ?><br /><input maxlength="30" type="text" class="tag-input" name="tag1" id="tag1"/></div>

    <div class="tag-field-container"><?php echo $lang->loc['second.tag']; ?><br /><input maxlength="30" type="text" class="tag-input" name="tag2" id="tag2"/></div>
</div>
<div id="fightResults" class="fight-results">
    <div class="fight-image">
    	<img src="<?php echo PATH; ?>/web-gallery/images/tagfight/tagfight_start.gif" alt="" name="fightanimation" id="fightanimation" />
        <a id="tag-fight-button" href="#" class="new-button" onclick="TagFight.init(); return false;"><b><?php echo $lang->loc['fight']; ?></b><i></i></a>
    </div>
</div>
<div class="tagfight-preload">
	<img src="<?php echo PATH; ?>/web-gallery/images/tagfight/tagfight_end_0.gif" width="1" height="1"/>

	<img src="<?php echo PATH; ?>/web-gallery/images/tagfight/tagfight_end_1.gif" width="1" height="1"/>
	<img src="<?php echo PATH; ?>/web-gallery/images/tagfight/tagfight_end_2.gif" width="1" height="1"/>
	<img src="<?php echo PATH; ?>/web-gallery/images/tagfight/tagfight_loop.gif" width="1" height="1"/>
	<img src="<?php echo PATH; ?>/web-gallery/images/tagfight/tagfight_start.gif" width="1" height="1"/>
</div>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php if($user->id != 0){ ?>
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">
	
							<h2 class="title"><?php echo $lang->loc['tag.match']; ?>
							</h2>
						<div id="tag-match-habblet-container">
<div id="tag-match-result">
    <?php echo $lang->loc['tag.match.desc']; ?>
</div>

<div id="tag-match-form">
<input type="text" id="tag-match-friend" value=""/>
<a class="new-button" id="tag-match-send" href="#"><b><?php echo $lang->loc['match']; ?></b><i></i></a>
</div>
<script type="text/javascript">
document.observe("dom:loaded", function() {
    Event.observe($('tag-match-friend'), "keypress", function(e) {
        if (e.keyCode == Event.KEY_RETURN) {
            TagHelper.matchFriend();
        }
    });
    Event.observe($('tag-match-send'), "click", function(e) { Event.stop(e); TagHelper.matchFriend(); });
});
</script>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php } ?>

</div>
<div id="column2" class="column">

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">
	
							<h2 class="title"><?php echo $lang->loc['tag.search']; ?>
							</h2>
<?php $page['bypass'] = true; require_once('./habblet/ajax_tagsearch.php'); ?>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php require_once('./templates/community_footer.php'); ?>