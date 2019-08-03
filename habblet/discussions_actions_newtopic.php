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
$lang->addLocale("groups.discussion.newtopic");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['groupId']);
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">
<tr>
    <td class="post-header-link" valign="top" style="width: 148px;"></td>
    <td class="post-header-name" valign="top"></td>    
</tr>
<tr>
	<td colspan="3" class="post-list-row-container"><div id="new-topic-preview"></div></td>
</tr>

<tr class="new-topic-entry-label" id="new-topic-entry-label">
	<td class="new-topic-entry-label"><?php echo $lang->loc['topic']; ?>:</td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
	    <div class="post-list-content-element"><input type="text" size="50" id="new-topic-name" value=""/></div>
	    </td>
	    </tr>
	    </table>
    </td>
</tr>
<tr class="topic-name-error">
    <td></td>
    <td>
        <div id="topic-name-error"></div>
    </td>
</tr>
<tr id="new-post-entry-message" style="display:none;">

	<td class="new-post-entry-label"><div class="new-post-entry-label" id="new-post-entry-label"><?php echo $lang->loc['post']; ?>:</div></td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
		<input type="hidden" id="edit-type" />
		<input type="hidden" id="post-id"  />
        <a href="#" class="preview-post-link" id="topic-form-preview"><?php echo $lang->loc['preview']; ?> &raquo;</a>
        <input type="hidden" id="spam-message" value="<?php echo $loc['spam.detected']; ?>"/>
		<textarea id="post-message" class="new-post-entry-message" rows="5" name="message" ></textarea>
    <?php $colors = explode("|",$lang->loc['colors']); ?>
	<script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("post-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
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

<?php if($settings->find("site_capcha") == "1"){ ?>
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
<?php } ?>

        <div class="button-area">
            <a id="topic-form-cancel" class="new-button red-button cancel-icon" href="#"><b><span></span><?php echo $lang->loc['cancel']; ?></b><i></i></a>
            <a id="topic-form-save" class="new-button green-button save-icon" href="#"><b><span></span><?php echo $lang->loc['save']; ?></b><i></i></a>
        </div>
        </td>
        </tr>
        </table>
	</td>
</tr>

</table>
<div id="new-post-preview" style="display:none;">
</div>
