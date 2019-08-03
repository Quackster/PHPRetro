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
$lang->addLocale("ajax.buttons");

$name = $input->FilterText($_GET['name']);
$id = $input->FilterText($_GET['id']);

if(!isset($_GET['id']) && isset($_GET['name'])){ if($serverdb->num_rows($data->select1($name)) > 0){ $id = $serverdb->result($data->select1($name), 0); }else{ $error = true; } }elseif(!isset($_GET['id']) && !isset($_GET['name'])){ $error = true; }
if($serverdb->num_rows($data->select2($id)) < 1){ $error = true; }
if($error == true){ $lang->clearLocale; require_once('./error.php'); exit; }

$userrow = $db->fetch_row($data->select2($id));

$page['id'] = "home";
$page['name'] = $lang->loc['pagename.home']." ".$input->HoloText($userrow[1]);
$page['type'] = "home";
if($userrow[0] == $user->id){ $page['cat'] = "home"; }else{ $page['cat'] = "community"; }
$sql = $db->query("SELECT * FROM ".PREFIX."homes_edit WHERE pageid = '".$user->id."' AND `type` = 'user' LIMIT 1");
if($db->num_rows($sql) > 0 && $userrow[0] == $user->id){
	$editrow = $db->fetch_assoc($sql);
	if(($editrow['time'] + (60*30)) < time()){ header('Location: '.PATH.'/myhabbo/cancel/'.$userrow[0].'?expired=true'); exit; }
	$page['edit'] = true; $_SESSION['page_edit'] = "home"; $page['bodyid'] = "editmode"; $sqladdon = "AND (location = '0' OR location = '-2')"; }else{ $page['bodyid'] = "viewmode"; $sqladdon = "AND location = '0'";
}

require_once('./templates/community_header.php');

$visible = $serverdb->result($serverdb->query("SELECT show_home FROM ".PREFIX."users WHERE id = '".$userrow[0]."' LIMIT 1"));
if($visible == 0 && $userrow[0] != $user->id){
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">

    <div class="habblet-container">
        <div class="cbb clearfix red ">
            <h2 class="title"><?php echo $lang->loc['user.hidden']; ?></h2>

            <div id="notfound-content" class="box-content">
                <p class="error-text">
                    <?php echo $lang->loc['user.hidden.desc']; ?>
                </p>
                <img id="error-image" src="<?php echo PATH; ?>/web-gallery/v2/images/activehomes/habbo_skeleton.gif" />

            </div>
        </div>
    </div>
</div>
<?php
require_once('./templates/community_footer.php'); exit;
}
$sql = $db->query("SELECT ".PREFIX."homes_catalogue.data FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ownerid = '".$userrow[0]."' AND type = '4' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id LIMIT 1");
if($db->num_rows($sql) > 0){ $home['background'] = formatItem(4,$db->result($sql),false); }else{ $home['background'] = "b_bg_pattern_abstract2"; }
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="mypage-wrapper" class="cbb blue">
<div class="box-tabs-container box-tabs-left clearfix">

<?php if($page['edit'] != true && $userrow[0] == $user->id){ ?>
	<a href="<?php echo PATH; ?>/myhabbo/startSession/<?php echo $userrow[0]; ?>" id="edit-button" class="new-button dark-button edit-icon" style="float:left"><b><span></span><?php echo $lang->loc['edit']; ?></b><i></i></a>
	<div class="myhabbo-view-tools">
	</div>
<?php }elseif($userrow[0] != $user->id){ ?>
	<div class="myhabbo-view-tools">
			<a href="#" id="reporting-button" style="display: none;"><?php echo $lang->loc['report']; ?></a>
			<a href="#" id="stop-reporting-button" style="display: none;"><?php echo $lang->loc['cancel.report']; ?></a>
	</div>
<?php } ?>

    <h2 class="page-owner"><?php echo $input->HoloText($userrow[1]); ?></h2>
    <ul class="box-tabs"></ul>
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

			<div id="mypage-bg" class="<?php echo $home['background']; ?>">
				<?php if($page['edit'] == true){ ?><div id="playground-outer"><?php } ?>
				<div id="playground">

<?php
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes.skin,".PREFIX."homes.x,".PREFIX."homes.y,".PREFIX."homes.z,".PREFIX."homes.variable FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ownerid = '".$userrow[0]."' AND type = '3' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id");
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
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data,".PREFIX."homes.x,".PREFIX."homes.y,".PREFIX."homes.z FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ownerid = '".$userrow[0]."' AND type = '1' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id");
while($row = $db->fetch_row($sql)){
?>

    <div class="movable sticker <?php echo formatItem(1,$row[1],false); ?>" style="left: <?php echo $row[2]; ?>px; top: <?php echo $row[3]; ?>px; z-index: <?php echo $row[4]; ?>" id="sticker-<?php echo $row[0]; ?>">
<?php if($page['edit'] == true){ ?>

<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="sticker-<?php echo $row[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("sticker-<?php echo $row[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $row[0]; ?>, "sticker", "sticker-<?php echo $row[0]; ?>-edit"); }, false);
</script>

<?php } ?>
    </div>

<?php } ?>

<?php
$sql = $db->query("SELECT ".PREFIX."homes.id,".PREFIX."homes_catalogue.data FROM ".PREFIX."homes,".PREFIX."homes_catalogue WHERE ownerid = '".$userrow[0]."' AND type = '2' ".$sqladdon." AND ".PREFIX."homes.itemid = ".PREFIX."homes_catalogue.id");
while($row = $db->fetch_row($sql)){
	$widget = $row[0];
	require('./habblet/myhabbo_widgets.php');
}
?>
				</div>
			<?php if($page['edit'] == true){ ?></div><?php } ?>
<?php require_once('./templates/myhabbo_footer.php'); ?>