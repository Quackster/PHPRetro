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
$data = new community_sql;

$search = $input->FilterText($_POST['tag']);
$pagenum = $_POST['pageNumber'];
if(!isset($_POST['pageNumber']) || $pagenum < 1){ $pagenum = 1; }
$correct = $input->stringToURL($input->HoloText($search));
if(strlen($search) > 20 || strlen($search) < 1 || $search != $correct){ $search = ""; }
}
$lang->addLocale("tags.search");

?>
						<div id="tag-search-habblet-container">
<?php
$count['total'] = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."tags WHERE tag = '".$search."'"));
$count['pageminus'] = $pagenum - 1;
$count['offset'] = $count['pageminus'] * 10;
$sql = $db->query("SELECT * FROM ".PREFIX."tags WHERE tag = '".$search."' ORDER BY id DESC LIMIT 10 OFFSET ".$count['offset']);
$count['thispage'] = $db->num_rows($sql);
$count['pages'] = ceil($count['total'] / 10);
$count['shown'] = $count['offset'] + 10;
if($count['shown'] > $count['total']){ $count['shown'] = $count['total']; }

$havetag = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."tags WHERE tag = '".$search."' AND ownerid = '".$user->id."' AND type = 'user'"));
?>
<form name="tag_search_form" action="<?php echo PATH; ?>/tag/search" class="search-box">
    <input type="text" name="tag" id="search_query" value="<?php echo $input->HoloText($search); ?>" class="search-box-query" style="float: left"/>
	<a onclick="$(this).up('form').submit(); return false;" href="#" class="new-button search-icon" style="float: left"><b><span></span></b><i></i></a>	
</form>        <p class="search-result-count"><?php if($count['total'] == 0){ echo $lang->loc['no.tag.result']; }else{ echo $count['offset'] + 1; ?> - <?php echo $count['shown']; ?> / <?php echo $count['total']; } ?></p>
<?php if($havetag == 0 && $user->id != 0 && $search != ""){ ?>
       <p id="tag-search-add" class="clearfix"><span style="float:left"><?php echo $lang->loc['tag.yourself']; ?>:</span> <a id="tag-search-tag-add" href="#" class="new-button" style="float:left" onclick="TagHelper.addThisTagToMe('<?php echo $input->HoloText($search); ?>',false);return false;"><b><?php echo $input->HoloText($search); ?></b><i></i></a></p>
       <p id="tag-search-add-result"><?php echo $lang->loc['ok']; ?></p>
       <script type="text/javascript">
       document.observe("dom:loaded", function() {
            TagHelper.setTexts({
            tagLimitText: "<?php echo addslashes($lang->loc['reached.tag.limit']); ?>",
            invalidTagText: "<?php echo addslashes($lang->loc['invalid.tag']); ?>",
            buttonText: "<?php echo addslashes($lang->loc['ok']); ?>"
            });
           TagHelper.init(<?php echo $user->id; ?>);
        });
        </script>
<?php } ?>
        <p class="search-result-divider"></p>
		
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="search-result">
        <tbody>
<?php
$i = 0;
while($row = $db->fetch_assoc($sql)){
$i++;
if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
if($row['type'] == "user"){ $sql2 = $data->select5($row['ownerid']); }else{ $sql2 = $data->select6($row['ownerid']); }
$details = $db->fetch_row($sql2);
?>

            <tr class="<?php echo $even; ?>">

                <td class="image" style="width:39px;">
                    <img src="<?php if($row['type'] == "user"){ echo $user->avatarURL($details[3],"s,4,4,sml,1,0"); }else{ echo PATH."/habbo-imaging/badge/".$details[3].".gif"; } ?>" alt="" align="left"/>
                </td>
                <td class="text">
                    <a href="<?php if($row['type'] == "user"){ echo PATH."/home/".$details[1]; }else{ echo groupURL($details[0]); } ?>" class="result-title"><?php echo $details[1]; ?></a><br/>
                    <span class="result-description"><?php echo $details[2]; ?></span>

    <ul class="tag-list">
<?php
$sql3 = $db->query("SELECT tag FROM ".PREFIX."tags WHERE ownerid = '".$row['ownerid']."' AND type = '".$row['type']."'");
while($tag = $db->fetch_row($sql3)){
?>
            <li><a href="<?php echo PATH; ?>/tag/<?php echo $input->HoloText($tag[0]); ?>" class="tag" style="font-size:10px"><?php echo $input->HoloText($tag[0]); ?></a> </li>

<?php } ?>
    </ul>

                </td>
            </tr>
			
<?php } ?>
        </tbody>
        </table>
<?php
$output = "";
if($count['pages'] > 1){
if($pagenum == "1"){ $output = $output.$lang->loc['first']."\n"; }else{ $output = $output."<a href=\"".PATH."/tag/".$input->HoloText($search)."?pageNumber=1\">".$lang->loc['first']."</a>\n"; }
$i = 0;
while($i < $count['pages']){
$i++;
if($i == $pagenum){ $output = $output.$i."\n"; }else{ $output = $output."<a href=\"".PATH."/tag/".$input->HoloText($search)."?pageNumber=".$i."\">".$i."</a>\n"; }
}
if($pagenum == $count['pages']){ $output = $output.$lang->loc['last']."\n"; }else{ $output = $output."<a href=\"".PATH."/tag/".$input->HoloText($search)."?pageNumber=".$count['pages']."\">".$lang->loc['last']."</a>\n"; }
}else{
$output = "1";
}
if(!isset($_GET['tag']) || $count['total'] == 0){ $output = ""; }
?>
        <p class="search-result-navigation">
            <?php echo $output; ?>
		</p>
</div>