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

if (!defined("IN_HOLOCMS")) { header("Location: ".PATH."/"); exit; }
$version = version();
$lang->addLocale("landing.header");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo SHORTNAME; ?>: <?php echo $lang->loc['pagename.register']; ?> </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
    <link rel="shortcut icon" href="<?php echo PATH; ?>/web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="alternate" type="application/rss+xml" title="<?php echo SHORTNAME; ?>: RSS" href="<?php echo PATH; ?>/rss" />
	
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/common.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/process.css" type="text/css" />

<script type="text/javascript">
document.habboLoggedIn = false;
var habboName = null;
var ad_keywords = "";
var habboReqPath = "<?php echo PATH; ?>";
var habboStaticFilePath = "<?php echo PATH; ?>/web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>/habbo-imaging/";
var habboPartner = "";
window.name = "habboMain";
if (typeof HabboClient != "undefined") { HabboClient.windowName = "client"; }


</script>

<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/registration.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/registration.js" type="text/javascript"></script>
    <script type="text/javascript">
        L10N.put("register.tooltip.name", "<?php echo addslashes($lang->loc['tooltip.name']); ?>");
        L10N.put("register.tooltip.password", "<?php echo addslashes($lang->loc['tooltip.password']); ?>");
        L10N.put("register.error.password_required", "<?php echo addslashes($lang->loc['error.password.required']); ?>");
        L10N.put("register.error.password_too_short", "<?php echo addslashes($lang->loc['error.password.too.short']); ?>");
        L10N.put("register.error.password_numbers", "<?php echo addslashes($lang->loc['error.password_numbers']); ?>");
        L10N.put("register.error.password_letters", "<?php echo addslashes($lang->loc['error.password_letters']); ?>");
        L10N.put("register.error.retyped_password_required", "<?php echo addslashes($lang->loc['error.retyped.password.required']); ?>");
        L10N.put("register.error.retyped_password_notsame", "<?php echo addslashes($lang->loc['error.retyped.password.notsame']); ?>");
        L10N.put("register.error.retyped_email_required", "<?php echo addslashes($lang->loc['error.retyped.email.required']); ?>");
        L10N.put("register.error.retyped_email_notsame", "<?php echo addslashes($lang->loc['error.retyped.email.notsame']); ?>");
        L10N.put("register.tooltip.namecheck", "<?php echo addslashes($lang->loc['tooltip.namecheck']); ?>");
        L10N.put("register.tooltip.retypepassword", "<?php echo addslashes($lang->loc['tooltip.retypepassword']); ?>");
        L10N.put("register.tooltip.personalinfo.disabled", "<?php echo addslashes($lang->loc['tooltip.personalinfo.disabled']); ?>");
        L10N.put("register.tooltip.namechecksuccess", "<?php echo addslashes($lang->loc['tooltip.namechecksuccess']); ?>");
        L10N.put("register.tooltip.passwordsuccess", "<?php echo addslashes($lang->loc['tooltip.passwordsuccess']); ?>");
        L10N.put("register.tooltip.passwordtooshort", "<?php echo addslashes($lang->loc['tooltip.passwordtooshort']); ?>");
        L10N.put("register.tooltip.passwordnotsame", "<?php echo addslashes($lang->loc['tooltip.passwordnotsame']); ?>");
        L10N.put("register.tooltip.invalidpassword", "<?php echo addslashes($lang->loc['tooltip.invalidpassword']); ?>");
        L10N.put("register.tooltip.email", "<?php echo addslashes($lang->loc['tooltip.email']); ?>");
        L10N.put("register.tooltip.retypeemail", "<?php echo addslashes($lang->loc['tooltip.retypeemail']); ?>");
        L10N.put("register.tooltip.invalidemail", "<?php echo addslashes($lang->loc['tooltip.invalidemail']); ?>");
        L10N.put("register.tooltip.emailsuccess", "<?php echo addslashes($lang->loc['tooltip.emailsuccess']); ?>");
        L10N.put("register.tooltip.emailnotsame", "<?php echo addslashes($lang->loc['tooltip.emailnotsame']); ?>");
        L10N.put("register.tooltip.enterpassword", "<?php echo addslashes($lang->loc['tooltip.enterpassword']); ?>");
        L10N.put("register.tooltip.entername", "<?php echo addslashes($lang->loc['tooltip.entername']); ?>");
        L10N.put("register.tooltip.enteremail", "<?php echo addslashes($lang->loc['tooltip.enteremail']); ?>");
        L10N.put("register.tooltip.enterbirthday", "<?php echo addslashes($lang->loc['tooltip.enterbirthday']); ?>");
        L10N.put("register.tooltip.acceptterms", "<?php echo addslashes($lang->loc['tooltip.acceptterms']); ?>");
        L10N.put("register.tooltip.invalidbirthday", "<?php echo addslashes($lang->loc['tooltip.invalidbirthday']); ?>");
        L10N.put("register.tooltip.emailandparentemailsame","<?php echo addslashes($lang->loc['tooltip.emailandparentemailsame']); ?>.");
        L10N.put("register.tooltip.entercaptcha","<?php echo addslashes($lang->loc['tooltip.entercaptcha']); ?>");
        L10N.put("register.tooltip.captchavalid","<?php echo addslashes($lang->loc['tooltip.captchavalid']); ?>");
        L10N.put("register.tooltip.captchainvalid","<?php echo addslashes($lang->loc['tooltip.captchainvalid']); ?>");
		L10N.put("register.error.parent_permission","<?php echo addslashes($lang->loc['error.parent.permission']); ?>");

        RegistrationForm.parentEmailAgeLimit = -1;
        L10N.put("register.message.parent_email_js_form", "<div\>\n\t<div class=\"register-label\"\><?php echo addslashes($lang->loc['require.parent.email']); ?></div\>\n\t<div id=\"parentEmail-error-box\"\>\n        <div class=\"register-error\"\>\n            <div class=\"rounded rounded-blue\"  id=\"parentEmail-error-box-container\"\>\n                <div id=\"parentEmail-error-box-content\"\>\n                    <?php echo addslashes($lang->loc['tooltip.enteremail']); ?>\n                </div\>\n            </div\>\n        </div\>\n\t</div\>\n\t<div class=\"register-label\"\><label for=\"register-parentEmail-bubble\"\><?php echo addslashes($lang->loc['parent.email']); ?></label\></div\>\n\t<div class=\"register-label\"\><input type=\"text\" name=\"bean.parentEmail\" id=\"register-parentEmail-bubble\" class=\"register-text-black\" size=\"15\" /\></div\>\n\n\n</div\>");

        RegistrationForm.isCaptchaEnabled = <?php if($settings->find("site_capcha") == "1"){ ?>true<?php }else{ ?>false<?php } ?>;
         L10N.put("register.message.captcha_js_form", "<div\>\n  <div id=\"recaptcha_image\" class=\"register-label\"\>\n    <img id=\"captcha\" src=\"<?php echo PATH; ?>/captcha.jpg?t=<?php echo time(); ?>&register=1\" alt=\"\" width=\"200\" height=\"60\" /\>\n  </div\>\n  <div class=\"register-label\" id=\"captcha-reload\"\>\n    <img src=\"<?php echo PATH; ?>/web-gallery/v2/images/shared_icons/reload_icon.gif\" width=\"15\" height=\"15\"/\>\n    <a href=\"#\"\><?php echo addslashes($lang->loc['cannot.read.capcha']); ?></a\>\n  </div\>\n  <div class=\"register-label\"\><label for=\"register-captcha-bubble\"\><?php echo addslashes($lang->loc['type.in.code']); ?></label\></div\>\n  <div class=\"register-input\"\><input type=\"text\" name=\"bean.captchaResponse\" id=\"register-captcha-bubble\" class=\"register-text-black\" value=\"\" size=\"15\" /\></div\>\n</div\>");

        L10N.put("register.message.age_limit_ban", "<div\>\n<p\>\n<?php echo addslashes($lang->loc['under.age.limit']); ?>\n</p\>\n\n<p style=\"text-align:right\"\>\n<input type=\"button\" class=\"submit\" id=\"register-parentEmail-cancel\" value=\"<?php echo addslashes($lang->loc['cancel']); ?>\" onclick=\"RegistrationForm.cancel(\'?ageLimit=true\')\" /\>\n</p\>\n</div\>");
        RegistrationForm.ageLimit = -1;
        RegistrationForm.banHours = 24;
        HabboView.add(function() {
            Rounder.addCorners($("register-avatar-editor-title"), 4, 4, "rounded-container");
            RegistrationForm.init(<?php if(isset($error['captcha'])){ echo "false"; }else{ echo "true"; } ?>);
            <?php if($refer == true){ ?>$$('#header ul.stats').each(Element.hide);<?php } ?>
        });

        HabboView.add(function() {
            var swfobj = new SWFObject("<?php echo PATH; ?>/flash/HabboRegistration.swf", "habboreg", "435", "400", "8");
            swfobj.addParam("base", "<?php echo PATH; ?>/flash/");
            swfobj.addParam("wmode", "opaque");
            swfobj.addParam("AllowScriptAccess", "always");
            swfobj.addVariable("figuredata_url", "<?php echo PATH; ?>/xml/figuredata.xml");
            swfobj.addVariable("draworder_url", "<?php echo PATH; ?>/xml/draworder.xml");
            swfobj.addVariable("localization_url", "<?php echo PATH; ?>/xml/figure_editor.xml");
            swfobj.addVariable("habbos_url", "<?php echo PATH; ?>/xml/promo_habbos_v2.xml");
            swfobj.addVariable("figure", "<?php echo $figure; ?>");
            swfobj.addVariable("gender", "<?php echo $gender; ?>");

            swfobj.addVariable("showClubSelections", "0");

            swfobj.write("register-avatar-editor");
            window.habboreg = $("habboreg"); // for MSIE and Flash Player 8
        });

    </script>


<meta name="description" content="<?php echo $settings->find("site_description"); ?>" />
<meta name="keywords" content="<?php echo $settings->find("site_keywords"); ?>" />

<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/ie6.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(<?php echo PATH; ?>/web-gallery/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="PHPRetro <?php echo $version['version']." ".$version['status']; ?>" />
</head>
<body id="register" class="process-template secure-page">

<div id="overlay"></div>

<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content">
			<div id="header" class="clearfix">
				<h1><a href="<?php echo PATH; ?>/"></a></h1>
				<ul class="stats">
					    <li class="stats-online"><span class="stats-fig"><?php echo GetOnlineCount(); ?></span> <?php echo $lang->loc['users.online.now']; ?></li>
					    <li class="stats-visited"><img src='<?php echo PATH; ?>/web-gallery/v2/images/<?php echo HotelStatus(); ?>.gif' alt='<?php echo HotelStatus(); ?>' border='0'></li>
				</ul>
			</div>
			<div id="process-content">