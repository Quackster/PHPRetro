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
$page['allow_guests'] = true;
require_once('../includes/core.php');
require_once('./includes/session.php');
}

$lang->addLocale("widget.tags");

// Query tags
$sql = $db->query("SELECT tag,id FROM ".PREFIX."tags WHERE ownerid = '".$user->id."' AND type = 'user' ORDER BY id ASC");
$count = $db->num_rows($sql);

	// Create the random tag questions array
	$randomq[] = "What is your favourite TV show?";
	$randomq[] = "Who is your favourite actor?";
	$randomq[] = "Who is your favourite actress?";
	$randomq[] = "Do you have a nickname?";
	$randomq[] = "What is your favorite song?";
	$randomq[] = "How do you describe yourself?";
	$randomq[] = "What is your favorite band?";
	$randomq[] = "What is your favorite comic?";
	$randomq[] = "What are you like?";
	$randomq[] = "What is your favorite food?";
	$randomq[] = "What sport you play?";
	$randomq[] = "Who was your first love?";
	$randomq[] = "What is your favorite movie?";
	$randomq[] = "Cats, dogs, or something more exotic?";
	$randomq[] = "What is your favorite color?";
	// Add new questions below this line
	$randomq[] = "Do you have a favorite staff member?";

// Select a random question from the array above
srand ((double) microtime() * 1000000);
$chosen = rand(0,count($randomq)-1);

// Appoint the variable
$tag_question = $randomq[$chosen];
?>
    <div class="habblet" id="my-tags-list">
<?php if($count > 0){
            echo "<ul class=\"tag-list make-clickable\">\n";
	while($row = $db->fetch_assoc($sql)){
                    printf("<li><a href=\"".PATH."/tag/%s\" class=\"tag\" style=\"font-size: 10px;\">%s</a>
                        <a class=\"tag-remove-link\" title=\"".$lang->loc['remove.tag']."\" href=\"#\"></a></li>\n", $row['tag'], $row['tag']);
	}
            echo "</ul>\n";
} ?>

<?php if($db->num_rows($sql) < 20){ ?>
     <form method="post" action="<?php echo PATH; ?>/myhabbo/tag/add" onsubmit="TagHelper.addFormTagToMe();return false;" >
    <div class="add-tag-form clearfix">
		<a class="new-button" href="#" id="add-tag-button" onclick="TagHelper.addFormTagToMe();return false;"><b><?php echo $lang->loc['add.tag']; ?></b><i></i></a>
        <input type="text" id="add-tag-input" maxlength="20" style="float: right"/>
        <em class="tag-question"><?php echo $tag_question; ?></em>
    </div>
    <div style="clear: both"></div> 
    </form>
<?php }else{ ?>
	<div class="add-tag-form"><?php echo $lang->loc['tag.limit.reached']; ?></div>
<?php } ?>

    </div>
</div>

<?php if($page['bypass'] != true){ ?>
<script type="text/javascript">

    TagHelper.setTexts({
        tagLimitText: "<?php echo $lang->loc['tag.limit']; ?>",
        invalidTagText: "<?php echo $lang->loc['tag.invalid']; ?>",
        buttonText: "<?php echo $lang->loc['ok']; ?>"
    });
        TagHelper.bindEventsToTagLists();

</script>
<?php } ?>