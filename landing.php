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

$page['new_landing'] = true;
$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "frontpage";

if($user->id > 0){ header("Location:".PATH."/me"); }

if(isset($_GET['error'])){
	$errorno = $_GET['error'];
	if($errorno == 1){
		$login_error = $lang->loc['error.1'];
	} elseif($errorno == 2){
		$login_error = $lang->loc['error.1'];
	} elseif(isset($_GET['ageLimit']) && $_GET['ageLimit'] == "true"){
		$login_error = $lang->loc['error.5'];
	}
}

$username = $input->HoloText($_GET['username']);
$rememberme = $input->HoloText($_GET['rememberme']);
$pageto = $input->HoloText($_GET['page']);

if(!isset($_SESSION['login'])){
	$_SESSION['login']['enabled'] = true;
	$_SESSION['login']['tries'] = 0;
}

require_once('./templates/login_header.php');

?>
<div id="fp-container">
    <div id="header" class="clearfix">
        <h1><a href="<?php echo PATH; ?>/"></a></h1>
        <span class="login-register-link">
            <?php echo $lang->loc['new.here']; ?>
            <a href="<?php echo PATH; ?>/register"><?php echo $lang->loc['screaming.register']; ?></a>

        </span>
    </div>
    <div id="content">
        <div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	
						<div class="logincontainer">
<?php
if(isset($_SESSION['error'])){
?>

    <div class="action-error flash-message"><div class="rounded"><ul>
        <li><?php echo $_SESSION['error']; ?></li>
    </ul></div></div>
	
<?php
unset($_SESSION['error']);
}
?>
<div class="cbb loginbox clearfix">
    <h2 class="title"><?php echo $lang->loc['sign.in']; ?></h2>
    <div class="box-content clearfix" id="login-habblet">

        <form action="<?php echo PATH; ?>/account/submit" method="post" class="login-habblet">
            <?php if(isset($_GET['page'])){ ?><input type="hidden" name="page" value="<?php echo $pageto; ?>" /><?php } ?>
            <ul>
                <li>
                    <label for="login-username" class="login-text"><?php echo $lang->loc['username']; ?></label>
                    <input tabindex="1" type="text" class="login-field" name="username" id="login-username" value="<?php echo $username; ?>" maxlength="32" />
                </li>
                <li>
                    <label for="login-password" class="login-text"><?php echo $lang->loc['password']; ?></label>

                    <input tabindex="2" type="password" class="login-field" name="password" id="login-password" maxlength="32" />
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
                    <input type="submit" value="<?php echo $lang->loc['sign.in']; ?>" class="submit" id="login-submit-button"/>
                    <a href="#" id="login-submit-new-button" class="new-button" style="margin-left: 0;display:none"><b style="padding-left: 10px; padding-right: 7px; width: 55px"><?php echo $lang->loc['sign.in']; ?></b><i></i></a>
                </li>
                <li id="remember-me" class="no-label">
                    <input tabindex="3" type="checkbox" value="true" name="_login_remember_me" id="login-remember-me"<?php if(isset($_GET['rememberme']) && $rememberme = "true"){ echo " checked=\"checked\""; }elseif($rememberme = "false"){ echo " checked=\"unchecked\""; } ?>/>
                    <label for="login-remember-me"><?php echo $lang->loc['remember.me']; ?></label>
                </li>

                <li id="register-link" class="no-label">
                    <a href="<?php echo PATH; ?>/register" class="login-register-link"><span><?php echo $lang->loc['register.link']; ?></span></a>
                </li>
                <li class="no-label">
                    <a href="<?php echo PATH; ?>/account/password/forgot" id="forgot-password"><span><?php echo $lang->loc['forgot']; ?></span></a>
                </li>
            </ul>
<div id="remember-me-notification" class="bottom-bubble" style="display:none;">

	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
                <?php echo $lang->loc['remember.warning']; ?>
	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>
        </form>

    </div>
</div>
</div>

<script type="text/javascript">
L10N.put("authentication.form.name", "<?php echo $lang->loc['username']; ?>");
L10N.put("authentication.form.password", "<?php echo $lang->loc['password']; ?>");
HabboView.add(function() {LoginFormUI.init();});
HabboView.add(function() {window.setTimeout(function() {RememberMeUI.init("newfrontpage");}, 100)});
</script>
	
						
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

			     		
				<div class="habblet-container ">		
	
						<div id="frontpage-image" style="background-image: url('<?php echo PATH; ?>/web-gallery/v2/images/landing/frontpg_misc_01.gif')"><div id="partner-logo"></div></div>
<?php $phrases = explode("|", $settings->find("site_promo_phrases")); ?>
    <script type="text/javascript">
    var sb = new SpeechBubble();
    var i = 0;
    sb.add("fp-bubble-"+i++, "frontpage-image", 108, 57, "<?php echo addslashes($phrases[1]); ?>");
    sb.add("fp-bubble-"+i++, "frontpage-image", 317, 51, "<?php echo addslashes($phrases[2]); ?>");
    sb.add("fp-bubble-"+i++, "frontpage-image", 6, 168, "<?php echo addslashes($phrases[0]); ?>");
    HabboView.add(function() {sb.render();});
    </script>
	
						
							
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<div id="column2" class="column">
</div>
<div id="column-footer">
		
				<div class="habblet-container ">		
	
						<div class="cbb" id="hotel-stats"><ul class="stats">
    <li class="stats-online"><span class="stats-fig"><?php echo GetOnlineCount(); ?></span> <?php echo $lang->loc['users.online.now']; ?></li>
    <li class="stats-online"><?php echo $lang->loc['hotel.is']; ?> <span class="stats-fig"><?php echo HotelStatus(); ?></span></li>

</ul>
</div>
	
						
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 
		
				<div class="habblet-container ">		
	
						<div class="cbb habblet box-content" id="tag-cloud-slim">
    <span class="tags-habbos-like"><?php echo $lang->loc['tags']; ?></span>

<?php
$lang->addLocale("ajax.tags");
$sql = $db->query("SELECT tag, COUNT(id) AS quantity FROM ".PREFIX."tags GROUP BY tag ORDER BY quantity DESC LIMIT 20");
if($db->num_rows($sql) < 1){ echo $lang->loc['no.tags']; }else{
echo "	    <ul class=\"tag-list\">";
	for($i=0;($array[$i] = @    $db->fetch_array($sql,1))!="";$i++)
        {
            $row[] = $array[$i];
        }
	sort($row);
	$i = -1;
	while($i <> $db->num_rows($sql)){
		$i++;
		$tag = $row[$i]['tag'];
		$count = $row[$i]['quantity'];
		$tags[$tag] = $count;
	}
		
		$max_qty = max(array_values($tags));
		$min_qty = min(array_values($tags));
		$spread = $max_qty - $min_qty;

		if($spread == 0){ $spread = 1; }

		$step = (200 - 100)/($spread);

		foreach($tags as $key => $value){
		    $size = 100 + (($value - $min_qty) * $step);
		    $size = ceil($size);
		    echo "<li><a href=\"".PATH."/tag/".strtolower($input->HoloText($key))."\" class=\"tag\" style=\"font-size:".$size."%\">".trim(strtolower($key))."</a> </li>\n";
		}

echo "</ul>";
}
?>

</div>
	
						
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
<?php require_once('./templates/login_footer.php'); ?>