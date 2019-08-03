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

$page['allow_guests'] = true;
require_once('./includes/core.php');
require_once('./includes/session.php');
$lang->addLocale("credits.collectables");

$page['id'] = "collectables";
$page['name'] = $lang->loc['pagename.collectables'];
$page['bodyid'] = "home";
$page['cat'] = "credits";
require_once('./templates/community_header.php');

$data = new credits_sql;
$this['month'] = date('m');
$this['year'] = date('Y');
$this['time'] = mktime(0,0,0,$this['month'],1,$this['year']);
$this['next_time'] = strtotime("+1 Month",$this['time']);
$sql = $data->select3($this['time']);
$row = $db->fetch_row($sql);
if($row[0] == ""){ $row[0] = $lang->loc['no.collectables']; $row[1] = $lang->loc['no.collectables.desc']; $row[2] = ""; $nocollectable = true; }
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
				<div class="habblet-container " id="collectible-current">
						<div class="cbb clearfix gray ">

							<h2 class="title"><?php echo $lang->loc['current.collectables']; ?>
							</h2>

						<div id="collectible-current-content" class="clearfix">
		<div id="collectibles-current-img" style="background-image: url(<?php echo str_replace("%path%",PATH,$row[2]); ?>)"></div>
		<h4><?php echo $input->HoloText($row[0]); ?></h4>
		<p><?php echo date('F')." ".date('Y'); ?></p>
			<p class="last"><?php echo $input->HoloText($row[1]); ?></p>
			<?php if($user->id != "0" && $nocollectable != true){ ?>
			<p id="collectibles-purchase">

				<a href="#" class="new-button collectibles-purchase-current"><b><?php echo $lang->loc['purchase']; ?></b><i></i></a>

				<span class="collectibles-timeleft"><?php echo $lang->loc['time.left']; ?>: <span id="collectibles-timeleft-value"></span></span>
			</p>
			<?php } ?>
	</div>

<?php if($user->id != "0" && $nocollectable != true){ ?>
<script type="text/javascript">
L10N.put("collectibles.purchase.title", "<?php echo $lang->loc['confirm.purchase.collectables']; ?>");
L10N.put("time.days", "{0}d");
L10N.put("time.hours", "{0}h");
L10N.put("time.minutes", "{0}min");
L10N.put("time.seconds", "{0}s");
Collectibles.init(<?php echo $this['next_time'] - time(); ?>);
</script>
<?php } ?>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>


				<div class="habblet-container ">
						<div class="cbb clearfix red ">

							<h2 class="title"><?php echo $lang->loc['showroom']; ?>
							</h2>
						<ul id="collectibles-list">
		<?php
		$sql = $data->select4($this['time']);
		$i = 0;
		while($row = $db->fetch_row($sql)) {
        $i++;
        if($input->IsEven($i)){
            $even = "even";
        } else {
            $even = "odd";
        }
		?>
	<li class="<?php echo $even; ?> clearfix">
		<div class="collectibles-prodimg" style="background-image: url(<?php echo str_replace("%path%",PATH,$row[2]); ?>)"></div>
		<h4><?php echo date('F Y',$row[3]); ?>: <?php echo $input->HoloText($row[0]); ?></h4>
		<p class="collectibles-proddesc last"><?php echo $input->HoloText($row[1]); ?></p>
	</li>
	<?php } ?>
</ul>



					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div id="column2" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix red ">

							<h2 class="title"><?php echo $lang->loc['what.are.collectables']; ?>
							</h2>

						<div id="collectibles-instructions" class="box-content">

<?php echo $lang->loc['collectables.desc']; ?>

</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

				<div class="habblet-container ">
						<div class="cbb clearfix red ">

							<h2 class="title"><?php echo $lang->loc['invest.in.collectables']; ?>
							</h2>

						<div class="box-content">

<p class="collectibles-value-intro">
	<img src="<?php echo PATH; ?>/web-gallery/v2/images/collectibles/ukplane.png" alt="" width="79" height="47" />
	<?php echo $lang->loc['collect.collectables']; ?>
</p>

<p class="clear last">
	<img src="<?php echo PATH; ?>/web-gallery/v2/images/collectibles/chart.png" alt="" width="272" height="117" />
</p>

</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>


</div>
<?php require_once('./templates/community_footer.php'); ?>
