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

$page['allow_guests'] = true;
$page['no_column3'] = true;
require_once('./includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;
$lang->addLocale("home.homes");
$lang->addLocale("community.groups");
$lang->addLocale("ajax.buttons");

function millisecondsToMinutes($int){
	return ceil($int / 60000);
}
$id = $input->FilterText($_GET['id']);

if(isset($_GET['alias']) && !isset($_GET['id'])){
	$alias = $input->FilterText($_GET['alias']);
	$sql = $data->select18($alias);
	if($serverdb->num_rows($sql) > 0){
		$id = $serverdb->result($sql);
	}else{
		$id = 0;
	}
}

$sql = $data->select14($id);
if($db->num_rows($sql) < 1){ $lang->clearLocale; require_once('./error.php'); exit; }

$grouprow = $db->fetch_row($sql);
$userrow = $db->fetch_row($data->select2($grouprow[6]));

$sql = $data->select15($user->id,$grouprow[0]);
$memberrow = $db->fetch_row($sql);
if($memberrow[2] > 1){ $hasrights = true; }else{ $hasrights = false; }

$page['id'] = "home";
$page['type'] = "groups";
$page['name'] = $input->HoloText($grouprow[2]).$lang->loc['pagename.groups'];
$page['cat'] = "community";
$sql = $db->query("SELECT * FROM ".PREFIX."homes_edit WHERE pageid = '".$grouprow[0]."' AND `type` = 'group' LIMIT 1");
if($db->num_rows($sql) > 0){
	$editrow = $db->fetch_assoc($sql);
	if(($editrow['time'] + (60*30)) < time()){
		$db->query("DELETE FROM ".PREFIX."homes_edit WHERE pageid = '".$grouprow[0]."' AND type = 'group' LIMIT 1");
		$db->query("DELETE FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id AND ".PREFIX."homes.location = '-".$grouprow[0]."' AND ".PREFIX."homes_catalogue.type = '2'");
		$db->query("UPDATE ".PREFIX."homes SET x = '1', y = '1', z = '1', location = '-1', skin = 'defaultskin', variable = '' WHERE location = '-".$grouprow[0]."' AND ownerid = '".$user->id."'");
		unset($_SESSION['page_edit']);
		$page['bodyid'] = "viewmode"; $sqladdon = "AND location = '".$grouprow[0]."'";
		$editrow['editorid'] = "-1";
	}elseif($editrow['editorid'] != $user->id && $_GET['concurrentEditing'] == "true"){
		$page['concurrent_editing'] = true;
		$concurrentrow = $db->fetch_row($data->select2($editrow['editorid']));
	}
	if($editrow['editorid'] == $user->id){
		$page['edit'] = true; $page['bodyid'] = "editmode"; $sqladdon = "AND (location = '".$grouprow[0]."' OR location = '-".$grouprow[0]."')";
		$_SESSION['page_edit'] = $grouprow[0];
		$timeout['twominutes'] = 1680000 - ((time() - $editrow['time']) * 1000);
		$timeout['expire'] = 1800000 - ((time() - $editrow['time']) * 1000);
	}else{
		$page['bodyid'] = "viewmode"; $sqladdon = "AND location = '".$grouprow[0]."'";
	}
}else{
	$page['bodyid'] = "viewmode"; $sqladdon = "AND location = '".$grouprow[0]."'";
}

require_once('./templates/community_header.php');

$sql = $db->query("SELECT ".PREFIX."homes_catalogue.data FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE type = '4' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id LIMIT 1");
if($db->num_rows($sql) > 0){ $group['background'] = formatItem(4,$db->result($sql),false); }else{ $group['background'] = "b_bg_colour_08"; }
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="mypage-wrapper" class="cbb blue">
<div class="box-tabs-container box-tabs-left clearfix">
<?php if($page['edit'] != true){ ?>
	<?php if($memberrow[2] > 1 && $page['edit'] != true){ ?><a href="#" id="myhabbo-group-tools-button" class="new-button dark-button edit-icon" style="float:left"><b><span></span><?php echo $lang->loc['edit']; ?></b><i></i></a><?php } ?>
	<div class="myhabbo-view-tools">
				<?php if($memberrow[0] != "" && $memberrow[3] != 1  && $memberrow[4] != 1){ ?>
					<a href="#" id="select-favorite-button"><?php echo $lang->loc['make.favorite']; ?></a>
				<?php }elseif($memberrow[0] != "" && $memberrow[3] == 1  && $memberrow[4] != 1){ ?>
					<a href="#" id="deselect-favorite-button"><?php echo $lang->loc['remove.favorite']; ?></a>
				<?php } ?>
				<?php if($memberrow[0] == ""){ ?>
					<?php if(($grouprow[5] == 0 || $grouprow[5] == 1 || $grouprow[5] == 3) && $user->id != 0){ ?><a href="<?php echo PATH; ?>/groups/actions/join?groupId=<?php echo $grouprow[0]; ?>" id="join-group-button"><?php if($grouprow[5] == 0){ echo $lang->loc['join']; }else{ echo $lang->loc['request.membership']; } ?></a><?php } ?>
					<a href="#" id="reporting-button" style="display: none;"><?php echo $lang->loc['show.report']; ?></a>
					<a href="#" id="stop-reporting-button" style="display: none;"><?php echo $lang->loc['hide.report']; ?></a>
				<?php }elseif($memberrow[2] < 3  && $memberrow[4] != 1){ ?>
					<a href="<?php echo PATH; ?>/groups/actions/leave?groupId=<?php echo $grouprow[0]; ?>" id="leave-group-button"><?php echo $lang->loc['leave.group']; ?></a>
				<?php } ?>
	</div>
<?php } ?>
    <h2 class="page-owner">
    	<?php echo $input->HoloText($grouprow[2]); ?>
			<?php if($grouprow[5] == 1){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/status_exclusive_big.gif" width="18" height="16" alt="<?php echo $lang->loc['exclusive.group']; ?>" title="<?php echo $lang->loc['exclusive.group']; ?>" class="header-bar-group-status" /><?php } ?>
			<?php if($grouprow[5] == 2){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/status_closed_big.gif" width="18" height="16" alt="<?php echo $lang->loc['closed.group']; ?>" title="<?php echo $lang->loc['closed.group']; ?>" class="header-bar-group-status" /><?php } ?>
    </h2>
    <ul class="box-tabs">
        <li class="selected"><a href="<?php echo groupURL($grouprow[0]); ?>"><?php echo $lang->loc['front.page']; ?></a><span class="tab-spacer"></span></li>
        <li><a href="<?php echo groupURL($grouprow[0]); ?>/discussions"><?php echo $lang->loc['discussion.forum']; ?><?php if($grouprow[8] == 1){ ?> <img src="<?php echo PATH; ?>/web-gallery/images/grouptabs/privatekey.png" title="<?php echo $lang->loc['private.forum']; ?>" alt="<?php echo $lang->loc['private.forum']; ?>" /><?php } ?></a><span class="tab-spacer"></span></li>
    </ul>
</div>
	<div id="mypage-content">
<?php if($page['edit'] == true){ ?>

<div id="top-toolbar" class="clearfix">
	<ul>
		<li><a href="#" id="inventory-button"><?php echo $lang->loc['inventory']; ?></a></li>
		<li><a href="#" id="webstore-button"><?php echo $lang->loc['web.store']; ?></a></li>
	</ul>
	
	<form action="#" method="get" style="width: 50%">
		<a id="cancel-button" class="new-button red-button cancel-icon" href="#"><b><span></span><?php echo $lang->loc['cancel.editing']; ?></b><i></i></a>
		<a id="save-button" class="new-button green-button save-icon" href="#"><b><span></span><?php echo $lang->loc['save.changes']; ?></b><i></i></a>
	</form>
</div>

<?php } ?>
			<div id="mypage-bg" class="<?php echo $group['background']; ?>">
				<?php if($page['edit'] == true){ ?><div id="playground-outer"><?php } ?>
				<div id="playground">

<?php
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes.skin,".PREFIX."homes.x,".PREFIX."homes.y,".PREFIX."homes.z,".PREFIX."homes.variable FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE type = '3' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id");
while($row = $db->fetch_row($sql)){
?>

<div class="movable stickie n_skin_<?php echo $row[1]; ?>-c" style=" left: <?php echo $row[2]; ?>px; top: <?php echo $row[3]; ?>px; z-index: <?php echo $row[4]; ?>;" id="stickie-<?php echo $row[0]; ?>">

	<div class="n_skin_<?php echo $row[1]; ?>" >
		<div class="stickie-header">
		<?php if($page['edit'] == true){ ?>
					<h3>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="stickie-<?php echo $row[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("stickie-<?php echo $row[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $row[0]; ?>, "stickie", "stickie-<?php echo $row[0]; ?>-edit"); }, false);
</script>
			</h3>
		<?php }else{ ?>
			<h3>					<img id="stickie-<?php echo $row[0]; ?>-report" class="report-button report-s" alt="report" src="<?php echo PATH; ?>/web-gallery/images/myhabbo/buttons/report_button.gif" style="display: none" />
			</h3>
		<?php } ?>
			<div class="clear"></div>
		</div>
		<div class="stickie-body">
			<div class="stickie-content">
				<?php if($userrow[2] > 5){ $html = true; }else{ $html = false; } ?>
				<div class="stickie-markup"><?php echo nl2br($input->bbcode_format($input->HoloText($row[5],$html))); ?></div>
				<div class="stickie-footer">
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<?php
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes.x,".PREFIX."homes.y,".PREFIX."homes.z,".PREFIX."homes.ownerid FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE type = '1' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id");
while($row = $db->fetch_row($sql)){
?>

    <div class="movable sticker <?php echo formatItem(1,$row[1],false); ?>" style="left: <?php echo $row[2]; ?>px; top: <?php echo $row[3]; ?>px; z-index: <?php echo $row[4]; ?>" id="sticker-<?php echo $row[0]; ?>">
<?php if($page['edit'] == true){ ?>

<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="sticker-<?php echo $row[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("sticker-<?php echo $row[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $row[0]; ?>, "sticker", "sticker-<?php echo $row[0]; ?>-edit"<?php if($row[5] != $user->id){ ?>, <?php echo $row[5]; } ?>); }, false);
</script>

<?php } ?>
    </div>

<?php } ?>

<?php
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE type = '2' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id");
while($row = $db->fetch_row($sql)){
	$widget = $row[0];
	require('./habblet/groups_widgets.php');
}
?>
				</div>
			<?php if($page['edit'] == true){ ?></div><?php } ?>
<?php require_once('./templates/myhabbo_footer.php'); ?>