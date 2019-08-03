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
$lang->addLocale("community.header");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo SHORTNAME; ?>: <?php echo $page['name']; ?> </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
    <link rel="shortcut icon" href="<?php echo PATH; ?>/web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="alternate" type="application/rss+xml" title="<?php echo SHORTNAME; ?>: <?php echo $lang->loc['rss']; ?>" href="<?php echo PATH; ?>/articles/rss.xml" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/common.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>/web-gallery/static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/local/com.css" type="text/css" />

<script src="<?php echo PATH; ?>/web-gallery/js/local/com.js" type="text/javascript"></script>

<script type="text/javascript">
document.habboLoggedIn = <?php if($user->id == 0){ echo "false"; }else{ echo "true"; } ?>;
var habboName = <?php if($user->id != 0){ ?>"<?php echo $user->name; ?>"<?php }else{ echo "null"; } ?>;
var ad_keywords = "";
var habboReqPath = "<?php echo PATH; ?>";
var habboStaticFilePath = "<?php echo PATH; ?>/web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>/habbo-imaging/";
var habboPartner = "";
window.name = "habboMain";
if (typeof HabboClient != "undefined") { HabboClient.windowName = "client"; }

</script>

<?php 
switch($page['id']){
	case "welcome":
?>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/welcome.css" type="text/css" />
<?php
		break;
	case "me":
?>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/personal.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/habboclub.js" type="text/javascript"></script>	
							
								<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/minimail.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/control.textarea.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/minimail.js" type="text/javascript"></script>
<?php
		break;
	case "profile":
?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/settings.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/settings.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/friendmanagement.css" type="text/css" />
<?php
		break;
	case "community":
?>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/rooms.css" type="text/css" /> 
<script src="<?php echo PATH; ?>/web-gallery/static/js/rooms.js" type="text/javascript"></script> 
<script src="<?php echo PATH; ?>/web-gallery/static/js/moredata.js" type="text/javascript"></script> 
<?php
		break;
	case "tryout":
?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/settings.js" type="text/javascript"></script>
<?php
		break;
	case "collectables":
?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/credits.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/collectibles.css" type="text/css" />
<?php
		break;
	case "home":
?>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/myhabbo.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/skins.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/dialogs.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/control.textarea.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/myhabbo.css" type="text/css" />
	<link href="<?php echo PATH; ?>/web-gallery/styles/myhabbo/assets.css" type="text/css" rel="stylesheet" />

<script src="<?php echo PATH; ?>/web-gallery/static/js/homeview.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/lightwindow.css" type="text/css" />

<script src="<?php echo PATH; ?>/web-gallery/static/js/homeauth.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/v2/styles/group.css" type="text/css" />
<style type="text/css">

    #playground, #playground-outer {
	    width: <?php if($user->IsHCMember($userrow[0])){ echo "922"; }else{ echo "752"; } ?>px;
	    height: 1360px;
    }

</style>

<?php if($page['edit'] == true){ ?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/homeedit.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
document.observe("dom:loaded", function() { initView(<?php echo $userrow[0]; ?>, <?php echo $userrow[0]; ?>); });
function isElementLimitReached() {
	if (getElementCount() >= 200) {
		showHabboHomeMessageBox("<?php echo addslashes($lang->loc['error']); ?>", "<?php echo addslashes($lang->loc['savehome.limit.error']); ?>", "<?php echo addslashes($lang->loc['close']); ?>");
		return true;
	}
	return false;
}

<?php if($page['type'] == "home"){ ?>
function cancelEditing(expired) {
	location.replace("<?php echo PATH; ?>/myhabbo/cancel/<?php echo $userrow[0]; ?>" + (expired ? "?expired=true" : ""));
}

function getSaveEditingActionName(){
	return '/myhabbo/save';
}
<?php }else{ ?>
function cancelEditing(expired) {
	location.replace("<?php echo PATH; ?>/groups/actions/cancelEditingSession" + (expired ? "?expired=true" : ""));
}

function getSaveEditingActionName(){
	return '/groups/actions/saveEditingSession';
}
<?php } ?>

function showEditErrorDialog() {
	var closeEditErrorDialog = function(e) { if (e) { Event.stop(e); } Element.remove($("myhabbo-error")); Overlay.hide(); }
	var dialog = Dialog.createDialog("myhabbo-error", "", false, false, false, closeEditErrorDialog);
	Dialog.setDialogBody(dialog, '<p><?php echo addslashes($lang->loc['error.dialog']); ?></p><p><a href="#" class="new-button" id="myhabbo-error-close"><b><?php echo addslashes($lang->loc['close']); ?></b><i></i></a></p><div class="clear"></div>');
	Event.observe($("myhabbo-error-close"), "click", closeEditErrorDialog);
	Dialog.moveDialogToCenter(dialog);
	Dialog.makeDialogDraggable(dialog);
}

<?php if($page['type'] == "groups"){ ?>
	document.observe("dom:loaded", function() { 
		Dialog.showInfoDialog("session-start-info-dialog", 
		"<?php echo addslashes($lang->loc['editing.session.timeout']); ?> <?php echo millisecondsToMinutes($timeout['expire']); ?> <?php echo addslashes($lang->loc['minutes']); ?>.", 
		"<?php echo addslashes($lang->loc['ok']); ?>", function(e) {Event.stop(e); Element.hide($("session-start-info-dialog"));Overlay.hide();Utils.setAllEmbededObjectsVisibility('hidden');});
		var timeToTwoMinuteWarning= <?php echo $timeout['twominutes']; ?>;
		if(timeToTwoMinuteWarning > 0){
			setTimeout(function(){ 
				Dialog.showInfoDialog("session-ends-warning-dialog",
					"<?php echo addslashes($lang->loc['editing.session.timeout']); ?> 2 <?php echo addslashes($lang->loc['minutes']); ?>.", 
					"<?php echo addslashes($lang->loc['ok']); ?>", function(e) {Event.stop(e); Element.hide($("session-ends-warning-dialog"));Overlay.hide();Utils.setAllEmbededObjectsVisibility('hidden');});
			}, timeToTwoMinuteWarning);
		}
	});
<?php } ?>

function showSaveOverlay() {
	var invalidPos = getElementsInInvalidPositions();
	if (invalidPos.length > 0) {
	    $A(invalidPos).each(function(el) { Element.scrollTo(el);  Effect.Pulsate(el); });
	    showHabboHomeMessageBox("<?php echo addslashes($lang->loc['cant.do.that']); ?>", "<?php echo addslashes($lang->loc['cant.do.that.desc']); ?>", "<?php echo addslashes($lang->loc['close']); ?>");
		return false;
	} else {
		Overlay.show(null,'<?php echo addslashes($lang->loc['saving']); ?>');
		return true;
	}
}
</script>
<?php }else{ ?>
<script type="text/javascript">
document.observe("dom:loaded", function() { initView(<?php if($page['type'] == "home"){ echo $userrow[0]; }else{ echo $grouprow[0]; } ?>, <?php if($user->id == "0"){ echo "null"; }else{ echo $user->id; } ?>); });
</script>
<?php } ?>
<?php
		break;
}
?>

<?php if($page['discussion'] == true){ ?><link href="<?php echo PATH; ?>/web-gallery/styles/discussions.css" type="text/css" rel="stylesheet"/><?php } ?>

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
<body id="<?php echo $page['bodyid']; ?>" class="<?php if($user->name == "Guest"){ echo "anonymous"; } ?> ">
<div id="overlay"></div>
<div id="header-container">
	<div id="header" class="clearfix">
		<h1><a href="<?php echo PATH; ?>/"></a></h1>
       <div id="subnavi">
<?php if($user->id != "0"){ ?>
			<div id="subnavi-user">
				<ul>
					<li id="myfriends"><a href="#"><span><?php echo $lang->loc['my.friends']; ?></span></a><span class="r"></span></li>
					<li id="mygroups"><a href="#"><span><?php echo $lang->loc['my.groups']; ?></span></a><span class="r"></span></li>
					<li id="myrooms"><a href="#"><span><?php echo $lang->loc['my.rooms']; ?></span></a><span class="r"></span></li>
				</ul>
			</div>
            <div id="subnavi-search">
                <div id="subnavi-search-upper">

                <ul id="subnavi-search-links">
                    <li><a href="<?php echo PATH; ?>/help" target="habbohelp" onclick="openOrFocusHelp(this); return false"><?php echo $lang->loc['help']; ?></a></li>
					<li><a href="<?php echo PATH; ?>/account/logout" class="userlink" id="signout"><?php echo $lang->loc['sign.out']; ?></a></li>
				</ul>
                </div>
            </div>
            <div id="to-hotel">
<?php if(HotelStatus() == "online"){ ?>
					    <a href="<?php echo PATH; ?>/client" class="new-button green-button" target="client" onclick="HabboClient.openOrFocus(this); return false;"><b><?php echo $lang->loc['enter']; ?></b><i></i></a>
<?php }else{ ?>
						<div id="hotel-closed-medium"><?php echo $lang->loc['closed']; ?></div>
<?php } ?>
			</div>
<?php }else{ ?>
            <div id="subnavi-user">
                <div class="clearfix">&nbsp;</div>
                <p>
				        <a href="<?php echo PATH; ?>/client" id="enter-hotel-open-medium-link" target="client" onclick="HabboClient.openOrFocus(this); return false;"><?php echo $lang->loc['enter']; ?></a>
                </p>
            </div>
            <div id="subnavi-login">
                <form action="<?php echo PATH; ?>/account/submit" method="post" id="login-form">
            		<input type="hidden" name="page" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
                    <ul>
                        <li>
                            <label for="login-username" class="login-text"><b><?php echo $lang->loc['username']; ?></b></label>

                            <input tabindex="1" type="text" class="login-field" name="username" id="login-username" />
		                    <a href="#" id="login-submit-new-button" class="new-button" style="float: left; display:none"><b><?php echo $lang->loc['login']; ?></b><i></i></a>
                            <input type="submit" id="login-submit-button" value="<?php echo $lang->loc['login']; ?>" class="submit"/>
                        </li>
                        <li>
                            <label for="login-password" class="login-text"><b><?php echo $lang->loc['password']; ?></b></label>
                            <input tabindex="2" type="password" class="login-field" name="password" id="login-password" />
                            <input tabindex="3" type="checkbox" name="_login_remember_me" value="true" id="login-remember-me" />

                            <label for="login-remember-me" class="left"><?php echo $lang->loc['remember']; ?></label>
                        </li>
                    </ul>
                </form>
                <div id="subnavi-login-help" class="clearfix">
                    <ul>
                        <li class="register"><a href="<?php echo PATH; ?>/account/password/forgot" id="forgot-password"><span><?php echo $lang->loc['forgot']; ?></span></a></li>
                    	<li><a href="<?php echo PATH; ?>/register"><span><?php echo $lang->loc['register']; ?></span></a></li>

                    </ul>
                </div>
<div id="remember-me-notification" class="bottom-bubble" style="display:none;">
	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
					<?php echo $lang->loc['remember.popup']; ?>
	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>

            </div>
<?php } ?>
        </div>
<?php if($user->id != 0){ ?>
		<script type="text/javascript">
		L10N.put("purchase.group.title", "<?php echo $lang->loc['purchase.group.title']; ?>");
		document.observe("dom:loaded", function() {
            $("signout").observe("click", function() {
                HabboClient.close();
            });
        });
        </script>
<?php }else{ ?>
		<script type="text/javascript">
			LoginFormUI.init();
			RememberMeUI.init("right");
		</script>
<?php } ?>
<ul id="navi">
		<?php if($user->name != "Guest"){ ?>
        <li<?php if($page['cat'] == "home"){ echo " class=\"selected\""; } ?>>
			<?php if($page['cat'] == "home"){ echo "<strong>".$user->name." </strong>"; }else{ echo "<a href=\"".PATH."/me\">".$user->name."</a>"; } ?>
			<span></span>
		</li>
		<?php }else{ ?>
		<li id="tab-register-now"><a href="<?php echo PATH; ?>/register"><?php echo $lang->loc['register.tab']; ?></a><span></span></li>  
		<?php } ?>
		<li<?php if($page['cat'] == "community"){ echo " class=\"selected\""; } ?>>
			<?php if($page['cat'] == "community"){ echo "<strong>".$lang->loc['community']." </strong>"; }else{ echo "<a href=\"".PATH."/community\">".$lang->loc['community']."</a>"; } ?>
			<span></span>
		</li>
		<li<?php if($page['cat'] == "credits"){ echo " class=\"selected\""; } ?>>
			<?php if($page['cat'] == "credits"){ echo "<strong>".$lang->loc['coins']." </strong>"; }else{ echo "<a href=\"".PATH."/credits\">".$lang->loc['coins']."</a>"; } ?>
			<span></span>
		</li>
		<?php if((int) $user->user("rank") > 4){ ?>
		<li id="tab-register-now"><a href="<?php echo PATH; ?>/housekeeping/"><?php echo $lang->loc['housekeeping']; ?></a><span></span></li>
		<?php } ?>
</ul>

        <div id="habbos-online"><div class="rounded"><span><?php echo GetOnlineCount()." ".$lang->loc['members.online']; ?></span></div></div>
	</div>
</div>

<div id="content-container">

<?php
switch($page['cat']){
	case "home":
?>
	<?php if($user->name != "Guest"){ ?>
<div id="navi2-container" class="pngbg">
    <div id="navi2" class="pngbg clearfix">
		<ul>
			<li class="<?php if($page['id'] == "me"){ echo "selected"; } ?>">
				<?php if($page['id'] == "me"){ echo $lang->loc['home']; }else{ echo "<a href=\"".PATH."/me\">".$lang->loc['home']."</a>"; } ?>
			</li>
    		<li class="<?php if($page['id'] == "home" && ($_GET['id'] == $user->id || $_GET['name'] == $user->name)){ echo "selected"; } ?>">
				<?php if($page['id'] == "home" && ($_POST['name'] == $user->name || $_GET['name'] == $user->name)){ echo $lang->loc['my.page']; }else{ echo "<a href=\"".PATH."/home/".$user->name."\">".$lang->loc['my.page']."</a>"; } ?>
    		</li>
    		<li class="<?php if($page['id'] == "profile"){ echo "selected"; } ?>">
				<?php if($page['id'] == "profile"){ echo $lang->loc['settings']; }else{ echo "<a href=\"".PATH."/profile\">".$lang->loc['settings']."</a>"; } ?>
    		</li>
			<li class=" last">
				<a href="<?php echo PATH; ?>/club"><?php echo $lang->loc['habbo.club']; ?></a>
			</li>
		</ul>
    </div>
</div>
	<?php } ?>
<?php
		break;
	case "community":
?>
<div id="navi2-container" class="pngbg">
    <div id="navi2" class="pngbg clearfix">
		<ul>
			<li class="<?php if($page['id'] == "community"){ echo "selected"; } ?>">
				<?php if($page['id'] == "community"){ echo $lang->loc['community']; }else{ echo "<a href=\"".PATH."/community\">".$lang->loc['community']."</a>"; } ?>
			</li>
    		<li class="<?php if($page['id'] == "news"){ echo "selected"; } ?>">
				<?php if($page['id'] == "news"){ echo $lang->loc['news']; }else{ echo "<a href=\"".PATH."/articles\">".$lang->loc['news']."</a>"; } ?>
    		</li>
    		<li class="<?php if($page['id'] == "tags"){ echo "selected"; } ?> last">
				<?php if($page['id'] == "tags"){ echo $lang->loc['tags']; }else{ echo "<a href=\"".PATH."/tag\">".$lang->loc['tags']."</a>"; } ?>
    		</li>
		</ul>
    </div>
</div>
<?php
		break;
	case "credits":
?>
<div id="navi2-container" class="pngbg">
    <div id="navi2" class="pngbg clearfix">
		<ul>
			<li class="<?php if($page['id'] == "credits"){ echo "selected"; } ?>">
				<?php if($page['id'] == "credits"){ echo $lang->loc['coins']; }else{ echo "<a href=\"".PATH."/credits\">".$lang->loc['coins']."</a>"; } ?>
			</li>
			<li class="<?php if($page['id'] == "club"){ echo "selected"; } ?>">
				<?php if($page['id'] == "club"){ echo $lang->loc['habbo.club']; }else{ echo "<a href=\"".PATH."/credits/club\">".$lang->loc['habbo.club']."</a>"; } ?>
			</li>
			<li class="<?php if($page['id'] == "collectables"){ echo "selected"; } ?>">
				<?php if($page['id'] == "collectables"){ echo $lang->loc['collectables']; }else{ echo "<a href=\"".PATH."/credits/collectables\">".$lang->loc['collectables']."</a>"; } ?>
			</li>
    		<li class="<?php if($page['id'] == "pixels"){ echo "selected"; } ?> last">
				<?php if($page['id'] == "pixels"){ echo $lang->loc['pixels']; }else{ echo "<a href=\"".PATH."/credits/pixels\">".$lang->loc['pixels']."</a>"; } ?>
    		</li>
		</ul>
    </div>
</div>
<?php
		break;
}
?>