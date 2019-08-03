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
$data = new community_sql;
$lang->addLocale("tags.tagmatch");

$name = $input->FilterText($_POST['friendName']);

$sql = $db->query("SELECT tag FROM ".PREFIX."tags WHERE ownerid = '".$user->id."'");
$i = 0;
while($row = $db->fetch_row($sql)){
$mytag[$i] = $row[0];
$i++;
}
$sql = $data->select4($name);
if($db->num_rows($sql) == 0){ ?>
    <div class="tag-match-error">
        <?php echo $lang->loc['friend.not.found']; ?>
    </div>
<?php exit;
}
$i = 0;
$sql = $db->query("SELECT tag FROM ".PREFIX."tags WHERE ownerid = '".$db->result($sql)."'");
while($row = $db->fetch_row($sql)){
$theirtag[$i] = $row[0];
$i++;
}
if(!is_array($mytag)){ $mytag = array(); }
if(!is_array($theirtag)){ $theirtag = array(); }
$identical = array_intersect($mytag, $theirtag);
$count['mine'] = count($mytag);
$count['same'] = count($theirtag);
if($count['mine'] == 0){ $count['mine'] = 1; }
$percent = ceil(($count['same'] / $count['mine']) * 100);

?>
    <div id="tag-match-value" style="display: none;"><?php echo $percent; ?></div>

    <div id="tag-match-value-display"><?php $percent; ?> %</div>

    <div id="tag-match-slogan" style="display: none;">
            <?php echo $lang->loc['match.result']; ?>
    </div>