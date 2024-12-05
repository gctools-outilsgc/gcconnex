<?php

/**
 *
 * User setting for Notification options. Displays different options for subscription settings, how to be notified and who or what to subscribe
 * @author Christine Yu <internalfire5@live.com>
 *
 */


gatekeeper();
$user = elgg_get_page_owner_entity();
$plugin = elgg_extract("entity", $vars);
$dbprefix = elgg_get_config('dbprefix');
$site = elgg_get_site_entity();
$lang = get_current_language();
elgg_load_library('elgg:gc_notification:functions');

$title = elgg_echo('cp_notifications:heading:page_title');


$content .= "<input type='text' style='visibility:hidden' name='user_guid' value='".$user->getGUID()."'> ";

if (strcmp(elgg_get_plugin_setting('cp_notifications_disable_content_notifications','cp_notifications'), 'yes') == 0) {
	$content .= "<div class='warning alert-warning col-sm-12'><p>".elgg_echo('cp_newsletter:NO_content_notifications')."</p></div>";
}

/// DIGEST OPTION FOR USER NOTIFICATIONS
$enable_digest = elgg_get_plugin_setting('cp_notifications_enable_bulk','cp_notifications');
if (strcmp($enable_digest, 'yes') == 0) {

	/// Information for the users regarding to the Notifications system
	$content .= "<div class='alert alert-info col-sm-12'><p>".elgg_echo('cp_newsletter:notice')."</p></div>";

	if (elgg_is_admin_user($user->guid))
		$content .= $_SERVER["HTTP_USER_AGENT"];

	$chk_email = create_checkboxes($user->getGUID(), 'cpn_set_digest', array('set_digest_yes', 'set_digest_no'), '', 'id_chkbox_enable_digest', 'class_chkbox_enable_digest');

	$more_info = information_icon(elgg_echo('cp_newsletter:information:digest_option'), elgg_echo('cp_newsletter:information:digest_option:url'));
	$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
	$content .= '<div class="col-sm-12 clearfix"> <h3 class="well">'.elgg_echo('cp_notifications:heading:newsletter_section').'</h3>';

	/// Warning for the Digest functionality
	$content .= "<div class='info_digest_section alert alert-warning col-xs-12' hidden><p>".elgg_echo('cp_newsletter:notice:disable_digest')."</p></div>";

	$content .= '<div class="col-sm-8">'.elgg_echo('cp_newsletter:enable_digest_option').$more_info.'</div>';
	$content .= "<div class='col-sm-2'>{$chk_email} </div> <div class='col-sm-2'>    </div>";


	if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $user->getOwnerGUID(),'cp_notifications'),'set_digest_yes') != 0)
		$visibility = "hidden";
		$content .= "<div id='more_digest_options' {$visibility}>";

		/// select daily or weekly notification
		$user_option = elgg_get_plugin_user_setting('cpn_set_digest_frequency', $user->guid, 'cp_notifications');
		if (strcmp($user_option, 'set_digest_daily') == 0) {
			$chk_occur_daily = "<input type='radio' name='params[cpn_set_digest_frequency]' value='set_digest_daily' checked='checked'> ".elgg_echo('cp_newsletter:label:daily');
			$chk_occur_weekly = "<input type='radio' name='params[cpn_set_digest_frequency]' value='set_digest_weekly'> ".elgg_echo('cp_newsletter:label:weekly');
		} else {
			$chk_occur_weekly = "<input type='radio' name='params[cpn_set_digest_frequency]' value='set_digest_weekly' checked='checked'> ".elgg_echo('cp_newsletter:label:weekly');
			$chk_occur_daily = "<input type='radio' name='params[cpn_set_digest_frequency]' value='set_digest_daily'> ".elgg_echo('cp_newsletter:label:daily');
		}

		$more_info = information_icon(elgg_echo('cp_newsletter:information:frequency'), elgg_echo('cp_newsletter:information:frequency:url'));
		$content .= '<div class="col-sm-8">'.elgg_echo('cp_newsletter:set_frequency')."{$more_info}</div>";
		$content .= "<form> <div class='col-sm-2'>{$chk_occur_daily}</div> <div class='col-sm-2'>{$chk_occur_weekly}</div> </form>";

		/// select language preference
		$user_option = elgg_get_plugin_user_setting('cpn_set_digest_language', $user->guid, 'cp_notifications');
		if (strcmp($user_option, 'set_digest_en') == 0 || ( !isset($user_option) && get_language() === 'en' )) {
			$chk_language_en = "<input type='radio' name='params[cpn_set_digest_language]' value='set_digest_en' checked='checked'> ".elgg_echo('cp_newsletter:label:english');
			$chk_language_fr = "<input type='radio' name='params[cpn_set_digest_language]' value='set_digest_fr'> ".elgg_echo('cp_newsletter:label:french');
		}
		else {
			$chk_language_fr = "<input type='radio' name='params[cpn_set_digest_language]' value='set_digest_fr' checked='checked'> ".elgg_echo('cp_newsletter:label:french');
			$chk_language_en = "<input type='radio' name='params[cpn_set_digest_language]' value='set_digest_en'> ".elgg_echo('cp_newsletter:label:english');
		}

		$more_info = information_icon(elgg_echo('cp_newsletter:information:language'), elgg_echo('cp_newsletter:information:language:url'));
		$content .= '<div class="col-sm-8">'.elgg_echo('cp_newsletter:set_language')."{$more_info}</div>";
		$content .= "<div class='col-sm-2'>{$chk_language_en}</div> <div class='col-sm-2'>{$chk_language_fr}</div>";

	$content .= "</div>";
	$content .= "</div>";
	$content .= "</section>";

}



/// PERSONAL NOTIFICATIONS (NOTIFY FOR LIKES, @MENTIONS AND MAYBE SHARES)
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '<div class="col-sm-12 clearfix"> <h3 class="well">'.elgg_echo('cp_notifications:heading:personal_section').'</h3>';

$personal_notifications = array('likes','mentions','content', 'opportunities');
foreach ($personal_notifications as $label) {

	$chk_email = create_checkboxes($user->getGUID(), "cpn_{$label}_email", array("{$label}_email", "set_notify_off"), elgg_echo('cp_notifications:chkbox:email'));
	$chk_site = create_checkboxes($user->getGUID(), "cpn_{$label}_site", array("{$label}_site", "set_notify_off"), elgg_echo('cp_notifications:chkbox:site'), '', 'chkbox_site');
	$content .= '<div class="col-sm-8">'.elgg_echo("cp_notifications:personal_{$label}").'</div>';
	$content .= "<div class='col-sm-2'>{$chk_email}</div> <div class='col-sm-2'>{$chk_site}</div>";
}

$content .= '</div>';
$content .= '</section>';



/// SUBSCRIBE TO COLLEAGUE NOTIFICATIONS
$colleagues = $user->getFriends(array('limit' => false));
$subscribed_colleagues = elgg_get_plugin_user_setting('subscribe_colleague_picker', $user->getOwnerGUID(),'cp_notifications');


	$subbed_colleagues = elgg_get_entities_from_relationship(array(
		'relationship' => 'cp_subscribed_to_site_mail',
		'relationship_guid' => $user->guid,
		'type' => 'user',
		'limit' => false,
	));

	foreach($subbed_colleagues as $c) {
		
		$subbed_colleague_guids[] = $c->getGUID();
	}

$colleague_picker = elgg_view('input/friendspicker', array(
	'entities' => $colleagues,
	'name' => 'params[subscribe_colleague_picker]',
	'value' => $subbed_colleague_guids//json_decode($subscribed_colleagues,true),
));

$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '	<div class="col-sm-12"><h3 class="well">'.elgg_echo('cp_notifications:heading:colleague_section').'</h3>';
//$content .= '		<div class="col-sm-8">'.elgg_echo('cp_notifications:pick_colleagues').'</div>';
$content .= '		<div class="accordion col-sm-12 clearfix mrgn-bttm-sm">';
$content .= '			<div class="tgl-panel clearfix">';
$content .= '				<details style="width:100%; display:inline-block;" >';
$content .= '					<summary>'.elgg_echo('cp_notifications:pick_colleagues').'</summary>';
$content .= "					<div style='padding:5px 15px 0px 5px;'> {$colleague_picker} </div>";
$content .= '				</details>';
$content .= '			</div>';
$content .= '		</div>';
$content .= '	</div>';
$content .= "</section>";



// SUBSCRIBED TO GROUP AND GROUP CONTENT
$subscribe_link = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/cp_notifications/user_autosubscription?sub=sub");
$unsubscribe_link = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/cp_notifications/user_autosubscription?sub=unsub");


$chk_all_email = create_checkboxes($user->getGUID(), "cpn_group_email_{$user->getGUID()}", array(),  elgg_echo('cp_notifications:chkbox:email'), 'chk_group_email', 'all-email');
$chk_all_site_mail = create_checkboxes($user->getGUID(), "cpn_group_site_{$user->getGUID()}", array(),  elgg_echo('cp_notifications:chkbox:site'), 'chk_group_site', 'all-site chkbox_site');

$query = "SELECT g.name, g.guid FROM {$dbprefix}entity_relationships r LEFT JOIN {$dbprefix}groups_entity g ON r.guid_two = g.guid WHERE r.guid_one = {$user->guid} AND r.relationship = 'member' ORDER BY g.name";
$groups = get_data($query);

/// SUBSCRIBE OR UNSUBSCRIBE TO ALL GROUP AND GROUP CONTENT NOTIFICATIONS
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '	<div class="col-sm-12 group-notification-options"><h3 class="well">'.elgg_echo('cp_notifications:heading:group_section').'</h3>';
$content .= "		<div style='padding-bottom:50px;'>";
$content .= "			<div style='border:1px solid black; padding: 2px 2px 2px 10px;'> <center><a href='{$subscribe_link}'> ".elgg_echo('cp_notifications:subscribe_all_label',array($subscribe_link,$unsubscribe_link))." </a></center></div>";
$content .= "		</div>";

$more_info = information_icon(elgg_echo('cp_newsletter:information:select_all'), elgg_echo('cp_newsletter:information:select_all:url'));
$content .= "<div class='col-sm-8'> ".elgg_echo('cp_notifications:chkbox:select_all_group_for_notification')." {$more_info} </div> <div class='col-sm-2 mrgn-bttm-md'>{$chk_all_email}</div>		<div class='col-sm-2 mrgn-bttm-md'>{$chk_all_site_mail}</div>";
$content .= "<hr/>";


$content .= "<div id='group_notifications_section'>";
foreach ($groups as $group) {
	if (!$group->guid) continue;

	$group_title = gc_explode_translation($group->name,$lang);
	// list all the groups, Update Relationship table as per selection by user
    $group_subscription = check_entity_relationship ($user->guid, 'cp_subscribed_to_email', $group->guid);
    $group_notification_settings = ($group_subscription) ? "sub_{$group->guid}" : "set_notify_off";
    elgg_set_plugin_user_setting("cpn_email_{$group->guid}", $group_notification_settings, $user->guid, 'cp_notifications');

    $group_subscription = check_entity_relationship ($user->guid, 'cp_subscribed_to_site_mail', $group->guid);
    $group_notification_settings = ($group_subscription) ? "sub_site_{$group->guid}" : "set_notify_off";
    elgg_set_plugin_user_setting("cpn_site_mail_{$group->guid}", $group_notification_settings, $user->guid, 'cp_notifications');

    $group_url = elgg_get_site_url()."groups/profile/{$group->guid}/{$group->name}";
    // Nick - checkboxes for email and site. if they are checked they will send 'sub_groupGUID' if not checked they will send 'unSub' (is now set_notify_off)
	$chk_email_grp = create_checkboxes($user->getGUID(), "cpn_email_{$group->guid}", array("sub_{$group->guid}", "set_notify_off"),  elgg_echo('cp_notifications:chkbox:email'), '', 'group_email');
	$chk_site_grp = create_checkboxes($user->getGUID(), "cpn_site_mail_{$group->guid}", array("sub_site_{$group->guid}", "set_notify_off"),  elgg_echo('cp_notifications:chkbox:site'), '', 'group_site chkbox_site');

	$content .= "			<div class='namefield col-sm-8'> <strong> <a href='{$group_url}' id='group-{$group->guid}'>{$group_title}</a> </strong> </div>";
    $content .= "			<div class='col-sm-2'>{$chk_email_grp}</div>	<div class='col-sm-2'>{$chk_site_grp}</div>";

	// GROUP CONTENT SUBSCRIPTIONS
	if (has_group_subscriptions($group->guid, $user->getGUID())) {
	    $content .= '		<div class="accordion col-sm-12 clearfix mrgn-bttm-sm">';
		$content .= '			<details onClick="return create_group_content_item('.$group->guid.', '.$user->getGUID().')">';
		$content .= "				<summary >".elgg_echo('cp_notifications:group_content')." ".$subscription_count.'</summary>';

	    $content .= "				<div id='group-content-{$group->guid}' class='tgl-panel clearfix'></div>";
	    $content .= '			</details>';
	    $content .= '		</div> <hr/>';
    } else {
    	$content .= '		<div class="col-sm-12 clearfix mrgn-bttm-sm">';
		$content .= '			<details">';
		$content .= "				<summary >".elgg_echo('cp_notifications:no_group_content').'</summary>';
	    $content .= '			</details>';
	    $content .= '		</div> <hr/>';
    }

}
$content .= "</div>";
$content .= "</section>";



/// PERSONAL SUBSCRIPTIONS (DISPLAYS ALL ITEMS THAT DO NOT BELONG IN GROUP NOTIFICATIONS)
$entity_list = array('blog', 'poll', 'bookmarks', 'event_calendar', 'file', 'photo', /*'task',*/ /*'page',*/ 'thewire'/*, 'task'*/);
$personal_subscriptions = get_data($query);


// ajax the view for personal notifications (performance enhancement)
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '<div class="col-sm-12 group-notification-options"><h3 class="well">'.elgg_echo('cp_notifications:heading:nonGroup_section').'</h3>';

$content .= "<div class='alert alert-info col-sm-12'><p>".elgg_echo('cp_newsletter:other_content:notice')."</p></div>";

$display_entity_list = array();
$content_text = "";

foreach ($entity_list as $subtype) {

	$content_text .= '<div class="accordion col-sm-12 clearfix mrgn-bttm-sm">';
	$content_text .= '<details onClick="return create_content_item('.$user->getGUID().',\''.$subtype.'\') ">';
	$content_text .= "<summary> ".elgg_echo("cp_notifications:subtype:{$subtype}")." </summary>";
	$content_text .= "<div id='personal-content-{$subtype}' class='tgl-panel clearfix'></div>";
	$content_text .= '</details>';
	$content_text .= "</div>";

	$display_entity_list[elgg_echo("cp_notifications:subtype:{$subtype}")] = $content_text;
	$content_text = "";
}

ksort($display_entity_list);
foreach ($display_entity_list as $key => $display) {
	$content .= $display;
}




$content .= "</div>";
$content .= "</section>";

if (strcmp(elgg_get_plugin_setting('cp_notifications_sidebar','cp_notifications'), 'yes') == 0)
	echo elgg_extend_view('page/elements/sidebar','cp_notifications/sidebar');

echo elgg_view_module('info', $title, $content);




$submit = elgg_view('input/submit',
	['value' => elgg_echo('save'), 'class' => 'btn btn-primary']
);
echo elgg_format_element('div', ['class' => 'elgg-foot'], $submit);

?>





<?php /// css scripts to render the usersettings page for notifications ?>





<style>

/* The switch - the box around the slider */
.switch {
	position: relative;
	display: inline-block;
	width: 30px;
	height: 15px;
}

/* Hide default HTML checkbox */
.switch input { display:none; }

/* The slider */
.slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #ccc;
	border: 1px solid #047177;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-transition: .4s;
	transition: .4s;
}

.slider:before {
	left: -1px;
	top : -1px;
	position: absolute;
	content: "";
	height: 15px;
	width: 15px;
	background-color: white;
	border: 1px solid #000;
	border-radius: 4px;
	-webkit-transition: .4s;
	transition: .4s;
}



input:checked + .slider {
	background-color: #047177;
}

input:focus + .slider {
	box-shadow: 0 0 1px #047177;
}

input:checked + .slider:before {
	transform: translateX( 15px );
}

/* Rounded sliders */
.slider.round {
	border-radius: 4px;
}

</style>


<?php /// jquery and javascripts to render the usersettings page for notifications ?>
<script>

	/// jquery to limit the functionality
	$(document).ready( function () {

		//$(".class_chkbox_enable_digest").removeClass('elgg-input-checkbox');
		//$("#id_chkbox_enable_digest").removeClass('elgg-input-checkbox');

		if ($(".class_chkbox_enable_digest").is(":checked"))
	        $(".chkbox_site").closest("label").css({"color":"gray"});
	    else
	        $(".chkbox_site").closest("label").css({"color":"black"});

		// select all groups
		$(".all-email").click(function() {
			var checkedStatus = this.checked;
			$(".group_email").prop('checked', $(this).prop("checked"));
		});

		$(".all-site").click(function() {
			var checkedStatus = this.checked;
			$(".group_site").prop('checked', $(this).prop("checked"));
		});

		// toggle for more digest options
		$('input[name="params[cpn_set_digest]"]').click(function() {

			if (document.getElementById("id_chkbox_enable_digest").checked) {
				document.getElementById("more_digest_options").style.display = "block";
			} else {
				document.getElementById("more_digest_options").style.display = "none";
			}

			//$("#more_digest_options").fadeToggle(this.checked);

			$(".chkbox_site").attr('disabled',this.checked);

			if ($(this).is(":checked"))
		        $(".chkbox_site").closest("label").css({"color":"gray"});
		    else
		       $(".chkbox_site").closest("label").css({"color":"black"});


			if (this.checked)
				$(".info_digest_section").show('slow');
			else
				$(".info_digest_section").hide();
		});

		$(' #digest_frequency').click(function(e) {
		    $(' #digest_frequency').not(this).prop('checked', false);

		    if ($("#digest_frequency:checked").length == 0)
		    	return false;
		});

		$(' #digest_language').click(function(e) {
		    $(' #digest_language').not(this).prop('checked', false);

    		if ($("#digest_language:checked").length == 0)
    			return false;
		});


	});


	/// Uses Ajax to dynamically create and display the list of group content that the user has subscribed to
	function create_group_content_item(grp_guid, usr_guid) {

		if ($('#group-content-' + grp_guid).is(':visible')) {
			// do nothing
		} else {
			var loading_text = elgg.echo('cp_notifications:loading');
			var nothing_text = elgg.echo('cp_notifications:no_group_subscription');

			$('#group-content-' + grp_guid).children().remove();
			$('#group-content-' + grp_guid).append("<div class='clearfix col-sm-12 list-break'>" + loading_text + "<div>");
			// jquery - retrieve the group content on user click (this way it doesn't try and load everything at once)
			elgg.action('cp_notify/retrieve_group_contents', {
				data: {
					group_guid: grp_guid,
					user_guid: usr_guid,
				},
				success: function (content_arr) {

					$('#group-content-' + grp_guid).children().remove();
					// create a list of all the content in the group that you are subscribed to
					for (var item in content_arr.output.text3)
						$('#group-content-' + grp_guid).append("<div class='clearfix col-sm-12 list-break'>" + content_arr.output.text3[item] + "<div>");

					if (content_arr.output.text3.length == 0)
						$('#group-content-' + grp_guid).append("<div class='clearfix col-sm-12 list-break'>" + nothing_text + "<div>");

					// jquery - when the unsubscribe button is clicked, remove entry from the subscribed to content
				    $('.unsub-button').on('click', function() {
				        var this_thing = $(this);
				        var guid = parseInt($(this_thing).attr('id'));

				        elgg.action('cp_notify/unsubscribe', {
			                data: {
			                	'guid':guid,
			                	'user_guid': elgg.get_page_owner_guid()
			                },
			                success: function(data) {
			                  $(this_thing).closest('.list-break').fadeOut();
			                }
				        });
				    });
				},
				error:function(xhr, status, error) {
					alert('Error: ' + status + '\nError Text: ' + error + '\nResponse Text: ' + xhr.responseText);
				}
			});

		}
	}


	/// Uses Ajax to dynamically create and display the list of personal content that the user has subscribed to
	function create_content_item(usr_guid, obj_subtype) {
		entity_subtype = obj_subtype;
		// loading indicator
		var loading_text = elgg.echo('cp_notifications:loading');
		$('#personal-content-' + entity_subtype).append("<div class='clearfix col-sm-12 list-break'>" + loading_text + "<div>");

		elgg.action('cp_notify/retrieve_personal_content', {
			data: {
				user_guid: usr_guid,
				subtype: entity_subtype
			},
			success: function (sample_text) {
				var nothing_text = elgg.echo('cp_notifications:no_personal_subscription');


				// assuming this is doing what i think it is doing
				$('#personal-content-' + entity_subtype).children().remove();
				// create a list of all the content in the group that you are subscribed to
				for (var item in sample_text.output.text3)
					$('#personal-content-' + entity_subtype).append("<div class='clearfix col-sm-12 list-break'>" + sample_text.output.text3[item] + "<div>");

				if (sample_text.output.text3.length == 0)
					$('#personal-content-' + entity_subtype).append("<div class='clearfix col-sm-12 list-break'>" + nothing_text + "<div>");

				// jquery - when the unsubscribe button is clicked, remove entry from the subscribed to content
			    $('.unsub-button').on('click', function() {
			        var this_thing = $(this);
			        var guid = parseInt($(this_thing).attr('id'));

			        elgg.action('cp_notify/unsubscribe', {
		                data: {
		                	'guid': guid,
		                	'user_guid': elgg.get_page_owner_guid()
		                },
		                success: function(data) {
		                  $(this_thing).closest('.list-break').fadeOut();
		                }
			        }); // elgg.action

			    }); // jquery click
			} // success for elgg.action

		}); // elgg.action
	}

</script>

<?php
