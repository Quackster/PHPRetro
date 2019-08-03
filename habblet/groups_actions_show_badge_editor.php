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
$id = $input->FilterText($_POST['groupId']);
$data = new home_sql;

$lang->addLocale("groups.badge");
$grouprow = $serverdb->fetch_row($data->select14($id));
?>
<div id="badge-editor-flash">
<?php echo $loc['require.flash']; ?> <a href="http://www.adobe.com/go/getflashplayer"><?php echo $loc['install.flash']; ?></a>.
</div>
<script type="text/javascript" language="JavaScript">
var swfobj = new SWFObject("<?php echo PATH; ?>/flash/BadgeEditor.swf", "badgeEditor", "280", "366", "8");
swfobj.addParam("base", "<?php echo PATH; ?>/flash/");
swfobj.addParam("bgcolor", "#FFFFFF");
swfobj.addVariable("post_url", "<?php echo PATH; ?>/groups/actions/update_group_badge?");
swfobj.addVariable("__app_key", "PHPRetro");
swfobj.addVariable("groupId", "<?php echo $grouprow[0]; ?>");
swfobj.addVariable("badge_data", "<?php echo $grouprow[1]; ?>");
swfobj.addVariable("localization_url", "<?php echo PATH; ?>/xml/badge_editor.xml");
swfobj.addVariable("xml_url", "<?php echo PATH; ?>/xml/badge_data.xml");
swfobj.addParam("allowScriptAccess", "always");
swfobj.write("badge-editor-flash");
</script>