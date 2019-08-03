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

function HoloDate(){
	$date['H'] = date('H');
	$date['i'] = date('i');
	$date['s'] = date('s');
	$date['m'] = date('m');
	$date['d'] = date('d');
	$date['Y'] = date('Y');
	$date['j'] = date('j');
	$date['n'] = date('n');
	$date['today'] = $date['d'];
	$date['month'] = $date['m'];
	$date['year'] = $date['Y'];
	$date['date_normal'] = date('d-m-Y',mktime($date['m'],$date['d'],$date['Y']));
	$date['date_reversed'] = date('Y-m-d', mktime($date['m'],$date['d'],$date['y']));
	$date['date_full'] = date('d-m-Y H:i:s',mktime($date['H'],$date['i'],$date['s'],$date['m'],$date['d'],$date['Y']));
	$date['date_time'] = date('H:i:s',mktime($date['H'],$date['i'],$date['s']));
	$date['date_hc'] = "".$date['j']."-".$date['n']."-".$date['Y']."";
	$date['regdate'] = $date['date_normal'];
	return $date;
}
function GenerateTicket($type = "sso",$length = 0){
switch($type){
case "sso":
	$data = GenerateTicket("random",8)."-".GenerateTicket("random",4)."-".GenerateTicket("random",4)."-".GenerateTicket("random",4)."-".GenerateTicket("random",12);
	return $data;
break; case "remember":
	$data = GenerateTicket("random",6)."-".md5(GenerateTicket("random",20))."-".md5(GenerateTicket("random",20));
	return $data;
break; case "random":
	$data = "";
	$possible = "0123456789abcdef"; 
	$i = 0;
	while ($i < $length) { 
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		$data .= $char;
		$i++;
	}
	return $data;
break;
}
	return $data;
}
function SendMUSData($data){
$ip = $GLOBALS['settings']->find("hotel_ip");
$port = $GLOBALS['settings']->find("hotel_mus");

if(!is_numeric($port)){ return false; }

$sock = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
socket_connect($sock, $ip, $port);

	if(!is_resource($sock)){
		return false;
	} else {
		socket_send($sock, $data, strlen($data), MSG_DONTROUTE);
		return true;
	}
	
socket_close($sock);
}
function GetOnlineCount(){
	return $GLOBALS['db']->result($GLOBALS['core']->select14());
}
function HotelStatus(){
	if($GLOBALS['settings']->find("site_status_image") == 2){
		@include('./cache/status.ret');
		if((($status['check'] + (60*30)) < time()) || $status['bypass'] == true){
			$fp = @fsockopen($GLOBALS['settings']->find("hotel_ip"), $GLOBALS['settings']->find("hotel_mus"), $errno, $errstr, 1);
			if($fp){
				$status['online'] = "online";
				@fclose($fp);
			} else {
				$status['online'] = "offline";
			}
			$fh = @fopen('./cache/status.ret', 'w');
			@fwrite($fh, "<?php\n"."$"."status['online'] = \"".$status['online']."\";\n"."$"."status['check'] = ".time().";\n");
			if($status['bypass'] == true && $status['online'] != "online"){
				@fwrite($fh, "$"."status['bypass'] = true;\n");
			}
			@fwrite($fh, "?>");
			@fclose($fh);
		}
	}elseif($GLOBALS['settings']->find("site_status_image") == 1){
		$fp = @fsockopen($GLOBALS['settings']->find("hotel_ip"), $GLOBALS['settings']->find("hotel_mus"), $errno, $errstr, 1);
		if($fp){
			$status['online'] = "online";
			fclose($fp);
		} else {
			$status['online'] = "offline";
		}
	}else{
		$status['online'] = "online";
	}
	return $status['online'];
}
function formatItem($type,$data,$pre){
	$str = "";

	switch($type){
		case 1: $str = $str . "s_"; break;
		case 2: $str = $str . "w_"; break;
		case 3: $str = $str . "commodity_"; break; // =S
		case 4: $str = $str . "b_"; break;
	}

	$str = $str . $data;

	if($pre == true){ $str = $str . "_pre"; }

	return $str;
}
function groupURL($id){
	$data = new home_sql;
	$row = $GLOBALS['serverdb']->fetch_row($data->select14($id));
	if($row[10] != ""){ return PATH."/groups/".$row[10]; }else{ return PATH."/groups/".$row[0]."/id"; }
}
?>