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
$lang->addLocale("discussion.topicsettings");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['groupId']);
$topicid = $input->FilterText($_POST['topicId']);

$topicrow = $db->fetch_assoc($db->query("SELECT * FROM ".PREFIX."forum_threads WHERE id = '".$topicid."' LIMIT 1"));
$memberrow = $db->fetch_row($data->select15($user->id,$id));
?>
<form action="#" method="post" id="topic-settings-form">
	<div id="topic-name-area">
	    	<div class="topic-name-input">
	    		<span class="topic-name-text" id="topic_name_text"><?php echo $lang->loc['topic']; ?></span>
	    	</div>
	    	<div class="topic-name-input">
	    		<input type="text" size="40" maxlength="32" name="topic_name" id="topic_name" onKeyUp="GroupUtils.validateGroupElements('topic_name', 32, 'myhabbo.topic.name.max.length.exceeded');" value="<?php echo $input->HoloText($topicrow['title']); ?>"/>
			</div>
            <div id="topic-name-error"></div>
            <div id="topic_name_message_error" class="error"></div>
    </div>
	<div id="topic-type-area">
		<div class="topic-type-label">
			<span class="topic-type-label"><?php echo $lang->loc['type']; ?>:</span>
		</div>
	    <div class="topic-type-input">
	    	<input type="radio" name="topic_type" id="topic_open" value="0"<?php if($topicrow['open'] == 1){ ?> checked="true"<?php } if($memberrow[2] < 2){ ?> disabled="true"<?php } ?> /> <?php echo $lang->loc['open']; ?><br /><input type="radio" name="topic_sticky" id="topic_normal" value="0" <?php if($topicrow['sticky'] == 0){ ?> checked="true"<?php } if($memberrow[2] < 2){ ?> disabled="true"<?php } ?>
              /> <?php echo $lang->loc['normal']; ?>
	    </div>
	    <div class="topic-type-input">
	    	 <input type="radio" name="topic_type" id="topic_closed" value="1"<?php if($topicrow['open'] == 0){ ?> checked="true"<?php } if($memberrow[2] < 2){ ?> disabled="true"<?php } ?>  /> <?php echo $lang->loc['closed'] ?><br /><input type="radio" name="topic_sticky" id="topic_sticky" value="1"<?php if($topicrow['sticky'] == 1){ ?> checked="true"<?php } if($memberrow[2] < 2){ ?> disabled="true"<?php } ?>
             /> <?php echo $lang->loc['sticky']; ?>
	    </div>
	</div>
	<br clear="all"/>
	<br clear="all"/>
	<div id="topic-button-area" class="topic-button-area">
		<a href="#" class="new-button cancel-topic-settings" id="cancel-topic-settings"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
		<?php if($memberrow[2] > 1){ ?><a href="#" class="new-button delete-topic" id="delete-topic"><b><?php echo $lang->loc['delete']; ?></b><i></i></a><?php } ?>
		<a href="#" class="new-button save-topic-settings" style="float:left; margin:0px;" id="save-topic-settings"><b><?php echo $lang->loc['ok']; ?></b><i></i></a>
	</div>
</form>
<div class="clear"></div>