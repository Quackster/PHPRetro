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

function writeConfig($db){
$data = 
'<?php
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

/*-------------------------------------------------------*\
| ****** NOTE REGARDING THE VARIABLES IN THIS FILE ****** |
+---------------------------------------------------------+
| If you get any errors while attempting to connect to    |
| MySQL, you will need to email your webhost because we   |
| cannot tell you the correct values for the variables    |
| in this file.                                           |
\*-------------------------------------------------------*/

//	****** MASTER DATABASE SETTINGS ******
//	These are the settings included to connect to your Database.
'.'$'.'conn[\'main\'][\'prefix\'] = "'.$db['db_prefix'].'";
'.'$'.'conn[\'main\'][\'server\'] = "mysql"; //mysql, pgsql, sqlite, or mssql
'.'$'.'conn[\'main\'][\'host\'] = "'.$db['db_host'].'"; //filename for SQLite
'.'$'.'conn[\'main\'][\'port\'] = "'.$db['db_port'].'";
'.'$'.'conn[\'main\'][\'username\'] = "'.$db['db_username'].'";
'.'$'.'conn[\'main\'][\'password\'] = "'.$db['db_password'].'";
'.'$'.'conn[\'main\'][\'database\'] = "'.$db['db_name'].'";

//	****** HOTEL DATABASE SETTINGS ******
//  EXPERIMENTAL!! Only turn this on if you know what to do. Please submit all
//  bugs and your fix for them (if possible) to http://code.google.com/p/phpretro
//	These are the settings included to connect to your hotel database Database.
'.'$'.'conn[\'server\'][\'enabled\'] = false;
'.'$'.'conn[\'server\'][\'server\'] = "mysql"; //mysql, pgsql, sqlite, or mssql
'.'$'.'conn[\'server\'][\'host\'] = "'.$db['db_host'].'"; //filename for SQLite
'.'$'.'conn[\'server\'][\'port\'] = "'.$db['db_port'].'";
'.'$'.'conn[\'server\'][\'username\'] = "'.$db['db_username'].'";
'.'$'.'conn[\'server\'][\'password\'] = "'.$db['db_password'].'";
'.'$'.'conn[\'server\'][\'database\'] = "'.$db['db_name'].'";
?>';
	$fh = @fopen("../install/config.php","w");
	
	if (!@fwrite($fh, $data)) {
		@fclose($fh);
		return false;
	} else {
		@fclose($fh);
		return true;
	}
}
function installTables(){
$prefix = "new-".PREFIX;
$query = array();
$query[] = "DROP TABLE IF EXISTS `".$prefix."alerts`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."banners`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."campaigns`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."client_errors`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."collectables`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."faq`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."forum_posts`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."forum_threads`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."guestbook`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."help`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."homes`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."homes_catalogue`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."homes_edit`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."minimail`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."news`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."ratings`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."recommended`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."settings`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."settings_pages`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."tags`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."transactions`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."users`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."verify`;";
$query[] = "DROP TABLE IF EXISTS `".$prefix."wardrobe`;";
$query[] = "CREATE TABLE `".$prefix."alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `alert` text NOT NULL,
  `type` enum('1','0','-1','2') NOT NULL DEFAULT '1',
  `time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."banners` (
  `id` int(35) NOT NULL AUTO_INCREMENT,
  `text` varchar(50) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '0',
  `advanced` int(1) DEFAULT NULL,
  `html` text,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."campaigns` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` text,
  `visible` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."client_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` text,
  `userid` int(11) DEFAULT NULL,
  `error_type` text,
  `os` text,
  `error_id` text,
  `hookerror` text,
  `error_message` text,
  `hookmsgb` text,
  `lastexecute` text,
  `lastmessage` text,
  `server_errors` text,
  `lastroom` text,
  `mus_errorcode` text,
  `client_process_list` text,
  `client_errors` text,
  `neterr_cast` text,
  `neterr_res` text,
  `client_uptime` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."collectables` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `image_small` varchar(255) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `furni_id` int(20) NOT NULL DEFAULT '0',
  `date` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."faq` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` enum('item','cat') NOT NULL DEFAULT 'item',
  `catid` int(11) DEFAULT NULL,
  `title` varchar(1000) NOT NULL,
  `content` text,
  `show_in_footer` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."forum_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `threadid` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `posterid` int(25) NOT NULL,
  `time` int(10) NOT NULL,
  `edit_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."forum_threads` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `starterid` int(25) NOT NULL,
  `title` varchar(30) NOT NULL,
  `open` enum('1','0') NOT NULL DEFAULT '1',
  `sticky` enum('1','0') NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL,
  `groupid` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."guestbook` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `message` text,
  `time` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `ownerid` int(10) DEFAULT NULL,
  `owner` enum('user','group') DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`ownerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `message` mediumtext NOT NULL,
  `date` varchar(50) NOT NULL,
  `picked_up` enum('0','1') NOT NULL,
  `subject` varchar(50) NOT NULL,
  `roomid` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."homes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) DEFAULT NULL,
  `ownerid` int(11) NOT NULL,
  `x` varchar(6) DEFAULT '1' COMMENT 'left',
  `y` varchar(6) DEFAULT '1' COMMENT 'top',
  `z` varchar(6) DEFAULT '1' COMMENT 'z-index',
  `skin` varchar(255) DEFAULT 'defaultskin',
  `location` int(11) DEFAULT '-1' COMMENT '-1 = inventory, 0 = user''s home page >1 = group id page',
  `variable` text,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`ownerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."homes_catalogue` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '-1 = groups only, 0 = anywhere, 1 = homes only',
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) DEFAULT NULL COMMENT 'ONLY for widgets',
  `type` enum('1','2','3','4') NOT NULL COMMENT 'stickers = 1, widgets = 2, notes = 3, backgrounds = 4',
  `data` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '1',
  `category` varchar(255) NOT NULL DEFAULT 'Default',
  `categoryid` int(11) NOT NULL,
  `minrank` int(11) DEFAULT '1',
  `where` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."homes_edit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` int(11) NOT NULL,
  `editorid` int(11) NOT NULL,
  `type` enum('group','user') NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."minimail` (
  `senderid` int(11) NOT NULL,
  `to_id` int(11) DEFAULT NULL,
  `subject` varchar(30) NOT NULL,
  `time` int(10) NOT NULL,
  `message` text NOT NULL,
  `read_mail` enum('0','1') NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deleted` int(10) DEFAULT '0',
  `conversationid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`to_id`,`senderid`,`read_mail`,`deleted`,`conversationid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."news` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `categories` text NOT NULL,
  `header_image` varchar(100) NOT NULL,
  `summary` text NOT NULL,
  `story` longtext NOT NULL,
  `time` int(10) NOT NULL,
  `author` text NOT NULL,
  `images` text,
  PRIMARY KEY (`id`),
  KEY `num` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `raterid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."recommended` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rec_id` int(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT 'group',
  `sponsered` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."security_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `ipaddress` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `event` text NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."settings` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `value` text,
  `label` varchar(255) DEFAULT NULL,
  `description` text,
  `type` enum('textbox','radiobuttons','selectbox','textarea','hidden') DEFAULT 'textbox',
  `values` text,
  `page` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."settings_pages` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."tags` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(25) NOT NULL,
  `type` enum('user','group') DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `descr` text NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ipaddress_last` varchar(255) DEFAULT NULL,
  `lastvisit` int(10) DEFAULT NULL,
  `online` int(10) DEFAULT '1',
  `newsletter` int(1) DEFAULT '1',
  `email_verified` tinyint(1) DEFAULT '0',
  `show_home` int(11) DEFAULT '1',
  `email_friendrequest` enum('0','1') DEFAULT '1',
  `email_minimail` enum('0','1') DEFAULT '1',
  `show_online` int(11) DEFAULT '1',
  `remember_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."verify` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `key_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".$prefix."wardrobe` (
  `userid` int(11) NOT NULL,
  `slotid` varchar(1) NOT NULL,
  `figure` text NOT NULL,
  `gender` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
return $query;
}
function installQueries(){
global $lang;
$lang->addLocale("installer.queries");
$loc = $lang->loc;
foreach($loc as &$data){
	$data = addslashes($data);
}
$query = array();
$query[] = "insert into `".PREFIX."campaigns` values('1','%path%/housekeeping/','http://images.habbohotel.co.uk/c_images/hot_campaign_images_gb/cb_country_160x60.gif','Please change','These are sample campaigns, please edit them via housekeeping.','1'),
 ('2','%path%/articles','http://images.habbohotel.co.uk/c_images/hot_campaign_images_gb/easter_160x60.gif','News','See the latest news in our hotel.','1'),
 ('3','http://code.google.com/p/phpretro/issues/list','http://images.habbohotel.co.uk/c_images/hot_campaign_images_gb/uk_newsletter_160x70.gif','Found a bug?','Submit it to our Google Codes page!','1');";
$query[] = "insert into `".PREFIX."faq` values('2','item','1','".$loc['faq.how.to.contact']."','".$loc['faq.how.to.contact.desc']."','0'),
 ('1','cat','0','".$loc['faq.contact.us']."','','1'),
 ('3','item','1','".$loc['faq.faster.reply']."','".$loc['faq.faster.reply.desc']."','0');";
$query[] = "insert into `".PREFIX."settings` values('site_name','Retro Hotel','".$loc['settings.site_name']."','".$loc['settings.site_name']."','textbox','','site','0','".$loc['settings.category.main']."'),
 ('site_shortname','Retro','".$loc['settings.site_shortname']."','".$loc['settings.site_shortname.desc']."','textbox','','site','1','".$loc['settings.category.main']."'),
 ('site_closed','0','".$loc['settings.site_closed']."','".$loc['settings.site_closed.desc']."','radiobuttons','".$loc['settings.site_closed.values']."','site','2','".$loc['settings.category.main']."'),
 ('site_tracking','','".$loc['settings.site_tracking']."','".$loc['settings.site_tracking.desc']."','textarea','','content','0','".$loc['settings.category.tracking']."'),
 ('site_path','http://localhost/phpretro','".$loc['settings.site_path']."','".$loc['settings.site_path.desc']."','textbox','','site','3','".$loc['settings.category.paths']."'),
 ('site_c_images_path','http://images.habbohotel.com/c_images','".$loc['settings.site_c_images_path']."','".$loc['settings.site_c_images_path.desc']."','textbox','','site','4','".$loc['settings.category.paths']."'),
 ('site_badges_path','/album1584/','".$loc['settings.site_badges_path']."','".$loc['settings.site_badges_path.desc']."','textbox','','site','5','".$loc['settings.category.paths']."'),
 ('site_language','en','".$loc['settings.site_language']."','".$loc['settings.site_language.desc']."','hidden','','content','1','".$loc['settings.category.site']."'),
 ('hotel_server','holograph','".$loc['settings.hotel_server']."','".$loc['settings.hotel_server.desc']."','hidden','','hotel','0','".$loc['settings.category.server']."'),
 ('hotel_ip','".$_SERVER['REMOTE_ADDR']."','".$loc['settings.hotel_ip']."','".$loc['settings.hotel_ip.desc']."','textbox','','hotel','1','".$loc['settings.category.paths']."'),
 ('hotel_port','21','".$loc['settings.hotel_port']."','".$loc['settings.hotel_port.desc']."','textbox','','hotel','2','".$loc['settings.category.paths']."'),
 ('hotel_mus','20','".$loc['settings.hotel_mus']."','".$loc['settings.hotel_mus.desc']."','textbox','','hotel','5','".$loc['settings.category.paths']."'),
 ('client_external_texts','http://hotel-us.habbo.com/gamedata/external?id=external_texts?','".$loc['settings.client_external_texts']."','".$loc['settings.client_external_texts.desc']."','textbox','','hotel','3','".$loc['settings.category.paths']."'),
 ('client_external_variables','http://hotel-us.habbo.com/gamedata/external?id=external_variables?','".$loc['settings.client_external_variables']."','".$loc['settings.client_external_variables.desc']."','textbox','','hotel','4','".$loc['settings.category.paths']."'),
 ('register_start_credits','1000','".$loc['settings.register_start_credits']."','".$loc['settings.register_start_credits.desc']."','textbox','','site','6','".$loc['settings.category.user']."'),
 ('register_referral_rewards','1000','".$loc['settings.register_referral_rewards']."','".$loc['settings.register_referral_rewards.desc']."','textbox','','site','7','".$loc['settings.category.user']."'),
 ('email_verify_enabled','0','".$loc['settings.email_verify_enabled']."','".$loc['settings.email_verify_enabled.desc']."','radiobuttons','".$loc['settings.email_verify_enabled.values']."','email','2','".$loc['settings.category.verify']."'),
 ('cache_settings','1','".$loc['settings.cache_settings']."','".$loc['settings.cache_settings.desc']."','radiobuttons','".$loc['settings.cache_settings.values']."','site','8','".$loc['settings.category.cache']."'),
 ('email_verify_reward','500','".$loc['settings.email_verify_reward']."','".$loc['settings.email_verify_reward.desc']."','textbox','','email','3','".$loc['settings.category.verify']."'),
 ('maintenance_style','1','".$loc['settings.maintenance_style']."','".$loc['settings.maintenance_style.desc']."','radiobuttons','".$loc['settings.maintenance_style.values']."','content','2','".$loc['settings.category.maintenance']."'),
 ('maintenance_twitter','phpretro','".$loc['settings.maintenance_twitter']."','".$loc['settings.maintenance_twitter.desc']."','textbox','','content','3','".$loc['settings.category.maintenance']."'),
 ('site_status_image','2','".$loc['settings.site_status_image']."','".$loc['settings.site_status_image.desc']."','selectbox','".$loc['settings.site_status_image.values']."','site','10','".$loc['settings.category.cache']."'),
 ('site_description','Join the world\'s largest virtual hangout where you can meet and make friends. Design your own rooms, collect cool furniture, throw parties and so much more! Create your FREE ".SHORTNAME." today!','".$loc['settings.site_description']."','".$loc['settings.site_description.desc']."','textarea','','content','4','".$loc['settings.category.metadata']."'),
 ('site_keywords','".SHORTNAME.", virtual, world, join, groups, forums, play, games, online, friends, teens, collecting, social network, create, collect, connect, furniture, virtual, goods, sharing, badges, social, networking, hangout, safe, music, celebrity, celebrity visits, cele','".$loc['settings.site_keywords']."','".$loc['settings.site_keywords.desc']."','textbox','','content','5','".$loc['settings.category.metadata']."'),
 ('site_flash_promo','2','".$loc['settings.site_flash_promo']."','".$loc['settings.site_flash_promo.desc']."','selectbox','".$loc['settings.site_flash_promo.values']."','content','7','".$loc['settings.category.landing']."'),
 ('site_cache_images','1','".$loc['settings.site_cache_images']."','".$loc['settings.site_cache_images.desc']."','radiobuttons','".$loc['settings.site_cache_images.values']."','site','9','".$loc['settings.category.cache']."'),
 ('site_new_landing_page','0','".$loc['settings.site_new_landing_page']."','".$loc['settings.site_new_landing_page.desc']."','radiobuttons','".$loc['settings.site_new_landing_page.values']."','content','6','".$loc['settings.category.landing']."'),
 ('site_allow_guests','1','".$loc['settings.site_allow_guests']."','".$loc['settings.site_allow_guests.desc']."','radiobuttons','".$loc['settings.site_allow_guests.values']."','security','2','".$loc['settings.category.guests']."'),
 ('site_welcome_text','When arriving to your room, you will be asked if you\'d like to meet ".SHORTNAME." Guides. ".SHORTNAME." guides are experienced ".SHORTNAME." players.','".$loc['settings.site_welcome_text']."','".$loc['settings.site_welcome_text.desc']."','textarea','','content','8','".$loc['settings.category.welcome']."'),
 ('site_hotel_image','htlview_br.png','".$loc['settings.site_hotel_image']."','".$loc['settings.site_hotel_image.desc']."','textbox','','content','9','".$loc['settings.category.home']."'),
 ('site_cookie_time','14','".$loc['settings.site_cookie_time']."','".$loc['settings.site_cookie_time.desc']."','textbox','','security','3','".$loc['settings.category.session']."'),
 ('site_session_time','30','".$loc['settings.site_session_time']."','".$loc['settings.site_session_time.desc']."','textbox','','security','4','".$loc['settings.category.session']."'),
 ('client_dcr','http://images.habbo.com/dcr/r34_20090707_0500_19058_b83e1dedb3e7933dd69b0887f671e9a3/habbo.dcr?','".$loc['settings.client_dcr']."','".$loc['settings.client_dcr.desc']."','textbox','','hotel','6','".$loc['settings.category.paths']."'),
 ('hk_notes','Welcome to Housekeeping!','','','hidden','','',null,''),
 ('client_log_errors','1','".$loc['settings.client_log_errors']."','".$loc['settings.client_log_errors.desc']."','radiobuttons','".$loc['settings.client_log_errors.values']."','security','5','".$loc['settings.category.logs']."'),
 ('site_capcha','1','".$loc['settings.site_capcha']."','".$loc['settings.site_capcha.desc']."','radiobuttons','".$loc['settings.site_capcha.values']."','security','6','".$loc['settings.category.capcha']."'),
 ('site_generate_promo_habbos','0','".$loc['settings.site_generate_promo_habbos']."','".$loc['settings.site_generate_promo_habbos.desc']."','radiobuttons','".$loc['settings.site_generate_promo_habbos.values']."','site','10','".$loc['settings.category.cache']."'),
 ('email_name','".SHORTNAME." USA','".$loc['settings.email_name']."','".$loc['settings.email_name.desc']."','textbox','','email','0','".$loc['settings.category.headers']."'),
 ('email_from','mailings@".strtolower(SHORTNAME).".com','".$loc['settings.email_from']."','".$loc['settings.email_from.desc']."','textbox','','email','1','".$loc['settings.category.headers']."'),
 ('site_promo_phrases','Virtual world, real fun|Create your ".SHORTNAME."...|...and make new friends :)','".$loc['settings.site_promo_phrases']."','".$loc['settings.site_promo_phrases.desc']."','textbox','','content','10','".$loc['settings.category.landing']."'),
 ('paper_disclaimer','Your disclaimer here.','".$loc['settings.paper_disclaimer']."','".$loc['settings.paper_disclaimer.desc']."','textarea','','content','11','".$loc['settings.category.papers']."'),
 ('paper_privacy','Your policy here.','".$loc['settings.paper_privacy']."','".$loc['settings.paper_privacy.desc']."','textarea','','content','12','".$loc['settings.category.papers']."'),
 ('site_highload','100','".$loc['settings.site_highload']."','".$loc['settings.site_highload.desc']."','textbox',null,'site','11','".$loc['settings.category.traffic']."'),
 ('version','','','','hidden','','','0','');";
$query[] = "insert into `".PREFIX."settings_pages` values('1','site','".$loc['settings.pages.site']."','".$loc['settings.pages.site.desc']."','site.png'),
 ('2','content','".$loc['settings.pages.content']."','".$loc['settings.pages.content.desc']."','content.png'),
 ('3','email','".$loc['settings.pages.email']."','".$loc['settings.pages.email.desc']."','email.png'),
 ('4','security','".$loc['settings.pages.security']."','".$loc['settings.pages.security.desc']."','security.png'),
 ('5','hotel','".$loc['settings.pages.hotel']."','".$loc['settings.pages.hotel.desc']."','hotel.png');";
return $query;
}
function strtotimestamp($str){
	$parts = explode(" ",$str);
	$date = explode("-",$parts[0]);
	$time = explode(":",$parts[1]);
	$timestamp = mktime((int) $time[0],(int) $time[1],(int) $time[2],(int) $date[1],(int) $date[0],(int) $date[2]);
	return $timestamp;
}
function tinker($array){
	foreach($array as &$item){
		$item = stripslashes($item);
		$item = mysql_real_escape_string($item);
	}
	return $array;
}
function migrateDB(){
	global $lang;
	define('SHORTNAME',$_SESSION['settings']['s_site_shortname']);
	define('PATH',$_SESSION['settings']['s_site_path']);
	define('PREFIX',$_SESSION['settings']['db_prefix']);
	$lang->addLocale("installer.installing");
	$lang->addLocale("installer.migrating");
	echo "<p>";
	define('IN_HOLOCMS', true);
	require('../install/config.php');
	require_once('../includes/classes.php');
	$db = new $conn['main']['server']($conn['main']);
	$GLOBALS['serverdb'] = $db;
	$queries = installTables();
	echo "<strong>".$lang->loc['creating.tables']."...</strong><br />";
	foreach($queries as $query){
		$db->query($query);
	}
	echo "<strong>".$lang->loc['migrating.alerts']."...</strong><br />";
	$db->query("INSERT INTO `new-".PREFIX."alerts` (id,userid,alert,`type`) SELECT id,userid,alert,`type` FROM cms_alerts");
	echo "<strong>".$lang->loc['migrating.banners']."...</strong><br />";
	$db->query("INSERT INTO `new-".PREFIX."banners` (id,`text`,banner,url,`status`,advanced,html) SELECT id,`text`,banner,url,`status`,advanced,html FROM cms_banners");
	echo "<strong>".$lang->loc['migrating.collectables']."...</strong><br />";
	$query = $db->query("SELECT title,image_small,image_large,tid,description,month,year FROM cms_collectables");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		$time = mktime(0,0,0,$row['month'],0,$row['year']);
		$db->query("INSERT INTO `new-".PREFIX."collectables` (image_small,image_large,furni_id,date) VALUES ('".$row['image_small']."','".$row['image_large']."','".$row['tid']."','".$time."')");
	}
	echo "<strong>".$lang->loc['migrating.forums']."...</strong><br />";
	$sql = $db->query("SELECT id FROM users WHERE rank = '7' LIMIT 1");
	$row = $db->fetch_assoc($sql);
	$admin = $row['id'];
	$db->query("INSERT INTO groups_details (name,description,ownerid,roomid,created,badge,type,forumtype,forumpremission,views,pane,alias) VALUES ('Forums','Discuss ".SHORTNAME." stuff here.','".$admin."','0','July 11, 2009','b1305Xs21118s63114','0','0','0','0','0','forums')");
	$forumid = $db->result($db->query("SELECT MAX(id) FROM groups_details"));
	$db->query("INSERT INTO groups_memberships (userid,groupid,member_rank,is_current,is_pending) VALUES ('".$admin."','".$forumid."','3','0','0')");
	$query = $db->query("SELECT id,`type`,title,author,unix,views,forumid FROM cms_forum_threads");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		$temp1 = $db->query("SELECT id FROM users WHERE name = '".$row['author']."' LIMIT 1");
		$temp2 = $db->fetch_row($temp1);
		$userid = $temp2[0];
		if($row['type'] == "1"){ $open = "1"; $sticky = "0"; }elseif($row['type'] == "2"){ $open = "0"; $sticky = "0"; }elseif($row['type'] == "3"){ $open = "1"; $sticky = "1"; }elseif($row['type'] == "4"){ $open = "0"; $sticky = "1"; }
		if($row['forumid'] == "0"){ $row['forumid'] = $forumid; }
		$db->query("INSERT INTO `new-".PREFIX."forum_threads` (id,starterid,title,open,sticky,views,groupid,time) VALUES ('".$row['id']."','".$userid."','".$row['title']."','".$open."','".$sticky."','".$row['views']."','".$row['forumid']."','".$row['unix']."')");
	}
	$query = $db->query("SELECT id,threadid,message,author,date,edit_date FROM cms_forum_posts");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		$temp1 = $db->query("SELECT id FROM users WHERE name = '".$row['author']."' LIMIT 1");
		$temp2 = $db->fetch_row($temp1);
		$userid = $temp2[0];
		if(!empty($row['edit_date'])){ $edittime = strtotimestamp($row['edit_date']); }else{ $edittime = ""; }
		$db->query("INSERT INTO `new-".PREFIX."forum_posts` (id,threadid,message,posterid,time,edit_time) VALUES ('".$row['id']."','".$row['threadid']."','".$row['message']."','".$userid."','".strtotimestamp($row['date'])."','".$edittime."')");
	}
	echo "<strong>".$lang->loc['migrating.guestbook']."...</strong><br />";
	$query = $db->query("SELECT cms_guestbook.id,cms_guestbook.message,cms_guestbook.time,cms_guestbook.userid,cms_homes_stickers.userid,cms_homes_stickers.groupid FROM cms_guestbook,cms_homes_stickers WHERE cms_guestbook.widget_id = cms_homes_stickers.id");
	while($row = $db->fetch_row($query)){
		$row = tinker($row);
		if($row[5] == "-1"){ $type = "user"; $ownerid = $row[4]; }else{ $type = "group"; $ownerid = $row[5]; }
		$db->query("INSERT INTO `new-".PREFIX."guestbook` (id,message,time,userid,ownerid,owner) VALUES ('".$row[0]."','".$row[1]."','".strtotimestamp($row[2])."','".$row[3]."','".$ownerid."','".$type."')");
	}
	echo "<strong>".$lang->loc['migrating.help']."...</strong><br />";
	$db->query("INSERT INTO `new-".PREFIX."help` (id,username,ip,message,date,picked_up,subject,roomid) SELECT id,username,ip,message,date,picked_up,subject,roomid FROM cms_help");
	echo "<strong>".$lang->loc['migrating.homes']."...</strong><br />";
	$query = $db->query("SELECT id,name,`type`,subtype,`data`,price,amount,category FROM cms_homes_catalouge");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		if($row['type'] != "1" && $row['type'] != "4"){ continue; }
		$categoryname = "Category ".$row['category'];
		$db->query("INSERT INTO `new-".PREFIX."homes_catalogue` (id,name,`desc`,`type`,`data`,price,category,categoryid,minrank,`where`) VALUES ('".$row['id']."','".$row['name']."',null,'".$row['type']."','".$row['data']."','".$row['price']."','".$categoryname."','".$row['category']."','1','0')");
	}
	global $max;
	$max = $db->result($db->query("SELECT MAX(id) FROM `new-".PREFIX."homes_catalogue`"));
	$category = $db->result($db->query("SELECT MAX(categoryid) FROM `new-".PREFIX."homes_catalogue`")); $category++;
	$lang->addLocale("installer.queries");
	function maxid($num){ return $GLOBALS['max'] + $num; }
	$category2 = $category + 1;
	$db->query("insert into `new-".PREFIX."homes_catalogue` values('".maxid(1)."','".$lang->loc['homes.profile.widget']."','".$lang->loc['homes.profile.widget.desc']."','2','profilewidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(2)."','".$lang->loc['homes.guestbook.widget']."','".$lang->loc['homes.guestbook.widget.desc']."','2','guestbookwidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(3)."','".$lang->loc['homes.scores.widget']."','".$lang->loc['homes.scores.widget.desc']."','2','highscoreswidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(4)."','".$lang->loc['homes.badges.widget']."','".$lang->loc['homes.badges.widget.desc']."','2','badgeswidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(5)."','".$lang->loc['homes.friends.widget']."','".$lang->loc['homes.friends.widget.desc']."','2','friendswidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(6)."','".$lang->loc['homes.groups.widget']."','".$lang->loc['homes.groups.widget.desc']."','2','groupswidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(7)."','".$lang->loc['homes.rooms.widget']."','".$lang->loc['homes.rooms.widget.desc']."','2','roomswidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(8)."','".$lang->loc['homes.trax.widget']."','".$lang->loc['homes.trax.widget.desc']."','2','traxplayerwidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','1'),
 ('".maxid(9)."','".$lang->loc['homes.ratings.widget']."','".$lang->loc['homes.ratings.widget.desc']."','2','ratingwidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','2','1'),
 ('".maxid(10)."','".$lang->loc['homes.groups.info.widget']."','".$lang->loc['homes.groups.info.widget.desc']."','2','groupinfowidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','-1'),
 ('".maxid(11)."','".$lang->loc['homes.groups.guestbook']."','".$lang->loc['homes.groups.guestbook.desc']."','2','guestbookwidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','-1'),
 ('".maxid(12)."','".$lang->loc['homes.groups.members']."','".$lang->loc['homes.groups.members.desc']."','2','memberwidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','-1'),
 ('".maxid(13)."','".$lang->loc['homes.groups.traxplayer']."','".$lang->loc['homes.groups.traxplayer.desc']."','2','traxplayerwidget','0','1','".$lang->loc['homes.widgets.category']."','".$category."','1','-1'),
 ('".maxid(14)."','".$lang->loc['homes.notes']."',null,'3','stickienote','2','5','".$lang->loc['homes.notes.category']."','".$category2."','1','0');");
 	$query = $db->query("SELECT userid,data,amount FROM cms_homes_inventory");
 	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
 		$temp1 = $db->query("SELECT id FROM `new-".PREFIX."homes_catalogue` WHERE data = '".$row['data']."' LIMIT 1");
 		$temp2 = $db->fetch_row($temp1);
 		$itemid = $temp2[0];
 		$i = 0;
 		while($i < (int) $row['amount']){
 			$db->query("INSERT INTO `new-".PREFIX."homes` (itemid,ownerid,location) VALUES ('".$itemid."','".$row['userid']."','-1')");
 			$i++;
 		}
 	}
 	$query = $db->query("SELECT userid,x,y,z,data,type,subtype,skin,groupid,var FROM cms_homes_stickers");
 	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
 		$temp1 = $db->query("SELECT id FROM `new-".PREFIX."homes_catalogue` WHERE data = '".$row['data']."' LIMIT 1");
 		if($db->num_rows($temp1) < 1){ $row['var'] = $row['data']; $itemid = maxid(14); }else{ $temp2 = $db->fetch_row($temp1); $itemid = $temp2[0]; }
 		if($row['groupid'] == "-1"){ $location = "0"; }else{ $location = $row['groupid']; }
 		if($row['type'] == "2"){
 			if($row['groupid'] == "-1"){
 				switch($row['subtype']){
 					case "1": $itemid = maxid(1); break;
					case "2": $itemid = maxid(6); break;
					case "3": $itemid = maxid(7); break;
					case "4": $itemid = maxid(2); break;
					case "5": $itemid = maxid(5); break;
					case "6": $itemid = maxid(8); break;
					case "7": $itemid = maxid(3); break;
					case "8": $itemid = maxid(4); break;
				}
			}else{
 				switch($row['subtype']){
 					case "1": $itemid = maxid(10); break;
					case "3": $itemid = maxid(12); break;
					case "4": $itemid = maxid(11); break;
					case "5": $itemid = maxid(13); break;
				}
			}
		}
		$db->query("INSERT INTO `new-".PREFIX."homes` (itemid,ownerid,x,y,z,skin,location,variable) VALUES ('".$itemid."','".$row['userid']."','".$row['x']."','".$row['y']."','".$row['z']."','".$row['skin']."','".$location."','".$row['var']."')");
	}
	echo "<strong>".$lang->loc['migrating.minimail']."...</strong><br />";
	$query = $db->query("SELECT senderid,to_id,subject,date,message,read_mail,id,deleted,conversationid FROM cms_minimail");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		$db->query("INSERT INTO `new-".PREFIX."minimail` (senderid,to_id,subject,time,message,read_mail,id,deleted,conversationid) VALUES ('".$row['senderid']."','".$row['to_id']."','".$row['subject']."','".strtotimestamp($row['date'])."','".$row['message']."','".$row['read_mail']."','".$row['id']."','".$row['deleted']."','".$row['conversationid']."')");
	}
	echo "<strong>".$lang->loc['migrating.news']."...</strong><br />";
	$query = $db->query("SELECT num,title,category,topstory,short_story,story,date,author FROM cms_news");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		$date = explode("-",$row['date']);
		$time = mktime(0,0,0,$date[1],$date[2],$date[0]);
		$db->query("INSERT INTO `new-".PREFIX."news` (id,title,categories,header_image,summary,story,time,author,images) VALUES ('".$row['num']."','".$row['title']."','".$row['category']."','".$row['topstory']."','".$row['short_story']."','".$row['story']."','".$time."','".$row['author']."',null)");
	}
	echo "<strong>".$lang->loc['migrating.recommended']."...</strong><br />";
	$db->query("INSERT INTO `new-".PREFIX."recommended` (id,rec_id,type) SELECT id,rec_id,type FROM cms_recommended");
	echo "<strong>".$lang->loc['migrating.tags']."...</strong><br />";
	$db->query("INSERT INTO `new-".PREFIX."tags` (id,ownerid,tag) SELECT id,ownerid,tag FROM cms_tags");
	echo "<strong>".$lang->loc['migrating.transactions']."...</strong><br />";
	$query = $db->query("SELECT id,date,amount,descr,userid FROM cms_transactions");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		$db->query("INSERT INTO `new-".PREFIX."transactions` (id,time,amount,descr,userid) VALUES ('".$row['id']."','".strtotimestamp($row['date'])."','".$row['amount']."','".$row['descr']."','".$row['userid']."')");
	}
	echo "<strong>".$lang->loc['migrating.email.verification']."...</strong><br />";
	$db->query("INSERT INTO `new-".PREFIX."verify` (id,email,key_hash) SELECT id,email,key_hash FROM cms_verify");
	echo "<strong>".$lang->loc['migrating.wardrobe']."...</strong><br />";
	$db->query("INSERT INTO `new-".PREFIX."wardrobe` (userid,slotid,figure,gender) SELECT userid,slotid,figure,gender FROM cms_wardrobe");
	echo "<strong>".$lang->loc['filling.in.users']."...</strong><br />";
	$query = $db->query("SELECT id,name,email,lastvisit,ipaddress_last,newsletter,email_verified FROM users");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		$db->query("INSERT INTO `new-".PREFIX."users` (id,name,ipaddress_last,lastvisit,online,newsletter,email_verified,show_home,email_friendrequest,email_minimail,show_online,email) VALUES ('".$row['id']."','".$row['name']."','".$row['ipaddress_last']."','".strtotimestamp($row['lastvisit'])."','".strtotimestamp($row['lastvisit'])."','".$row['newsletter']."','".$row['email_verified']."','1','1','1','1','".$row['email']."')");
	}
	echo "<strong>".$lang->loc['migrating.settings']."...</strong><br />";
	$queries = installQueries();
	foreach($queries as $query){
		$db->query($query);
	}
	$query = $db->query("SELECT contentkey,contentvalue FROM cms_content");
	while($row = $db->fetch_assoc($query)){
		$row = tinker($row);
		switch($row['contentkey']){
			case "enable-flash-promo": $_SESSION['settings']['s_site_flash_promo'] = $row['contentvalue']; break;
			case "allow-guests": $_SESSION['settings']['s_site_allow_guests'] = $row['contentvalue']; break;
			case "newsletter-3from": $_SESSION['settings']['s_email_name'] = $row['contentvalue']; break;
			case "newsletter-4fromname": $_SESSION['settings']['s_email_from'] = $row['contentvalue']; break;
			default: continue; break;
		}
	}
	$query = $db->query("SELECT * FROM cms_system LIMIT 1");
	$row = $db->fetch_assoc($query);
	$_SESSION['settings']['s_site_name'] = $row['sitename'];
	$_SESSION['settings']['s_site_shortname'] = $row['shortname'];
	$_SESSION['settings']['s_site_closed'] = $row['site_closed'];
	$_SESSION['settings']['s_hotel_ip'] = $row['ip'];
	$_SESSION['settings']['s_hotel_port'] = $row['port'];
	$_SESSION['settings']['s_client_external_texts'] = $row['texts'];
	$_SESSION['settings']['s_client_external_variables'] = $row['variables'];
	$_SESSION['settings']['s_client_dcr'] = $row['dcr'];
	$_SESSION['settings']['s_register_start_credits'] = $row['start_credits'];
	$_SESSION['settings']['s_hk_notes'] = $row['admin_notes'];
	$_SESSION['settings']['s_site_tracking'] = $row['analytics'];
	echo "<strong>".$lang->loc['removing.old.content']."...</strong><br />";
	$query = $db->query("SHOW tables");
	while($row = $db->fetch_row($query)){
		if (substr($row[0], 0, 4) == "cms_"){
			$db->query("DROP TABLE `".$row[0]."`");
		}
	}
	$query = $db->query("SHOW tables");
	while($row = $db->fetch_row($query)){
		if (substr($row[0], 0, 4) == "new-"){
			$name = substr($row[0], 4);
			$db->query("RENAME TABLE `".$row[0]."` TO `".$name."`");
		}
	}
	@unlink('../config.php');
	echo "<strong>".$lang->loc['updating.settings']."...</strong><br />";
	$queries = installQueries($_SESSION['settings']['db_prefix'],$loc);
	foreach($queries as $query){
		$db->query($query);
	}
	foreach($_SESSION['settings'] as $key => $value){
		if(substr($key, 0, 2) == "s_"){
			$key = substr($key, 2);
			$db->query("UPDATE ".PREFIX."settings SET value = '".$value."' WHERE id = '".$key."' LIMIT 1");
		}
	}
	echo "<strong>".$lang->loc['modifying.hotel.database']."...</strong><br />";
	require('../includes/data/holograph.php');
	$data = new installer_sql;
	$data->alter1();
	echo "<strong>".$lang->loc['generating.cache']."...</strong><br />";
	$page['old'] = getcwd();
	$page['dir'] = '\install';
	if(strpos($_SERVER['SERVER_SOFTWARE'],"Win") == false){ $page['dir'] = str_replace('\\','/',$page['dir']); }
	chdir(str_replace($page['dir'], "", getcwd()));
	$GLOBALS['db'] = $db;
	$GLOBALS['input'] = new HoloInput();
	$settings = new HoloSettings();
	$settings->generateCache();
	$fh = @fopen('./cache/status.ret', 'w');
	@fwrite($fh, "<?php\n"."$"."status['bypass'] = true;\n?>");
	@fclose($fh);
	chdir($page['old']);
	echo "<strong>".$lang->loc['done'].".</strong><br />";
	/*
	echo 
'
<script type="text/javascript">
<!--
function delayer(){
    window.location = "./?installed=success"
}
setTimeout(\'delayer()\', 5000)
//-->
</script>
';
	echo '<a href="./?installed=success">'.$lang->loc['not.redirected'].'...</a></p>';
	*/
}
?>