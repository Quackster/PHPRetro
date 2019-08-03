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

if(!defined("IN_HOLOCMS")) { header("Location: ".PATH); exit; }

class HoloInput {
	function FilterText($str) {
		if(get_magic_quotes_gpc()){ $str = stripslashes($str); }
		$str = preg_replace(array('/\x{0001}/u','/\x{0002}/u','/\x{0003}/u','/\x{0005}/u','/\x{0009}/u'),' ',$str);
		if($GLOBALS['conn']['main']['server'] == "mysql" || $GLOBALS['conn']['server']['server'] == "mysql"){ $str = mysql_real_escape_string($str); }else{ $str = addslashes($str); }
		return $str;
	}
	function HoloText($str, $advanced=false) {
		$str = stripslashes($str);
		if($advanced != true){ $str = htmlspecialchars($str,ENT_COMPAT,"UTF-8"); }
		return $str;
	}
	function stringToURL($str,$lowercase=true,$spaces=false){
		$str = trim(preg_replace('/\s\s+/',' ',preg_replace("/[^A-Za-z0-9-]/", " ", $str)));
		if($lowercase == true){ $str = strtolower($str); }
		if($spaces == true){ $str = str_replace(" ", "-", $str); }else{ str_replace(" ", "", $str); }
		return $str;
	}
	function HoloHash($password, $username){
		$string = sha1($password.strtolower($username));
		return $string;
	}
	function IsEven($intNumber)
	{
		if($intNumber % 2 == 0){
			return true;
		} else {
			return false;
		}
	}
	function unicodeToImage($str){
		$search = array(
						//'/\x{007c}/u',
						'/\x{00a5}/u',
						'/\x{00aa}/u',
						'/\x{00ac}/u',
						'/\x{00b1}/u',
						'/\x{00b5}/u',
						'/\x{00b6}/u',
						'/\x{00ba}/u',
						'/\x{00bb}/u',
						//'/\x{00cc}/u',
						//'/\x{00cd}/u',
						'/\x{00d5}/u',
						'/\x{00f5}/u',
						'/\x{00f7}/u',
						'/\x{0192}/u',
						'/\x{2014}/u',
						//'/\x{2018}/'u,
						'/\x{2020}/u',
						'/\x{2021}/u',
						'/\x{2022}/u'
						);
		$replace = array(
						//'<img src="'.PATH.'/web-gallery/images/fonts/volter/white_heart.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/165.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/170.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/172.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/177.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/181.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/182.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/186.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/187.gif" class="vchar" />',
						//'<img src="'.PATH.'/web-gallery/images/fonts/volter/white_padlock.gif" class="vchar" />',
						//'<img src="'.PATH.'/web-gallery/images/fonts/volter/single_music_note.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/213.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/245.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/247.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/131.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/151.gif" class="vchar" />',
						//'<img src="'.PATH.'/web-gallery/images/fonts/volter/black_padlock.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/134.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/135.gif" class="vchar" />',
						'<img src="'.PATH.'/web-gallery/images/fonts/volter/149.gif" class="vchar" />'
						);
		$str = preg_replace($search,$replace,$str);
		return $str;
	}
	function bbcode_format($str){

		// Parse smilies
			$smilies = array(":)",";)",":P",";P",":p",";p","(L)","(l)",":o",":O");
			$smilies_replace = array(
			" <img src='".PATH."/web-gallery/smilies/smile.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/wink.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/tongue.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/winktongue.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/tongue.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/winktongue.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/heart.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/heart.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/shocked.gif' alt='Smiley' title='Smiley' border='0'> ",
			" <img src='".PATH."/web-gallery/smilies/shocked.gif' alt='Smiley' title='Smiley' border='0'> ");
		$str = str_replace($smilies,$smilies_replace,$str);

		// Parse BB code
	        $simple_search = array(
	                                '/\[b\](.*?)\[\/b\]/is',
	                                '/\[i\](.*?)\[\/i\]/is',
	                                '/\[u\](.*?)\[\/u\]/is',
	                                '/\[s\](.*?)\[\/s\]/is',
	                                '/\[quote\](.*?)\[\/quote\]/is',
	                                '/\[link\=(.*?)\](.*?)\[\/link\]/is',
	                                '/\[url\=(.*?)\](.*?)\[\/url\]/is',
	                                '/\[color\=(.*?)\](.*?)\[\/color\]/is',
	                                '/\[size=small\](.*?)\[\/size\]/is',
	                                '/\[size=large\](.*?)\[\/size\]/is',
	                                '/\[code\](.*?)\[\/code\]/is',
	                                '/\[habbo\=(.*?)\](.*?)\[\/habbo\]/is',
	                                '/\[room\=(.*?)\](.*?)\[\/room\]/is',
	                                '/\[group\=(.*?)\](.*?)\[\/group\]/is'
	                                );

	        $simple_replace = array(
	                                "<b>$1</b>",
	                                "<i>$1</i>",
	                                "<u>$1</u>",
	                                "<s>$1</s>",
	                                "<div class=\"bbcode-quote\">$1</div>",
	                                "<a href=\"$1\">$2</a>",
	                                "<a href=\"$1\">$2</a>",
	                                "<span style=\"color: $1;\">$2</span>",
	                                "<span style=\"font-size: 9px;\">$1</span>",
	                                "<span style=\"font-size: 14px;\">$1</span>",
	                                "<pre>$1</pre>",
	                                "<a href=\"".PATH."/home/$1/id\">$2</a>",
	                                "<a onclick=\"roomForward(this, '$1', 'private'); return false;\" target=\"client\" href=\"".PATH."/client?forwardId=2&roomId=$1\">$2</a>",
	                                "<a href=\"".PATH."/groups/$1/id\">$2</a>"
	                                );

	        $str = preg_replace ($simple_search, $simple_replace, $str);

	        return $str;
	}
}
class HoloUser {
	var $id = 0; var $name = "Guest"; var $password = null; var $logged_in = false; var $ip = null; var $time = null;
	var $error = 0; var $banned; var $user = array('0','Guest','null','0',null,null,null,null,null,null,null,null,null);
	function HoloUser($name,$password,$updateuser=false,$rememberme=null){
		$data = new index_sql;
		$date = HoloDate();
		if(empty($name) || empty($password)){
			$this->error = 1; return false;
		}
		if($GLOBALS['serverdb']->num_rows($data->select1($name, $password)) < 1){
			$this->error = 2; return false;
		}
		$id = $GLOBALS['serverdb']->result($data->select1($name, $password));
		if($this->IsUserBanned($id) == true){
			$row = $GLOBALS['serverdb']->fetch_row($GLOBALS['core']->select2($id));
			$this->banned['reason'] = $row[0];
			$this->banned['expire'] = $row[1];
			$this->error = 3; return false;
		}
		if($this->error == 0 && !is_array($this->banned)){
			$this->ip = $_SERVER['REMOTE_ADDR'];
			if($rememberme == "true"){
				$token = GenerateTicket("remember");
				$GLOBALS['serverdb']->query("UPDATE ".PREFIX."users SET remember_token = '".$token."' WHERE id = '".$id."' LIMIT 1");
				setcookie("rememberme", "true", time()+60*60*24*$GLOBALS['settings']->find("site_cookie_time"), "/");
				setcookie("rememberme_token", $token, time()+60*60*24*$GLOBALS['settings']->find("site_cookie_time"), "/");
			}
			if($updateuser == true){ $this->updateUser($id); }
			$this->user = $GLOBALS['serverdb']->fetch_row($GLOBALS['core']->select3($id)); $this->id = $id; $this->name = $this->user("name"); $this->figure = $this->user("figure"); $this->password = $password; $this->logged_in = true;
		}
		$this->time = time();
		return true;
	}
	function destroy(){
		@session_start();
		setcookie("rememberme", "", time()-60*60*24*100, "/"); setcookie("cookpass", "", time()-60*60*24*100, "/");
		setcookie("rememberme_token", "", time()-60*60*24*100, "/"); setcookie("cookpass", "", time()-60*60*24*100, "/");
		$_SESSION = array();
		if(isset($_COOKIE[session_name()])) { setcookie(session_name(), "", time()-60*60*24*100, "/"); }
		@session_destroy();
		return true;
	}
	function refresh(){
		$GLOBALS['user'] = new HoloUser($this->name,$this->password);
		$_SESSION['user'] = $GLOBALS['user'];
		return true;
	}
	function user($key){
		switch($key){
			case "id":
				$value = $this->user[0]; break;
			case "name":
				$value = $this->user[1]; break;
			case "password":
				$value = $this->user[2]; break;
			case "rank":
				$value = $this->user[3]; break;
			case "birth":
				$value = $this->user[5]; break;
			case "figure":
				$value = $this->user[6]; break;
			case "sex":
				$value = $this->user[7]; break;
			case "mission":
				$value = $this->user[8]; break;
			case "credits":
				$value = $this->user[9]; break;
			case "tickets":
				$value = $this->user[10]; break;
			case "ticket_sso":
				$value = $this->user[11]; break;
			case "pixels":
				$value = $this->user[12]; break;
			default:
				$value = $GLOBALS['serverdb']->result($GLOBALS['serverdb']->query("SELECT ".$key." FROM ".PREFIX."users WHERE id = '".$this->user[0]."' LIMIT 1")); break;
		}
		return $value;
	}
	function avatarURL($figure,$style,$return = 0){
		if($figure == "self"){ $figure = $this->figure; }
		$figure = $GLOBALS['input']->HoloText($figure);
		$hash = md5($figure.strtolower($style));
		$style = explode(",", $style);
		if($style[0] == "s"){ $style[6] = "1"; }else{ $style[6] = "0"; }
		if($style[3] == "sml"){ $style[7] = "1"; }else{ $style[7] = "0"; }
		$expandedstyle = "s-".$style[6].".g-".$style[7].".d-".$style[1].".h-".$style[2].".a-0";
		if($GLOBALS['settings']->find("site_cache_images") == "1" && file_exists("./cache/avatars/".$figure.",".$expandedstyle.",".$hash.".png")){
			$URL = PATH."/habbo-imaging/avatar/".$figure.",".$expandedstyle.",".$hash.".gif";
		}elseif($GLOBALS['settings']->find("site_cache_images") == "1" && !file_exists("./cache/avatars/".$figure.",".$expandedstyle.",".$hash.".png")){
			$URL = "http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=".$figure."&size=".$style[0]."&direction=".$style[1]."&head_direction=".$style[2]."&crr=".$style[5]."&gesture=".$style[3]."&frame=".$style[4];
			$i = file_get_contents($URL);
			$f = fopen("./cache/avatars/".$figure.",".$expandedstyle.",".$hash.".png","w+");
			fwrite($f,$i);
			fclose($f);
			$URL = PATH."/habbo-imaging/avatar/".$figure.",".$expandedstyle.",".$hash.".gif";
		}elseif($GLOBALS['settings']->find("site_cache_images") == "0"){
			$URL = "http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=".$figure."&size=".$style[0]."&direction=".$style[1]."&head_direction=".$style[2]."&crr=".$style[5]."&gesture=".$style[3]."&frame=".$style[4];
		}
		if($return == 0){ return $URL; }else{ return $hash; }
	}
	function updateUser($id){
		$lastvisit = $GLOBALS['db']->result($GLOBALS['db']->query("SELECT online FROM ".PREFIX."users WHERE id = '".$id."' LIMIT 1"));
		$GLOBALS['db']->query("UPDATE ".PREFIX."users SET lastvisit = '".$lastvisit."', online = '".time()."', ipaddress_last = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$id."' LIMIT 1");
		$GLOBALS['core']->update5(GenerateTicket("sso"), $id);
		$GLOBALS['core']->update6($id, date('d-m-Y H:i:s'));
	}
	function GetUserBadge($id){
		if($id == "self"){ $id = $this->id; }
		$id = $GLOBALS['input']->FilterText($id);
		if($GLOBALS['serverdb']->num_rows($GLOBALS['core']->select5($id)) > 0){
			return $GLOBALS['serverdb']->result($GLOBALS['core']->select5($id));
		} else {
			return false;
		}
	}
	function GetUserGroup($id){
		if($id == "self"){ $id = $this->id; }
		if($GLOBALS['serverdb']->num_rows($GLOBALS['core']->select6($id)) > 0){
			return $GLOBALS['serverdb']->result($GLOBALS['core']->select6($id));
		} else {
			return false;
		}
	}
	function GetUserGroupBadge($id){
		if($id == "self"){ $id = $this->id; }
		if($GLOBALS['serverdb']->num_rows($GLOBALS['core']->select6($id)) > 0){
			return $GLOBALS['serverdb']->result($GLOBALS['core']->select7($GLOBALS['serverdb']->result($GLOBALS['core']->select6($id))));
		} else {
			return false;
		}
	}
	function HCDaysLeft($id){
		if($id == "self"){ $id = $this->id; }
		if($GLOBALS['serverdb']->num_rows($GLOBALS['core']->select8($id)) > 0){
			$days_left = $GLOBALS['serverdb']->result($GLOBALS['core']->select8($id)) * 31;
			$tmp = explode("-", $GLOBALS['serverdb']->result($GLOBALS['core']->select8($id), 0, 1));
			$day = $tmp[0];
			$month = $tmp[1];
			$year = $tmp[2];
			$then = mktime(0, 0, 0, $month, $day, $year, 0);
			$now = time();
			$difference = $now - $then;
			if ($difference < 0){
				$difference = 0;
			}
			$days_expired = floor($difference/60/60/24);
			$days_left = $days_left - $days_expired;
			return $days_left;
		} else {
			return 0;
		}
	}
	function IsHCMember($id){
		if($id == "self"){ $id = $this->id; }
	    if($this->HCDaysLeft($id) > 0 ){
	        return true;
	    } else {
	        if($GLOBALS['serverdb']->result($GLOBALS['core']->select9($id)) > 0){
				$GLOBALS['core']->update2($id);
	            @SendMUSData('UPRS' . $id);
	        }
	        return false;
	    }
	}
	function GiveHC($id, $months){
		if($id == "self"){ $id = $this->id; }
		if($GLOBALS['serverdb']->result($GLOBALS['core']->select9($id)) > 0){
			$GLOBALS['core']->update3($id, $months);
			if($GLOBALS['serverdb']->result($GLOBALS['core']->select11($id)) < 1){
				$GLOBALS['core']->update4($id);
			}
		} else {
			$m = date('m');
			$d = date('d');
			$Y = date('Y');
			$date = date('d-m-Y', mktime($m,$d,$Y));
			$GLOBALS['core']->insert1($id, $date);
			$this->GiveHC($id, $months);
		}
		@SendMUSData('UPRS' . $id);
		@SendMUSData('UPRC' . $id);
	}
	function IsUserOnline($id){
		if($id == "self"){ $id = $this->id; }
		$timeout = ((int) $GLOBALS['settings']->find("site_session_time")) * 60;
		$sql = $GLOBALS['db']->query("SELECT online,show_online FROM ".PREFIX."users WHERE id = '".$id."' LIMIT 1");
		if($GLOBALS['db']->result($sql, 0, 1) == 0){
			return false;
		}else{
			if($GLOBALS['db']->result($sql) + $timeout >= time()){
				return true;
			} else {
				return false;
			}
		}
	}
	function IsUserBanned($id){
		if($id == "self"){ $id = $this->id; }
		if(!is_numeric($id)){ return false; }
		if($GLOBALS['serverdb']->num_rows($GLOBALS['core']->select2($id)) > 0){
			$xbits = explode(" ", $GLOBALS['serverdb']->result($GLOBALS['core']->select2($id), 0, 1));
			$xtime = explode(":", $xbits[1]);
			$xdate = explode("-", $xbits[0]);
			$stamp_now = time();
			$stamp_expire = mktime((int) $xtime[0], (int) $xtime[1], (int) $xtime[2], (int) $xdate[0], (int) $xdate[1], (int) $xdate[2]);
			if($stamp_now < $stamp_expire){
				return true;
			} else {
				$GLOBALS['core']->delete1($id);
				return false;
			}
		} else {
			return false;
		}
	}
}
class HoloDatabase {
	var $connection;
	var $error;
	var $lastquery;
	function HoloDatabase($conn){
		switch($conn['server']){
			case "mysql":
				$this->connection = mysql_connect($conn['host'].":".$conn['port'], $conn['username'], $conn['password'], true);
				mysql_select_db($conn['database'],$this->connection) or $this->error = mysql_error();
				break;
			case "pgsql":
				$this->connection = pg_connect("host=".$conn['host']." port=".$conn['port']." dbname=".$conn['database']." user=".$conn['username']." password=".$conn['password']);
				break;
			case "sqlite":
				$this->connection = sqlite_open($conn['host'], 0666, $this->error);
				break;
			case "mssql":
				$this->connection = mssql_connect($conn['host'].",".$conn['port'],$conn['username'],$conn['password'],true);
				break;
		}
	}
}
class mysql extends HoloDatabase {
	function query($query){
		if(defined('DEBUG')){ $this->lastquery = $query; }
		$query = mysql_query($query,$this->connection);
		return $query;
	}
	function fetch_assoc($query){
		$result = mysql_fetch_assoc($query);
		if(defined('DEBUG')){ $error = mysql_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_row($query){
		$result = mysql_fetch_row($query);
		if(defined('DEBUG')){ $error = mysql_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_array($result,$result_type=0){
		$result = mysql_fetch_array($result,$result_type);
		if(defined('DEBUG')){ $error = mysql_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function num_rows($query){
		$result = mysql_num_rows($query);
		if(defined('DEBUG')){ $error = mysql_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function result($query,$row=0,$column=0){
		$result = mysql_result($query,$row,$column);
		if(defined('DEBUG')){ if($result == false){ echo mysql_error($this->connection) . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function insert_id($query=null){
		return mysql_insert_id($this->connection);
	}
}
class pgsql extends HoloDatabase {
	function query($query){
		if(defined('DEBUG')){ $this->lastquery = $query; }
		$query = pg_query($this->connection,$query);
		return $query;
	}
	function fetch_assoc($query){
		$result = pg_fetch_assoc($query);
		if(defined('DEBUG')){ $error = pg_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_row($query){
		$result = pg_fetch_row($query);
		if(defined('DEBUG')){ $error = pg_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_array($result,$result_type=0){
		$result = pg_fetch_array($result,null,$result_type);
		if(defined('DEBUG')){ $error = pg_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function num_rows($query){
		$result = pg_num_rows($query);
		if(defined('DEBUG')){ $error = pg_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function result($query,$row=0,$column=0){
		$result = pg_fetch_result($query,$row,$column);
		if(defined('DEBUG')){ if($result == false){ echo pg_last_error($this->connection) . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function insert_id($query){
		return pg_last_oid($query);
	}
}
class sqlite extends HoloDatabase {
	function query($query){
		if(defined('DEBUG')){ $this->lastquery = $query; }
		$query = sqlite_query($query,$this->connection);
		return $query;
	}
	function fetch_assoc($query){
		$result = sqlite_fetch_all($query);
		if(defined('DEBUG')){ $error = sqlite_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_row($query){
		$result = sqlite_fetch_all($query,SQLITE_NUM);
		if(defined('DEBUG')){ $error = sqlite_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_array($result,$result_type=0){
		$result = sqlite_fetch_array($result,$result_type);
		if(defined('DEBUG')){ $error = sqlite_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function num_rows($query){
		$result = sqlite_num_rows($query);
		if(defined('DEBUG')){ $error = sqlite_last_error($this->connection); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function result($query,$row=0,$column=0){
		sqlite_seek($query,$row);
		$result = sqlite_fetch_array($query);
		$result = $result[$column];
		if(defined('DEBUG')){ if($result == false){ echo sqlite_last_error($this->connection) . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function insert_id($query){
		return sqlite_last_insert_rowid($this->connection);
	}
}
class mssql extends HoloDatabase {
	function query($query){
		if(defined('DEBUG')){ $this->lastquery = $query; }
		$query = mssql_query($query,$this->connection);
		return $query;
	}
	function fetch_assoc($query){
		$result = mssql_fetch_assoc($query);
		if(defined('DEBUG')){ $error = mssql_get_last_message(); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_row($query){
		$result = mssql_fetch_row($query);
		if(defined('DEBUG')){ $error = mssql_get_last_message(); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function fetch_array($result,$result_type=0){
		$result = mssql_fetch_array($result,$result_type);
		if(defined('DEBUG')){ $error = mssql_get_last_message(); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function num_rows($query){
		$result = mssql_num_rows($query);
		if(defined('DEBUG')){ $error = mssql_get_last_message(); if($result == false && !empty($error)){ echo $error . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function result($query,$row=0,$column=0){
		$result = mssql_result($query,$row,$column);
		if(defined('DEBUG')){ if($result == false){ echo mssql_get_last_message() . "<br />Query that errored: ".$this->lastquery; } }
		return $result;
	}
	function insert_id($query){
		return mssql_result(mssql_query("SELECT @@identity"),0);
	}
}
class HoloLocale {
	var $loc = array();
	function addLocale($keys){
		if(is_array($keys)){
			foreach($keys as $key){
				require('./includes/languages/'.$GLOBALS['settings']->find("site_language").'.php');
				$this->loc = array_merge($this->loc,$loc);
			}
		}else{
			$key = $keys;
			require('./includes/languages/'.$GLOBALS['settings']->find("site_language").'.php');
			$this->loc = array_merge($this->loc,$loc);
		}
		return true;
	}
	function clearLocale($key){
		unset($this->loc);
		return true;
	}
}
class HoloFigureCheck {
	var $error = 0;
	function HoloFigureCheck($figure=null,$gender=null,$club=false){
		if(empty($figure)){ $this->error = 12; return false; }
		$xml = simplexml_load_file('./xml/figuredata.xml');
		$sets = explode(".",$figure);
		foreach($sets as $set){
			$valid = array(false,false,false,false);
			$parts = explode("-",$set);
			$havesets[] = $parts[0];
			foreach($xml->sets->settype as $settype){
				if((string) $settype['mandatory'] == "1"){ $mandatory[] = $settype['type']; }
				if((string) $settype['type'] == $parts[0]){
					$parts[3] = $settype['paletteid'];
					$valid[0] = true; $type = $settype;
					break;
				}
			}
			if($valid[0] != true){ $this->error = 1; return false; }
			foreach($type->set as $xset){
				if((string) $xset['id'] == $parts[1]){
					if($xset['selectable'] == "0"){ $this->error = 2; return false; }
					if($xset['colorable'] == "0"){ $nocolor = true; if($parts[2] != ""){ $this->error = 3; return false; } }else{ $nocolor = false; }
					if($xset['gender'] != $gender && $xset['gender'] != "U"){ $this->error = 4; return false; }
					if($xset['club'] == "1" && $club == false){ $this->error = 5; return false; }
					$valid[1] = true; $details = $xset;
					break;
				}
			}
			if($valid[1] != true){ $this->error = 6; return false; }
			if($nocolor != true){
				foreach($xml->colors->palette as $palette){
					if((string) $palette['id'] == (string) $parts[3]){
						$valid[2] = true; $pat = $palette;
						break;
					}
				}
				if($valid[2] != true){ $this->error = 7; return false; }
				foreach($pat->color as $color){
					if((string) $color['id'] == $parts[2]){
						if($color['club'] == "1" && $club == false){ $this->error = 8; return false; }
						if($color['selectable'] == "0"){ $this->error = 9; return false; }
						$valid[3] = true;
						break;
					}
				}
				if($valid[3] != true){ $this->error = 10; return false; }
			}
		}
		if(count($mandatory) != count(array_intersect($mandatory,$havesets))){ $this->error = 11; return false; }
		return true;
	}
	function generateFigure($club=true,$gender=null){
		if($gender == null){ if(rand(0,1) == 0){ $gender = "M"; }else{ $gender = "F"; } }
		if($club == true){ $club = (bool) rand(0,1); }
		$xml = simplexml_load_file('./xml/figuredata.xml');
		$figure = "";
		foreach($xml->sets->settype as $settype){
			if((string) $settype['mandatory'] == "1" || rand(0,1) == 1){
				$item['settype'] = $settype['type'];
				$palette = (int) $settype['paletteid'];
				$possible = array();
				foreach($settype->set as $xset){
					if($xset['gender'] != "U" && $xset['gender'] != $gender){ $fail = true; }
					if($xset['selectable'] == "0"){ $fail = true; }
					if($xset['colorable'] == "0"){ $color = false; }else{ $color = true; }
					if($xset['club'] == "1" && $club == false){ $fail = true; }
					if($fail != true){ $possible[] = array($xset['id'],$color); }
					$fail = false; $color = false;
				}
				$count = count($possible);
				$num = rand(0,$count-1);
				$item['set'] = $possible[$num][0];
				if($possible[$num][1] == false){ $item['color'] = ""; }else{
					$possible = array();
					foreach($xml->colors->palette[$palette-1]->color as $color){
						if($color['club'] == "1" && $club == false){ $fail = true; }
						if($color['selectable'] == "0"){ $fail = true; }
						if($fail != true){ $possible[] = $color['id']; }
						$fail = false;
					}
					$count = count($possible);
					$num = rand(0,$count-1);
					$item['color'] = $possible[$num];
				}
				$figure .= $item['settype']."-".$item['set']."-".$item['color'].".";
			}
		}
		$figure = substr($figure, 0, -1);
		return array($figure,$gender);
	}
}
class HoloSettings {
	var $cache;
	function HoloSettings(){
		@include('./cache/settings.ret');
		if(isset($setting)){ $this->cache = $setting; }
		return true;
	}
	function generateCache(){
		if($this->find("cache_settings") == "1"){
			$fh = @fopen('./cache/settings.ret', 'w');
			@fwrite($fh, "<?php\n/*DO NOT EDIT THIS FILE, EDIT THE SETTINGS TABLE OR USE HOUSEKEEPING, THIS FILE IS JUST A CACHE*/\n");
			$sql = $GLOBALS['db']->query("SELECT id,value FROM ".PREFIX."settings");
			while($row = $GLOBALS['db']->fetch_assoc($sql)){
				@fwrite($fh, "$"."setting['".$row['id']."'] = \"".$GLOBALS['input']->FilterText($row['value'])."\";\n");
			}
			@fwrite($fh, "?>");
			@fclose($fh);
		}else{
			@unlink('./cache/settings.ret');
		}
		$this->HoloSettings();
		return true;
	}
	function find($key){
		if(!empty($this->cache)){
			return $GLOBALS['input']->HoloText($this->cache[$key],true);
		}else{
			$sql = $GLOBALS['db']->query("SELECT value FROM ".PREFIX."settings WHERE id = '".$key."' LIMIT 1");
			return $GLOBALS['input']->HoloText($GLOBALS['db']->result($sql),true);
		}
	}
	function checkCache(){
		if($this->find("cache_settings") == "1"){
			@require('./cache/settings.ret');
			$sql = $GLOBALS['db']->query("SELECT id,value FROM ".PREFIX."settings");
			while($row = $GLOBALS['db']->fetch_assoc($sql)){
				if(stripslashes($setting[$row['id']]) != stripslashes($row['value'])){ return true; }
			}
			return false;
		}else{
			@unlink('./cache/settings.ret');
			return false;
		}	
	}
}
class HoloMail {
	var $plaintext;
	var $html;
	var $logo;
	var $boundary;
	var $email;
	var $subject;
	function sendSimpleMessage($to,$subject,$html,$plaintext=null){
		$this->logo = $this->generateLogo();
		$this->html = $this->htmlToMessage('./templates/email_header.php').$html.$this->htmlToMessage('./templates/email_footer.php');
		if($plaintext == null){ $this->plaintext = $this->generatePlainText($this->html); }else{ $this->plaintext = $plaintext; }
		$array = $this->generateHeaders($to,$subject); $header = $array[1];
		$message = $this->generateMessage();
		$success = @mail($to,$subject,$message,$header);
		return $success;
	}
	function sendNewsletter($to,$subject,$html){
		$this->html = $html;
		$this->plaintext = $this->generatePlainText($html);
		$array = $this->generateHeaders($to,$subject); $header = $array[1];
		$message = $this->generateMessage();
		$success = @mail($to,$subject,$message,$header);
		return $success;
	}
	function generatePlainText($html){
		return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", strip_tags(str_replace("<br />", "\n", str_replace("%name%", $row['name'], $html))));
	}
	function generateHeaders($to,$subject){
$this->boundary = time();
$preheader = '';
$preheader .= 'To: '.$to."\r\n";
$preheader .= 'Subject: '.$subject;
$header = '';
$header .= 'Return-Path: <'.$GLOBALS['settings']->find("email_from").'>'."\r\n";
$header .= 'Date: '.date('r (T)')."\r\n";
$header .= 'From: "'.$GLOBALS['settings']->find("email_name").'" <'.$GLOBALS['settings']->find("email_from").'>'."\r\n";
$header .= 'MIME-Version: 1.0'."\r\n";
$header .= 'Content-Type: multipart/related; '."\r\n";
$header .= '	boundary="----=_Part_402930_17237178.'.$this->boundary.'"';
return array($preheader,$header);
	}
	function generateLogo($file=null){
		if($file == null){ $file = './web-gallery/email/images/habbologo.gif'; }
		$fh = fopen($file, "r");
		$image = fread ($fh, filesize($file));
		fclose($fh);
		$encodedimage = chunk_split(base64_encode($image));
		if($encodedimage == ""){
			$encodedimage = 
'R0lGODlhoABCAJEDAP/OAAAAAP5jAf//ACH5BAEAAAMALAAAAACgAEIAAAL/nI+py+0Po5y02ouz
3rz7D4biSJbmiabqyrbuC8fyTNf2jef6zvf+D3QFhrih8YhMBhBK5KEJfUKVjClRsTRka1broHv8
gp1jp3TMFC+3syHgDX+74/AknW6/6/N6vFFr1Cf3pyVWyBXQN3d3JOi36FgXGBnHF0m49qWJqJi4
B0k5SSnpOToIenm1xdZW6tfpGoqaGis7KximVlQ72GlayZv6Kzl8ynpzmxzseMu8jPsMe5Wj7Ptp
zRhcfc2dLUC4i/3aPZ4tDnxO/CnwPW2zbU6OLq8eb1/ux95+LAOPP38P4L96A3ut0weORjNo6QwG
JCgwIkRJ+ti5a1UMgD+J/7IybqRYMWG/aPQcFnRG8lFDjQEqWuT3YuHKj9BE2aLJ0mW7dylP4vxk
kxbOITovxpBZUtiwoLZmtnRpFAbShx2LTfWp7WlImEJ6clRKlaVTp0W5thjqdaLJr2g7leU51mrW
uGGVveWUtG3euXvdQjXLQm9dvoPp5vsLt6/ipWnXjiKKGG/hxb+ufnV2VyFhrCtryrXMUitCwCsE
c2bcuFFl0aMTT379mClK2UB17pR8Gvbsq0deLuxtO2rMMsSLT9lHfOsY2y95Gn9ufPTy4F2Yt3ZO
nbXv7Nytd/du3Qj48KQDQ/6rfd935ePRt2cu/r10aufZl00f37189fvty10X3gp+9Um3HoH75Xcg
cO2JhMyA291X4IMLKjghERRmV95R0G3IYXFnoPFDhyJ6oUYZC4ARRIoqrshiiy6+CGOMMs5IY402
3ohjjjruyGOPPv4IZJBCDklkkUYeWQAAOw==';
		}
		return $encodedimage;
	}
	function generateMessage(){
		$message = '';
		$message .= 
'------=_Part_402930_17237178.'.$this->boundary.'
Content-Type: multipart/alternative; 
	boundary="----=_Part_402931_29846152.'.$this->boundary.'"'."\r\n\r\n";
		if($this->plaintext != ""){ $message .=
'------=_Part_402931_29846152.'.$this->boundary.'
Content-Type: text/plain; charset=ISO-8859-1
Content-Transfer-Encoding: 7bit

'.$this->plaintext."\r\n";
		}
		if($this->html != ""){ $message .=
'------=_Part_402931_29846152.'.$this->boundary.'
Content-Type: text/html;charset=ISO-8859-1
Content-Transfer-Encoding: 7bit

'.$this->html.'
------=_Part_402931_29846152.'.$this->boundary.'--'."\r\n\r\n";
		}
		if($this->logo != ""){ $message .=
'------=_Part_402930_17237178.'.$this->boundary.'
Content-Type: image/gif
Content-Transfer-Encoding: base64
Content-Disposition: inline
Content-ID: <habbologo>

'.$this->logo.'
------=_Part_402930_17237178.'.$this->boundary.'--';
		}
		return $message;
	}
function htmlToMessage($file){
global $lang;
ob_start();
include($file);
$contents = ob_get_clean();
ob_end_clean();
return $contents;
}
}
?>