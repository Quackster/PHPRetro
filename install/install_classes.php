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

class HoloLocaleInstaller {
	var $loc = array();
	function addLocale($keys){
		if(is_array($keys)){
			foreach($keys as $key){
				require('../includes/languages/'.$_SESSION['settings']['s_site_language'].'.php');
				$this->loc = array_merge($this->loc,$loc);
			}
		}else{
			$key = $keys;
			require('../includes/languages/'.$_SESSION['settings']['s_site_language'].'.php');
			$this->loc = array_merge($this->loc,$loc);
		}
		return true;
	}
	function clearLocale($key){
		unset($this->loc);
		return true;
	}
}
?>