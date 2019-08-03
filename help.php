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

require_once('./includes/core.php');
$lang->addLocale("faq");
require_once('./templates/faq_header.php');

$id = $input->FilterText($_GET['id']);
$query = $input->FilterText($_POST['query']);
?>
<div id="faq-category-content" class="clearfix" >
<?php if(isset($_GET['id'])){
$sql = $db->query("SELECT * FROM ".PREFIX."faq WHERE id = '".$id."' LIMIT 1");
$row = $db->fetch_assoc($sql);
?>
<p class="faq-category-description"><?php echo $row['content']; ?></p>
<?php
$sql = $db->query("SELECT * FROM ".PREFIX."faq WHERE catid = '".$id."'");
$i = 0;
	while($row = $db->fetch_assoc($sql)){
	$i++;
	if($i == 1){ $selected = "selected"; }
	if($i != 1){ $faqitem = "$(\"faq-item-content-".$row['id']."\").hide();"; }
		echo "<h4 id=\"faq-item-header-".$row['id']."\" class=\"faq-item-header faq-toggle \"><span class=\"faq-toggle ".$selected."\" id=\"faq-header-text-".$row['id']."\">".$input->HoloText($row['title'], true)."</span></h4>
	<div id=\"faq-item-content-".$row['id']."\" class=\"faq-item-content clearfix\">
	    <div class=\"faq-item-content clearfix\">".$input->HoloText($row['content'], true)."</div>
	<div class=\"faq-close-container\">
	<div id=\"faq-close-button-".$row['id']."\" class=\"faq-close-button clearfix faq-toggle\" style=\"display:none\">".$lang->loc['close.faq']." <img id=\"faq-close-image-".$row['id']."\" class=\"faq-toggle\" src=\"".PATH."/web-gallery/v2/images/faq/close_btn.png\"/></div>
	</div>
	</div>

	<script type=\"text/javascript\">
	    ".$faqitem."
	    $(\"faq-close-button-".$row['id']."\").show();
	</script>\n";
	}
}elseif(isset($_POST['query'])){
$sql = $db->query("SELECT * FROM ".PREFIX."faq WHERE (type = 'item') AND (title LIKE '%".$query."%' OR content LIKE '%".$query."%')");
$count = $db->num_rows($sql);
if($count == 0){;
	echo $lang->loc['search.no.result'];
}else{
	while($row = $db->fetch_assoc($sql)){
	$cat = $db->result($db->query("SELECT title FROM ".PREFIX."faq WHERE id = '".$row['catid']."' LIMIT 1"));
		echo "<h4 id=\"faq-item-header-".$row['id']."\" class=\"faq-item-header faq-toggle \"><span class=\"faq-toggle \" id=\"faq-header-text-".$row['id']."\">".$input->HoloText($row['title'], true)."</span><span class=\"item-category\"> - ".$cat."</span></h4>
	<div id=\"faq-item-content-".$row['id']."\" class=\"faq-item-content clearfix\">
	    <div class=\"faq-item-content clearfix\">".$input->HoloText($row['content'], true)."</div>
	<div class=\"faq-close-container\">
	<div id=\"faq-close-button-".$row['id']."\" class=\"faq-close-button clearfix faq-toggle\" style=\"display:none\">".$lang->loc['close.faq']." <img id=\"faq-close-image-".$row['id']."\" class=\"faq-toggle\" src=\"".PATH."/web-gallery/v2/images/faq/close_btn.png\"/></div>
	</div>
	</div>

	<script type=\"text/javascript\">
	    $(\"faq-item-content-".$row['id']."\").hide();
	    $(\"faq-close-button-".$row['id']."\").show();
	</script>\n";
	}
}
}?>
<script type="text/javascript">
    FaqItems.init();
    SearchBoxHelper.init();
</script>
</div>

</div>
<?php require_once('./templates/faq_footer.php'); ?>