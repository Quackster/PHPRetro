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
require_once('./includes/core.php');
$lang->addLocale("community.error");

$page['id'] = "error";
$page['name'] = $lang->loc['pagename.error'];
$page['bodyid'] = "home";

require_once('./templates/community_header.php');
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix red ">

							<h2 class="title"><?php echo $lang->loc['page.not.found']; ?>
							</h2>
						<div id="notfound-content" class="box-content">
    <p class="error-text"><?php echo $lang->loc['page.not.found.error']; ?></p> <img id="error-image" src="<?php echo PATH; ?>/web-gallery/v2/images/error.gif" />
    <p class="error-text"><?php echo $lang->loc['user.back.button'];?></p>
</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div id="column2" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix green ">

							<h2 class="title"><?php echo $lang->loc['error.looking.for']; ?>
							</h2>
						<div id="notfound-looking-for" class="box-content">
    <p><b><?php echo $lang->loc['error.option.1']; ?></b><br/>
    <?php echo $lang->loc['error.choice.1']; ?> <a href="<?php echo PATH; ?>/community"><?php echo $lang->loc['error.community']; ?></a> <?php echo $lang->loc['error.page'] ?>.</p>

    <p><b><?php echo $lang->loc['error.option.2']; ?></b><br/>
    <?php echo $lang->loc['error.choice.2']; ?> <a href="<?php echo PATH; ?>/community"><?php echo $lang->loc['error.recommanded.rooms']; ?></a> <?php echo $lang->loc['error.list']; ?>.</p>

    <p><b><?php echo $lang->loc['error.option.3']; ?></b><br/>
    <?php echo $lang->loc['error.choice.3'] ?> <a href="<?php echo PATH; ?>/community"><?php echo $lang->loc['error.tags']; ?></a> <?php echo $lang->loc['error.list']; ?>.</p>

     <p><b><?php echo $lang->loc['error.option.4']; ?></b><br/>
    <?php echo $lang->loc['error.choice.4']; ?> <a href="<?php echo PATH; ?>/credits"><?php echo $lang->loc['error.coins']; ?></a> <?php echo $lang->loc['error.page']; ?>.</p>
</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>

<?php require_once('templates/community_footer.php'); ?>