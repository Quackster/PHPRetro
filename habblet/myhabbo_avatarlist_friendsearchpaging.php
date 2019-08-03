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

if($page['bypass'] == true){
$pagenum = "1";
$search = "";
}else{
$page['dir'] = '\habblet';
require_once('../includes/core.php');
$pagenum = $_POST['pageNumber'];
$search = $input->FilterText($_POST['searchString']);
$widgetid = $_POST['widgetId'];
$data = new home_sql;
}
$lang->addLocale("friendswidget.friendslist");

$userid = $db->result($db->query("SELECT ownerid FROM ".PREFIX."homes WHERE id = '".$widgetid."'"));
$offset = $pagenum - 1;
$offset = $offset * 20;
$count = $serverdb->num_rows($data->select8($userid,$search));
$fsql = $data->select8($userid,$search,20,$offset);
?>
<div class="avatar-widget-list-container">
<ul id="avatar-list-list" class="avatar-widget-list">
<?php if($count == 0 && $search == ""){ echo $lang->loc['no.friends']; }else{ ?>

<?php while($frow = $db->fetch_row($fsql)){ ?>

	<li id="avatar-list-<?php echo $widgetid; ?>-<?php echo $frow[0]; ?>" title="<?php echo $input->HoloText($frow[1]); ?>"><div class="avatar-list-open"><a href="#" id="avatar-list-open-link-<?php echo $widgetid; ?>-<?php echo $frow[0]; ?>" class="avatar-list-open-link"></a></div>
<div class="avatar-list-avatar"><img src="<?php echo $user->avatarURL($frow[2],"s,2,2,sml,1,0"); ?>" alt="" /></div>
<h4><a href="<?php echo PATH; ?>/home/<?php echo $input->HoloText($frow[1]); ?>"><?php echo $input->HoloText($frow[1]); ?></a></h4>
<p class="avatar-list-birthday"><?php echo $input->HoloText($frow[3]); ?></p>
<p>

</p></li>

<?php } ?>
</ul>
<?php } ?>

<div id="avatar-list-info" class="avatar-list-info">
<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
<div class="avatar-list-info-container"></div>
</div>

</div>

<div id="avatar-list-paging">
<?php
if($count == 0){ echo "0 - 0"; }else{
$at = $pagenum - 1;
$at = $at * 20;
$at = $at + 1;
$to = $offset + 20;
if($to > $count){ $to = $count; }
$totalpages = ceil($count / 20);
?>
    <?php echo $at; ?> - <?php echo $to; ?> / <?php echo $count; ?>
    <br/>
	<?php if($pagenum != 1){ ?>
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-first" ><?php echo $lang->loc['first']; ?></a> |
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-previous" >&lt;&lt;</a> |
	<?php }else{ ?>
	<?php echo $lang->loc['first']; ?> |
    &lt;&lt; |
	<?php } ?>
	<?php if($pagenum != $totalpages){ ?>
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-next" >&gt;&gt;</a> |
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-last" ><?php echo $lang->loc['last']; ?></a>
	<?php }else{ ?>
	&gt;&gt; |
    <?php echo $lang->loc['last']; ?>
	<?php } ?>
<?php } ?>
<input type="hidden" id="pageNumber" value="<?php echo $pagenum	; ?>"/>
<input type="hidden" id="totalPages" value="<?php echo $totalpages; ?>"/>
</div>

<script type="text/javascript">
<?php if($page['bypass'] == true){ ?>
document.observe("dom:loaded", function() {
	window.widget<?php echo $widgetid; ?> = new FriendsWidget('<?php echo $userid; ?>', '<?php echo $widgetid; ?>');
});
<?php } ?>
</script>