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
$data = new me_sql;
$lang->addLocale("searchhabbos.search");

if(isset($_POST['searchString'])) {
$page = $_POST['pageNumber'];
$search = $input->FilterText($_POST['searchString']);
$sql = $data->select8($search);
$count = $db->num_rows($sql);
$pages = ceil($count / 10);
if($page == null){ $page = 1; }
$limit = 10;
$offset = $page - 1;
$offset = $offset * 10;
$sql = $data->select8($search, $limit, $offset);
if($db->num_rows($sql) > 0) {
echo '<ul class="habblet-list">';
while($row = $db->fetch_row($sql)) {
		$i++;

        if($input->IsEven($i)){
            $even = "odd";
        } else {
            $even = "even";
        }
		if($user->IsUserOnline($row[2]) == true){
			$online = "online";
		}else{
			$online = "offline";
		}
		?>

              <li class="<?php echo $even." ".$online; ?>" homeurl="<?php echo PATH; ?>/home/<?php echo $input->HoloText($row[0]); ?>" style="background-image: url(<?php echo $user->avatarURL($row[1],"s,2,2,sml,1,0"); ?>)">
	            	    <div class="item">
	            		    <b><?php echo $input->HoloText($row[0]); ?></b><br />

	            	    </div>
	            	    <div class="lastlogin">
	            	    	<b><?php echo $lang->loc['last.visit']; ?></b><br />
	            	    		<span title="<?php echo date('n/j/y g:i A',$row[3]); ?>"><?php echo date('n/j/y g:i A',$row[3]); ?></span>
	            	    </div>
	            	    <div class="tools">
	            	    		<a href="#" class="add" avatarid="<?php echo $row[2]; ?>" title="<?php echo $lang->loc['send.request']; ?>"></a>
	            	    </div>
	            	    <div class="clear"></div>
	                </li>

<?php			} ?>
							    <div id="habblet-paging-avatar-habblet-list-container">
        <p id="avatar-habblet-list-container-list-paging" class="paging-navigation">
		            	 <?php if($page > 1) { ?><a href="#" class="avatar-habblet-list-container-list-paging-link" id="avatar-habblet-list-container-list-previous">&laquo;</a><?php } else { ?><span class="disabled">&laquo;</span><?php } ?>
		<?php           
		$i = 0;
		$n = $pages;
		while ($i <> $n){
			$i++;
			if ($i < $page + 8){
				if($i == $page){ echo "<span class=\"current\">".$i."</span>\n";
				} else {
					if ($i + 4 >= $page && $page + 4 >= $i){
						echo "<a href=\"#\" class=\"avatar-habblet-list-container-list-paging-link\" id=\"avatar-habblet-list-container-list-page-".$i."\">".$i."</a>\n";
					}
				}
			}
		}
		?>
		<?php if($page < $pages) { ?><a href="#" class="avatar-habblet-list-container-list-paging-link" id="avatar-habblet-list-container-list-next">&raquo;</a><?php }else{ ?><span class="disabled">&raquo;</span><?php } ?>
			        </p>
        <input type="hidden" id="avatar-habblet-list-container-pageNumber" value="<?php echo $page; ?>"/>
        <input type="hidden" id="avatar-habblet-list-container-totalPages" value="<?php echo $pages; ?>"/>
    </div>
				<?php
			}else{
			echo "<div class=\"box-content\">
                ".$lang->loc['not.found']." <br>
       </div>";
		}
}

?>