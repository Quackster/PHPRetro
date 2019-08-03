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

if($page['bypass'] != true){
$page['dir'] = '\habblet';
$page['allow_guests'] = true;
require_once('../includes/core.php');
require_once('./includes/session.php');

if(isset($_POST['month'])){ $month = $_POST['month']; }elseif(isset($_GET['month'])){ $month = $_GET['month']; }else{ $month = 0; }
if(isset($_POST['catalogpage'])){ $catalogpage = $_POST['catalogpage']; }elseif(isset($_GET['catalogpage'])){ $catalogpage = $_GET['catalogpage']; }else{ $catalogpage = "undefined"; }
if($catalogpage == "undefined"){ $catalogpage = 0; }
}
$lang->addLocale("club.gifts");

$pages['total'] = 100;
$pages['current'] = $month;
$pages['minus_five'] = $month - 5;
$pages['plus_five'] = $month + 5;
if($pages['minus_five'] < 0){ $pages['minus_five'] = 0; }
if($pages['minus_five'] > $pages['total']){ $pages['minus_five'] = $pages['total']; }

$data = new credits_sql;

?>
<script src="<?php echo PATH; ?>/web-gallery/static/js/habboclub.js" type="text/javascript"></script>
<div id="hc-gift-catalog">
  <div class="box-content">
    <div id="hc-catalog">
      <div class="hc-catalog-navi">
        <?php if(($pages['current'] - 1) >= 0){ ?><a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['minus_five']; ?>&catalogpage=0" onclick="return habboclub.catalogUpdate(<?php echo $pages['minus_five']; ?>, 0)">&lt;&lt;</a><?php }else{ ?>&lt;&lt;<?php } ?>
      </div>
      <div class="hc-catalog-navi">
        <?php if(($pages['current'] - 1) >= 0){ ?><a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['current'] - 1; ?>" onclick="return habboclub.catalogUpdate(<?php echo $pages['current'] - 1; ?>)"><?php echo $lang->loc['previous']; ?></a><?php }else{ ?><?php echo $lang->loc['previous']; ?><?php } ?>
      </div>

      <div class="hc-catalog-monthNumber">
        <b><?php echo $pages['current'] + 1; ?></b>
      </div>

<?php if(($pages['current'] + 1) <= $pages['total']){ ?>
      <div class="hc-catalog-monthNumber">
        <a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['current'] + 1; ?>&catalogpage=0" onclick="return habboclub.catalogUpdate(<?php echo $pages['current'] + 1; ?>, 0)"><?php echo $pages['current'] + 2; ?></a>
      </div>
<?php } ?>

<?php if(($pages['current'] + 2) <= $pages['total']){ ?>
      <div class="hc-catalog-monthNumber">
        <a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['current'] + 2; ?>&catalogpage=0" onclick="return habboclub.catalogUpdate(<?php echo $pages['current'] + 2; ?>, 0)"><?php echo $pages['current'] + 3; ?></a>
      </div>
<?php } ?>

<?php if(($pages['current'] + 3) <= $pages['total']){ ?>
      <div class="hc-catalog-monthNumber">
        <a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['current'] + 3; ?>&catalogpage=0" onclick="return habboclub.catalogUpdate(<?php echo $pages['current'] + 3; ?>, 0)"><?php echo $pages['current'] + 4; ?></a>
      </div>
<?php } ?>

<?php if(($pages['current'] + 4) <= $pages['total']){ ?>
      <div class="hc-catalog-monthNumber">
        <a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['current'] + 4; ?>&catalogpage=0" onclick="return habboclub.catalogUpdate(<?php echo $pages['current'] + 4; ?>, 0)"><?php echo $pages['current'] + 5; ?></a>
      </div>
<?php } ?>
	  
      <div class="hc-catalog-navi">
        <?php if(($pages['current'] + 1) <= $pages['total']){ ?><a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['current'] + 1; ?>" onclick="return habboclub.catalogUpdate(<?php echo $pages['current'] + 1; ?>)"><?php echo $lang->loc['next']; ?></a><?php }else{ ?><?php echo $lang->loc['next']; ?><?php } ?>
      </div>
      <div class="hc-catalog-navi">
        <?php if(($pages['current'] + 1) <= $pages['total']){ ?><a href="<?php echo PATH; ?>/credits/habboclub?month=<?php echo $pages['plus_five']; ?>&catalogpage=0" onclick="return habboclub.catalogUpdate(<?php echo $pages['plus_five']; ?>, 0)">&gt;&gt;</a><?php }else{ ?>&gt;&gt;<?php } ?>
      </div>

    </div>
<?php
$total_months = $serverdb->result($serverdb->query("SELECT MAX(month) FROM ".PREFIX."gifts WHERE type = 'club'"));
if(($pages['current'] + 1) > $total_months){ $month = fmod(($pages['current'] + 1), $total_months); }else{ $month = $pages['current'] + 1; }
$row = $db->fetch_row($data->select1($month));
?>
    <div id="hc-catalog-selectedGift">
      <div id="hc-catalog-starGreen">
        <div id="hc-catalog-giftNumber">
          #<?php echo $pages['current'] + 1; ?>
        </div>
      </div>
      <div id="hc-catalog-giftPicture">
        <img src="<?php echo str_replace("%path%", PATH, $row[1]); ?>" alt="<?php echo $row[0]; ?>" />
      </div>
    </div>
    <div id="hc-catalog-giftName">
      <b><?php echo $row[0]; ?></b>
    </div>
  </div>
</div>