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

require_once('./includes/core.php');
require_once('./includes/session.php');
$data = new me_sql;
$lang->addLocale("home.me");

$page['id'] = "me";
$page['name'] = $lang->loc['pagename.me'];
$page['bodyid'] = "home";
$page['cat'] = "home";
require_once('./templates/community_header.php');
?>

<div id="container">
	<div id="content">
    <div id="column1" class="column">
				<div class="habblet-container ">

						<div id="new-personal-info" style="background-image:url(<?php echo PATH; ?>/web-gallery/v2/images/personal_info/hotel_views/<?php echo $settings->find("site_hotel_image"); ?>)" />
	<div class="enter-hotel-btn">
<?php if(HotelStatus() == "online"){ ?>
		<div class="open enter-btn">
				<a href="<?php echo PATH; ?>/client" target="client" onclick="openOrFocusHabbo(this); return false;"><?php echo $lang->loc['enter.short']; ?><i></i></a>
			<b></b>
		</div>
<?php } else { ?>
<div class="closed enter-btn">
	<span><?php echo $lang->loc['closed.short']; ?></span>
	<b></b>
</div>
<?php } ?>
	</div>

	<div id="habbo-plate">
		<a href="<?php echo PATH; ?>/profile">
			<img alt="<?php echo $user->name; ?>" src="<?php echo $user->avatarURL("self","b,3,3,sml,1,0"); ?>" width="64" height="110" />
		</a>
	</div>

	<div id="habbo-info">
		<div id="motto-container" class="clearfix">
			<strong><?php echo $user->name; ?>:</strong>
			<div>
				<span title="<?php echo $lang->loc['change.motto']; ?>"><?php if($user->user("mission") != ""){ echo $input->unicodeToImage($input->HoloText($user->user("mission"))); } else { echo $lang->loc['change.motto']; } ?></span>
				<p style="display: none"><input type="text" length="30" name="motto" value="<?php echo $input->HoloText($user->user("mission")); ?>"/></p>
			</div>
		</div>
		<div id="motto-links" style="display: none"><a href="#" id="motto-cancel"><?php echo $lang->loc['cancel']; ?></a></div>
	</div>

	<ul id="link-bar" class="clearfix">
		<li class="change-looks"><a href="<?php echo PATH; ?>/profile"><?php echo $lang->loc['change.looks']; ?> &raquo;</a></li>
		<li class="credits">
			<a href="<?php echo PATH; ?>/credits"><?php echo $user->user("credits"); ?></a> <?php echo $lang->loc['credits']; ?>
		</li>
		<li class="club">
                	<a href="<?php echo PATH; ?>/club"><?php if( !$user->IsHCMember("self") ){ echo $lang->loc['join.club']." &raquo;</a>"; } else { echo $user->HCDaysLeft("self") . " </a>".$lang->loc['hc.days']; }?>
		</li>
		    <li class="activitypoints">
			    <a href="<?php echo PATH; ?>/credits/pixels"><?php echo $user->user("pixels"); ?></a> <?php echo $lang->loc['pixels']; ?>
		    </li>
	</ul>

    <div id="habbo-feed">
        <ul id="feed-items">

<?php
if($serverdb->result($data->select1($user->id), 0) == "1" && $serverdb->result($core->select9($user->id), 0) == 0) {
$removed = $db->result($db->query("SELECT COUNT(*) FROM ".PREFIX."alerts WHERE userid = '".$user->id."' AND alert = 'clubalert' AND type = '-1'"));
if($removed < 1){ ?>
<li id="feed-item-hc-reminder">
    <a href="#" class="remove-feed-item" id="remove-hc-reminder" title="<?php echo $lang->loc['remove.hc.notice']; ?>"><?php echo $lang->loc['remove.hc.notice']; ?></a>

	<div>
			<?php echo $lang->loc['hc.subscribe.question']; ?>
	</div>
	<div id="hc-reminder-buttons" class="clearfix">
		<a href="#" class="new-button" id="hc-reminder-1" title="31 <?php echo $lang->loc['days']; ?>, 20 <?php echo $lang->loc['credits']; ?>"><b>1 <?php echo $lang->loc['months']; ?></b><i></i></a>
		<a href="#" class="new-button" id="hc-reminder-2" title="93 <?php echo $lang->loc['days']; ?>, 50 <?php echo $lang->loc['credits']; ?>"><b>3 <?php echo $lang->loc['months']; ?></b><i></i></a>
		<a href="#" class="new-button" id="hc-reminder-3" title="186 <?php echo $lang->loc['days']; ?>, 80 <?php echo $lang->loc['credits']; ?>"><b>6 <?php echo $lang->loc['months']; ?></b><i></i></a>
	</div>

</li>
<script type="text/javascript">
L10N.put("subscription.title", "<?php echo addslashes($lang->loc['habbo.club']); ?>");
</script>
<?php
}
}

if($user->user("rank") > 4){
    $sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."help WHERE picked_up = '0'");
    if($db->result($sql) > 0){
            echo "            <li class=\"small\" id=\"feed-group-discussion\">
                <strong>".$lang->loc['staff.messages']."</strong><br />".$lang->loc['there.are']." <strong><a href=\"".PATH."/housekeeping/help\" target=\"_self\">".$db->result($sql)."</a></strong> ".$lang->loc['help.quries']."
            </li>";
    }
}

$sql = $db->query("SELECT * FROM ".PREFIX."alerts WHERE userid = '".$user->id."' AND type > -1 ORDER BY id DESC");
    if($db->num_rows($sql) > 0){
		while($row = $db->fetch_assoc($sql)) {
	        if($row['type'] == 2){
				$heading = $lang->loc['notification'];
	        }else{
				$heading = $lang->loc['message'];
			}
?>
			<li id="feed-item-campaign" class="contributed">
			    <a href="#" class="remove-feed-item" title="<?php echo $lang->loc['remove.notification']; ?>"><?php echo $lang->loc['remove.notification']; ?></a>
			    <div>
			            <b><?php echo $heading; ?></b><br />
			            <?php echo nl2br($input->HoloText($row['alert'],true)); ?>
			    </div>
			</li>

<?php
        }
    }
$dob = $user->user("birth");
$bits = explode("-", $dob);
$day = $bits[0];
$month2 = $bits[1];
$year2 = $bits[2];
$date = HoloDate();
if($day == $date['today'] && $month2 == $date['month']){
?>
			<li id="feed-birthday">
			    <div>
			            <?php echo $lang->loc['happy.birthday'].", ".$user->name."!"; ?>
			    </div>
			</li>
<?php
}
if($serverdb->num_rows($data->select3($user->id)) != 0){ ?>
			<li id="feed-notification">
				<?php echo $lang->loc['you.have']; ?> <a href="<?php echo PATH; ?>/client" onclick="HabboClient.openOrFocus(this); return false;"><?php echo $serverdb->num_rows($data->select3($user->id)); ?> <?php echo $lang->loc['friend.requests']; ?></a> <?php echo $lang->loc['waiting']; ?>
			</li>
<?php }
$cutoff = (time() - 1801);
$sql = $data->select4($cutoff, $user->id);
$count = $serverdb->num_rows($sql);
$i = 0;
if($db->num_rows($sql) > 0){
?>
			<li id="feed-friends">
				<?php echo $lang->loc['you.have']; ?> <strong><?php echo $count; ?></strong> <?php echo $lang->loc['friends.online']; ?>
				<span>
			<?php while($row = $db->fetch_row($sql)){
					$i++;
					echo $row[0];
					if($i < $count){ echo ", "; }
					echo "\n";
				} ?>
				</span>
			</li>
<?php } 

$sql = $data->select14($user->id);
$i = 0;
$groups = "";
while($row = $db->fetch_row($sql)){
	$row2 = $db->fetch_assoc($db->query("SELECT MAX(".PREFIX."forum_posts.time) AS lastpost_time FROM ".PREFIX."forum_threads,".PREFIX."forum_posts WHERE groupid = '".$row[0]."' LIMIT 1"));
	if($row2['lastpost_time'] > $user->user("lastvisit")){
		$i++;
		$groups = $groups."\n<a href=\"".groupURL($row[0])."/discussions\">".$row[1]."</a>, ";
	}
}
if($i > 0 && $groups != ""){
$groups = substr($groups,0,-2);
?>
            <li class="small" id="feed-group-discussion">
            	<strong><?php echo $i; ?></strong> <?php echo $lang->loc['groups.new.messages']; ?>:
            	<span><?php echo $groups; ?>
            	</span>
            </li>
<?php } ?>

            <li class="small" id="feed-lastlogin">
                <?php echo $lang->loc['last.online']; ?>:
                <?php echo date('M j, Y g:i:s A', $user->user("lastvisit")); ?>
            </li>


        </ul>
    </div>
    <p class="last"></p>
</div>

<script type="text/javascript">
    HabboView.add(function() {
        L10N.put("personal_info.motto_editor.spamming", "<?php echo addslashes($lang->loc['no.spam']); ?>");
        PersonalInfo.init("");
    });
</script>


                </div>
                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
				
<?php $lang->addLocale("widget.campaigns"); ?>
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">

	
							<h2 class="title"><?php echo $lang->loc['hot.campaigns']; ?>
							</h2>
						<div id="hotcampaigns-habblet-list-container">
    <ul id="hotcampaigns-habblet-list">
<?php
$i = 0; $sql = $db->query("SELECT * FROM ".PREFIX."campaigns WHERE visible = '1' ORDER BY id DESC");
while($row = $db->fetch_assoc($sql)){
if($input->IsEven($i)){ $even = "even"; }else{ $even = "odd"; }
?>

        <li class="<?php echo $even; ?>">
            <div class="hotcampaign-container">
                <a href="<?php echo str_replace("%path%",PATH,$row['url']); ?>"><img src="<?php echo str_replace("%path%",PATH,$row['image']); ?>" align="left" alt="" /></a>
                <h3><?php echo $input->HoloText($row['name'],true); ?></h3>
                <p><?php echo $input->HoloText($row['desc'],true); ?></p>

                <p class="link"><a href="<?php echo str_replace("%path%",PATH,$row['url']); ?>"><?php echo $lang->loc['go.there']; ?> &raquo;</a></p>
            </div>
        </li>

<?php $i++; } ?>
    </ul>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php $lang->addLocale("widget.minimail"); ?>
<div class="habblet-container minimail" id="mail">
                        <div class="cbb clearfix blue ">

                            <h2 class="title"><?php echo $lang->loc['my.messages']; ?>
                            </h2>
                        <div id="minimail">
    <div class="minimail-contents">
		<?php
		$page['bypass'] = true;
		$label = "inbox";
		require('./habblet/minimail_loadMessages.php');
		?>
	    </div>
		<div id="message-compose-wait"></div>
	    <form style="display: none" id="message-compose">
	        <div><?php echo $lang->loc['to']; ?></div>
	        <div id="message-recipients-container" class="input-text" style="width: 426px; margin-bottom: 1em">
	        	<input type="text" value="" id="message-recipients" />
	        	<div class="autocomplete" id="message-recipients-auto">
	        		<div class="default" style="display: none;"><?php echo $lang->loc['type.name']; ?></div>
	        		<ul class="feed" style="display: none;"></ul>

	        	</div>
	        </div>
	        <div><?php echo $lang->loc['subject']; ?><br/>
	        <input type="text" style="margin: 5px 0" id="message-subject" class="message-text" maxlength="100" tabindex="2" />
	        </div>
	        <div><?php echo $lang->loc['message']; ?><br/>
	        <textarea style="margin: 5px 0" rows="5" cols="10" id="message-body" class="message-text" tabindex="3"></textarea>

	        </div>
	        <div class="new-buttons clearfix">
	            <a href="#" class="new-button preview"><b><?php echo $lang->loc['preview']; ?></b><i></i></a>
	            <a href="#" class="new-button send"><b><?php echo $lang->loc['send']; ?></b><i></i></a>
	        </div>
	    </form>
	</div>
		<?php
		$sql = $db->query("SELECT COUNT(*) FROM ".PREFIX."minimail WHERE to_id = '".$user->id."'");
		?>
		<script type="text/javascript">
		L10N.put("minimail.compose", "<?php echo $lang->loc['compose']; ?>").put("minimail.cancel", "<?php echo $lang->loc['cancel']; ?>")
			.put("bbcode.colors.red", "<?php echo $lang->loc['red']; ?>").put("bbcode.colors.orange", "<?php echo $lang->loc['orange']; ?>")
	    	.put("bbcode.colors.yellow", "<?php echo $lang->loc['yellow']; ?>").put("bbcode.colors.green", "<?php echo $lang->loc['green']; ?>")
	    	.put("bbcode.colors.cyan", "<?php echo $lang->loc['cyan']; ?>").put("bbcode.colors.blue", "<?php echo $lang->loc['blue']; ?>")
	    	.put("bbcode.colors.gray", "<?php echo $lang->loc['gray']; ?>").put("bbcode.colors.black", "<?php echo $lang->loc['black']; ?>")
	    	.put("minimail.empty_body.confirm", "<?php echo $lang->loc['empty.message']; ?>")
	    	.put("bbcode.colors.label", "<?php echo $lang->loc['color']; ?>").put("linktool.find.label", " ")
	    	.put("linktool.scope.habbos", "<?php echo $lang->loc['habbos']; ?>").put("linktool.scope.rooms", "<?php echo $lang->loc['rooms']; ?>")
	    	.put("linktool.scope.groups", "<?php echo $lang->loc['groups']; ?>").put("minimail.report.title", "<?php echo $lang->loc['report']; ?>");

	    L10N.put("date.pretty.just_now", "<?php echo $lang->loc['just.now']; ?>");
	    L10N.put("date.pretty.one_minute_ago", "1 <?php echo $lang->loc['minute']." ".$lang->loc['ago']; ?>");
	    L10N.put("date.pretty.minutes_ago", "{0} <?php echo $lang->loc['minutes']." ".$lang->loc['ago']; ?>");
	    L10N.put("date.pretty.one_hour_ago", "1 <?php echo $lang->loc['hour']." ".$lang->loc['ago']; ?>");
	    L10N.put("date.pretty.hours_ago", "{0} <?php echo $lang->loc['hours']." ".$lang->loc['ago']; ?>");
	    L10N.put("date.pretty.yesterday", "<?php echo $lang->loc['yesterday']; ?>");
	    L10N.put("date.pretty.days_ago", "{0} <?php echo $lang->loc['days']." ".$lang->loc['ago']; ?>");
	    L10N.put("date.pretty.one_week_ago", "1 <?php echo $lang->loc['week']." ".$lang->loc['ago']; ?>");
	    L10N.put("date.pretty.weeks_ago", "{0} <?php echo $lang->loc['weeks']." ".$lang->loc['ago']; ?>");
		new MiniMail({ pageSize: 10,
		   total: <?php echo $db->result($sql); ?>,
		   friendCount: <?php echo $serverdb->result($data->select5($user->id), 0); ?>,
		   maxRecipients: 50,
		   messageMaxLength: 20,
		   bodyMaxLength: 4096,
		   secondLevel: <?php if($serverdb->result($data->select5($user->id), 0) == 0){ echo "true"; }else{ echo "false"; } ?>});
	</script>
	</div></div>
    <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php $lang->addLocale("widget.searchhabbos"); ?>
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">
<div class="box-tabs-container clearfix">
    <h2><?php echo $lang->loc['habbos']; ?></h2>
    <ul class="box-tabs">
        <li id="tab-0-4-1"><a href="#"><?php echo $lang->loc['search.habbos']; ?></a><span class="tab-spacer"></span></li>

        <li id="tab-0-4-2" class="selected"><a href="#"><?php echo $lang->loc['invite.friends']; ?></a><span class="tab-spacer"></span></li>
    </ul>
</div>
    <div id="tab-0-4-1-content"  style="display: none">
<div class="habblet-content-info">
    <a name="habbo-search"><?php echo $lang->loc['type.in.name']; ?></a>
</div>
<div id="habbo-search-error-container" style="display: none;"><div id="habbo-search-error" class="rounded rounded-red"></div></div>
<br clear="all"/>
<div id="avatar-habblet-list-search">
    <input type="text" id="avatar-habblet-search-string"/>

    <a href="#" id="avatar-habblet-search-button" class="new-button"><b><?php echo $lang->loc['search']; ?></b><i></i></a>
</div>

<br clear="all"/>

<div id="avatar-habblet-content">
<div id="avatar-habblet-list-container" class="habblet-list-container">
        <ul class="habblet-list">
        </ul>

</div>
<script type="text/javascript">
    L10N.put("habblet.search.error.search_string_too_long", "<?php echo $lang->loc['search.too.long']; ?>");
    L10N.put("habblet.search.error.search_string_too_short", "<?php echo $lang->loc['search.too.short']; ?>");
    L10N.put("habblet.search.add_friend.title", "<?php echo $lang->loc['add.to.friends']; ?>");
	new HabboSearchHabblet(2, 30);

</script>

</div>

<script type="text/javascript">
    Rounder.addCorners($("habbo-search-error"), 8, 8);
</script>    </div>
    <div id="tab-0-4-2-content" >
<div id="friend-invitation-habblet-container" class="box-content">
    <div style="display: none"> 
    <div id="invitation-form" class="clearfix">
        <textarea name="invitation_message" id="invitation_message" class="invitation-message"><?php echo $lang->loc['come.hang.out']; ?>
- <?php echo $user->name; ?></textarea>
        <div id="invitation-email">
            <div class="invitation-input">1.<input  onkeypress="$('invitation_recipient2').enable()" type="text" name="invitation_recipients" id="invitation_recipient1" value="<?php echo $lang->loc['friends.email']; ?>" class="invitation-input" />

            </div>
            <div class="invitation-input">2.<input disabled onkeypress="$('invitation_recipient3').enable()" type="text" name="invitation_recipients" id="invitation_recipient2" value="<?php echo $lang->loc['friends.email']; ?>" class="invitation-input" />
            </div>
            <div class="invitation-input">3.<input disabled  type="text" name="invitation_recipients" id="invitation_recipient3" value="<?php echo $lang->loc['friends.email']; ?>" class="invitation-input" />
            </div>
        </div>
        <div class="clear"></div>
        <div class="fielderror" id="invitation_message_error" style="display: none;"><div class="rounded"></div></div>

    </div>

    <div class="invitation-buttons clearfix" id="invitation_buttons">
		<a  class="new-button" id="send-friend-invite-button" href="#"><b><?php echo $lang->loc['invite.friends']; ?></b><i></i></a>
    </div>
    
    <hr/>
    </div>
    <div id="invitation-link-container">
        <h3><?php echo $lang->loc['enjoy.more']; ?></h3>

        <div class="copytext">
            <p><?php echo $lang->loc['invite.desc']; ?>
<?php if($settings->find("register_referral_rewards") != "0"){ ?><?php echo " ".$lang->loc['reward.text']; ?> <?php echo $settings->find("register_referral_rewards"); ?> <?php echo $lang->loc['credits']; ?>.<?php } ?></p>
        </div>
        <div class="invitation-buttons clearfix"> 
            <a  class="new-button" id="getlink-friend-invite-button" href="#"><b><?php echo $lang->loc['invite.button']; ?></b><i></i></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    L10N.put("invitation.button.invite", "<?php echo $lang->loc['invite.friends']; ?>");
    L10N.put("invitation.form.recipient", "<?php echo $lang->loc['friends.email']; ?>");
    L10N.put("invitation.error.message_too_long", "invitation.error.message_limit");
    inviteFriendHabblet = new InviteFriendHabblet(500);   
    $("friend-invitation-habblet-container").select(".fielderror .rounded").each(function(el) {
        Rounder.addCorners(el, 8, 8);
    });

</script>    </div>

					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php $lang->addLocale("widget.events"); ?>
<?php $categories = explode("|", $lang->loc['events.categories']); ?>
<div class="habblet-container ">		
						<div class="cbb clearfix darkred ">
	
							<h2 class="title"><?php echo $lang->loc['events']; ?>
							</h2>
						<div id="current-events">
	<div class="category-selector">
	<p><?php echo $lang->loc['browse.events']; ?></p>
	<select id="event-category">
		<option value="1"><?php echo $categories[0]; ?></option>
		<option value="2"><?php echo $categories[1]; ?></option>
		<option value="3"><?php echo $categories[2]; ?></option>
		<option value="4"><?php echo $categories[3]; ?></option>
		<option value="5"><?php echo $categories[4]; ?></option>
		<option value="6"><?php echo $categories[5]; ?></option>
		<option value="7"><?php echo $categories[6]; ?></option>
		<option value="8"><?php echo $categories[7]; ?></option>
		<option value="9"><?php echo $categories[8]; ?></option>
		<option value="10"><?php echo $categories[9]; ?></option>
		<option value="11"><?php echo $categories[10]; ?></option>
	</select>
	</div>
	<div id="event-list">

<?php $page['bypass'] = true; require_once('./habblet/ajax_load_events.php'); ?>

	</div>
</div>
<script type="text/javascript">
	document.observe('dom:loaded', function() {
		CurrentRoomEvents.init();
	});
</script>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
				<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
<div id="column2" class="column">
<?php $lang->addLocale("widget.news"); ?>
				<div class="habblet-container news-promo">
						<div class="cbb clearfix notitle ">

<?php $sql = $db->query("SELECT * FROM ".PREFIX."news ORDER BY time DESC LIMIT 5");
$i = 0;
while($row = $db->fetch_assoc($sql)){
	$row['summary'] = nl2br($input->HoloText($row['summary'], true));
	$row['title'] = $input->HoloText($row['title'], true);
	$row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true);
	$row['date'] = date('M j, Y', $row['time']);
	$news[$i] = $row;
	$i++;
}
?>
						<div id="newspromo">
        <div id="topstories">
	        <div class="topstory" style="background-image: url(<?php echo $news[0]['header_image']; ?>)">
	            <h4><?php echo $lang->loc['latest.news']; ?></a></h4>
	            <h3><a href="<?php echo PATH."/articles/".$news[0]['id']."-".$news[0]['title_safe']; ?>"><?php echo $news[0]['title']; ?></a></h3>
	            <p class="summary">
	            <?php echo $news[0]['summary']; ?>
	            </p>
	            <p>
	                <a href="<?php echo PATH."/articles/".$news[0]['id']."-".$news[0]['title_safe']; ?>"><?php echo $lang->loc['read.more']; ?></a>
	            </p>
	        </div>
	        <div class="topstory" style="background-image: url(<?php echo $news[1]['header_image']; ?>); display: none">
	            <h4><?php echo $lang->loc['latest.news']; ?></a></h4>
	            <h3><a href="<?php echo PATH."/articles/".$news[1]['id']."-".$news[1]['title_safe']; ?>"><?php echo $news[1]['title']; ?></a></h3>
	            <p class="summary">
	            <?php echo $news[1]['summary']; ?>
	            </p>
	            <p>
	                <a href="<?php echo PATH."/articles/".$news[1]['id']."-".$news[1]['title_safe']; ?>"><?php echo $lang->loc['read.more']; ?></a>
	            </p>
	        </div>
	        <div class="topstory" style="background-image: url(<?php echo $news[2]['header_image']; ?>); display: none">
	            <h4><?php echo $lang->loc['latest.news']; ?></a></h4>
	            <h3><a href="<?php echo PATH."/articles/".$news[2]['id']."-".$news[2]['title_safe']; ?>"><?php echo $news[2]['title']; ?></a></h3>
	            <p class="summary">
	            <?php echo $news[2]['summary']; ?>
	            </p>
	            <p>
	                <a href="<?php echo PATH."/articles/".$news[2]['id']."-".$news[2]['title_safe']; ?>"><?php echo $lang->loc['read.more']; ?></a>
	            </p>
	        </div>
            <div id="topstories-nav" style="display: none"><a href="#" class="prev"><?php echo $lang->loc['news.previous']; ?></a><span>1</span> / 3<a href="#" class="next"><?php echo $lang->loc['news.next']; ?></a></div>
        </div>
        <ul class="widelist">
            <li class="even">
                <a href="<?php echo PATH."/articles/".$news[3]['id']."-".$news[3]['title_safe']; ?>"><?php echo $news[3]['title']; ?></a><div class="newsitem-date"><?php echo $news[3]['date']; ?></div>
            </li>
            <li class="odd">
                <a href="<?php echo PATH."/articles/".$news[4]['id']."-".$news[4]['title_safe']; ?>"><?php echo $news[4]['title']; ?></a><div class="newsitem-date"><?php echo $news[3]['date']; ?></div>
            </li>
            <li class="last"><a href="<?php echo PATH; ?>/articles"><?php echo $lang->loc['news.more']; ?></a></li>
        </ul>
</div>
<script type="text/javascript">
	document.observe("dom:loaded", function() { NewsPromo.init(); });
</script>
					</div>

				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php $lang->addLocale("widget.staffpicks"); ?>
				<div class="habblet-container ">		
						<div class="cbb clearfix red ">
<div class="box-tabs-container clearfix">
    <h2><?php echo $lang->loc['staff.picks']; ?></h2>
    <ul class="box-tabs">
        <li id="tab-1-3-1"><a href="#"><?php echo $lang->loc['rooms']; ?></a><span class="tab-spacer"></span></li>
        <li id="tab-1-3-2" class="selected"><a href="#"><?php echo $lang->loc['groups']; ?></a><span class="tab-spacer"></span></li>
    </ul>

</div>
    <div id="tab-1-3-1-content"  style="display: none">
    		<div class="progressbar"><img src="<?php echo PATH; ?>/web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></div>
    		<a href="<?php echo PATH; ?>/habblet/proxy?hid=h21" class="tab-ajax"></a>
    </div>
    <div id="tab-1-3-2-content" >
<div id="staffpicks-groups-habblet-list-container" class="habblet-list-container groups-list">
    <ul class="habblet-list two-cols clearfix">
<?php 
$sql = $data->select15(0);
$i = 0;
while($row = $db->fetch_row($sql)){
	if($input->IsEven($i)){
		$even = "even left";
	} else {
		$even = "even right";
	}
?>

        <li class="<?php echo $even; ?>" style="background-image: url(<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $row[2]; ?>.gif)">
            <a class="item" href="<?php echo groupURL($row[0]); ?>"><?php echo $input->HoloText($row[1]); ?></a>
        </li>
<?php $i++; } ?>
    </ul>

</div>
    </div>

					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php $lang->addLocale("widget.recommended"); ?>
<div class="habblet-container ">        
                        <div class="cbb clearfix blue ">
    
                            <h2 class="title"><?php echo $lang->loc['recommended']; ?>
                            </h2>
                        <div id="promogroups-habblet-list-container" class="habblet-list-container groups-list">
    <ul class="habblet-list two-cols clearfix">
    <?php
	$sql = $data->select15(1);
	$i = 0;
    while($row = $db->fetch_row($sql)) {
        if($input->IsEven($i)){
            $even = "even left";
        } else {
            $even = "even right";
        }
    ?>
            <li class="<?php echo $even; ?>" style="background-image: url(<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $row[2]; ?>.gif)">
        <?php if($row[3] != "0") { ?><a href="<?php echo PATH; ?>/client?forwardId=2&amp;roomId=<?php echo $row[3]; ?>" onclick="HabboClient.roomForward(this, '<?php echo $row[3]; ?>', 'private'); return false;" target="client" class="group-room"></a><?php } ?>
            <a class="item" href="<?php echo groupURL($row[0]); ?>"><?php echo $input->HoloText($row[1]); ?></a>
            </li>
            <?php $i++; } ?>
    </ul>
</div>
    
                        
                    </div>
                </div>
                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

<?php $lang->addLocale("widget.tags"); ?>
				<div class="habblet-container ">		
						<div class="cbb clearfix green ">
<div class="box-tabs-container clearfix">
    <h2><?php echo $lang->loc['tags']; ?></h2>
    <ul class="box-tabs">
        <li id="tab-1-5-1"><a href="#"><?php echo $lang->loc['habbos.like']; ?>...</a><span class="tab-spacer"></span></li>

        <li id="tab-1-5-2" class="selected"><a href="#"><?php echo $lang->loc['my.tags']; ?></a><span class="tab-spacer"></span></li>
    </ul>
</div>
    <div id="tab-1-5-1-content"  style="display: none">
    		<div class="progressbar"><img src="<?php echo PATH; ?>/web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></div>
    		<a href="<?php echo PATH; ?>/habblet/proxy?hid=h24" class="tab-ajax"></a>
    </div>
    <div id="tab-1-5-2-content" >
		<div id="my-tag-info" class="habblet-content-info">
		<?php if($count > 19){ echo $lang->loc['tag.limit']; } elseif($count == 0){ echo $lang->loc['tag.none']; }else{ echo $lang->loc['tag.keep.going']; } ?>
		    </div>
<div class="box-content">

<?php
$page['bypass'] = true;
require_once('./habblet/mytagslist.php');
?>

<script type="text/javascript">
document.observe("dom:loaded", function() {
    TagHelper.setTexts({
        tagLimitText: "<?php echo addslashes($lang->loc['tag.limit']); ?>",
        invalidTagText: "<?php echo addslashes($lang->loc['tag.invalid']); ?>",
        buttonText: "<?php echo addslashes($lang->loc['ok']); ?>"
    });
        TagHelper.init('<?php echo $user->id; ?>');
});
</script>
    </div>

					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
				
<?php $lang->addLocale("widget.groups"); ?>
<div class="habblet-container ">
                        <div class="cbb clearfix blue ">
<div class="box-tabs-container clearfix">
    <h2><?php echo $lang->loc['groups']; ?></h2>
    <ul class="box-tabs">
        <li id="tab-2-1"><a href="#"><?php echo $lang->loc['hot.groups']; ?></a><span class="tab-spacer"></span></li>
        <li id="tab-2-2" class="selected"><a href="#"><?php echo $lang->loc['my.groups']; ?></a><span class="tab-spacer"></span></li>
    </ul>
</div>
    <div id="tab-2-1-content"  style="display: none">
    		<div class="progressbar"><img src="<?php echo PATH; ?>/web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></div>
    		<a href="<?php echo PATH; ?>/habblet/proxy?hid=groups" class="tab-ajax"></a>
    </div>
    <div id="tab-2-2-content" >


         <div id="groups-habblet-info" class="habblet-content-info">
                <?php echo $lang->loc['groups.info']; ?>
         </div>

    <div id="groups-habblet-list-container" class="habblet-list-container groups-list">

<?php
$sql = $data->select18($user->id);

echo "\n    <ul class=\"habblet-list two-cols clearfix\">";

$i = 0; $rights = 0; $lefts = 0; 

while($row = $db->fetch_row($sql)){

	if($input->IsEven($i)){
		$pos = "right";
		$rights++;
	} else {
		$pos = "left";
		$lefts++;
	}

	if($input->IsEven($lefts)){
		$oddeven = "odd";
	} else {
		$oddeven = "even";
	}

	echo "            <li class=\"".$oddeven." ".$pos."\" style=\"background-image: url(".PATH."/habbo-imaging/badge/".$row[2].".gif)\">\n            	\n                \n                <a class=\"item\" href=\"".groupURL($row[0])."\">".$input->HoloText($row[1])."</a>\n            </li>";
	$i++;
}

$rights_should_be = $lefts;
if($rights !== $rights_should_be){
	echo "<li class=\"".$oddeven." right\"><div class=\"item\">&nbsp;</div></li>";
}

echo "\n    </ul>";
?>

		<div class="habblet-button-row clearfix"><a class="new-button" id="purchase-group-button" href="#"><b><?php echo $lang->loc['buy.group']; ?></b><i></i></a></div>
    </div>

    <div id="groups-habblet-group-purchase-button" class="habblet-list-container"></div>

<script type="text/javascript">
    $("purchase-group-button").observe("click", function(e) { Event.stop(e); GroupPurchase.open(); });
</script>





    </div>

					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>

<script type="text/javascript">
	HabboView.add(LoginFormUI.init);
</script>
<?php

require('./templates/community_footer.php');

?>