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

if($page['bypass'] != true){
$page['dir'] = '\habblet';
$page['allow_guests'] = true;
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new home_sql;

$id = $input->FilterText($_POST['groupId']);
$msg = $input->FilterText($_POST['tagMsgCode']);
}
$lang->addLocale("tags.ajax");
$lang->addLocale("ajax.buttons");

?>
<div id="profile-tags-container">
<?php
$sql = $db->query("SELECT * FROM ".PREFIX."tags WHERE ownerid = '".$id."' AND type = 'group' ORDER BY id ASC");
if($db->num_rows($sql) < 1){ echo $lang->loc['no.tags']; }else{
while($row = $db->fetch_assoc($sql)){
?>

    <span class="tag-search-rowholder">
        <a href="<?php echo PATH; ?>/tag/<?php echo $input->HoloText($row['tag']); ?>" class="tag"
        ><?php echo $input->HoloText($row['tag']); ?></a><img border="0" class="tag-delete-link" onMouseOver="this.src='<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_delete_hi.gif'" onMouseOut="this.src='<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_delete.gif'" src="<?php echo PATH; ?>/web-gallery/images/buttons/tags/tag_button_delete.gif"
        />
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