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
$lang->addLocale("community.tags");

$sql = $db->query("SELECT COUNT(id) FROM ".PREFIX."tags WHERE tag = '".$input->FilterText($_POST['tag1'])."'");
$tag_1_results = $db->result($sql);
$sql = $db->query("SELECT COUNT(id) FROM ".PREFIX."tags WHERE tag = '".$input->FilterText($_POST['tag2'])."'");
$tag_2_results = $db->result($sql);

$tag_1 = $input->HoloText($_POST['tag1']);
$tag_2 = $input->HoloText($_POST['tag2']);

if($tag_1_results == $tag_2_results){

$end = 0;
} elseif($tag_1_results > $tag_2_results){
$tag_1 = "<b>" . $input->HoloText($_POST['tag1']) . "</b>";
$end = 2;
} elseif($tag_1_results < $tag_2_results){
$tag_2 = "<b>" . $input->HoloText($_POST['tag2']) . "</b>";
$end = 1;
}

echo "			<div id=\"fightResultCount\" class=\"fight-result-count\">
				"; if($end == 0){ echo $lang->loc['tie']; } else { echo $lang->loc['winner']; } echo "<br />
			    ".$tag_1."
			(".$tag_1_results.") hits
            <br/>
                ".$tag_2."
            (".$tag_2_results.") hits 
		    </div>
			<div class=\"fight-image\">
					<img src=\"".PATH."/web-gallery/images/tagfight/tagfight_end_".$end.".gif\" alt=\"\" name=\"fightanimation\" id=\"fightanimation\" />
                <a id=\"tag-fight-button-new\" href=\"#\" class=\"new-button\" onclick=\"TagFight.newFight(); return false;\"><b>".$lang->loc['again']."</b><i></i></a>
                <a id=\"tag-fight-button\" href=\"#\" style=\"display:none\" class=\"new-button\" onclick=\"TagFight.init(); return false;\"><b>".$lang->loc['fight']."</b><i></i></a>
            </div>
";

?>