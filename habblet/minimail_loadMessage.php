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
$lang->addLocale("widget.minimail");

$data = new me_sql;
$mesid = $input->FilterText($_GET['messageId']);
$label = $_GET['label'];
$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE id = '".$mesid."'");
$row = $db->fetch_assoc($sql);
$senderrow = $db->fetch_row($data->select6($row['senderid']));
$torow = $db->fetch_row($data->select6($row['to_id']));
?>
	<ul class="message-headers">
				<li><a href="#" class="report" title="<?php echo $lang->loc['report']; ?>"></a></li>
			<li><b><?php echo $lang->loc['subject']; ?>:</b> <?php echo $row['subject']; ?></li>
			<li><b><?php echo $lang->loc['from']; ?>:</b> <?php echo $senderrow[0]; ?></li>
			<li><b><?php echo $lang->loc['to']; ?>:</b> <?php echo $torow[0]; ?></li>

		</ul>
		<div class="body-text"><?php echo $input->bbcode_format($input->HoloText($row['message'])); ?><br></div>
		<div class="reply-controls">
			<div>
				<div class="new-buttons clearfix">
				<?php if($row['conversationid'] != '0'){ ?>
					<a href="#" class="related-messages" id="rel-<?php echo $row['conversationid']; ?>" title="<?php echo $lang->loc['show.conversation']; ?>"></a>
				<?php } ?>
				<?php if($label == "trash"){ ?>
					<a href="#" class="new-button undelete"><b><?php echo $lang->loc['undelete']; ?></b><i></i></a>
					<a href="#" class="new-button red-button delete"><b><?php echo $lang->loc['delete']; ?></b><i></i></a>
				<?php }elseif($label == "inbox") { ?>
					<a href="#" class="new-button red-button delete"><b><?php echo $lang->loc['delete']; ?></b><i></i></a>
					<a href="#" class="new-button reply"><b><?php echo $lang->loc['reply']; ?></b><i></i></a>
				<?php } ?>
				</div>
			</div>
			<div style="display: none;">
				<textarea rows="5" cols="10" class="message-text"></textarea><br>
				<div class="new-buttons clearfix">
					<a href="#" class="new-button cancel-reply"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
					<a href="#" class="new-button preview"><b><?php echo $lang->loc['preview']; ?></b><i></i></a>

					<a href="#" class="new-button send-reply"><b><?php echo $lang->loc['send']; ?></b><i></i></a>
				</div>
			</div>
		</div>
	<?php if($label == "inbox"){ $db->query("UPDATE ".PREFIX."minimail SET read_mail = '1' WHERE id = '".$mesid."'");}