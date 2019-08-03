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

define("IN_HOLOCMS", TRUE);

if(strpos($_SERVER['SERVER_SOFTWARE'],"Win") == false){ $page['dir'] = str_replace('\\','/',$page['dir']); }
chdir(str_replace($page['dir'], "", getcwd()));

if(@ini_get('date.timezone') == null && function_exists("date_default_timezone_get")){ @date_default_timezone_set("America/Los_Angeles"); }

if(strpos($page['dir'],'habblet') && (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') && $page['no_ajax'] != true){ header('Location: ../'); exit; }

if(!include_once('./includes/config.php')){ if(file_exists('./install/config.php')){ echo "<h1>Please move ./install/config.php to ./includes/config.php to continue.</h1>"; }elseif(file_exists('./install/index.php')){ header('Location: ./install/'); }else{ echo "<h1>Cannot find config.php in includes folder. Cannot find the install folder either. Did you copy all the files?"; } exit; }
define("PREFIX", $conn['main']['prefix']);
require_once('./includes/classes.php');
$db = new $conn['main']['server']($conn['main']);
if($conn['server']['enabled'] == true){ $serverdb = new $conn['server']['server']($conn['server']); }else{ $serverdb = $db; }
$settings = new HoloSettings;
$input = new HoloInput;
$lang = new HoloLocale;

session_start();

define("PATH", $settings->find("site_path"));
define("SHORTNAME", $settings->find("site_shortname"));
define("FULLNAME", $settings->find("site_name"));
//define("DEBUG", true); //Uncomment this line to show detailed database error messages.

require('./includes/data/'.$settings->find("hotel_server").'.php');
$core = new core_sql;
require('./includes/functions.php');
require('./includes/version.php');

if($page['housekeeping'] != true){ if(is_object($_SESSION['user'])){ $user = $_SESSION['user']; }else{ $user = new HoloUser(null,null); } }else{ if(is_object($_SESSION['hk_user'])){ $user = $_SESSION['hk_user']; }else{ $user = new HoloUser(null,null); } }

if($user->error == 1 && $page['bypass_user_check'] != true && $_COOKIE['rememberme'] == "true" && $page['housekeeping'] != true){ $_SESSION['page'] = $_SERVER["REQUEST_URI"]; header("Location: ".PATH."/security_check_token"); }

if($settings->find("site_closed") == "1" && $page['id'] != "maintenance" && $page['housekeeping'] != true && $user->user("rank") < 5){
	header("Location: ".PATH."/maintenance"); exit;
}
?>