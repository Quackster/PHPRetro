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
$lang->addLocale("stickie.editor");
$lang->addLocale("ajax.buttons");

$note = $input->HoloText($_POST['noteText']);
$skin = $_POST['skin'];
$scope = $_POST['scope'];
if($scope == ""){ $scope = 1; }
$query = $input->HoloText($_POST['query']);
?>
<form action="#" method="post" id="webstore-notes-form">

<input type="hidden" name="maxlength" id="webstore-notes-maxlength" value="<?php echo $user->user("rank") > 5 ? "1.7976931348623157E+10308" : "500"; ?>" />

<div id="webstore-notes-counter"><?php echo $user->user("rank") > 5 ? "&#8734" : 500; ?></div>

<p>
	<select id="webstore-notes-skin" name="skin">
	<?php $skins = explode("|", $lang->loc['skins']); ?>
			<option value="1" id="webstore-notes-skins-select-defaultskin"<?php if($skin == 1){ ?> selected="selected"<?php } ?>><?php echo $skins[0]; ?></option>
			<option value="6" id="webstore-notes-skins-select-goldenskin"<?php if($skin == 6){ ?> selected="selected"<?php } ?>><?php echo $skins[5]; ?></option>

			<?php if($user->user("rank") > 5){ ?><option value="9" id="webstore-notes-skins-select-default"<?php if($skin == 9){ ?> selected="selected"<?php } ?>><?php echo $skins[8]; ?></option><?php } ?>
			
			<option value="3" id="webstore-notes-skins-select-metalskin"<?php if($skin == 3){ ?> selected="selected"<?php } ?>><?php echo $skins[2]; ?></option>
			<option value="5" id="webstore-notes-skins-select-notepadskin"<?php if($skin == 5){ ?> selected="selected"<?php } ?>><?php echo $skins[4]; ?></option>
			<option value="2" id="webstore-notes-skins-select-speechbubbleskin"<?php if($skin == 2){ ?> selected="selected"<?php } ?>><?php echo $skins[1]; ?></option>
			<option value="4" id="webstore-notes-skins-select-noteitskin"<?php if($skin == 4){ ?> selected="selected"<?php } ?>><?php echo $skins[3]; ?></option>
<?php if($user->IsHCMember("self")){ ?>
			<option value="8" id="webstore-notes-skins-select-hc_pillowskin"<?php if($skin == 8){ ?> selected="selected"<?php } ?>><?php echo $skins[7]; ?></option>
			<option value="7" id="webstore-notes-skins-select-hc_machineskin"<?php if($skin == 7){ ?> selected="selected"<?php } ?>><?php echo $skins[6]; ?></option>
<?php } ?>
	</select>
</p>

<p class="warning"><?php echo $lang->loc['notes.warning.not.editable']; ?></p>

<div id="webstore-notes-edit-container">
<textarea id="webstore-notes-text" rows="7" cols="42" name="noteText"><?php echo $note; ?></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("webstore-notes-text");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
		<?php $colors = explode("|",$lang->loc['colors']); ?>
        var colors = { "red" : ["#d80000", "<?php echo addslashes($colors[0]); ?>"],
            "orange" : ["#fe6301", "<?php echo addslashes($colors[1]); ?>"],
            "yellow" : ["#ffce00", "<?php echo addslashes($colors[2]); ?>"],
            "green" : ["#6cc800", "<?php echo addslashes($colors[3]); ?>"],
            "cyan" : ["#00c6c4", "<?php echo addslashes($colors[4]); ?>"],
            "blue" : ["#0070d7", "<?php echo addslashes($colors[5]); ?>"],
            "gray" : ["#828282", "<?php echo addslashes($colors[6]); ?>"],
            "black" : ["#000000", "<?php echo addslashes($colors[7]); ?>"]
        };
        bbcodeToolbar.addColorSelect("<?php echo $lang->loc['color']; ?>", colors, true);
    </script>
<div id="linktool">
    <div id="linktool-scope">
        <label for="linktool-query-input"><?php echo $lang->loc['create.link']; ?>:</label>
        <input type="radio" name="scope" class="linktool-scope" value="1"<?php if($scope == 1){ ?> checked="checked"<?php } ?>/><?php echo $lang->loc['habbos']; ?>
        <input type="radio" name="scope" class="linktool-scope" value="2"<?php if($scope == 2){ ?> checked="checked"<?php } ?>/><?php echo $lang->loc['rooms']; ?>
        <input type="radio" name="scope" class="linktool-scope" value="3"<?php if($scope == 3){ ?> checked="checked"<?php } ?>/><?php echo $lang->loc['groups']; ?>
    </div>
    <input id="linktool-query" type="text" name="query" value="<?php echo $query; ?>"/>
    <a href="#" class="new-button" id="linktool-find"><b><?php echo $lang->loc['find']; ?></b><i></i></a>
    <div class="clear" style="height: 0;"><!-- --></div>
    <div id="linktool-results" style="display: none">
    </div>
    <script type="text/javascript">
        linkTool = new LinkTool(bbcodeToolbar.textarea);
    </script>
</div>
</div>

</form>

<p>
<a href="#" class="new-button" id="webstore-confirm-cancel"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
<a href="#" class="new-button" id="webstore-notes-continue"><b><?php echo $lang->loc['continue']; ?></b><i></i></a>
</p>

<div class="clear"></div>