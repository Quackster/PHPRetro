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
$data = new credits_sql;
$lang->addLocale("collectables.buy");
$lang->addLocale("ajax.buttons");

$this['month'] = date('m');
$this['year'] = date('Y');
$this['time'] = mktime(0,0,0,$this['month'],1,$this['year']);

$furni_id = $serverdb->result($data->select3($this['time']), 0, 3);

if(($user->user("credits") - 25) > 0) {
$credits = $user->user("credits") - 25;
$data->update1($user->id,$credits);
$data->insert1($user->id,$furni_id);
$user->refresh();
$db->query("INSERT INTO ".PREFIX."transactions (userid,amount,time,descr) VALUES ('".$user->id."','25','".time()."','Bought a collectable')");
@SendMUSData('UPRC' . $user->id);
@SendMUSData('UPRH' . $user->id);
$message = $lang->loc['collectable.bought']." ".$input->HoloText($serverdb->result($data->select3($this['time']), 0)).".";
}else{
$message = $lang->loc['purchase.failed'];
}
?>
<p>
<?php echo $message; ?>.
</p>


<p>
<a href="#" class="new-button" id="collectibles-close"><b><?php echo $lang->loc['ok']; ?></b><i></i></a>
</p>