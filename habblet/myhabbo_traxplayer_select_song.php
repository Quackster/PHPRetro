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

$id = $input->FilterText($_POST['songId']);
$widgetid = $input->FilterText($_POST['widgetId']);
$data = new home_sql;

$widgetrow = $db->fetch_row($db->query("SELECT id,location,ownerid FROM ".PREFIX."homes WHERE ".PREFIX."homes.id = '".$widgetid."' LIMIT 1"));
$widgetrow[1] = str_replace('-','',$widgetrow[1]);

if($widgetrow[1] == "0" || $widgetrow[1] == "2"){ $type = "user"; }else{ $type = "group"; $ownerid = $widgetrow[1]; $mrow = $db->fetch_row($data->select15($user->id,$ownerid)); }

if(($type == "user" && $ownerid == $user->id) || ($type == "group" && $mrow[2] > 1)){
	$db->query("UPDATE ".PREFIX."homes SET variable = '".$id."' WHERE id = '".$widgetid."' LIMIT 1");
}
?>
<embed type="application/x-shockwave-flash"
src="<?php echo PATH; ?>/flash/traxplayer/traxplayer.swf" name="traxplayer" quality="high"
base="<?php echo PATH; ?>/flash/traxplayer/" allowscriptaccess="always" menu="false"
wmode="transparent" flashvars="songUrl=<?php echo PATH; ?>/trax/song/<?php echo $id; ?>&amp;sampleUrl=http://images.habbohotel.com/dcr/hof_furni//mp3/"
height="66" width="210" />