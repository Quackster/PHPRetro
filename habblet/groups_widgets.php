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

$widgetrow = $db->fetch_row($db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes.x,".PREFIX."homes.y,".PREFIX."homes.z,".PREFIX."homes.location,".PREFIX."homes.skin,".PREFIX."homes.variable,".PREFIX."homes_catalogue.minrank FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id AND ".PREFIX."homes.id = '".$widget."' LIMIT 1"));
$widgetrow[5] = str_replace('-','',$widgetrow[5]);
$grouprow = $db->fetch_row($data->select14($widgetrow[5]));
$memberrow = $db->fetch_row($data->select15($user->id,$grouprow[0]));

switch($widgetrow[1]){
///////////////////////////////////////////
case "groupinfowidget":
///////////////////////////////////////////
$lang->addLocale("groups.widget.info");
$lang->addLocale("ajax.buttons");
?>
<div class="movable widget GroupInfoWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
<div class="w_skin_<?php echo $widgetrow[6]; ?>">
	<div class="widget-corner" id="widget-<?php echo $widgetrow[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($page['edit'] == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $widgetrow[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $widgetrow[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $widgetrow[0]; ?>, "widget", "widget-<?php echo $widgetrow[0]; ?>-edit"); }, false);
</script>
<?php } ?>
<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['group.info']; ?></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">

<div class="group-info-icon"><img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $grouprow[1]; ?>.gif" /></div>
	    <img id="groupname-<?php echo $grouprow[0]; ?>-report" class="report-button report-gn"
			alt="report"
			src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif"
			style="display: none;" />
<h4><?php echo $input->HoloText($grouprow[2]); ?></h4>

<p><?php echo $lang->loc['created.on']; ?>: <b><?php echo $grouprow[4]; ?></b></p>
<?php $count = $serverdb->num_rows($data->select16($grouprow[0])); ?>
<p><b><?php echo $count; ?></b> <?php echo $lang->loc['users.in.group']; ?></p>
<?php if($grouprow[7] != "0"){ $roomrow = $db->fetch_row($data->select17($grouprow[7])); ?><p><a href="<?php echo PATH; ?>/client?forwardId=2&amp;roomId=<?php echo $roomrow[0]; ?>" onclick="HabboClient.roomForward(this, '<?php echo $roomrow[0]; ?>', 'private'); return false;" target="client" class="group-info-room"><?php echo $input->unicodeToImage($input->HoloText($roomrow[1])); ?></a></p><?php } ?>
<div class="group-info-description"><?php echo nl2br($input->HoloText($grouprow[3])); ?></div>



    <div id="profile-tags-panel">
    <div id="profile-tag-list">
<div id="profile-tags-container">
<?php
$sql2 = $db->query("SELECT * FROM ".PREFIX."tags WHERE ownerid = '".$grouprow[0]."' AND type = 'group' ORDER BY id ASC");
if($db->num_rows($sql2) < 1){ echo $lang->loc['no.tags']; }else{
while($tagsrow = $db->fetch_assoc($sql2)){
?>

    <span class="tag-search-rowholder">
	<?php if($memberrow[2] > 1){ ?>
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
<?php if($memberrow[2] > 1){ ?>
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
        new GroupInfoWidget('<?php echo $grouprow[0]; ?>', '<?php echo $user->id; ?>');
    });
</script>



	<img id="groupdesc-<?php echo $grouprow[0]; ?>-report" class="report-button report-gd"
	    alt="report"
	    src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif"
        style="display: none;" />

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
$count = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."guestbook WHERE ownerid = '".$grouprow[0]."' AND owner = 'group'"));
$start = $db->result($db->query("SELECT MAX(id) FROM ".PREFIX."guestbook WHERE ownerid = '".$grouprow[0]."' AND owner = 'group'"), 0 );
if($memberrow[2] != ""){ $ismember = true; }else{ $ismember = false; }
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
<?php if($count == 0){ ?>	<div id="guestbook-empty-notes"><?php echo $lang->loc['guestbook.no.entries']; ?></div><?php }else{ $page['bypass'] = true; $widget = $widgetrow[0]; $owner = $grouprow[0]; require('./habblet/myhabbo_guestbook_list.php'); } ?>
</ul></div>

<?php if($page['edit'] != true && ($display != "private" || ($display == "private" && $ismember == true)) && $user->id != 0){ ?>
	<div class="guestbook-toolbar clearfix">
	<a href="#" class="new-button envelope-icon" id="guestbook-open-dialog">
	<b><span></span><?php echo $lang->loc['new.message']; ?></b><i></i>
	</a>
	</div>
<?php } ?>

<script type="text/javascript">	
	document.observe("dom:loaded", function() {
		var gb<?php echo $widgetrow[0]; ?> = new GuestbookWidget('<?php echo $grouprow[0]; ?>', '<?php echo $widgetrow[0]; ?>', 500);
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
case "memberwidget":
///////////////////////////////////////////
$lang->addLocale("groups.widget.members");
?>
<div class="movable widget MemberWidget" id="widget-<?php echo $widgetrow[0]; ?>" style=" left: <?php echo $widgetrow[2]; ?>px; top: <?php echo $widgetrow[3]; ?>px; z-index: <?php echo $widgetrow[4]; ?>;">
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
$count = $serverdb->num_rows($data->select16($grouprow[0]));
?>
		<span class="header-left">&nbsp;</span><span class="header-middle"><?php echo $lang->loc['members.of.group']; ?> (<span id="avatar-list-size"
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

<?php $widgetid = $widgetrow[0]; $page['bypass'] = true; require_once('./habblet/myhabbo_avatarlist_membersearchpaging.php'); ?>

</div>
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
	<?php $tsql = $data->select12($grouprow[6]); while($trow = $db->fetch_row($tsql)){ ?>

        <option value="<?php echo $trow[0]; ?>"><?php echo $input->HoloText($trow[1]); ?></option>

	<?php } ?>
    </select>
</div>
<?php }elseif($widgetrow[7] == ""){ echo $lang->loc['no.songs']; }else{ ?>
<div id="traxplayer-content" style="text-align:center;"></div>
<embed type="application/x-shockwave-flash"
src="<?php echo PATH; ?>/flash/traxplayer/traxplayer.swf" name="traxplayer" quality="high"
base="<?php echo PATH; ?>/flash/traxplayer/" allowscriptaccess="always" menu="false"
wmode="transparent" flashvars="songUrl=<?php echo PATH; ?>/trax/song/<?php echo $input->HoloText($widgetrow[7]); ?>&amp;sampleUrl=http://images.habbohotel.com/dcr/hof_furni//mp3/" height="66" width="210" />
<?php } ?>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
break 1;
}
?>