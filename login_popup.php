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

$data = new index_sql;
$lang->addLocale("landing.login");
$lang->addLocale("landing.login.popup");

if(!isset($_SESSION['login'])){
	$_SESSION['login']['enabled'] = true;
	$_SESSION['login']['tries'] = 0;
}

$page['name'] = $lang->loc['pagename.popup'];
$page['bodyid'] = "popup";

if($user->id > 0){ header("Location:".PATH."/client"); }

require_once('./templates/login_header.php');

?>
	        	<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	
						<div class="cbb clearfix green">
    <h2 class="title"><?php echo $lang->loc['register.link']; ?></h2>

    <div class="box-content">
        <p><?php echo $lang->loc['popup.register.desc']; ?>?</p>
        <div class="register-button clearfix">
            <a href="<?php echo PATH; ?>/register" onclick="HabboClient.closeHabboAndOpenMainWindow(this); return false;"><?php echo $lang->loc['popup.register.button']; ?></a>
            <span></span>
        </div>                
    </div>
</div>
	
						
					
				</div>

				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<div id="column2" class="column">
			     		
				<div class="habblet-container ">		
	
						<div class="cbb loginbox clearfix ">
    <h2 class="title"><?php echo $lang->loc['sign.in']; ?></h2>
    <div class="box-content clearfix" id="login-habblet">
        <form action="<?php echo PATH; ?>/account/submit" method="post" class="login-habblet">
            
            <ul>

                <li>
                    <label for="login-username" class="login-text"><?php echo $lang->loc['username']; ?></label>
                    <input tabindex="1" type="text" class="login-field" name="username" id="login-username" value="" />
                </li>
                <li>
                    <label for="login-password" class="login-text"><?php echo $lang->loc['password']; ?></label>
                    <input tabindex="2" type="password" class="login-field" name="password" id="login-password" />
<?php if($_SESSION['login']['tries'] > 4 && $settings->find("site_capcha") == "1"){ ?>
                </li>
                <li>

<h3>

<label for="bean_captcha" class="registration-text"><?php echo $lang->loc['type.security.code']; ?></label>
</h3>

<div id="captcha-code-error"></div>

<p></p>

<div class="register-label" id="captcha-reload">
    <p>
        <img src="<?php echo PATH; ?>/web-gallery/v2/images/shared_icons/reload_icon.gif" width="15" height="15" alt=""/>
        <a id="captcha-reload-link" href="#"><?php echo $lang->loc['cannot.read.code']; ?></a>
    </p>

</div>

<script type="text/javascript">
document.observe("dom:loaded", function() {
    Event.observe($("captcha-reload"), "click", function(e) {Utils.reloadCaptcha()});
});
</script>

<p id="captcha-container">
    <img id="captcha" src="<?php echo PATH; ?>/captcha.jpg?t=<?php echo time(); ?>" alt="" width="200" height="50" />
</p>

<p>
<input type="text" name="captcha" id="captcha-code" value="" class="registration-text required-captcha" />
</p>
<?php } ?>
	                    <input type="submit" value="Log in" class="submit" id="login-submit-button"/>

	                    <a href="#" id="login-submit-new-button" class="new-button" style="float: left; margin-left: 0;display:none"><b style="padding-left: 10px; padding-right: 7px; width: 55px">Log in</b><i></i></a>
                </li>
                <li class="no-label">
                    <input tabindex="4" type="checkbox" name="_login_remember_me" id="login-remember-me" value="true"/>
                    <label for="login-remember-me"><?php echo $lang->loc['remember.me']; ?></label>
                </li>
                <li class="no-label">
                    <a href="<?php echo PATH; ?>/register" class="login-register-link" onclick="HabboClient.closeHabboAndOpenMainWindow(this); return false;"><span><?php echo $lang->loc['register.link']; ?></span></a>

                </li>
                <li class="no-label">
                    <a href="<?php echo PATH; ?>/account/password/forgot" id="forgot-password"><span><?php echo $lang->loc['forgot']; ?></span></a>
                </li>
            </ul>
        </form>

    </div>
</div>

<div id="remember-me-notification" class="bottom-bubble" style="display:none;">
	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
	<?php echo $lang->loc['remember.warning']; ?>
	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>
<script type="text/javascript">
	HabboView.add(LoginFormUI.init);
	HabboView.add(RememberMeUI.init);
</script>
	
						
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
<?php require_once('./templates/login_footer.php'); ?>