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
$data = new home_sql;
$lang->addLocale("groups.settings");
$lang->addLocale("ajax.buttons");

$id = $input->FilterText($_POST['groupId']);

$grouprow = $db->fetch_row($data->select14($id));
if($grouprow[10] != ""){ $alias = $grouprow[10]; $noalias = false; }else{ $alias = ""; $noalias = true; }

if($grouprow[6] != $user->id){ exit; }
?>
<form action="#" method="post" id="group-settings-form">

  <div id="group-settings">
    <div id="group-settings-data" class="group-settings-pane">
      <div id="group-logo">
        <img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $grouprow[1]; ?>.gif" />
      </div>
      <div id="group-identity-area">
        <div id="group-name-area">
          <div id="group_name_message_error" class="error"></div>
          <label for="group_name" id="group_name_text"><?php echo $lang->loc['edit.group.name']; ?>:</label>
          <input type="text" name="group_name" id="group_name" onKeyUp="GroupUtils.validateGroupElements('group_name', 30, '<?php echo addslashes($lang->loc['group.name.limit.reached']); ?>');" value="<?php echo $input->HoloText($grouprow[2]); ?>"/><br />
        </div>

        <div id="group-url-area">
          <div id="group_url_message_error" class="error"></div>
            <label for="group_url" id="group_url_text"><?php echo $lang->loc['edit.group.url']; ?>:</label><br/>
			<?php if($noalias == true){ ?>
			
            <input type="text" name="group_url" id="group_url" onKeyUp="GroupUtils.validateGroupElements('group_url', 30, '<?php echo addslashes($lang->loc['url.limit.reached']); ?>');" value="<?php echo $input->HoloText($alias); ?>"/><br />
            <input type="hidden" name="group_url_edited" id="group_url_edited" value="1"/>
			
			<?php }else{ ?>
			
			<span id="group_url_text"><a href="<?php echo PATH; ?>/groups/<?php echo $input->HoloText($alias); ?>">/groups/<?php echo $input->HoloText($alias); ?></a></span><br/>
            <input type="hidden" name="group_url" id="group_url" value="<?php echo $input->HoloText($alias); ?>"/>
            <input type="hidden" name="group_url_edited" id="group_url_edited" value="0"/>
			
			<?php } ?>
          </div>
        </div>

        <div id="group-description-area">
          <div id="group_description_message_error" class="error"></div>
          <label for="group_description" id="description_text"><?php echo $lang->loc['edit.text'] ?>:</label>
          <span id="description_chars_left">
            <label for="characters_left"><?php echo $lang->loc['characters.left']; ?>:</label>
            <input id="group_description-counter" type="text" value="210" size="3" readonly="readonly" class="amount" />
          </span>
          <textarea name="group_description" id="group_description" onKeyUp="GroupUtils.validateGroupElements('group_description', 255, '<?php echo addslashes($lang->loc['description.limit.reached']); ?>');"><?php echo $input->HoloText($grouprow[3]); ?></textarea>
        </div>
      </div>
      <div id="group-settings-type" class="group-settings-pane group-settings-selection">
        <label for="group_type"><?php echo $lang->loc['edit.group.type']; ?>:</label>
        <input type="radio" name="group_type" id="group_type" value="0"<?php if($grouprow[5] == 0){ ?> checked="checked"<?php } if($grouprow[5] == 3){ ?> disabled="disabled"<?php } ?> />
        <div class="description">
          <div class="group-type-normal"><?php echo $lang->loc['regular']; ?></div>
          <p><?php echo $lang->loc['regular.desc']; ?></p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="1"<?php if($grouprow[5] == 1){ ?> checked="checked"<?php } if($grouprow[5] == 3){ ?> disabled="disabled"<?php } ?> />
        <div class="description">
          <div class="group-type-exclusive"><?php echo $lang->loc['exclusive']; ?></div>
          <p><?php echo $lang->loc['exclusive.desc']; ?></p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="2"<?php if($grouprow[5] == 2){ ?> checked="checked"<?php } if($grouprow[5] == 3){ ?> disabled="disabled"<?php } ?> />
        <div class="description">
          <div class="group-type-private"><?php echo $lang->loc['private']; ?></div>
          <p><?php echo $lang->loc['private.desc']; ?></p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="3"<?php if($grouprow[5] == 3){ ?> checked="checked"<?php } if($grouprow[5] == 3){ ?> disabled="disabled"<?php } ?> />
        <div class="description">
          <div class="group-type-large"><?php echo $lang->loc['unlimited']; ?></div>
          <p><?php echo $lang->loc['unlimited.desc']; ?></p>
          <p class="description-note"><?php echo $lang->loc['unlimited.note']; ?></p>
        </div>
        <input type="hidden" id="initial_group_type" value="0">
      </div>
    </div>


    <div id="forum-settings" style="display: none;">

      <div id="forum-settings-type" class="group-settings-pane group-settings-selection">
        <label for="forum_type"><?php echo $lang->loc['edit.forum.type']; ?>:</label>
        <input type="radio" name="forum_type" id="forum_type" value="0"<?php if($grouprow[8] == 0){ ?> checked="checked"<?php } ?> />
        <div class="description">
          <?php echo $lang->loc['public.forum']; ?><br />
          <p><?php echo $lang->loc['public.forum.desc']; ?></p>
        </div>
        <input type="radio" name="forum_type" id="forum_type" value="1"<?php if($grouprow[8] == 1){ ?> checked="checked"<?php } ?> />
        <div class="description">
          <?php echo $lang->loc['private.forum']; ?><br />
          <p><?php echo $lang->loc['private.forum.desc']; ?></p>
        </div>
      </div>

      <div id="forum-settings-topics" class="group-settings-pane group-settings-selection">
        <label for="new_topic_permission"><?php echo $lang->loc['edit.new.thread']; ?>:</label>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="2"<?php if($grouprow[9] == 2){ ?> checked="checked"<?php } ?> />
        <div class="description">
          <?php echo $lang->loc['admin']; ?><br />
          <p><?php echo $lang->loc['admin.desc']; ?></p>
        </div>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="1"<?php if($grouprow[9] == 1){ ?> checked="checked"<?php } ?> />
        <div class="description">
          <?php echo $lang->loc['members']; ?><br />
          <p><?php echo $lang->loc['members.desc']; ?></p>
        </div>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="0"<?php if($grouprow[9] == 0){ ?> checked="checked"<?php } ?> />
        <div class="description">
          <?php echo $lang->loc['everyone']; ?><br />
          <p><?php echo $lang->loc['everyone.desc']; ?></p>
        </div>
      </div>
    </div>


    <div id="room-settings" style="display: none;">
      <label><?php echo $lang->loc['select.group.room']; ?>:</label>
      <div id="room-settings-id" class="group-settings-pane-wide group-settings-selection">
        <ul>
          <li><input type="radio" name="roomId" value=""<?php if($grouprow[7] == "0"){ ?> checked="checked"<?php } ?> /><div><?php echo $lang->loc['no.room']; ?></div></li>
          
<?php
$i = 0;
$sql = $data->select11($user->id);
while($row = $serverdb->fetch_row($sql)){
	if($input->IsEven($i)){ $even = " class=\"even\""; }else{ $even = ""; }
?>

		  <li<?php echo $even; ?>>
            <input type="radio" name="roomId" value="<?php echo $row[0]; ?>"<?php if($grouprow[7] == $row[0]){ ?> checked="checked"<?php } ?> />
            <a href="<?php echo PATH; ?>/client?forwardId=2&amp;roomId=<?php echo $row[0]; ?>" onclick="HabboClient.roomForward(this, '<?php echo $row[0]; ?>', 'private'); return false;" target="client" class="room-enter"><?php echo $lang->loc['enter']; ?></a>
            <div>
              <?php echo $input->unicodeToImage($input->HoloText($row[1])); ?><br />
              <span class="room-description"><?php echo $input->unicodeToImage($input->HoloText($row[2])); ?></span>
            </div>
          </li>

<?php $i++; } ?>
        </ul>
      </div>
    </div>

    <div id="group-button-area">
      <a href="#" id="group-settings-update-button" class="new-button" onclick="showGroupSettingsConfirmation('<?php echo $grouprow[0]; ?>');">
        <b><?php echo $lang->loc['save.changes']; ?></b><i></i>
      </a>
      <a id="group-delete-button" href="#" class="new-button red-button" onclick="openGroupActionDialog('/groups/actions/confirm_delete_group', '/groups/actions/delete_group', null , '<?php echo $grouprow[0]; ?>', null);">
        <b><?php echo $lang->loc['delete.group']; ?></b><i></i>
      </a>
      <a href="#" id="group-settings-close-button" class="new-button" onclick="closeGroupSettings(); return false;"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
    </div>
  </div>
</form>

<div class="clear"></div>

<script type="text/javascript" language="JavaScript">
    L10N.put("group.settings.title.text", "<?php echo addslashes($lang->loc['edit.group.settings']); ?>");
    L10N.put("group.settings.group_type_change_warning.normal", "<?php echo addslashes($lang->loc['confirm.change.group.type']); ?> <strong\><?php echo addslashes($lang->loc['normal.confirm']); ?></strong\>?");
    L10N.put("group.settings.group_type_change_warning.exclusive", "<?php echo addslashes($lang->loc['confirm.change.group.type']); ?> <strong \><?php echo addslashes($lang->loc['exclusive.confirm']); ?></strong\>?");
    L10N.put("group.settings.group_type_change_warning.closed", "<?php echo addslashes($lang->loc['confirm.change.group.type']); ?> <strong\><?php echo addslashes($lang->loc['private.confirm']); ?></strong\>?");
    L10N.put("group.settings.group_type_change_warning.large", "<?php echo addslashes($lang->loc['confirm.change.group.type']); ?> <strong\><?php echo addslashes($lang->loc['large.confirm']); ?></strong\>? <?php echo addslashes($lang->loc['large.confirm.warning']); ?>");
    L10N.put("myhabbo.groups.confirmation_ok", "<?php echo addslashes($lang->loc['ok']); ?>");
    L10N.put("myhabbo.groups.confirmation_cancel", "<?php echo addslashes($lang->loc['cancel']); ?>");
    switchGroupSettingsTab(null, "group");
</script>
