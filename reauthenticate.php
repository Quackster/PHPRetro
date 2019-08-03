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

$page['bypass_user_check'] = true;
require_once('./includes/core.php');
require_once('./includes/session.php');
$lang->addLocale("landing.login");
$lang->addLocale("landing.reauthenticate");

$page['name'] = $lang->loc['pagename.reauthenticate'];
$page['bodyid'] = "reauthenticate";

if($user->id == 0){ header("Location: ".PATH."/"); }

if(isset($_POST['password'])) {
	$username = $user->name;
	$password = $input->FilterText($_POST['password']);
	$password_hash = $input->HoloHash($password, $username);

	$user = new HoloUser($username,$password_hash,true);
	$_SESSION['user'] = $user;
	unset($_SESSION['reauthenticate']);
	
	if($user->error > 0){
		$user->destroy();
		header("Location: ".PATH."/?page=".$input->HoloText($_POST['page'])."&username=".$username."&error=".$user->error); exit;
	}else{
		$_SESSION['page'] = $input->HoloText($_POST['page']);
		header("Location: ".PATH."/security_check"); exit;
	}
}

require_once('./templates/login_header.php');
?>
	        	<div id="column1" class="column">
	<div class="cbb clearfix green">
		<h2 class="title"><?php echo $lang->loc['rea.enter.password']; ?></h2>

		<div class="box-content">
			<p><?php echo $lang->loc['rea.desc.1']; ?></p>
			<p><?php echo $lang->loc['rea.desc.2']; ?> <strong><?php echo $user->name; ?></strong>, <?php echo $lang->loc['please']; ?> <a href="<?php echo PATH; ?>/account/logout?origin=default"><?php echo $lang->loc['sign.out']; ?></a>.</p>
			<p><?php echo $lang->loc['if.forgot.password']; ?> <a href="<?php echo PATH; ?>/account/password/forgot"><?php echo $lang->loc['click.here']; ?></a>.</p>			
		</div>

	</div>					
</div>

<div id="column2" class="column">
<?php if(isset($error)){ ?>
<div class="action-error flash-message"><div class="rounded"><ul>
	<li><?php echo $error; ?></li>
</ul></div></div>
<?php } ?>

<div class="cbb gray clearfix">
    <h2 class="title"><?php echo $lang->loc['sign.in']; ?></h2>
    
    <div class="box-content clearfix" id="login-habblet">
        <form action="<?php echo PATH; ?>/account/reauthenticate" method="post" class="login-habblet">
        	<input type="hidden" name="page" value="<?php echo $_SESSION['page']; ?>" />
            <ul>

                <li>
                    <label for="login-username" class="login-text"><?php echo $lang->loc['username']; ?></label>
                    <span class="username"><?php echo $user->name; ?></span>
                </li>
                <li>
                    <label for="login-password" class="login-text"><?php echo $lang->loc['password']; ?></label>
                    <input tabindex="2" type="password" class="login-field" name="password" id="login-password" />

                    <input type="submit" value="<?php echo $lang->loc['sign.in']; ?>" class="submit" id="login-submit-button"/>
					<a style="float: left; margin-left: 0pt; display: none" class="new-button" id="login-submit-new-button" href="#"><b style="padding-left: 10px; padding-right: 7px; width: 55px;"><?php echo $lang->loc['sign.in']; ?></b><i></i></a>                    
                </li>
            </ul>
        </form>

    </div>
</div>
</div>
<script type="text/javascript">
	HabboView.add(LoginFormUI.init);
	HabboView.add(RememberMeUI.init);
</script>
<?php require_once('./templates/login_footer.php'); ?>
