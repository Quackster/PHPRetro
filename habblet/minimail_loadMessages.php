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

switch($_POST['label']){ case "sent": $sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE senderid = '".$user->id."'"); break;
case "trash": $sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '1'"); break;
case "conversation": $sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE (to_id = '".$user->id."' OR senderid = '".$user->id."') AND conversationid = '".$input->FilterText($_POST['conversationId'])."'"); break;
default: $sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."'"); break;
}
header('X-JSON: {"totalMessages":'.$db->result($sql).'}');
}
$data = new me_sql;
$lang->addLocale("minimail.loadmessages");

if(isset($_POST['label']) || $page['bypass'] == true){
	if(!isset($label)){ $label = $input->FilterText($_POST['label']); }
	if(!isset($start)){ $start = $_POST['start']; }
	$conversationid = $_POST['conversationId'];
	$unread = $_POST['unreadOnly'];
	?>
		<a href="#" class="new-button compose"><b><?php echo $lang->loc['compose']; ?></b><i></i></a>
	<div class="clearfix labels nostandard">
		<ul class="box-tabs">
		<?php
		$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND read_mail = '0'");
		$unreadmail = $db->num_rows($sql);
		?>
			<li <?php if($label == "inbox"){ echo "class=\"selected\""; } ?>><a href="#" label="inbox"><?php echo $lang->loc['inbox']; ?><?php if($unreadmail <> 0){ echo " (".$unreadmail.")"; } ?></a><span class="tab-spacer"></span></li>
			<li <?php if($label == "sent"){ echo "class=\"selected\"";  } ?>><a href="#" label="sent"><?php echo $lang->loc['sent']; ?></a><span class="tab-spacer"></span></li>
			<li <?php if($label == "trash"){ echo "class=\"selected\""; } ?>><a href="#" label="trash"><?php echo $lang->loc['trash']; ?></a><span class="tab-spacer"></span></li>
		</ul>

	</div>
	<div id="message-list" class="label-<?php echo $label; ?>">
	<div class="new-buttons clearfix">
		<div class="labels inbox-refresh"><a href="#" class="new-button green-button" label="inbox" style="float: left; margin: 0"><b><?php echo $lang->loc['refresh']; ?></b><i></i></a></div>
	</div>

	<div style="clear: both; height: 1px"></div>
<?php switch($label){
case "inbox": ?>
	<div class="navigation">
		<div class="unread-selector"><input type="checkbox" class="unread-only" <?php if($unread == "true"){ echo "checked"; } ?>/> <?php echo $lang->loc['only.unread']; ?></div>
			<?php
			$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '0'");
			$allmail = $db->result($sql);
			$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '0' AND read_mail = '0'");
			$unreadmail = $db->result($sql);
			if($unread == "true"){
				$allnum = $unreadmail;
			} else {
				$allnum = $allmail;
			}
			if($start != null){
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if($endnum > $allnum){ $endnum = $allnum; }
			} else {
				$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '0' LIMIT 10");
				$endnum = $db->num_rows($sql);
				$offset = "0";
				$startnum = "1";
				if($endnum > $allnum){ $endnum = $allnum; }
			}
			$var1 = " <a href=\"#\" class=\"newer\">".$lang->loc['newer']."</a> ";
			$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
			$var3 = " <a href=\"#\" class=\"older\">".$lang->loc['older']."</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">".$lang->loc['newest']."</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"newest\">".$lang->loc['oldest']."</a> -->";
			$totalpages = ceil($allnum / 10);
			if($endnum != $allnum && $startnum != 1){
				$maillist = $var1.$var2.$var3;
			} elseif($endnum != $allnum && $startnum == 1){
				$maillist = $var2.$var3;
			} elseif($endnum == $allnum && $startnum != 1){
				$maillist = $var1.$var2;
			} elseif($endnum == $allnum && $startnum == 1){
				$maillist = $var2;
			}
			if($startnum + 20 < $allnum && $endnum <> $allnum){
				$maillist = $maillist.$var5;
			}
			if($startnum - 20 > 0){
				$maillist = $var4.$maillist;
			}
			$maillist = "<p>".$maillist."</p>";
			?>
		<?php if($allmail == 0){ ?>
			<p class="no-messages">
				   <?php echo $lang->loc['no.messages']; ?>
			</p>
		<?php } elseif($unreadmail == "0" && $unread == "true"){ ?>
			<p class="no-messages">
				   <?php echo $lang->loc['no.unread.messages']; ?>
			</p>
		<?php } ?>
			<div class="progress"></div>
			<?php if($unread == "true"){
				if($unreadmail <> 0){ echo $maillist; }
				} else {
				if($allmail <> 0){ echo $maillist; }
				} ?>
	</div>

	<?php
			   $i = 0;
			   if($unread == "true"){
			   	$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '0' AND read_mail = '0' ORDER BY id DESC LIMIT 10 OFFSET ".$offset);
			   } else {
			   	$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '0' ORDER BY id DESC LIMIT 10 OFFSET ".$offset);
			   }
			   while ($row = $db->fetch_assoc($sql)) {
					   $i++;

					   if($row['read_mail'] == 0){
						   $read = "unread";
					   } else {
						   $read = "read";
					   }
					   $row['isodate'] = date('Y-m-dTH:i:s', $row['time']);
					   $row['date'] = date('M j, Y g:i:s A', $row['time']);

					   $senderrow = $db->fetch_row($data->select6($row['senderid']));
					   $figure = $user->avatarURL($senderrow[2],"s,9,2,sml,1,0");

	printf("	<div class=\"message-item %s \" id=\"msg-%s\">
			<div class=\"message-preview\" status=\"%s\">

				<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
					%s
				</span>
				<img src=\"%s\" />
				<span class=\"message-sender\" title=\"%s\">%s</span>

				<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
			</div>
			<div class=\"message-body\" style=\"display: none;\">
				<div class=\"contents\"></div>

				<div class=\"message-body-bottom\"></div>
			</div>
		</div>", $read, $row['id'], $read, $row['isodate'], $row['date'], $row['date'], $figure, $senderrow[0], $senderrow[0], $row['subject'], $row['subject']);
			   }
	?>

	<div class="navigation">
			<div class="progress"></div>

			<?php if($unread == "true"){
				if($unreadmail <> 0){ echo $maillist; }
				} else {
				if($allmail <> 0){ echo $maillist; }
				} ?>
	</div>

	</div>
<?php break;
case "sent": ?>
	<div class="navigation">
		<?php
		$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE senderid = '".$user->id."'");
		$allmail = $db->result($sql);
		$allnum = $allmail;
		if($start != null){
			$offset = $start;
			$startnum = $start + 1;
			$endnum = $start + 10;
			if($endnum > $allnum){ $endnum = $allnum; }
		} else {
			$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE senderid = '".$user->id."' LIMIT 10");
			$endnum = $db->num_rows($sql);
			$offset = "0";
			$startnum = "1";
		}
		$var1 = " <a href=\"#\" class=\"newer\">".$lang->loc['newer']."</a> ";
		$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
		$var3 = " <a href=\"#\" class=\"older\">".$lang->loc['older']."</a> ";
		$var4 = " <a href=\"#\" class=\"newest\">".$lang->loc['newest']."</a> ";
		$var5 = "<!-- <a href=\"#\" class=\"newest\">".$lang->loc['oldest']."</a> -->";
		$totalpages = ceil($allnum / 10);
		if($endnum != $allnum && $startnum != 1){
			$maillist = $var1.$var2.$var3;
		} elseif($endnum != $allnum && $startnum == 1){
			$maillist = $var2.$var3;
		} elseif($endnum == $allnum && $startnum != 1){
			$maillist = $var1.$var2;
		} elseif($endnum == $allnum && $startnum == 1){
			$maillist = $var2;
		}
		if($startnum + 20 < $allnum && $endnum <> $allnum){
			$maillist = $maillist.$var5;
		}
		if($startnum - 20 > 0){
			$maillist = $var4.$maillist;
		}
		$maillist = "<p>".$maillist."</p>";
		?>
		<?php if($allmail == 0){ ?>
			<p class="no-messages">
				   <?php echo $lang->loc['no.sent.messages']; ?>
			</p>
		<?php } ?>
			<div class="progress"></div>

			<?php if($allmail <> 0){ echo $maillist; } ?>
	</div>
	<?php
			   $i = 0;
			   $sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE senderid = '".$user->id."' ORDER BY id DESC LIMIT 10 OFFSET ".$offset);

			   while ($row = $db->fetch_assoc($sql)) {
					   $i++;

					   if($row['read_mail'] == 0){
						   $read = "unread";
					   } else {
						   $read = "read";
					   }
					   $row['isodate'] = date('Y-m-dTH:i:s', $row['time']);
					   $row['date'] = date('M j, Y g:i:s A', $row['time']);

					   $torow = $db->fetch_row($data->select6($row['to_id']));
					   $figure = $user->avatarURL($torow[2],"s,9,2,sml,1,0");

	printf("	<div class=\"message-item %s \" id=\"msg-%s\">
			<div class=\"message-preview\" status=\"%s\">

				<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
					%s
				</span>
				<img src=\"%s\" />
				<span class=\"message-sender\" title=\"".$lang->loc['to'].": %s\">".$lang->loc['to'].": %s</span>

				<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
			</div>
			<div class=\"message-body\" style=\"display: none;\">
				<div class=\"contents\"></div>

				<div class=\"message-body-bottom\"></div>
			</div>
		</div>", $read, $row['id'], $read, $row['isodate'], $row['date'], $row['date'], $figure, $torow[0], $torow[0], $row['subject'], $row['subject']);
			   }
	?>

	<div class="navigation">
			<div class="progress"></div>

			<?php if($allmail <> 0){ echo $maillist; } ?>
</div>
<?php break;
case "trash": ?>
		<div class="trash-controls notice">
			<?php echo $lang->loc['messages.30.days']; ?> <a href="#" class="empty-trash"><?php echo $lang->loc['empty.trash']; ?></a>

		</div>

	<div class="navigation">
		<?php
		$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '1'");
		$allmail = $db->result($sql);
		$allnum = $allmail;
		if($start != null){
			$offset = $start;
			$startnum = $start + 1;
			$endnum = $start + 10;
			if($endnum > $allnum){ $endnum = $allnum; }
		} else {
			$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '1' LIMIT 10");
			$endnum = $db->num_rows($sql);
			$offset = "0";
			$startnum = "1";
		}
		$var1 = " <a href=\"#\" class=\"newer\">".$lang->loc['newer']."</a> ";
		$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
		$var3 = " <a href=\"#\" class=\"older\">".$lang->loc['older']."</a> ";
		$var4 = " <a href=\"#\" class=\"newest\">".$lang->loc['newest']."</a> ";
		$var5 = "<!-- <a href=\"#\" class=\"newest\">".$lang->loc['oldest']."</a> -->";
		$totalpages = ceil($allnum / 10);
		if($endnum != $allnum && $startnum != 1){
			$maillist = $var1.$var2.$var3;
		} elseif($endnum != $allnum && $startnum == 1){
			$maillist = $var2.$var3;
		} elseif($endnum == $allnum && $startnum != 1){
			$maillist = $var1.$var2;
		} elseif($endnum == $allnum && $startnum == 1){
			$maillist = $var2;
		}
		if($startnum + 20 < $allnum && $endnum <> $allnum){
			$maillist = $maillist.$var5;
		}
		if($startnum - 20 > 0){
			$maillist = $var4.$maillist;
		}
		$maillist = "<p>".$maillist."</p>";
		?>
		<?php if($allmail == 0){ ?>
			<p class="no-messages">
				   <?php echo $lang->loc['no.deleted.messages']; ?>
			</p>
		<?php } ?>
			<div class="progress"></div>

			<?php if($allmail <> 0){ echo $maillist; } ?>
	</div>
	<?php
			   $i = 0;
			   $sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE to_id = '".$user->id."' AND deleted = '1' ORDER BY ID DESC LIMIT 10 OFFSET ".$offset);
			   while ($row = $db->fetch_assoc($sql)) {
					   $i++;
					   if($row['read_mail'] == 0){
						   $read = "unread";
					   } else {
						   $read = "read";
					   }
					   $row['isodate'] = date('Y-m-dTH:i:s', $row['time']);
					   $row['date'] = date('M j, Y g:i:s A', $row['time']);

					   $senderrow = $db->fetch_row($data->select6($row['senderid']));
					   $figure = $user->avatarURL($senderrow[2],"s,9,2,sml,1,0");

	printf("	<div class=\"message-item %s \" id=\"msg-%s\">
			<div class=\"message-preview\" status=\"%s\">

				<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
					%s
				</span>
				<img src=\"%s\" />
				<span class=\"message-sender\" title=\"%s\">%s</span>

				<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
			</div>
			<div class=\"message-body\" style=\"display: none;\">
				<div class=\"contents\"></div>

				<div class=\"message-body-bottom\"></div>
			</div>
		</div>", $read, $row['id'], $read, $row['isodate'], $row['date'], $row['date'], $figure, $senderrow[0], $senderrow[0], $row['subject'], $row['subject']);
			   }
	?>

	<div class="navigation">
			<div class="progress"></div>

			<?php if($allmail <> 0){ echo $maillist; } ?>
</div>

</div>
<?php break;
case "conversation": ?>
		<div class="trash-controls notice">
			<?php echo $lang->loc['reading.conversation']; ?>

		</div>
	<?php $id = $input->FilterText($_POST['messageId']);
	$conid = $input->FilterText($_POST['conversationId']); ?>

	<div class="navigation">
		<?php
		$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE conversationid = '".$conid."' AND deleted = '0'");
		$allmail = $db->result($sql);
		$allnum = $allmail;
		if($start != null){
			$offset = $start;
			$startnum = $start + 1;
			$endnum = $start + 10;
			if($endnum > $allnum){ $endnum = $allnum; }
		} else {
			$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE conversationid = '".$conid."' AND deleted = '0' LIMIT 10");
			$endnum = $db->result($sql);
			$offset = "0";
			$startnum = "1";
		}
		$var1 = " <a href=\"#\" class=\"newer\">".$lang->loc['newer']."</a> ";
		$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
		$var3 = " <a href=\"#\" class=\"older\">".$lang->loc['older']."</a> ";
		$var4 = " <a href=\"#\" class=\"newest\">".$lang->loc['newest']."</a> ";
		$var5 = "<!-- <a href=\"#\" class=\"newest\">".$lang->loc['oldest']."</a> -->";
		$totalpages = ceil($allnum / 10);
		if($endnum != $allnum && $startnum != 1){
			$maillist = $var1.$var2.$var3;
		} elseif($endnum != $allnum && $startnum == 1){
			$maillist = $var2.$var3;
		} elseif($endnum == $allnum && $startnum != 1){
			$maillist = $var1.$var2;
		} elseif($endnum == $allnum && $startnum == 1){
			$maillist = $var2;
		}
		if($startnum + 20 < $allnum && $endnum <> $allnum){
			$maillist = $maillist.$var5;
		}
		if($startnum - 20 > 0){
			$maillist = $var4.$maillist;
		}
		$maillist = "<p>".$maillist."</p>";
		?>
		<?php if($allmail == 0){ ?>
			<p class="no-messages">
				   <?php echo $lang->loc['no.conversation.messages']; ?>
			</p>
		<?php } ?>
			<div class="progress"></div>

			<?php if($allmail <> 0){ echo $maillist; } ?>
	</div>
	<?php
			   $i = 0;
			   $sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE conversationid = '".$conid."' AND deleted = '0' ORDER BY id DESC LIMIT 10 OFFSET ".$offset);

			   while ($row = $db->fetch_assoc($sql)) {
					   $i++;

					   if($row['read_mail'] == 0){
						   $read = "unread";
					   } else {
						   $read = "read";
					   }
					   $row['isodate'] = date('Y-m-dTH:i:s', $row['time']);
					   $row['date'] = date('M j, Y g:i:s A', $row['time']);

					   $senderrow = $db->fetch_row($data->select6($row['senderid']));
					   $figure = $user->avatarURL($senderrow[2],"s,9,2,sml,1,0");

	printf("	<div class=\"message-item %s \" id=\"msg-%s\">
			<div class=\"message-preview\" status=\"%s\">

				<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
					%s
				</span>
				<img src=\"%s\" />
				<span class=\"message-sender\" title=\"%s\">%s</span>

				<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
			</div>
			<div class=\"message-body\" style=\"display: none;\">
				<div class=\"contents\"></div>

				<div class=\"message-body-bottom\"></div>
			</div>
		</div>", $read, $row['id'], $read, $row['isodate'], $row['date'], $row['date'], $figure, $senderrow[0], $senderrow[0], $row['subject'], $row['subject']);
			   }
	?>

	<div class="navigation">
			<div class="progress"></div>

			<?php if($allmail <> 0){ echo $maillist; } ?>
</div>
<?php }
	if($page['bypass'] == true && $message != ""){ ?><div style="opacity: 1;" class="notification"><?php echo $message; ?></div></div><?php }
}
?>