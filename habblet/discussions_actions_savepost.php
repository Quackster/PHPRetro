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
$message = $input->FilterText($_POST['message']);
$topicid = $input->FilterText($_POST['topicId']);
$captcha = strtolower($_POST['captcha']);
$pagenum = (int) $input->FilterText($_POST['page']);

if(($_SESSION['register-captcha-bubble'] == $captcha && !empty($_SESSION['register-captcha-bubble'])) || $settings->find("site_capcha") == "0"){
	unset($_SESSION['register-captcha-bubble']);
} else {
	header('X-JSON: {"captchaError":"true"}'); exit;
}

$sql = $data->select14($id);
$grouprow = $db->fetch_row($sql);
$sql = $data->select15($user->id,$grouprow[0]);
$memberrow = $db->fetch_row($sql);
$threadrow = $db->fetch_assoc($db->query("SELECT * FROM ".PREFIX."forum_threads WHERE id = '".$topicid."' LIMIT 1"));

if($grouprow[9] == 2 && $memberrow[2] < 2){ exit; }
if($grouprow[9] == 1 && $memberrow[2] < 1){ exit; }
if($threadrow['open'] == "0"){ exit; }
if((int) $user->user("email_verified") < 1){ exit; }

$db->query("INSERT INTO ".PREFIX."forum_posts (threadid,message,posterid,time,edit_time) VALUES ('".$threadrow['id']."','".$message."','".$user->id."','".time()."','0')");

$lang->addLocale("groups.discussion");
$lang->addLocale("ajax.buttons");
$lang->addLocale("groups.discussion.showtopic");
$lang->addLocale("groups.discussion.topic");
$sql = $db->query("SELECT * FROM ".PREFIX."forum_threads WHERE id = '".$topicid."' LIMIT 1");
if($db->num_rows($sql) < 1){ $lang->clearLocale; require_once('./error.php'); exit; }
$threadrow = $db->fetch_assoc($sql);
$sql = $data->select14($id);
if($db->num_rows($sql) < 1){ $lang->clearLocale; require_once('./error.php'); exit; }
$grouprow = $db->fetch_row($sql);
?>
    <div class="postlist-header clearfix">
<?php if($user->id != 0 && ((($grouprow[9] == 2 && $memberrow[2] > 1) || ($grouprow[9] == 1 && $memberrow[2] > 0)) || ($grouprow[9] == 0)) && $threadrow['open'] == "1"){ ?>
                    <a href="#" id="create-post-message" class="create-post-link verify-email"><?php echo $lang->loc['post.reply']; ?></a>
                    <input type="hidden" id="email-verfication-ok" value="<?php echo (int) $user->user("email_verified") == 1 ? "1" : "0"; ?>"/>
<?php }elseif($threadrow['open'] == "0"){ ?>
<span class="topic-closed"><img src="<?php echo PATH; ?>/web-gallery/images/groups/status_closed.gif" title="<?php echo $lang->loc['closed.thread']; ?>"> <?php echo $lang->loc['closed.thread']; ?></span>
<?php }
if($memberrow[2] > 1 || $threadrow['starterid'] == $user->id){
?>
                <a href="#" id="edit-topic-settings" class="edit-topic-settings-link"><?php echo $lang->loc['edit.thread']; ?> &raquo;</a>
                <input type="hidden" id="settings_dialog_header" value="<?php echo $lang->loc['edit.thread.settings']; ?>"/>
<?php } ?>
<?php
$total = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."forum_posts WHERE threadid = '".$threadrow['id']."'"));
$pages = ceil($total / 10);
if($pagenum == "-1"){ $pagenum = $pages; }
$end = 9; if(($pagenum + $end) > $pages){ $end = $pages - $pagenum; }
$links = "";
if($pages == 0){ $links = "0"; }else{
	if($pagenum != 1){ $links .= "<a href=\"".groupURL($threadrow['groupid'])."/discussions/".$threadrow['id']."/id/page/".($pagenum - 1)."\" >&lt;&lt;</a>\n"; }
	$links .= $pagenum."\n";
	$i = 0; while($i < $end){ $i++; $links .= "<a href=\"".groupURL($threadrow['groupid'])."/discussions/".$threadrow['id']."/id/page/".($pagenum + $i)."\">".($pagenum + $i)."</a>\n"; }
	if($pagenum + 9 < $pages){ $links .= "<a href=\"".groupURL($threadrow['groupid'])."/discussions/".$threadrow['id']."/id/page/".($pagenum + 1)."\" >&gt;&gt;</a>\n"; }
}
$offset = ($pagenum - 1) * 10;
?>
        <div class="page-num-list">
            <input type="hidden" id="current-page" value="<?php echo $pagenum; ?>"/>
    <?php echo $lang->loc['view.page'] ?>:
<?php echo $links; ?>        </div>
    </div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">
<?php
$sql = $db->query("SELECT * FROM ".PREFIX."forum_posts WHERE threadid = '".$threadrow['id']."' ORDER BY time ASC LIMIT 10 OFFSET ".$offset);
$firstid = $db->result($db->query("SELECT id FROM ".PREFIX."forum_posts WHERE threadid = '".$threadrow['id']."' ORDER BY time ASC LIMIT 1"));
$i = 0;
while($row = $db->fetch_assoc($sql)){
$posterrow = $db->fetch_row($data->select2($row['posterid']));
if($user->IsUserOnline($posterrow[0]) == true){ $online = "online_anim"; }else{ $online = "offline"; }
$posts = $db->result($db->query("SELECT COUNT(id) FROM ".PREFIX."forum_posts WHERE posterid = '".$posterrow[0]."'"));
if($row['id'] == $firstid){ $row['title'] = $threadrow['title']; }else{ $row['title'] = "RE: ".$threadrow['title']; }
if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
?>

<tr class="post-list-index-<?php echo $even; ?>">
	<td class="post-list-row-container">
		<a href="<?php echo PATH; ?>/home/<?php echo $posterrow[0]; ?>/id" class="post-list-creator-link post-list-creator-info"><?php echo $input->HoloText($posterrow[1]); ?></a>

            <img alt="<?php echo $online; ?>" src="<?php echo PATH; ?>/web-gallery/images/myhabbo/habbo_<?php echo $online; ?>.gif" />
		<div class="post-list-posts post-list-creator-info"><?php echo $lang->loc['message']; ?>: <?php echo $posts; ?></div>
		<div class="clearfix">
            <div class="post-list-creator-avatar"><img src="<?php echo $user->avatarURL($posterrow[4],"b,2,2,,1,0"); ?>" alt="" /></div>
            <div class="post-list-group-badge">
                <?php if($user->GetUserGroup($posterrow[0]) != false){ ?><a href="<?php echo groupURL($user->GetUserGroup($posterrow[0])); ?>"><img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $user->GetUserGroupBadge($posterrow[0]); ?>.gif" /></a><?php } ?>
            </div>
            <div class="post-list-avatar-badge">
				<?php if($user->GetUserBadge($posterrow[0]) != false){ ?><img src="<?php echo $settings->find("site_c_images_path").$settings->find("site_badges_path").$user->GetUserBadge($posterrow[0]).".gif"; ?>" /><?php } ?>
			</div>
        </div>
        <div class="post-list-motto post-list-creator-info"><?php $input->unicodeToImage($user->user("mission")); ?></div>
	</td>
	<td class="post-list-message" valign="top" colspan="2">
                    <?php if($user->id != 0 && ((($grouprow[9] == 2 && $memberrow[2] > 1) || ($grouprow[9] == 1 && $memberrow[2] > 0)) || ($grouprow[9] == 0)) && $threadrow['open'] == "1"){ ?><a href="#" class="quote-post-link verify-email" id="quote-post-<?php echo $row['id']; ?>-message"><?php echo $lang->loc['quote'] ?></a><?php } ?>
                    <?php if(($row['posterid'] == $user->id || $memberrow[2] > 1) && $threadrow['open'] == "1" && $row['message'] != $lang->loc['post.deleted']){ ?><a href="#" class="edit-post-link verify-email" id="edit-post-<?php echo $row['id']; ?>-message"><?php echo $lang->loc['edit']; ?></a><?php } ?>
        <span class="post-list-message-header"><?php echo $input->HoloText($row['title']); ?></span><br />
        <span class="post-list-message-time"><?php echo date('M j, Y (g:i A)',$row['time']); ?></span>
        <div class="post-list-report-element">
                <?php if($row['posterid'] != $user->id){ ?><a href="#" id="report-post-<?php echo $row['id']; ?>" class="create-report-button report-post"></a><?php } ?>
				<?php if(($row['posterid'] == $user->id || $memberrow[2] > 1) && $threadrow['open'] == "1"){ ?><a href="#" id="delete-post-<?php echo $row['id']; ?>" class="delete-button delete-post"></a><?php } ?>
        </div>
        <div class="post-list-content-element">
			<?php if($row['edit_time'] != 0){ ?><span class="post-list-message-edited"><?php echo $lang->loc['last.edited']; ?>: <?php echo date('M j, Y (g:i A)',$row['edit_time']); ?></span><br /><?php } ?>
            <?php echo $input->bbcode_format(nl2br($input->HoloText($row['message']))); ?>
                <input type="hidden" id="<?php echo $row['id']; ?>-message" value="<?php echo $input->HoloText($row['message']); ?>" />
        </div>
        <div>
        </div>

	</td>
</tr>

<?php if($i == 0){ ?>

	<tr class="postlist-leaderboard">
	    <td colspan="3">    <div class="habblet ad-forum-leaderboard">
    
    </div>
</td>
	</tr>

<?php } $i++; }
$lang->addLocale("groups.discussion.newtopic");
$lang->addLocale("ajax.buttons"); ?>
<tr id="new-post-entry-message" style="display:none;">

	<td class="new-post-entry-label"><div class="new-post-entry-label" id="new-post-entry-label"><?php echo $lang->loc['post']; ?>:</div></td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
		<input type="hidden" id="edit-type" />

		<input type="hidden" id="post-id"  />
        <a href="#" class="preview-post-link" id="post-form-preview"><?php echo $lang->loc['preview']; ?> &raquo;</a>
        <input type="hidden" id="spam-message" value="<?php echo $lang->loc['spam.detected']; ?>"/>
		<textarea id="post-message" class="new-post-entry-message" rows="5" name="message" ></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("post-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
		<?php $colors = explode("|",$lang->loc['colors']); ?>
        var colors = { "red" : ["#d80000", "<?php echo addslashes($colors[0]); ?>"],
            "orange" : ["#fe6301", "<?php echo addslashes($colors[1]); ?>"],
            "yellow" : ["#ffce00", "<?php echo addslashes($colors[2]); ?>"],
            "green" : ["#6cc800", "<?php echo addslashes($colors[3]); ?>"],
            "cyan" : ["#00c6c4", "<?php echo addslashes($colors[4]); ?>"],
            "blue" : ["#0070d7", "<?php echo addslashes($colors[5]); ?>"],
            "gray" : ["#828282", "<?php echo addslashes($colors[6]); ?>"],
            "black" : ["#000000", "<?php echo addslashes($colors[7]); ?>"]
        };
        bbcodeToolbar.addColorSelect("<?php echo addslashes($lang->loc['colors.desc']); ?>", colors, false);
    </script>
<div id="linktool-inline">
    <div id="linktool-scope">
        <label for="linktool-query-input"><?php echo $lang->loc['create.link.to']; ?>:</label>

        <input type="radio" name="scope" class="linktool-scope" value="1" checked="checked"/><?php echo $lang->loc['habbos']; ?>
        <input type="radio" name="scope" class="linktool-scope" value="2"/><?php echo $lang->loc['rooms']; ?>
        <input type="radio" name="scope" class="linktool-scope" value="3"/><?php echo $lang->loc['groups']; ?>&nbsp;
    </div>
    <div class="linktool-input">
        <input id="linktool-query" type="text" size="30" name="query" value=""/>
        <input id="linktool-find" class="search" type="submit" title="<?php echo $lang->loc['find']; ?>" value=""/>
    </div>
    <div class="clear" style="height: 0;"><!-- --></div>

    <div id="linktool-results" style="display: none">
    </div>
    <script type="text/javascript">
        linkTool = new LinkTool(bbcodeToolbar.textarea);
    </script>
</div>
	    <div id="discussion-captcha">
<h3>
<label for="bean_captcha" class="registration-text"><?php echo $lang->loc['type.security.code']; ?></label>
</h3>

<div id="captcha-code-error"></div>

<p></p>

<div class="register-label" id="captcha-reload">
    <p>
        <img src="<?php echo PATH; ?>/web-gallery/v2/images/shared_icons/reload_icon.gif" width="15" height="15" alt=""/>
        <a id="captcha-reload-link" href="#"><?php echo $lang->loc['cant.read.code']; ?></a>
    </p>
</div>

<script type="text/javascript">
document.observe("dom:loaded", function() {
    Event.observe($("captcha-reload"), "click", function(e) {Utils.reloadCaptcha()});
});
</script>

<p id="captcha-container">
</p>

<p>
<input type="text" name="captcha" id="captcha-code" value="" class="registration-text required-captcha" />
</p>
</div>
        <div class="button-area">
            <a id="post-form-cancel" class="new-button red-button cancel-icon" href="#"><b><span></span><?php echo $lang->loc['cancel']; ?></b><i></i></a>
            <a id="post-form-save" class="new-button green-button save-icon" href="#"><b><span></span><?php echo $lang->loc['save']; ?></b><i></i></a>
        </div>

        </td>
        </tr>
        </table>
	</td>
</tr>
</table>
<div id="new-post-preview" style="display:none;">
</div>
    <div class="postlist-footer clearfix">
<?php if($user->id != 0 && ((($grouprow[9] == 2 && $memberrow[2] > 1) || ($grouprow[9] == 1 && $memberrow[2] > 0)) || ($grouprow[9] == 0)) && $threadrow['open'] == "1"){ ?>
                    <a href="#" id="create-post-message" class="create-post-link verify-email"><?php echo $lang->loc['post.reply']; ?></a>
<?php }elseif($threadrow['open'] == "0"){ ?>
<span class="topic-closed"><img src="<?php echo PATH; ?>/web-gallery/images/groups/status_closed.gif" title="<?php echo $lang->loc['closed.thread']; ?>"> <?php echo $lang->loc['closed.thread']; ?></span>
<?php }elseif($user->id == 0){ ?>
<p style="padding: 0 10px 10px 10px">
<?php echo $lang->loc['requires.login'] ?>
<a href="<?php echo PATH; ?>/"><?php echo $lang->loc['sign.in.now']; ?></a>
<?php } ?>

</p>        <div class="page-num-list">
    <?php echo $lang->loc['view.page']; ?>:
<?php echo $links; ?>        </div>
    </div>

<script type="text/javascript">
L10N.put("myhabbo.discussion.error.topic_name_empty", "<?php echo addslashes($lang->loc['topic.name.empty']); ?>");
L10N.put("register.error.security_code", "<?php echo addslashes($lang->loc['invalid.capcha']); ?>");
Discussions.initialize("<?php echo $grouprow[0]; ?>", "<?php echo $grouprow[10]; ?>", "<?php echo $threadrow['id']; ?>");
Discussions.captchaPublicKey = "<?php echo time(); ?>";
Discussions.captchaUrl = "<?php echo PATH; ?>/captcha.jpg?t=";
</script>