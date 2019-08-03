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
$data = new community_sql;
$lang->addLocale("community.news");

$id = $input->FilterText($_GET['id']);
$category = $input->stringToURL($input->HoloText($_GET['category'],true),true,false);
$archive = $_GET['archive'];
$pagenum = $_GET['pageNumber'];
if(!isset($_GET['pageNumber'])){ $pagenum = 1; }

if(!isset($id) || $id == ""){ $id = $db->result($db->query("SELECT MAX(id) AS count FROM ".PREFIX."news LIMIT 1")); }

$news_row = $db->fetch_assoc($db->query("SELECT * FROM ".PREFIX."news WHERE id = '".$id."' LIMIT 1"));
foreach ($news_row as &$value) {
    $value = $input->HoloText($value, true);
}
$page['id'] = "news";
$page['name'] = $lang->loc['pagename.news']." - ".$news_row['title'];
$page['bodyid'] = "news";
$page['cat'] = "community";

require_once('./templates/community_header.php');
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">

	
							<h2 class="title"><?php echo $lang->loc['pagename.news']; ?>
							</h2>
						<div id="article-archive">
<?php if(isset($_GET['archive']) && $archive = "true"){
$count = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."news"));
$pages = ceil($count / 20); ?>
<div id="article-paging" class="clearfix">
        <?php if(($pagenum + 1) <= $pages){ ?><a href="<?php echo PATH; ?>/articles/archive?pageNumber=<?php echo $pagenum + 1; ?>" class="older">&lt;&lt; <?php echo $lang->loc['older']; ?></a><?php } ?>
        <?php if(($pagenum - 1) > 0){ ?><a href="<?php echo PATH; ?>/articles/archive?pageNumber=<?php echo $pagenum - 1; ?>" class="newer"><?php echo $lang->loc['newer']; ?> &gt;&gt;</a><?php } ?>
</div>
<?php } ?>
<?php
if((!isset($archive) || $archive == "false") && (!isset($_GET['category']) || $_GET['category'] = "")){
$time['stop'] = time() - 60*60*24;
$sql = $db->query("SELECT * FROM ".PREFIX."news WHERE time > ".$time['stop']." ORDER BY id DESC"); 
if($db->num_rows($sql) > 0){ ?>
<h2><?php echo $lang->loc['today']; ?></h2>
<ul>

<?php while($row = $db->fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>/articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24; $time['stop'] = time() - 60*60*24*2;
$sql = $db->query("SELECT * FROM ".PREFIX."news WHERE time < ".$time['start']." AND time > ".$time['stop']." ORDER BY id DESC"); 
if($db->num_rows($sql) > 0){ ?>
<h2><?php echo $lang->loc['yesterday']; ?></h2>
<ul>

<?php while($row = $db->fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>/articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24*2; $time['stop'] = time() - 60*60*24*7;
$sql = $db->query("SELECT * FROM ".PREFIX."news WHERE time < ".$time['start']." AND time > ".$time['stop']." ORDER BY id DESC"); 
if($db->num_rows($sql) > 0){ ?>
<h2><?php echo $lang->loc['this.week']; ?></h2>
<ul>

<?php while($row = $db->fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>/articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24*7; $time['stop'] = time() - 60*60*24*14;
$sql = $db->query("SELECT * FROM ".PREFIX."news WHERE time < ".$time['start']." AND time > ".$time['stop']." ORDER BY id DESC"); 
if($db->num_rows($sql) > 0){ ?>
<h2><?php echo $lang->loc['last.week']; ?></h2>
<ul>

<?php while($row = $db->fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>/articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24*14; $time['stop'] = time() - 60*60*24*30;
$sql = $db->query("SELECT * FROM ".PREFIX."news WHERE time < ".$time['start']." AND time > ".$time['stop']." ORDER BY id DESC"); 
if($db->num_rows($sql) > 0){ ?>
<h2><?php echo $lang->loc['this.month']; ?></h2>
<ul>

<?php while($row = $db->fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>/articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
}elseif(isset($_GET['archive']) && $archive = "true"){ ?>
<h2><?php echo $lang->loc['pagename.news']; ?></h2>
<ul>

<?php
$sql = "SELECT * FROM ".PREFIX."news ORDER BY time DESC LIMIT 20";
if($pagenum > 1){ $sql = $sql." OFFSET ".($pagenum - 1) * 20; }
$sql = $db->query($sql);
while($row = $db->fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>/articles/<?php echo $row['id']."-".$row['title_safe']; ?>/in/archive<?php if($pagenum > 1){ echo $pagenum; } ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }elseif(isset($_GET['category'])){ ?>
<h2><?php echo $lang->loc['pagename.news']; ?></h2>
<ul>

<?php
$sql = $db->query("SELECT * FROM ".PREFIX."news WHERE categories LIKE '%".$category."%'");
while($row = $db->fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>/articles/<?php echo $row['id']."-".$row['title_safe']; ?>/in/category/<?php echo $category; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php } ?>

<a href="<?php echo PATH; ?>/articles/archive"><?php echo $lang->loc['more.news']; ?> &raquo;</a>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<div id="column2" class="column">

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix notitle ">
	
							
						<div id="article-wrapper">
	<h2><?php echo $news_row['title']; ?></h2>
	<div class="article-meta"><?php echo $lang->loc['posted']." ".date('M j, Y',$news_row['time']); ?> 
	<?php $categories = explode(",",$news_row['categories']); $output = ""; foreach($categories as &$value){ $output = $output."<a href=\"".PATH."/articles/category/".$input->stringToURL($input->HoloText($value,true),true,true)."\">".$value."</a>, "; } $output = substr_replace($output,"",-2); ?>
		<?php echo $output; ?></div>

	<?php $images = explode(",",$news_row['images']); if(!empty($images[0])){ ?>
			<img src="<?php echo $images[0]; ?>" class="article-image"/>
	<?php } ?>
	<p class="summary"><?php echo nl2br($news_row['summary']); ?></p>
	
	<div class="article-body">
<p><?php echo nl2br($news_row['story']); ?></p>
<div class="article-author">- <?php echo $news_row['author']; ?></div>
	
<?php if(count($images) > 1){ unset($images[0]); $output = ""; foreach($images as &$value){ $output = $output."<a href=\"".$value."\" style=\"background-image: url(".$value."); background-position: -0px -0px\"></a>\n"; } ?>
	<div class="article-images clearfix">
	
		<?php echo $output; ?>
	
	</div>
<?php } ?>

	<script type="text/javascript" language="Javascript">
		document.observe("dom:loaded", function() {
			$$('.article-images a').each(function(a) {
				Event.observe(a, 'click', function(e) {
					Event.stop(e);
					Overlay.lightbox(a.href, "<?php echo $lang->loc['image.loading']; ?>");
				});
			});
			
			$$('a.article-<?php echo $news_row['id']; ?>').each(function(a) {
				a.replace(a.innerHTML);
			});
		});
	</script>
	</div>
</div>
	
							
						
					</div>
				</div>

				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php require_once('./templates/community_footer.php'); ?>
