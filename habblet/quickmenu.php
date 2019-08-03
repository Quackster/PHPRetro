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

$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');
$data = new header_footer_sql;
$lang->addLocale("quickmenu");

switch($_GET['key']){
	case "friends_all": $mode = 1; break;
	case "groups": $mode = 2; break;
	case "rooms": $mode = 3; break;
}

$sql = $data->select1($mode, $user->id, $user->name);
$i = 0;
	if($db->num_rows($sql) > 0){
		switch($mode){
			case 1:
				$sql2 = $data->select1($mode, $user->id, $user->name, 1800);
				if($db->num_rows($sql2) > 0){
					echo "<ul id=\"online-friends\">\n";
					while ($row = $db->fetch_row($sql2)){
						$i++;
						if($input->IsEven($i)){ $even = "odd"; } else { $even = "even"; }
						printf("        <li class=\"%s\"><a href=\"".PATH."/home/%s\">%s</a></li>\n",$even,$input->HoloText($row[1]),$input->HoloText($row[1]));
					}
					echo "\n</ul>";
				}
				$sql2 = $data->select1($mode, $user->id, $user->name, -1800);
				if($db->num_rows($sql2) > 0){
					echo "<ul id=\"offline-friends\">\n";
					while ($row = $db->fetch_row($sql2)){
						$i++;
						if($input->IsEven($i)){ $even = "odd"; } else { $even = "even"; }
						printf("        <li class=\"%s\"><a href=\"".PATH."/home/%s\">%s</a></li>\n",$even,$input->HoloText($row[1]),$input->HoloText($row[1]));
					}
					echo "\n</ul>";
				}
				break;
			case 2:
				echo "<ul id=\"quickmenu-groups\">\n";
				while($row = $db->fetch_row($sql)){
					$i++;
					echo "<li class=\"";
					if($input->IsEven($i)){ echo "odd"; } else { echo "even"; }
					echo "\">";
					if($row[5] != "0"){ echo "<a href=\"".PATH."/client?forwardId=2&amp;roomId=".$row[5]."\" onclick=\"HabboClient.roomForward(this, '".$row[5]."', 'private'); return false;\" target=\"client\" class=\"group-room\" title=\"".$lang->loc['group.room']."\"></a>"; }
					if($row[2] == 1){ echo "<div class=\"favourite-group\" title=\"".$lang->loc['favorite']."\"></div>\n"; }
					if($row[3] > 1 && $row[4] != $user->id){ echo "<div class=\"admin-group\" title=\"".$lang->loc['administrator']."\"></div>\n"; }
					if($row[3] > 1 && $row[4] == $user->id){ echo "<div class=\"owned-group\" title=\"".$lang->loc['owner']."\"></div>\n"; }
					echo "\n<a href=\"".groupURL($row[0])."\">".$input->HoloText($row[1])."</a>\n</li>";
				}
				echo "\n</ul>\n";
				echo "<p class=\"create-group\"><a href=\"#\" onclick=\"GroupPurchase.open(); return false;\">".$lang->loc['create.group']."</a></p>";
				break;
			case 3:
				echo "<ul id=\"quickmenu-rooms\">\n";
				while ($row = $db->fetch_row($sql)){
					$i++;
					if($input->IsEven($i)){ $even = "odd"; } else { $even = "even"; }
					printf("        <li class=\"%s\"><a href=\"".PATH."/client?forwardId=2&amp;roomId=%s\" onclick=\"roomForward(this, '%s', 'private'); return false;\" target=\"client\" id=\"room-navigation-link_%s\">%s</a></li>\n",$even,$row[0],$row[0],$row[0],$input->unicodeToImage($input->HoloText($row[1])));
				}
				echo "\n</ul>\n";
				echo "<p class=\"create-room\"><a href=\"".PATH."/client?shortcut=roomomatic\" onclick=\"HabboClient.openShortcut(this, 'roomomatic'); return false;\" target=\"client\">".$lang->loc['create.room']."</a></p>";
				break;
		}
	} else {
		switch($mode){
			case 1:
				echo "<ul id=\"quickmenu-friends\">\n	<li class=\"odd\">".$lang->loc['no.friends']."</li>\n</ul>";
				break;
			case 2:
				echo "<ul id=\"quickmenu-groups\">\n	<li class=\"odd\">".$lang->loc['no.groups']."</li>\n</ul>\n";
				echo "<p class=\"create-group\"><a href=\"#\" onclick=\"GroupPurchase.open(); return false;\">".$lang->loc['create.group']."</a></p>";
				break;
			case 3:
				echo "<ul id=\"quickmenu-rooms\">\n	<li class=\"odd\">".$lang->loc['no.rooms']."</li>\n</ul>\n";
				echo "<p class=\"create-room\"><a href=\"".PATH."/client?shortcut=roomomatic\" onclick=\"HabboClient.openShortcut(this, 'roomomatic'); return false;\" target=\"client\">".$lang->loc['create.room']."</a></p>";
				break;
		}
	}
?>