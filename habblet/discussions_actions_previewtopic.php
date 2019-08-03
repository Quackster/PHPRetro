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
$lang->addLocale("groups.discussion.topic");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['groupId']);
$message = nl2br($input->bbcode_format($input->HoloText($_POST['message'])));
$name = $input->HoloText($_POST['topicName']);
$posts = $db->result($db->query("SELECT COUNT(id) FROM ".PREFIX."forum_posts WHERE posterid = '".$user->id."'"));
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">
<tr class="post-list-index-preview">
	<td class="post-list-row-container">
	<?php if($user->IsUserOnline("self") == true){ $online = "online_anim"; }else{ $online = "offline"; } ?>
		<a href="<?php echo PATH; ?>/home/<?php echo $user->id; ?>/id" class="post-list-creator-link post-list-creator-info"><?php echo $input->HoloText($user->name); ?></a>
            <img alt="<?php echo $online; ?>" src="<?php echo PATH; ?>/web-gallery/images/myhabbo/habbo_<?php echo $online; ?>.gif" />
		<div class="post-list-posts post-list-creator-info"><?php echo $lang->loc['message']; ?>: <?php echo $posts; ?></div>
		<div class="clearfix">
            <div class="post-list-creator-avatar"><img src="<?php echo $user->avatarURL("self","b,2,2,,1,0"); ?>" alt="" /></div>
            <div class="post-list-group-badge">
                <?php if($user->GetUserGroup("self") != false){ ?><a href="<?php echo groupURL($user->GetUserGroup("self")); ?>"><img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $user->GetUserGroupBadge("self"); ?>.gif" /></a><?php } ?>
            </div>
            <div class="post-list-avatar-badge">
				<?php if($user->GetUserBadge("self") != false){ ?><img src="<?php echo $settings->find("site_c_images_path").$settings->find("site_badges_path").$user->GetUserBadge("self").".gif"; ?>" /><?php } ?>
			</div>
        </div>
        <div class="post-list-motto post-list-creator-info">
			<?php if($user->user("mission") != ""){ echo $input->unicodeToImage($input->HoloText($user->user("mission"))); } ?>
		</div>
	</td>
	<td class="post-list-message" valign="top" colspan="2">
            <a href="#" id="edit-post-message" class="resume-edit-link">&laquo; <?php echo $lang->loc['edit']; ?></a>
        <span class="post-list-message-header"> <?php echo $name; ?></span><br />
        <span class="post-list-message-time"><?php echo date('M j, Y (g:i A)'); ?></span>
        <div class="post-list-report-element">
        </div>
        <div class="post-list-content-element">
            <?php echo $message; ?>
        </div>
        <div>
                <?php if($settings->find("site_capcha") == "1"){ ?><div id="discussion-captcha-preview"></div><?php } ?>
                <div class="button-area">
  		            <a id="topic-form-cancel-preview" class="new-button red-button cancel-icon" href="#"><b><span></span><?php echo $lang->loc['cancel']; ?></b><i></i></a>
		            <a id="topic-form-save-preview" class="new-button green-button save-icon" href="#"><b><span></span><?php echo $lang->loc['save']; ?></b><i></i></a>
		        </div>
        </div>
	</td>
</tr>
</table>