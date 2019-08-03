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
//	These are the settings required to connect to your Database.
'.'$'.'conn[\'main\'][\'prefix\'] = "'.$db['db_prefix'].'";
'.'$'.'conn[\'main\'][\'server\'] = "'.$db['db_server'].'"; //mysql, pgsql, sqlite, or mssql
'.'$'.'conn[\'main\'][\'host\'] = "'.$db['db_host'].'"; //filename for SQLite
'.'$'.'conn[\'main\'][\'port\'] = "'.$db['db_port'].'";
'.'$'.'conn[\'main\'][\'username\'] = "'.$db['db_username'].'";
'.'$'.'conn[\'main\'][\'password\'] = "'.$db['db_password'].'";
'.'$'.'conn[\'main\'][\'database\'] = "'.$db['db_name'].'";

//	****** HOTEL DATABASE SETTINGS ******
//  EXPERIMENTAL!! Only turn this on if you know what to do. Please submit all
//  bugs and your fix for them (if possible) to http://code.google.com/p/phpretro
//	These are the settings required to connect to your hotel database Database.
'.'$'.'conn[\'server\'][\'enabled\'] = false;
'.'$'.'conn[\'server\'][\'server\'] = "'.$db['db_server'].'"; //mysql, pgsql, sqlite, or mssql
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
$query = array();
$query[] = "DROP TABLE IF EXISTS `".PREFIX."alerts`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."banners`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."campaigns`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."client_errors`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."collectables`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."faq`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."forum_posts`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."forum_threads`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."guestbook`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."help`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."homes`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."homes_catalogue`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."homes_edit`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."minimail`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."news`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."ratings`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."recommended`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."settings`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."settings_pages`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."tags`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."transactions`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."users`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."verify`;";
$query[] = "DROP TABLE IF EXISTS `".PREFIX."wardrobe`;";
$query[] = "CREATE TABLE `".PREFIX."alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `alert` text NOT NULL,
  `type` enum('1','0','-1','2') NOT NULL DEFAULT '1',
  `time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."banners` (
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
$query[] = "CREATE TABLE `".PREFIX."campaigns` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` text,
  `visible` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."client_errors` (
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
$query[] = "CREATE TABLE `".PREFIX."collectables` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `image_small` varchar(255) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `furni_id` int(20) NOT NULL DEFAULT '0',
  `date` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."faq` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` enum('item','cat') NOT NULL DEFAULT 'item',
  `catid` int(11) DEFAULT NULL,
  `title` varchar(1000) NOT NULL,
  `content` text,
  `show_in_footer` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."forum_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `threadid` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `posterid` int(25) NOT NULL,
  `time` int(10) NOT NULL,
  `edit_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."forum_threads` (
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
$query[] = "CREATE TABLE `".PREFIX."guestbook` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `message` text,
  `time` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `ownerid` int(10) DEFAULT NULL,
  `owner` enum('user','group') DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`ownerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."help` (
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
$query[] = "CREATE TABLE `".PREFIX."homes` (
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
$query[] = "CREATE TABLE `".PREFIX."homes_catalogue` (
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
$query[] = "CREATE TABLE `".PREFIX."homes_edit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` int(11) NOT NULL,
  `editorid` int(11) NOT NULL,
  `type` enum('group','user') NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."minimail` (
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
$query[] = "CREATE TABLE `".PREFIX."news` (
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
$query[] = "CREATE TABLE `".PREFIX."ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `raterid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."recommended` (
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
$query[] = "CREATE TABLE `".PREFIX."settings` (
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
$query[] = "CREATE TABLE `".PREFIX."settings_pages` (
  `order` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."tags` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(25) NOT NULL,
  `type` enum('user','group') DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `descr` text NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."users` (
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
$query[] = "CREATE TABLE `".PREFIX."verify` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `key_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$query[] = "CREATE TABLE `".PREFIX."wardrobe` (
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
$query[] = "insert into `".PREFIX."homes_catalogue` values('101','".$loc['homes.profile.widget']."','".$loc['homes.profile.widget.desc']."','2','profilewidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('102','".$loc['homes.guestbook.widget']."','".$loc['homes.guestbook.widget.desc']."','2','guestbookwidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('103','".$loc['homes.scores.widget']."','".$loc['homes.scores.widget.desc']."','2','highscoreswidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('104','".$loc['homes.badges.widget']."','".$loc['homes.badges.widget.desc']."','2','badgeswidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('105','".$loc['homes.friends.widget']."','".$loc['homes.friends.widget.desc']."','2','friendswidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('106','".$loc['homes.groups.widget']."','".$loc['homes.groups.widget.desc']."','2','groupswidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('107','".$loc['homes.rooms.widget']."','".$loc['homes.rooms.widget.desc']."','2','roomswidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('108','".$loc['homes.trax.widget']."','".$loc['homes.trax.widget.desc']."','2','traxplayerwidget','0','1','".$loc['homes.widgets.category']."','100','1','1'),
 ('109','".$loc['homes.ratings.widget']."','".$loc['homes.ratings.widget.desc']."','2','ratingwidget','0','1','".$loc['homes.widgets.category']."','100','2','1'),
 ('110','".$loc['homes.groups.info.widget']."','".$loc['homes.groups.info.widget.desc']."','2','groupinfowidget','0','1','".$loc['homes.widgets.category']."','100','1','-1'),
 ('111','".$loc['homes.groups.guestbook']."','".$loc['homes.groups.guestbook.desc']."','2','guestbookwidget','0','1','".$loc['homes.widgets.category']."','100','1','-1'),
 ('112','".$loc['homes.groups.members']."','".$loc['homes.groups.members.desc']."','2','memberwidget','0','1','".$loc['homes.widgets.category']."','100','1','-1'),
 ('113','".$loc['homes.groups.traxplayer']."','".$loc['homes.groups.traxplayer.desc']."','2','traxplayerwidget','0','1','".$loc['homes.widgets.category']."','100','1','-1'),
 ('114','".$loc['homes.notes']."',null,'3','stickienote','2','5','".$loc['homes.notes.category']."','101','1','0'),
 ('116','Trax Sfx',null,'1','trax_sfx','1','1','Trax','102','1','0'),
 ('117','Trax Rock',null,'1','trax_rock','1','2','Trax 2','103','1','0'),
 ('118','Wood Background',null,'4','bg_wood','3','1','Backgrounds','104','1','0');";
$query[] = "insert into `".PREFIX."news` values('1','No news','Installed','./web-gallery/images/top-story/TS_Web60[1].png','No news yet.','No news yet.','1234567890','Yifan',null),
 ('2','No news','Installed','./web-gallery/images/top-story/credits.png','No news yet.','No news yet.','1234567891','Yifan',null),
 ('3','No news','Installed','./web-gallery/images/top-story/attention_topstory[1].png','No news yet.','No news yet.','1234567892','Yifan',null),
 ('4','Found a bug?','Installed','./web-gallery/images/top-story/bluecallie.gif','Submit it to http://code.google.com/p/phpretro','No news yet.','1234567893','Yifan',null),
 ('5','Welcome To PHPRetro!','Installed','./web-gallery/images/top-story/construction.png','Create a new news article via Housekeeping','No news yet.','1234567894','Yifan',null);";
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
function installDB(){
	@set_time_limit(0);
	global $lang;
	define('SHORTNAME',$_SESSION['settings']['s_site_shortname']);
	define('PATH',$_SESSION['settings']['s_site_path']);
	define('PREFIX',$_SESSION['settings']['db_prefix']);
	$lang->addLocale("installer.installing");
	echo "<p>";
	define('IN_HOLOCMS', true);
	require_once('../install/config.php');
	require_once('../includes/classes.php');
	require_once('../includes/functions.php');
	$input = new HoloInput();
	$db = new $conn['main']['server']($conn['main']);
	$GLOBALS['serverdb'] = $db;
	$queries = installTables();
	echo "<strong>".$lang->loc['creating.tables']."...</strong><br />";
	foreach($queries as $query){
		$db->query($query);
	}
	echo "<strong>".$lang->loc['inserting.queries']."...</strong><br />";
	$queries = installQueries();
	foreach($queries as $query){
		$db->query($query);
	}
	echo "<strong>".$lang->loc['updating.settings']."...</strong><br />";
	foreach($_SESSION['settings'] as $key => $value){
		if(substr($key, 0, 2) == "s_"){
			$key = substr($key, 2);
			$db->query("UPDATE ".PREFIX."settings SET value = '".$value."' WHERE id = '".$key."' LIMIT 1");
		}
	}
	echo "<strong>".$lang->loc['modifying.hotel.database']."...</strong><br />";
	require('../includes/data/'.$_SESSION['settings']['s_hotel_server'].'.php');
	$data = new installer_sql;
	$data->alter1();
	$data->delete1();
	echo "<strong>".$lang->loc['creating.administrator.account']."...</strong><br />";
	$password = $input->HoloHash($_SESSION['settings']['admin_password'],$_SESSION['settings']['admin_username']);
	$data->insert1($input->FilterText($_SESSION['settings']['admin_username']),$password);
	$id = $GLOBALS['serverdb']->insert_id();
	$data->insert2($id,$input->FilterText($_SESSION['settings']['admin_username']),$input->FilterText($_SESSION['settings']['admin_email']));
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