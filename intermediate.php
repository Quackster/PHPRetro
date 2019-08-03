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

require_once('./includes/core.php');

if($settings->find("site_new_landing_page") == "1"){ require_once("./landing.php"); exit; }
$lang->addLocale("landing.intermediate");

$page['name'] = $lang->loc['pagename.intermediate'];
$page['bodyid'] = "intermediate";

require_once('./templates/login_header.php');

?>
	        	<div id="enter-hotel">
    <div class="open enter-btn">
            <a href="<?php echo PATH; ?>/client" target="client"
                onclick="return onClientOpen(this)"><?php echo $lang->loc['enter.hotel']; ?><i></i></a>
        <b></b>
    </div>
</div>

<div id="info">
    <?php echo $lang->loc['intermediate.desc']; ?>
</div>
<div id="enter-mypage">
    <a href="<?php echo PATH; ?>/me"><?php echo $lang->loc['go.to.homepage']; ?></a>
</div>

<script type="text/javascript">
    timedRedirect();
</script>
<?php require_once('./templates/login_footer.php'); ?>