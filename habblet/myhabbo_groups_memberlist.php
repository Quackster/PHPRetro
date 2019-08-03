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
$pagenum = $_POST['pageNumber'];
$search = $input->FilterText($_POST['searchString']);
$id = $input->FilterText($_POST['groupId']);
if(isset($_POST['pending']) && $_POST['pending'] == "true"){ $pending = 1; }else{ $pending = 0; }
$data = new home_sql;
if($pagenum == ""){ $pagenum = 1; }

$lang->addLocale("groups.settings.members");

$count['pending'] = $serverdb->num_rows($data->select16($id,$search,0,0,1));
$count['search'] = $serverdb->num_rows($data->select16($id,$search,0,0,$pending));
$count['total'] = $serverdb->num_rows($data->select16($id));
header('X-JSON: {"pending":"'.$lang->loc['pending.members'].' ('.$count['pending'].')","members":"'.$lang->loc['members'].' ('.$count['total'].')"}');
if($pending == 1){
	$limit = 12;
	$offset = $pagenum - 1;
	$offset = $offset * 12;
}else{
	$offset = 0;
	$limit = 0;
}
$sql = $data->select16($id,$search,$limit,$offset,$pending);
$grouprow = $serverdb->fetch_row($data->select14($id));
?>
<div id="group-memberlist-members-list">

<form method="post" action="#" onsubmit="return false;">
<ul class="habblet-list two-cols clearfix">
<?php $i = 0; $n = 0; while($row = $serverdb->fetch_row($sql)){
if($input->IsEven($i)){ $side = "left"; }else{ $side = "right"; $n++; }
if($input->IsEven($n)){ $even = "even"; }else{ $even = "odd"; }
if($user->IsUserOnline($row[0])){ $online = "online"; }else{ $online = "offline"; }
?>

    <li class="<?php echo $even; ?> <?php echo $online; ?> <?php echo $side; ?>">
    	<div class="item" style="padding-left: 5px; padding-bottom: 4px;">
    		<div style="float: right; width: 16px; height: 16px; margin-top: 1px">
				<?php if($row[1] == 3){ ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/owner_icon.gif" width="15" height="15" alt="<?php echo $lang->loc['owner']; ?>" title="<?php echo $lang->loc['owner']; ?>" /><?php } ?>
				<?php if($row[1] == 2){ $type = "a"; ?><img src="<?php echo PATH; ?>/web-gallery/images/groups/administrator_icon.gif" width="15" height="15" alt="<?php echo $lang->loc['administrator']; ?>" title="<?php echo $lang->loc['administrator']; ?>" /><?php } ?>
				<?php if($row[1] < 2){ $type = "m"; } ?>
			</div>
				<input type="checkbox" <?php if($row[0] == $grouprow[6]){ ?>disabled="disabled" <?php }else{ ?>id="group-memberlist-<?php echo $type; ?>-<?php echo $row[0]; ?>" <?php } ?>style="margin: 0; padding: 0; vertical-align: middle"/>
    	    <a class="home-page-link" href="<?php echo PATH; ?>/home/<?php echo $input->HoloText($row[4]); ?>"><span><?php echo $input->HoloText($row[4]); ?></span></a>
        </div>
    </li>
	
<?php $i++; } ?>
<?php if(!$input->IsEven($i)){ ?><li class="<?php echo $even; ?> right"><div class="item">&nbsp;</div></li><?php } ?>
</ul>

</form>
</div>
<div id="member-list-pagenumbers">
<?php
if($count['search'] == 0){ echo "0 - 0"; }else{
$at = $pagenum - 1;
$at = $at * 12;
$at = $at + 1;
$to = $offset + 12;
if($to > $count['search']){ $to = $count['search']; }
if($limit == 0){ $to = $count['search']; }
$totalpages = ceil($count['search'] / 20);
if($count['search'] > 0){ echo $at; ?> - <?php echo $to; ?> / <?php echo $count['search']; }else{ echo "0 / 0"; } ?>
</div>
<div id="member-list-paging" style="display:none;">
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
<input type="hidden" id="pageNumberMemberList" value="<?php echo $pagenum; ?>"/>
<input type="hidden" id="totalPagesMemberList" value="<?php echo $totalpages; ?>"/>
</div>