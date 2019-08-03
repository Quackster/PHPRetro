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
$lang->addLocale("landing.login");

$data = new index_sql;

$page['name'] = $lang->loc['pagename.home'];
$page['bodyid'] = "landing";

if($user->id > 0){ header("Location:".PATH."/me"); }

if(!empty($_GET['error'])){
	$error = $input->HoloText($_GET['error']);
	if(!is_numeric($error)){ $error = 2; }
	$error = $lang->loc['error.'.$error];
}elseif(!empty($_SESSION['error'])){
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
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
<?php 
$phrases = explode("|", $settings->find("site_promo_phrases"));
if((int) $settings->find("site_flash_promo") > 0){ ?>

	        	<div id="column1" class="column">
				<div class="habblet-container " id="create-habbo">

						<div id="create-habbo-flash">
	<div id="create-habbo-nonflash" style="background-image: url(<?php echo PATH; ?>/web-gallery/v2/images/landing/landing_group.png)">
        <div id="landing-register-text"><a href="<?php echo PATH; ?>/register"><span><?php echo $lang->loc['join.now']; ?></span></a></div>
        <div id="landing-promotional-text"><span><?php echo $lang->loc['join.desc']; ?></span></div>
    </div>
	<div class="cbb clearfix green" id="habbo-intro-nonflash">
		<h2 class="title"><?php echo $lang->loc['get.flash']; ?></h2>
		<div class="box-content">
			<ul>
				<li id="habbo-intro-install" style="display:none"><a href="http://www.adobe.com/go/getflashplayer">Install Flash Player 8 or higher</a></li>
				<noscript><li>Enable JavaScript</li></noscript>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript" language="JavaScript">
var swfobj = new SWFObject("<?php echo PATH; ?>/flash/intro/habbos<?php if((int) $settings->find("site_flash_promo") > 1){ echo "_v2"; } ?>.swf", "ch", "396", "378", "8");
swfobj.addParam("AllowScriptAccess", "always");
swfobj.addParam("wmode", "transparent");
swfobj.addVariable("base_url", "<?php echo PATH; ?>/flash/intro");
swfobj.addVariable("habbos_url", "<?php echo PATH; ?>/xml/promo_habbos<?php if((int) $settings->find("site_flash_promo") > 1){ echo "_v2"; } ?>.xml");
swfobj.addVariable("create_button_text", "<?php echo $lang->loc['join.now']; ?>");
swfobj.addVariable("in_hotel_text", "<?php echo $lang->loc['flash.in.hotel']; ?>");
swfobj.addVariable("slogan", "<?php echo $lang->loc['join.desc']; ?>");
swfobj.addVariable("video_start", "<?php echo $lang->loc['flash.play']; ?>");
swfobj.addVariable("video_stop", "<?php echo $lang->loc['flash.stop']; ?>");
swfobj.addVariable("button_link", "<?php echo PATH; ?>/register");
swfobj.addVariable("localization_url", "<?php echo PATH; ?>/xml/landing_intro.xml");
swfobj.addVariable("video_link", "<?php echo PATH; ?>/flash/intro/Habbo_intro.swf");
swfobj.addVariable("select_button_text", "<?php echo $lang->loc['join.now']; ?>");
swfobj.addVariable("header_text", "<?php echo $phrases[1]; ?>");
swfobj.write("create-habbo-flash");
HabboView.add(function() {
	if (deconcept.SWFObjectUtil.getPlayerVersion()["major"] >= 8) {
		try { $("habbo-intro-nonflash").hide(); } catch (e) {}
	} else {
		$("habbo-intro-install").show();
	}
});
</script>
<?php } else { ?>

	        	<div id="column1" class="column">
			     		
				<div class="habblet-container " id="create-habbo">		
	
						<div id="create-habbo" class="layout-static">
	<div id="create-habbo-nonflash" style="background-image: url(<?php echo PATH; ?>/web-gallery/v2/images/landing/pixel.gif)">
        <div class="landing-text-1"><span><?php echo $phrases[0]; ?></span></div>
        <div class="landing-text-2"><span><?php echo $phrases[1]; ?></span></div>
        <div class="landing-text-3"><span><?php echo $phrases[2]; ?></span></div>

        <div id="landing-register-text"><a href="<?php echo PATH; ?>/register"><span><?php echo $lang->loc['join.now']; ?></span></a></div>
        <div id="landing-promotional-text"><span><?php echo $lang->loc['join.desc']; ?></span></div>
    </div>
</div>
<?php } ?>



				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div id="column2" class="column">
				<div class="habblet-container ">

<?php
	if(isset($error)){
		echo "\n<div class=\"action-error flash-message\">\n <div class=\"rounded\">\n  <ul>\n   <li>".$error."</li>\n  </ul>\n </div>\n</div>\n";
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
                    <input tabindex="1" type="text" class="login-field" name="username" id="login-username" value="<?php echo $username; ?>"/>
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
	                <input type="submit" value="<?php echo $lang->loc['sign.in']; ?>" class="submit" id="login-submit-button"/>
	                <a href="#" id="login-submit-new-button" class="new-button" style="float: left; margin-left: 0;display:none"><b style="padding-left: 10px; padding-right: 7px; width: 55px"><?php echo $lang->loc['sign.in']; ?></b><i></i></a>
                </li>
                <li class="no-label">
                    <input tabindex="3" type="checkbox" value="true" name="_login_remember_me" id="login-remember-me"<?php if(isset($_GET['rememberme']) && $rememberme = "true"){ echo " checked=\"checked\""; }elseif($rememberme = "false"){ echo " checked=\"unchecked\""; } ?>/>
                    <label for="login-remember-me"><?php echo $lang->loc['remember.me']; ?></label>
                </li>
                <li class="no-label">
                    <a href="<?php echo PATH; ?>/register" class="login-register-link"><span><?php echo $lang->loc['register.link']; ?></span></a>
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

				<div class="habblet-container ">

						<div class="ad-container">
<div id="geoip-ad" style="display:none"></div>
</div>



				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

				<div class="habblet-container ">





				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

				<div class="habblet-container ">

						<div class="ad-container">
<a href="register.php"><img src="<?php echo PATH; ?>/web-gallery/v2/images/landing/uk_party_frontpage_image.gif" alt="" /></a>
</div>
	
						
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<div id="column3" class="column">
</div>
<div id="column-footer">
		
				<div class="habblet-container ">		
	
						<div class="habblet box-content" id="tag-cloud-slim">
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
			 
 
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
<?php require_once('./templates/login_footer.php'); ?>