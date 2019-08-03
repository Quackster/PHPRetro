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

if (!defined("IN_HOLOCMS")) { header("Location: ".PATH."/"); exit; }

/*

	Please do not remove the copyright infomation below.  Doing so shows disrespct towards all HoloCMS/PHPRetro developers.
	You may remove any links though (you selfish jerk)
	
	The developers of this project do this for free with no personal gain, if you remove the copyright, you are breaking the license.
	If I find too many people doing so, then either 1) the project will be discontinued, or 2) the project will be closed-source

*/
$lang->addLocale("footer");
$lang->addLocale("homes.footer");

if($page['discussion'] == true){
?>
    <div class="habblet ">
<?php if(!$user->IsHCMember($userrow[0]) && $page['edit'] != true){ ?>
		<?php $sql = $db->query("SELECT * FROM ".PREFIX."banners WHERE status = '1' ORDER BY id ASC");

		while($row = $db->fetch_assoc($sql)) { ?>
		<?php if($row['advanced'] == "1"){
		echo $input->HoloText($row['html'], true)."\n<br />\n";
		}else{ ?>
		<?php if(!empty($row['banner'])){ ?><a target="blank" href="<?php echo $row['url']; ?>"><img src="<?php echo $row['banner']; ?>"></a><br /><?php } ?>
		<?php if(!empty($row['text'])){ ?><a target="blank" href="<?php echo $row['url']; ?>"><?php echo $row['text']; ?></a><br /><?php } ?>
		<?php } ?>
		<?php } ?>
<?php } ?>
    </div>
                </td>
            </tr>
        </table>
    </div>
  </div>
<?php }else{ ?>
				<div id="mypage-ad">
<?php if(!$user->IsHCMember($userrow[0]) && $page['edit'] != true){ ?>
<div class="habblet ">
	<div class="ad-container">
		<?php $sql = $db->query("SELECT * FROM ".PREFIX."banners WHERE status = '1' ORDER BY id ASC");

		while($row = $db->fetch_assoc($sql)) { ?>
		<?php if($row['advanced'] == "1"){
		echo $input->HoloText($row['html'], true)."\n<br />\n";
		}else{ ?>
		<?php if(!empty($row['banner'])){ ?><a target="blank" href="<?php echo $row['url']; ?>"><img src="<?php echo $row['banner']; ?>"></a><br /><?php } ?>
		<?php if(!empty($row['text'])){ ?><a target="blank" href="<?php echo $row['url']; ?>"><?php echo $row['text']; ?></a><br /><?php } ?>
		<?php } ?>
		<?php } ?>
	</div>
</div>
<?php } ?>
				</div>
			</div>
	</div>
</div>
<?php } ?>

<?php if($page['edit'] == true){ ?>
<script language="JavaScript" type="text/javascript">
initEditToolbar();
initMovableItems();
document.observe("dom:loaded", initDraggableDialogs);
Utils.setAllEmbededObjectsVisibility('hidden');
</script>
<?php }else{ ?>
<script type="text/javascript">
	Event.observe(window, "load", observeAnim);
	document.observe("dom:loaded", function() {
		initDraggableDialogs();
	});
</script>
<?php } ?>

<?php if($page['edit'] == true){ ?><div id="edit-save" style="display:none;"></div><?php } ?>
    </div>
<div id="footer">
	<p><a href="<?php echo PATH; ?>/" target="_self"><?php echo $lang->loc['link.homepage']; ?></a> | <a href="<?php echo PATH; ?>/papers/disclaimer" target="_self"><?php echo $lang->loc['link.disclaimer']; ?></a> | <a href="<?php echo PATH; ?>/papers/privacy" target="_self"><?php echo $lang->loc['link.privacy']; ?></a><?php echo $content; ?></p>
	<?php /*@@* DO NOT EDIT OR REMOVE THE LINE BELOW WHATSOEVER! *@@ You ARE allowed to remove the links though*/ ?>
	<p>Powered by <a href="http://www.phpretro.com/">PHPRetro</a> &copy 2009 <a href="http://www.yifanlu.com/">Yifan Lu</a>, Based on HoloCMS By <a href="http://www.meth0d.org">Meth0d</a><br /><?php echo $lang->loc['copyright.habbo']; ?></p>
	<?php /*@@* DO NOT EDIT OR REMOVE THE LINE ABOVE WHATSOEVER! *@@ You ARE allowed to remove the links though*/ ?>
</div></div>

</div>

<?php if($page['concurrent_editing'] == true){ ?>
<div class="dialog-grey" id="groups-concurrent-editing">
	<div class="dialog-grey-top dialog-grey-handle">
		<div><h3><span><?php echo $lang->loc['session.timeout.error']; ?></span></h3></div>
		
	</div>
	<div class="dialog-grey-content clearfix">
		<div id="groups-concurrent-editing-body" class="dialog-grey-body">
		<span class="avatar-image-frame">
			<img src="<?php echo $user->avatarURL($concurrentrow[4],"b,2,2,,1,0"); ?>" alt="<?php echo $input->HoloText($concurrentrow[1]); ?>" title="<?php echo $input->HoloText($concurrentrow[1]); ?>"/>
		</span>
		<div>
		<?php echo $lang->loc['currently.edited']; ?>:<br/>
		<a href="<?php echo PATH; ?>/home/<?php echo $input->HoloText($concurrentrow[1]); ?>"><?php echo $input->HoloText($concurrentrow[1]); ?></a>
		<?php echo $lang->loc['start.time']; ?>: <b> <?php echo date('d-M-Y H:i:s',$editrow['time']); ?> </b><br/>
		<?php echo $lang->loc['concurrent.timeout']; ?> <?php echo millisecondsToMinutes($timeout['expire']); ?> <?php echo $lang->loc['minutes']; ?><br/>
		<?php echo $lang->loc['please.try.later'] ?><br/>
		<a href="#" class="new-button" id="groups-concurrent-editing-close" >
			<b><?php echo $lang->loc['ok']; ?></b><i></i>
		</a>
		</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="dialog-grey-bottom"><div></div></div>
</div>
	<script type="text/javascript">
		Overlay.show();
		Dialog.moveDialogToCenter($("groups-concurrent-editing"));
		Event.observe($("groups-concurrent-editing-close"), "click", function(e) { 
			Event.stop(e);
			Element.remove($("groups-concurrent-editing"))
			Overlay.hide();
		});
	</script>
<?php } ?>

<?php if($page['edit'] != true){ ?>
<?php if($user->id > 0 && !$page['discussion']){ ?>
<div class="cbb topdialog" id="guestbook-form-dialog">
	<h2 class="title dialog-handle"><?php echo $lang->loc['edit.guestbook.entry']; ?></h2>
	
	<a class="topdialog-exit" href="#" id="guestbook-form-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-form-dialog-body">

<div id="guestbook-form-tab">
<form method="post" id="guestbook-form">
    <p>
        <?php echo $lang->loc['note.guestbook.char.limit']; ?>
        <input type="hidden" name="ownerId" value="<?php echo $userrow[0]; ?>" />
	</p>
	<div>
	    <textarea cols="15" rows="5" name="message" id="guestbook-message"></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("guestbook-message");
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
        bbcodeToolbar.addColorSelect("<?php echo $lang->loc['color']; ?>", colors, true);
    </script>

<div id="linktool">
    <div id="linktool-scope">
        <label for="linktool-query-input"><?php echo $lang->loc['create.link']; ?>:</label>
        <input type="radio" name="scope" class="linktool-scope" value="1" checked="checked"/><?php echo $lang->loc['habbos']; ?>
        <input type="radio" name="scope" class="linktool-scope" value="2"/><?php echo $lang->loc['rooms']; ?>
        <input type="radio" name="scope" class="linktool-scope" value="3"/><?php echo $lang->loc['groups']; ?>
    </div>
    <input id="linktool-query" type="text" name="query" value=""/>
    <a href="#" class="new-button" id="linktool-find"><b><?php echo $lang->loc['find']; ?></b><i></i></a>
    <div class="clear" style="height: 0;"><!-- --></div>

    <div id="linktool-results" style="display: none">
    </div>
    <script type="text/javascript">
        linkTool = new LinkTool(bbcodeToolbar.textarea);
    </script>
</div>
    </div>

	<div class="guestbook-toolbar clearfix">
		<a href="#" class="new-button" id="guestbook-form-cancel"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
		<a href="#" class="new-button" id="guestbook-form-preview"><b><?php echo $lang->loc['preview']; ?></b><i></i></a>	
	</div>

</form>
</div>
<div id="guestbook-preview-tab">&nbsp;</div>
	</div>
</div>	
<div class="cbb topdialog" id="guestbook-delete-dialog">
	<h2 class="title dialog-handle"><?php echo $lang->loc['delete.entry']; ?></h2>
	
	<a class="topdialog-exit" href="#" id="guestbook-delete-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-delete-dialog-body">
<form method="post" id="guestbook-delete-form">
	<input type="hidden" name="entryId" id="guestbook-delete-id" value="" />

	<p><?php echo $lang->loc['are.you.sure.delete.entry']; ?></p>
	<p>
		<a href="#" id="guestbook-delete-cancel" class="new-button"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
		<a href="#" id="guestbook-delete" class="new-button"><b><?php echo $lang->loc['delete']; ?></b><i></i></a>
	</p>
</form>
	</div>
</div>
<?php } ?>
<?php if($page['type'] == "groups"){ ?>
<?php if($user->id > 0){ ?>
<div id="group-tools" class="bottom-bubble">
	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
<h3><?php echo $lang->loc['edit.group']; ?></h3>

<ul>
	<li><a href="<?php echo PATH; ?>/groups/actions/startEditingSession/<?php echo $grouprow[0]; ?>" id="group-tools-style"><?php echo $lang->loc['modify.page']; ?></a></li>
	<?php if($memberrow[2] == 3){ ?><li><a href="#" id="group-tools-settings"><?php echo $lang->loc['settings']; ?></a></li><?php } ?>
	<li><a href="#" id="group-tools-badge"><?php echo $lang->loc['badge']; ?></a></li>
	<li><a href="#" id="group-tools-members"><?php echo $lang->loc['members']; ?></a></li>
</ul>

	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>

<div class="cbb topdialog black" id="dialog-group-settings">
	
	<div class="box-tabs-container">
<ul class="box-tabs">
	<li class="selected" id="group-settings-link-group"><a href="#"><?php echo $lang->loc['groups.settings']; ?></a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-forum"><a href="#"><?php echo $lang->loc['forum.settings']; ?></a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-room"><a href="#"><?php echo $lang->loc['room.settings']; ?></a><span class="tab-spacer"></span></li>
</ul>
</div>

	<a class="topdialog-exit" href="#" id="dialog-group-settings-exit">X</a>
	<div class="topdialog-body" id="dialog-group-settings-body">
<p style="text-align:center"><img src="<?php echo PATH; ?>/web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></p>
	</div>
</div>	

<script language="JavaScript" type="text/javascript">
Event.observe("dialog-group-settings-exit", "click", function(e) {
    Event.stop(e);
    closeGroupSettings();
}, false);
</script><div class="cbb topdialog black" id="group-memberlist">
	
	<div class="box-tabs-container">
<ul class="box-tabs">
	<li class="selected" id="group-memberlist-link-members"><a href="#"><?php echo $lang->loc['members']; ?></a><span class="tab-spacer"></span></li>
	<li id="group-memberlist-link-pending"><a href="#"><?php echo $lang->loc['pending.members']; ?></a><span class="tab-spacer"></span></li>
</ul>
</div>

	<a class="topdialog-exit" href="#" id="group-memberlist-exit">X</a>
	<div class="topdialog-body" id="group-memberlist-body">
<div id="group-memberlist-members-search" class="clearfix">
    
    <a id="group-memberlist-members-search-button" href="#" class="new-button"><b><?php echo $lang->loc['search']; ?></b><i></i></a>
    <input type="text" id="group-memberlist-members-search-string"/>
</div>
<div id="group-memberlist-members" style="clear: both"></div>
<div id="group-memberlist-members-buttons" class="clearfix">
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-give-rights"><b><?php echo $lang->loc['give.rights']; ?></b><i></i></a>
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-revoke-rights"><b><?php echo $lang->loc['revoke.rights']; ?></b><i></i></a>
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-remove"><b><?php echo $lang->loc['remove']; ?></b><i></i></a>
	<a href="#" class="new-button group-memberlist-button" id="group-memberlist-button-close"><b><?php echo $lang->loc['close']; ?></b><i></i></a>
</div>
<div id="group-memberlist-pending" style="clear: both"></div>
<div id="group-memberlist-pending-buttons" class="clearfix">
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-accept"><b><?php echo $lang->loc['accept']; ?></b><i></i></a>
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-decline"><b><?php echo $lang->loc['reject']; ?></b><i></i></a>
	<a href="#" class="new-button group-memberlist-button" id="group-memberlist-button-close2"><b><?php echo $lang->loc['close']; ?></b><i></i></a>
</div>
	</div>
</div>
<?php } ?>
<?php if($page['discussion'] == true){ ?>
<div class="cbb topdialog" id="postentry-verifyemail-dialog">
	<h2 class="title dialog-handle"><?php echo $lang->loc['confirm.email']; ?></h2>

	
	<a class="topdialog-exit" href="#" id="postentry-verifyemail-dialog-exit">X</a>
	<div class="topdialog-body" id="postentry-verifyemail-dialog-body">
	<p><?php echo $lang->loc['email.confirmation.required']; ?></p>
	<p><a href="<?php echo PATH; ?>/profile/profile?tab=3"><?php echo $lang->loc['email.activate']; ?></a></p>
	<p class="clearfix">
		<a href="#" id="postentry-verifyemail-ok" class="new-button"><b><?php echo $lang->loc['ok']; ?></b><i></i></a>
	</p>

	</div>
</div>
<?php } ?>
<?php if($page['discussion.post'] == true){ ?>
<div class="cbb topdialog" id="postentry-delete-dialog">
	<h2 class="title dialog-handle"><?php echo $lang->loc['delete.discussion']; ?></h2>
	
	<a class="topdialog-exit" href="#" id="postentry-delete-dialog-exit">X</a>
	<div class="topdialog-body" id="postentry-delete-dialog-body">
<form method="post" id="postentry-delete-form">
	<input type="hidden" name="entryId" id="postentry-delete-id" value="" />
	<p><?php echo $lang->loc['delete.confirm']; ?></p>
	<p class="clearfix">
		<a href="#" id="postentry-delete-cancel" class="new-button"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
		<a href="#" id="postentry-delete" class="new-button"><b><?php echo $lang->loc['delete']; ?></b><i></i></a>
	</p>
</form>
	</div>
</div>
<?php } ?>
<?php } ?>
<?php }else{ ?>
<div id="edit-menu" class="menu">
	<div class="menu-header">
		<div class="menu-exit" id="edit-menu-exit"><img src="<?php echo PATH; ?>/web-gallery/images/dialogs/menu-exit.gif" alt="" width="11" height="11" /></div>
		<h3><?php echo $lang->loc['edit']; ?></h3>

	</div>
	<div class="menu-body">
		<div class="menu-content">
			<form action="#" onsubmit="return false;">
				<div id="edit-menu-skins">
	<select id="edit-menu-skins-select">
	<?php $skins = explode("|", $lang->loc['skins']); ?>
			<option value="1" id="edit-menu-skins-select-defaultskin"><?php echo $skins[0]; ?></option>
			<option value="6" id="edit-menu-skins-select-goldenskin"><?php echo $skins[5]; ?></option>

			<?php if($userrow[2] > 5){ ?><option value="9" id="edit-menu-skins-select-default"><?php echo $skins[8]; ?></option><?php } ?>
			
			<option value="3" id="edit-menu-skins-select-metalskin"><?php echo $skins[2]; ?></option>
			<option value="5" id="edit-menu-skins-select-notepadskin"><?php echo $skins[4]; ?></option>
			<option value="2" id="edit-menu-skins-select-speechbubbleskin"><?php echo $skins[1]; ?></option>
			<option value="4" id="edit-menu-skins-select-noteitskin"><?php echo $skins[3]; ?></option>
<?php if($user->IsHCMember($userrow[0])){ ?>
			<option value="8" id="edit-menu-skins-select-hc_pillowskin"><?php echo $skins[7]; ?></option>
			<option value="7" id="edit-menu-skins-select-hc_machineskin"><?php echo $skins[6]; ?></option>
<?php } ?>
	</select>
				</div>
				<div id="edit-menu-stickie">

					<p><?php echo $lang->loc['warning.delete.note']; ?></p>
				</div>
				<div id="rating-edit-menu">
					<input type="button" id="ratings-reset-link" 
						value="<?php echo $lang->loc['reset.rating.']; ?>" />
				</div>
				<div id="highscorelist-edit-menu" style="display:none">
					<select id="highscorelist-game">
						<option value=""><?php echo $lang->loc['select.game']; ?></option>
						<?php $games = explode("|",$lang->loc['games']); ?>
						<option value="1"><?php echo $games[1]; ?></option>
						<option value="2"><?php echo $games[2]; ?></option>
						<option value="0"><?php echo $games[0]; ?></option>
					</select>
				</div>
				<div id="edit-menu-remove-group-warning">
					<p><?php echo $lang->loc['warning.group.other.owner']; ?></p>

				</div>
				<div id="edit-menu-gb-availability">
					<select id="guestbook-privacy-options">
						<option value="private"><?php if($page['type'] == "home"){ echo $lang->loc['friends.only']; }else{ echo $lang->loc['members.only']; } ?></option>
						<option value="public"><?php echo $lang->loc['public']; ?></option>
					</select>
				</div>
				<div id="edit-menu-trax-select">

					<select id="trax-select-options"></select>
				</div>
				<div id="edit-menu-remove">
					<input type="button" id="edit-menu-remove-button" value="<?php echo $lang->loc['remove']; ?>" />
				</div>
			</form>
			<div class="clear"></div>
		</div>
	</div>

	<div class="menu-bottom"></div>
</div>
<script language="JavaScript" type="text/javascript">
Event.observe(window, "resize", function() { if (editMenuOpen) closeEditMenu(); }, false);
Event.observe(document, "click", function() { if (editMenuOpen) closeEditMenu(); }, false);
Event.observe("edit-menu", "click", Event.stop, false);
Event.observe("edit-menu-exit", "click", function() { closeEditMenu(); }, false);
Event.observe("edit-menu-remove-button", "click", handleEditRemove, false);
Event.observe("edit-menu-skins-select", "click", Event.stop, false);
Event.observe("edit-menu-skins-select", "change", handleEditSkinChange, false);
Event.observe("guestbook-privacy-options", "click", Event.stop, false);
Event.observe("guestbook-privacy-options", "change", handleGuestbookPrivacySettings, false);
Event.observe("trax-select-options", "click", Event.stop, false);
Event.observe("trax-select-options", "change", handleTraxplayerTrackChange, false);
</script>

<?php } ?>

<script type="text/javascript">
HabboView.run();
</script>

<?php echo $settings->find("site_tracking"); ?>

</body>
</html>