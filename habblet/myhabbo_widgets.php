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

$data = new home_sql;

$widgetrow = $db->fetch_row($db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes.x,".PREFIX."homes.y,".PREFIX."homes.z,".PREFIX."homes.ownerid,".PREFIX."homes.skin,".PREFIX."homes.variable,".PREFIX."homes_catalogue.minrank FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id AND ".PREFIX."homes.id = '".$widget."' LIMIT 1"));
$userrow = $db->fetch_row($data->select2($widgetrow[5]));

switch($widgetrow[1]){
///////////////////////////////////////////
case "profilewidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.profile");
$lang->addLocale("ajax.buttons");
?>
<div class="movable widget ProfileWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['my.profile']; ?></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
	<div class="profile-info">
		<div class="name" style="float: left">
		<span class="name-text"><?php echo $input->HoloText($userrow[1]); ?></span>
		<?php if($page['edit'] != true){; ?>
					<img id="name-<?php echo $userrow[0]; ?>-report" class="report-button report-n"
				alt="report"
				src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif"
				style="display: none;" />
		<?php } ?>
		</div>

		<br class="clear" />

		<?php $online = $user->IsUserOnline($userrow[0]); if($online == true){ $online = "online"; $suffix = "_anim"; }else{ $online = "offline"; } ?>
			<img alt="<?php echo $online; ?>" src="<?php echo PATH; ?>/web-gallery/images/myhabbo/profile/habbo_<?php echo $online.$suffix; ?>.gif" />
		<div class="birthday text">
			<?php echo $lang->loc['habbo.created.on'] ?>:
		</div>
		<div class="birthday date">
			<?php echo $input->HoloText($userrow[3]); ?>
		</div>
		<div>
    	<?php $bsql = $data->select10($userrow[0]); if($db->num_rows($bsql) != 0){ $brow = $db->fetch_row($bsql); ?><a href="<?php echo groupURL($brow[0]); ?>" title="<?php echo $input->HoloText($brow[2]); ?>"><img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $input->HoloText($brow[1]); ?>.gif" /></a><?php } ?>
            <?php if($user->GetUserBadge($userrow[0]) != false){ ?><img src="<?php echo $settings->find("site_c_images_path").$settings->find("site_badges_path").$user->GetUserBadge($userrow[0]).".gif"; ?>" /><?php } ?>
        </div>
	</div>
	<div class="profile-figure">
			<img alt="<?php echo $input->HoloText($userrow[1]); ?>" src="<?php echo $user->avatarURL($userrow[4],"b,4,4,,1,0"); ?>" />
	</div>
	<?php if($userrow[5] != ""){ ?>
	<div class="profile-motto">
		<?php echo $input->unicodeToImage($input->HoloText($userrow[5])); ?>
		<?php if($page['edit'] != true){; ?>
				<img id="motto-<?php echo $userrow[0]; ?>-report" class="report-button report-n"
			alt="report"
			src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif"
			style="display: none;" />
		<?php } ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php if($userrow[0] != $user->id){ ?>
		<div class="profile-friend-request clearfix">
			<?php if($serverdb->num_rows($data->select4($user->id,$userrow[0])) > 0){ ?>
			<strong><?php echo $input->HoloText($userrow[1]); ?></strong> <?php echo $lang->loc['is.your.friend']; ?>.
			<?php }else{ ?>
			<a class="new-button" id="add-friend" style="float: left"><b><?php echo $lang->loc['add.as.friend']; ?></b><i></i></a>
			<?php } ?>
		</div>
	<?php } ?>
	<br clear="all" style="display: block; height: 1px"/>
    <div id="profile-tags-panel">
    <div id="profile-tag-list">
<div id="profile-tags-container">
<?php
$sql2 = $db->query("SELECT * FROM ".PREFIX."tags WHERE ownerid = '".$userrow[0]."' AND type = 'user' ORDER BY id ASC");
if($db->num_rows($sql2) < 1){ echo $lang->loc['no.tags']; }else{
while($tagsrow = $db->fetch_assoc($sql2)){
?>

    <span class="tag-search-rowholder">
	<?php if($userrow[0] == $user->id){ ?>
        <a href="<?php echo PATH; ?>/tag/<?php echo $input->HoloText($tagsrow['tag']); ?>" class="tag"
        ><?php echo $input->HoloText($tagsrow['tag']); ?></a><img border="0" class="tag-delete-link" onMouseOver="this.src='<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_delete_hi.gif'" onMouseOut="this.src='<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_delete.gif'" src="<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_delete.gif"
        />
	<?php }else{ ?>
        <a href="<?php echo PATH; ?>/tag/<?php echo $input->HoloText($tagsrow['tag']); ?>" class="tag"
        ><?php echo $input->HoloText($tagsrow['tag']); ?></a><img border="0" class="tag-add-link" onMouseOver="this.src='<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_add_hi.gif'" onMouseOut="this.src='<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_add.gif'" src="<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_add.gif"
        />
	<?php } ?>
    </span>

<?php } ?>
    <img id="tag-img-added" border="0" class="tag-none-link" src="<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_added.gif" style="display:none"/>    
<?php } ?>
</div>

<script type="text/javascript">
    document.observe("dom:loaded", function() {
        TagHelper.setTexts({
            buttonText: "<?php echo addslashes($lang->loc['ok']); ?>",
            tagLimitText: "<?php echo addslashes($lang->loc['tags.limit']); ?>"
        });
    });
</script>
    </div>
<?php if($userrow[0] == $user->id){ ?>
<div id="profile-tags-status-field">
 <div style="display: block;">
  <div class="content-red">
   <div class="content-red-body">
    <span id="tag-limit-message"><img src="<?php echo PATH; ?>/web-gallery/images/register/icon_error.gif"/> <?php echo $lang->loc['tags.limit']; ?></span>
    <span id="tag-invalid-message"><img src="<?php echo PATH; ?>/web-gallery/images/register/icon_error.gif"/> <?php echo $lang->loc['invalid.tag']; ?></span>
   </div>
  </div>
 <div class="content-red-bottom">
  <div class="content-red-bottom-body"></div>
 </div>
 </div>
</div>        <div class="profile-add-tag">
            <input type="text" id="profile-add-tag-input" maxlength="30"/><br clear="all"/>
            <a href="#" class="new-button" style="float:left;margin:5px 0 0 0;" id="profile-add-tag"><b><?php echo $lang->loc['add.tag']; ?></b><i></i></a>
        </div>
<?php } ?>
    </div>
    <script type="text/javascript">
		document.observe("dom:loaded", function() {
			new ProfileWidget('<?php echo $userrow[0]; ?>', '<?php echo $user->id; ?>', {
				headerText: "<?php echo addslashes($lang->loc['are.you.sure']); ?>",
				messageText: "<?php echo addslashes($lang->loc['sure.you.ask']); ?> <strong\><?php echo $input->HoloText(addslashes($userrow[1])); ?></strong\> <?php echo addslashes($lang->loc['to.be.your.friend']); ?>",
				loginText: "<?php echo addslashes($lang->loc['login.error.friend.request']); ?>",
				buttonText: "<?php echo addslashes($lang->loc['ok']); ?>",
				cancelButtonText: "<?php echo addslashes($lang->loc['cancel']); ?>"
			});
		});
	</script>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
///////////////////////////////////////////
case "guestbookwidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.guestbook");
?>
<div class="movable widget GuestbookWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
<?php
$count = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."guestbook WHERE ownerid = '".$userrow[0]."' AND owner = 'user'"));
$start = $db->result($db->query("SELECT MAX(id) FROM ".PREFIX."guestbook WHERE ownerid = '".$userrow[0]."' AND owner = 'user'"), 0 );
$isfriend = $data->select4($user->id,$userrow[0]);
if($db->num_rows($isfriend) > 0){ $isfriend = true; }else{ $isfriend = false; }
if($userrow[0] == $user->id){ $isfriend = true; }
$start = $start + 1;
if($widgetrow[7] == "private"){ $display = "private"; }else{ $display = "public"; }
?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['my.guestbook']; ?>(<span id="guestbook-size"><?php echo $count; ?></span>) <span id="guestbook-type" class="<?php echo $display; ?>"><img src="<?php echo PATH; ?>/web-gallery/images/groups/status_exclusive.gif" title="myhabbo.guestbook.unknown.private" alt="myhabbo.guestbook.unknown.private"/></span></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<div id="guestbook-wrapper" class="gb-<?php echo $display; ?>">
<ul class="guestbook-entries" id="guestbook-entry-container">
<?php if($count == 0){ ?>	<div id="guestbook-empty-notes"><?php echo $lang->loc['guestbook.no.entries']; ?></div><?php }else{ $page['bypass'] = true; $widget = $widgetrow[0]; $owner = $userrow[0]; require('./habblet/myhabbo_guestbook_list.php'); } ?>
</ul></div>

<?php if($page['edit'] != true && ($display != "private" || ($display == "private" && $isfriend == true)) && $user->id != 0){ ?>
	<div class="guestbook-toolbar clearfix">
	<a href="#" class="new-button envelope-icon" id="guestbook-open-dialog">
	<b><span></span><?php echo $lang->loc['new.message']; ?></b><i></i>
	</a>
	</div>
<?php } ?>

<script type="text/javascript">	
	document.observe("dom:loaded", function() {
		var gb<?php echo $widgetrow[0]; ?> = new GuestbookWidget('<?php echo $userrow[0]; ?>', '<?php echo $widgetrow[0]; ?>', 500);
		<?php if($count > 20){ ?>gb<?php echo $widgetrow[0]; ?>.monitorScrollPosition();<?php } ?>
		var editMenuSection = $('guestbook-privacy-options');
		if (editMenuSection) {
			gb<?php echo $widgetrow[0]; ?>.updateOptionsList('<?php echo $display; ?>');
		}
	});
</script>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
///////////////////////////////////////////
case "highscoreswidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.highscore");
?>
<div class="movable widget HighScoresWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['high.scores']; ?></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<?php $hsrow = $db->fetch_row($data->select6($userrow[0])); ?>
	<table>
	<?php if($hsrow[1] == 0 || $hsrow[1] == ""){ ?>
			<tr>
				<td><?php echo $lang->loc['no.high.scores']; ?></td>
			</tr>
	<?php }else{ ; ?>
			<tr colspan="2">
			<th><a href="#"><?php echo $lang->loc['battle.ball']; ?></a></th>
			</tr>
			<tr>
				<td><?php echo $lang->loc['games.played'] ?></td>

				<td><?php echo $input->HoloText($hsrow[1]); ?></td>
			</tr>
			<tr>
				<td><?php echo $lang->loc['total.scores']; ?></td>
				<td><?php echo $input->HoloText($hsrow[0]); ?></td>
			</tr>
	<?php } ?>
	</table>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
///////////////////////////////////////////
case "badgeswidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.badges");
?>
<div class="movable widget BadgesWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['badges.achievements']; ?></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
    <div id="badgelist-content">
	<?php $badgessql = $data->select7($userrow[0]); if($db->num_rows($badgessql) < 1){ echo $lang->loc['no.badges']; }else{ ?>
    <ul class="clearfix">
	<?php while($badgerow = $db->fetch_row($badgessql)){ ?>
	
            <li style="background-image: url(<?php echo $settings->find("site_c_images_path").$settings->find("site_badges_path").$badgerow[0].".gif"; ?>)"></li>

	<?php } ?>
    </ul>
	<?php } ?>

    </div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
///////////////////////////////////////////
case "friendswidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.friends");
?>
<div class="movable widget FriendsWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
<?php
$count = $serverdb->num_rows($data->select8($userrow[0]));
?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['my.friends']; ?> (<span id="avatar-list-size"
><?php echo $count; ?></span>)</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">

<div id="avatar-list-search">
<input type="text" style="float:left;" id="avatarlist-search-string"/>
<a class="new-button" style="float:left;" id="avatarlist-search-button"><b><?php echo $lang->loc['search']; ?></b><i></i></a>
</div>
<br clear="all"/>

<div id="avatarlist-content">

<?php $widgetid = $widgetrow[0]; $page['bypass'] = true; require_once('./habblet/myhabbo_avatarlist_friendsearchpaging.php'); ?>

</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
///////////////////////////////////////////
case "groupswidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.groups");
?>
<div class="movable widget GroupsWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
<?php $gsql = $data->select10($userrow[0]); $count = $db->num_rows($gsql); ?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['my.groups']; ?> (<span id="groups-list-size"><?php echo $count; ?></span>)</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">

<?php if($count == 0){ ?>
<div class="groups-list-none">
<?php echo $lang->loc['no.groups']; ?>
</div>
<?php }else{ ?>
<div class="groups-list-container">
<ul class="groups-list">
<?php while($grow = $db->fetch_row($gsql)){ ?>

	<li title="<?php echo $input->HoloText($grow[2]); ?>" id="groups-list-<?php echo $widgetrow[0]; ?>-<?php echo $grow[0]; ?>">
		<div class="groups-list-icon"><a href="<?php echo groupURL($grow[0]); ?>"><img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $grow[1]; ?>.gif"/></a></div>
		<div class="groups-list-open"></div>
		<h4>

		<a href="<?php echo groupURL($grow[0]); ?>"><?php echo $input->HoloText($grow[2]); ?></a>
		<?php if($grow[5] == '1'){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/status_exclusive.gif" width="16" height="12" alt="<?php echo $lang->loc['exclusive']; ?>" title="<?php echo $lang->loc['exclusive']; ?>" /><?php } ?>
		</h4>
		<p>
		<?php echo $lang->loc['group.created']; ?>:<br /> 
		<?php if($grow[7] == '1'){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/favourite_group_icon.gif" width="15" height="15" class="groups-list-icon" alt="<?php echo $lang->loc['favorite']; ?>" title="<?php echo $lang->loc['favorite']; ?>" /><?php } ?>
		<?php if($grow[6] > 1 && $grow[8] == $userrow[0]){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/owner_icon.gif" width="15" height="15" class="groups-list-icon" alt="<?php echo $lang->loc['owner']; ?>" title="<?php echo $lang->loc['owner']; ?>" /><?php } ?>
		<?php if($grow[6] > 1 && $grow[8] != $userrow[0]){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/administrator_icon.gif" width="15" height="15" class="groups-list-icon" alt="<?php echo $lang->loc['admin'] ?>" title="<?php echo $lang->loc['admin']; ?>" /><?php } ?>
		<b><?php echo $input->HoloText($grow[4]); ?></b>
		</p>
		<div class="clear"></div>

	</li>
	
<?php } ?>
</ul></div>
<?php } ?>

<div class="groups-list-loading"><div><a href="#" class="groups-loading-close"></a></div><div class="clear"></div><p style="text-align:center"><img src="<?php echo PATH; ?>/web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></p></div>
<div class="groups-list-info"></div>

		<div class="clear"></div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">	

	new GroupsWidget('<?php echo $userrow[0]; ?>', '<?php echo $widgetrow[0]; ?>');

</script>
<?php
break 1;
///////////////////////////////////////////
case "roomswidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.rooms");
?>
<div class="movable widget RoomsWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
<?php $rsql = $data->select11($userrow[0]); $count = $db->num_rows($rsql); ?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['my.rooms']; ?></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
    <?php if($count < 1){ echo $lang->loc['no.rooms']; }else{ ?>
<div id="room_wrapper">
<table border="0" cellpadding="0" cellspacing="0">
<?php $i = 0; while($rrow = $db->fetch_row($rsql)){ $i++; switch($rrow[3]){ case 0: $state = "room_icon_open"; $text = $lang->loc['enter.room']; break; case 1: $state = "room_icon_locked"; $text = $lang->loc['password.protected']; break; case 2: $state = "room_icon_password"; $text = $lang->loc['locked']; break; }?>

<tr>

<td valign="top" <?php if($i != $count){ ?>class="dotted-line"<?php } ?>>
		<div class="room_image">
				<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/rooms/<?php echo $state; ?>.gif" alt="" align="middle"/>
		</div>
</td>
<td <?php if($i != $count){ ?>class="dotted-line"<?php } ?>>
        	<div class="room_info">
        		<div class="room_name">
        			<?php echo $input->unicodeToImage($input->HoloText($rrow[1])); ?>
        		</div>
				<div class="clear"></div>

        		<div><?php echo $input->unicodeToImage($input->HoloText($rrow[2])); ?>
        		</div>
					<?php if($rrow[3] < 2){ ?><a href="<?php echo PATH; ?>/client?forwardId=2&amp;roomId=<?php echo $input->HoloText($rrow[0]); ?>"
					   target="client"
					   id="room-navigation-link_<?php echo $input->HoloText($rrow[0]); ?>"
					   onclick="HabboClient.roomForward(this, '<?php echo $input->HoloText($rrow[0]); ?>', 'private', false); return false;"><?php } ?>
					 <?php echo $text; ?>
					 <?php if($rrow[3] < 2){ ?></a><?php } ?>
        	</div>
		<br class="clear" />

</td>
</tr>

<?php } ?>
</table>
</div>
<?php } ?>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
///////////////////////////////////////////
case "traxplayerwidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.trax");
?>
<div class="movable widget TraxPlayerWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['traxplayer']; ?></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<?php if($page['edit'] == true){ ?>
<div id="traxplayer-content" style="text-align: center;">
	<img src="<?php echo PATH; ?>/web-gallery/images/traxplayer/player.png"/>
</div>

<div id="edit-menu-trax-select-temp" style="display:none">
    <select id="trax-select-options-temp">
    <option value="">- <?php echo $lang->loc['choose.song']; ?> -</option>
	<?php $tsql = $data->select12($userrow[0]); while($trow = $db->fetch_row($tsql)){ ?>

        <option value="<?php echo $trow[0]; ?>"><?php echo $input->HoloText($trow[1]); ?></option>

	<?php } ?>
    </select>
</div>
<?php }elseif($widgetrow[7] == ""){ echo $lang->loc['no.songs']; }else{ ?>
<div id="traxplayer-content" style="text-align:center;"></div>
<embed type="application/x-shockwave-flash"
src="<?php echo PATH; ?>/flash/traxplayer/traxplayer.swf" name="traxplayer" quality="high"
base="<?php echo PATH; ?>/web-gallery/flash/traxplayer/" allowscriptaccess="always" menu="false"
wmode="transparent" flashvars="songUrl=<?php echo PATH; ?>/trax/song/<?php echo $input->HoloText($widgetrow[7]); ?>&amp;sampleUrl=http://images.habbohotel.com/dcr/hof_furni//mp3/" height="66" width="210" />
<?php } ?>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
///////////////////////////////////////////
case "ratingwidget":
///////////////////////////////////////////
$lang->addLocale("homes.widget.rating");
?>
<div class="movable widget RatingWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['my.rating']; ?></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
	<div id="rating-main">
<?php
$myvote = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."ratings WHERE raterid = '".$user->id."' AND userid = '".$userrow[0]."'"));
$totalvotes = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."ratings WHERE userid = '".$userrow[0]."'"));
$highvotes = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."ratings WHERE userid = '".$userrow[0]."' AND rating > 3"));
if($userrow[0] == $user->id || $myvote > 0){ $page['bypass'] = true; $ownerid = $userrow[0]; $widgetid = $widgetrow[0]; $rate = 0; require_once('./habblet/myhabbo_rating_rate.php'); }else{ ?>
<script type="text/javascript">	
	var ratingWidget;
	document.observe("dom:loaded", function() { 
		ratingWidget = new RatingWidget(<?php echo $userrow[0]; ?>, <?php echo $widgetrow[0]; ?>);
	}); 
</script><div class="rating-average">
		<b><?php echo $lang->loc['cast.vote']; ?></b>
	<div id="rating-stars" class="rating-stars" >
				<ul id="rating-unit_ul1" class="rating-unit-rating">
				<li class="rating-current-rating" style="width:0px;" />
					<li><a href="#"   class="r1-unit rater">1</a></li>
					<li><a href="#"   class="r2-unit rater">2</a></li>
					<li><a href="#"   class="r3-unit rater">3</a></li>
					<li><a href="#"   class="r4-unit rater">4</a></li>
					<li><a href="#"   class="r5-unit rater">5</a></li>
	
			</ul>	
	</div>
	<?php echo $totalvotes; ?> <?php echo $lang->loc['votes.total']; ?>
	
	<br/>
	(<?php echo $highvotes; ?> <?php echo $lang->loc['high.votes.total']; ?>)
</div>
<?php } ?>

	</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
}
?>