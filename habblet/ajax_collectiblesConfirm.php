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
$lang->addLocale("collectables.confirm");
$lang->addLocale("ajax.buttons");

$this['month'] = date('m');
$this['year'] = date('Y');
$this['time'] = mktime(0,0,0,$this['month'],1,$this['year']);

$name = $serverdb->result($data->select3($this['time']), 0);
?>

<p>
<?php echo $lang->loc['confirm.collectable.purchase']." ".$input->HoloText($name); ?>? <?php echo $lang->loc['collectable.price']; ?>.
</p>

<p>
<a href="#" class="new-button" id="collectibles-purchase"><b><?php echo $lang->loc['purchase']; ?></b><i></i></a>
<a href="#" class="new-button" id="collectibles-close"><b><?php echo $lang->loc['cancel']; ?></b><i></i></a>
</p>