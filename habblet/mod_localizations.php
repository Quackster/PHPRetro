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
$page['allow_guests'] = true;
require_once('../includes/core.php');
$lang->addLocale("report");
?>
{
 "success" : {
		"title" : "<?php echo $lang->loc['success']; ?>",
		"message" : "<?php echo $lang->loc['success.message']; ?>",
		"btnText" : "<?php echo $lang->loc['close']; ?>"
	},

 "error" : {
		"title" : "<?php echo $lang->loc['error']; ?>",
		"message" : "<?php echo $lang->loc['error.message']; ?>",
		"btnText" : "<?php echo $lang->loc['close']; ?>"
	},

 "spam" : {
		"title" : "<?php echo $lang->loc['spam']; ?>",
		"message" : "<?php echo $lang->loc['spam.message']; ?>",
		"btnText" : "<?php echo $lang->loc['close']; ?>"
	},

 "name" : {
		"title" : "<?php echo $lang->loc['name']; ?>",
		"message" : "<?php echo $lang->loc['name.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "room" : { 
		"title" : "<?php echo $lang->loc['room']; ?>",
		"message" : "<?php echo $lang->loc['room.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "motto" : {
		"title" : "<?php echo $lang->loc['motto']; ?>",
		"message" : "<?php echo $lang->loc['motto.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "stickie" : {
		"title" : "<?php echo $lang->loc['stickie']; ?>",
		"message" : "<?php echo $lang->loc['stickie.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "animator" : {
		"title" : "<?php echo $lang->loc['animator']; ?>",
		"message" : "<?php echo $lang->loc['animator.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "habbomovie" : { 
		"title" : "<?php echo $lang->loc['movie']; ?>",
		"message" : "<?php echo $lang->loc['movie.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "groupname" : {
		"title" : "<?php echo $lang->loc['group']; ?>",
		"message" : "<?php echo $lang->loc['group.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},
	
 "url" : {
		"title" : "myhabbo.dialogs.groupurlreport.title",
		"message" : "myhabbo.dialogs.groupurlreport.text",
		"btnCancelText" : "myhabbo.dialogs.groupurlreport.cancel",
		"btnReportText" : "myhabbo.dialogs.groupurlreport.report"
	},

 "groupdesc" : {
		"title" : "<?php echo $lang->loc['discussion']; ?>",
		"message" : "<?php echo $lang->loc['discussion.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "guestbook" : {
		"title" : "<?php echo $lang->loc['guestbook']; ?>",
		"message" : "<?php echo $lang->loc['guestbook.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	},

 "discussionpost" : {
		"title" : "<?php echo $lang->loc['post']; ?>",
		"message" : "<?php echo $lang->loc['post.message']; ?>",
		"btnCancelText" : "<?php echo $lang->loc['cancel']; ?>",
		"btnReportText" : "<?php echo $lang->loc['report']; ?>"
	}
}