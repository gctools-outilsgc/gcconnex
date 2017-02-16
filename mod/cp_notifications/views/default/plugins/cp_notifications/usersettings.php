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
elgg_load_library('elgg:gc_notification:functions');

$title = elgg_echo('cp_notify:panel_title',array("<a href='".elgg_get_site_url()."settings/user/'>".elgg_echo('label:email')."</a>"));
$current_user = elgg_get_logged_in_user_entity();


/// DIGEST OPTION FOR USER NOTIFICATIONS
$enable_digest = elgg_get_plugin_setting('cp_notifications_enable_bulk','cp_notifications');
if (strcmp($enable_digest, 'yes') == 0) {
	
	/// enable notifications digest
	$chk_email = create_checkboxes($user->getGUID(), 'cpn_set_digest', array('set_digest_yes', 'set_digest_no'), elgg_echo('label:email'));
	$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
	$content .= '<div class="col-sm-12 clearfix"> <h3 class="well">'.elgg_echo('cp_notify:NewsletterSettings').'</h3>'; 
	$content .= '<div class="col-sm-8">'.elgg_echo('cp_notify:enable_digest').'</div>';
	$content .= "<div class='col-sm-2'>{$chk_email}</div> <div class='col-sm-2'>     </div>";

	
	if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $user->getOwnerGUID(),'cp_notifications'),'set_digest_yes') != 0)
		$visibility = "hidden";

	$content .= "<div id='more_digest_options' {$visibility}>";

		/// select daily or weekly notification
		$chk_occur_daily = create_checkboxes($user->getGUID(), 'cpn_set_digest_freq_daily', array('set_digest_daily', 'set_digest_no'), elgg_echo('label:daily'), 'digest_frequency');
		$chk_occur_weekly = create_checkboxes($user->getGUID(), 'cpn_set_digest_freq_weekly', array('set_digest_weekly', 'set_digest_no'), elgg_echo('label:weekly'), 'digest_frequency');
		$more_info = "<span class='pull-right'><a title='How frequent the digest should be sent out' target='_blank' href='#'><i class='fa fa-info-circle icon-sel'><span class='wb-invisible'> </span></i></a></span>";

		$content .= '<div class="col-sm-8">'.elgg_echo('cp_notify:set_frequency')."{$more_info}</div>";
		$content .= "<div class='col-sm-2'>{$chk_occur_daily}</div> <div class='col-sm-2'>{$chk_occur_weekly}</div>";	
		
		/// select language preference
		$chk_language_en = create_checkboxes($user->getGUID(), 'cpn_set_digest_lang_en', array('set_digest_en', 'set_digest_no'), elgg_echo('label:english'), 'digest_language');
		$chk_language_fr = create_checkboxes($user->getGUID(), 'cpn_set_digest_lang_fr', array('set_digest_fr', 'set_digest_no'), elgg_echo('label:french'), 'digest_language');
		$more_info = "<span class='pull-right'><a title='What is the preferred language that the digest should be sent in' target='_blank' href='#'><i class='fa fa-info-circle icon-sel'><span class='wb-invisible'> </span></i></a></span>";

		$content .= '<div class="col-sm-8">'.elgg_echo('cp_notify:set_language')."{$more_info}</div>";
		$content .= "<div class='col-sm-2'>{$chk_language_en}</div> <div class='col-sm-2'>{$chk_language_fr}</div>";

	$content .= "</div>";

	$content .= "</div>";
	$content .= "</section>";

}

/// PERSONAL NOTIFICATIONS (NOTIFY FOR LIKES, @MENTIONS AND MAYBE SHARES)
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '<div class="col-sm-12 clearfix"> <h3 class="well">'.elgg_echo('cp_notify:personalNotif').'</h3>';

$personal_notifications = array('likes','mentions','content', 'opportunities');
foreach ($personal_notifications as $label) {

	$chk_email = create_checkboxes($user->getGUID(), "cpn_{$label}_email", array("{$label}_email", "set_notify_off"), elgg_echo('label:email'));
	$chk_site = create_checkboxes($user->getGUID(), "cpn_{$label}_site", array("{$label}_site", "set_notify_off"), elgg_echo('label:site'));
	$content .= '<div class="col-sm-8">'.elgg_echo("cp_notify:personal_{$label}").'</div>';
	$content .= "<div class='col-sm-2'>{$chk_email}</div> <div class='col-sm-2'>{$chk_site}</div>";
}

$content .= '</div>';
$content .= '</section>';


 
/// SUBSCRIBE TO COLLEAGUE NOTIFICATIONS
$colleagues = $user->getFriends(array('limit' => false));
$subscribed_colleagues = elgg_get_plugin_user_setting('subscribe_colleague_picker', $user->getOwnerGUID(),'cp_notifications');

$colleague_picker = elgg_view('input/friendspicker', array(
	'entities' => $colleagues, 
	'name' => 'params[subscribe_colleague_picker]', 
	'value' => json_decode($subscribed_colleagues,true),
));

$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '	<div class="col-sm-12"><h3 class="well">'.elgg_echo('cp_notify:collNotif').'</h3>';
$content .= '		<div class="col-sm-8">'.elgg_echo('cp_notify:colleagueContent').'</div>';
$content .= '		<div class="accordion col-sm-12 clearfix mrgn-bttm-sm">';
$content .= '			<div class="tgl-panel clearfix">';
$content .= '				<details style="width:100%; display:inline-block;" >';
$content .= '					<summary>'.elgg_echo('cp_notify:pickColleagues').'</summary>';
$content .= "					<div style='padding:5px 15px 0px 5px;'> {$colleague_picker} </div>";
$content .= '				</details>';
$content .= '			</div>';	
$content .= '		</div>';		
$content .= '	</div>';		
$content .= "</section>";



// SUBSCRIBED TO GROUP AND GROUP CONTENT
$subscribe_link = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/cp_notifications/user_autosubscription?sub=sub");
$unsubscribe_link = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/cp_notifications/user_autosubscription?sub=unsub");

$chk_all_email = elgg_view('input/checkbox', array(
	'name' => "params[cpn_group_email_{$user->getGUID()}]",
	'label'=>elgg_echo('cp_notify:emailsForGroup'),
	'class'=>'all-email'
));

$chk_all_site_mail = elgg_view('input/checkbox', array(
	'name' => "params[cpn_group_site_{$user->getGUID()}]",
	'label' => elgg_echo('cp_notify:siteForGroup'),
	'class'=>'all-site'
));

$query = "
SELECT g.name, g.guid
FROM elggentity_relationships r
	LEFT JOIN elgggroups_entity g ON r.guid_two = g.guid
WHERE r.guid_one = {$user->guid} AND r.relationship = 'member' 
";
$groups = get_data($query);

// $options = array(
// 	'relationship' => 'member',
// 	'relationship_guid' => $user->guid,
// 	'type' => 'group',
// 	'joins' => array("INNER JOIN {$dbprefix}groups_entity g ON (e.guid = g.guid)"),
// 	'order_by' => 'g.name',
// 	'offset' => $group_offset,
// 	'limit' => false,
// );
//$groups = elgg_get_entities_from_relationship($options);


/// SUBSCRIBE OR UNSUBSCRIBE TO ALL GROUP AND GROUP CONTENT NOTIFICATIONS 
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '	<div class="col-sm-12 group-notification-options"><h3 class="well">'.elgg_echo('cp_notify:groupNotif').'</h3>';
$content .= "		<div style='padding-bottom:50px;'>";
$content .= "			<div style='border:1px solid black; padding: 2px 2px 2px 10px;'> <center><a href='{$subscribe_link}'> ".elgg_echo('cp_notify:subscribe_all_label',array($subscribe_link,$unsubscribe_link))." </a></center></div>";
$content .= "		</div>";

$content .= "		<div class='clearfix brdr-bttm mrgn-bttm-sm'>";
$content .= "			<div class='col-sm-2 col-sm-offset-8 mrgn-bttm-md'>{$chk_all_email}</div>";
$content .= "			<div class='col-sm-2 mrgn-bttm-md'>{$chk_all_site_mail}</div>";

// script to check all email and site mail's group checkboxes
$content .='<script>$(".all-email").click(function(){$(".group-check").prop("checked", this.checked);$(".group-check").trigger("change")})</script>';
$content .='<script>$(".all-site").click(function(){$(".group-site").prop("checked", this.checked);$(".group-site").trigger("change")})</script>';

foreach ($groups as $group) {

    // Nick - This asks for the inputs of the checkboxes. If the checkbox is checked it will save it's value. else it will return 'unSub' or 'site_unSub'
	$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$group->guid}", $user->guid);	// setting email notification

	// list all the groups, Update Relationship table as per selection by user
    $group_subscription = check_entity_relationship ($user->guid, 'cp_subscribed_to_email', $group->guid);
    if ($group_subscription) 
    	elgg_set_plugin_user_setting("cpn_email_{$group->guid}", "sub_{$group->guid}", $user->guid, 'cp_notifications');
    else
    	elgg_set_plugin_user_setting("cpn_email_{$group->guid}", "set_notify_off", $user->guid, 'cp_notifications');

    $group_subscription = check_entity_relationship ($user->guid, 'cp_subscribed_to_site_mail', $group->guid);
    if ($group_subscription) 
    	elgg_set_plugin_user_setting("cpn_site_mail_{$group->guid}", "sub_{$group->guid}", $user->guid, 'cp_notifications');
    else
    	elgg_set_plugin_user_setting("cpn_site_mail_{$group->guid}", "set_notify_off", $user->guid, 'cp_notifications');


    $group_url = elgg_get_site_url()."groups/profile/{$group->guid}/{$group->name}";
    // Nick - checkboxes for email and site. if they are checked they will send 'sub_groupGUID' if not checked they will send 'unSub' (is now set_notify_off)
	$chk_email_grp = create_checkboxes($user->getGUID(), "cpn_email_{$group->guid}", array("sub_{$group->guid}", "set_notify_off"), elgg_echo('label:email'));
	$chk_site_grp = create_checkboxes($user->getGUID(), "cpn_site_mail_{$group->guid}", array("'sub_site_{$group->guid}", "set_notify_off"), elgg_echo('label:site'));

	$content .= "			<div class='namefield col-sm-8'> <strong> <a href='{$group_url}' id='group-{$group->guid}'>{$group->name}</a> </strong> </div>";
    $content .= "			<div class='col-sm-2'>{$chk_email_grp}</div>";
    $content .= "			<div class='col-sm-2'>{$chk_site_grp}</div>";

	// GROUP CONTENT SUBSCRIPTIONS
    $content .= '		<div class="accordion col-sm-12 clearfix mrgn-bttm-sm">';
	$content .= '			<details onClick="return create_group_content_item('.$group->guid.', '.$user->getGUID().')">';
	$content .= "				<summary >".elgg_echo('cp_notify:groupContent').'</summary>';
    $content .= "				<div id='group-content-{$group->guid}' class='tgl-panel clearfix'></div>";
    $content .= '			</details>';	
    $content .= '		</div>';			
   				
} 
$content .= '	</div>';
$content .= "</section>";





/// PERSONAL SUBSCRIPTIONS (DISPLAYS ALL ITEMS THAT DO NOT BELONG IN GROUP NOTIFICATIONS)

// cyu - patched issue with personal subscription that contains group content
// $query = "
// SELECT e.guid, e.subtype as entity_subtype, es.subtype, o.title, o.description
// FROM {$dbprefix}entity_subtypes es, {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o 
// WHERE e.container_guid 
// 	NOT IN (SELECT guid 
// 			FROM {$dbprefix}groups_entity) 
// 	AND e.subtype = es.id 
// 	AND o.description <> '' 
// 	AND o.guid = e.guid 
// 	AND o.guid = r.guid_two 
// 	AND r.guid_one = {$current_user->getGUID()} 
// 	AND r.relationship = 'cp_subscribed_to_email' 
// 	AND (	es.subtype = 'poll' OR
// 			es.subtype = 'blog' OR
// 			es.subtype = 'bookmark' OR
// 			es.subtype = 'event_calendar' OR
// 			es.subtype = 'file' OR
// 			es.subtype = 'photo' OR
// 			es.subtype = 'album' OR
// 			es.subtype = 'task' OR
// 			es.subtype = 'page' OR
// 			es.subtype = 'page_top' OR
// 			es.subtype = 'idea' OR
// 			es.subtype = 'thewire' )
// ";

$entity_list = array('blog', 'poll', 'bookmarks', 'event_calendar', 'file', 'photo', 'task', /*'page',*/ 'thewire'/*, 'task'*/);
$personal_subscriptions = get_data($query);


// ajax the view for personal notifications (performance enhancement)
$content .= "<section id='notificationstable' cellspacing='0' cellpadding='4' width='100%' class='clearfix'>";
$content .= '<div class="col-sm-12 group-notification-options"><h3 class="well">'.elgg_echo('cp_notify:personal_setting').'</h3>';

foreach ($entity_list as $subtype) {

	$display_subtype = cp_translate_subtype($subtype);

	$content .= '<div class="accordion col-sm-12 clearfix mrgn-bttm-sm">';
	//$content .= '<details onClick="return create_content_item('.$user->getGUID().',"'.$subtype.'")">';
	$content .= '<details onClick="return create_content_item('.$user->getGUID().',\''.$subtype.'\') ">';
	$content .= "<summary> {$display_subtype} </summary>";
	$content .= "<div id='personal-content-{$subtype}' class='tgl-panel clearfix'></div>";
	$content .= '</details>';
	$content .= "</div>";
}

$content .= "</div>";
$content .= "</section>";


// $cp_count = 0;
// foreach ($personal_subscriptions as $subscription) {
// 	$content_title = $subscription->title;
// 	if (!$content_title) $content_title = elgg_echo('cp_notify:wirepost_generic_title');

// 	// cyu - clean up the html tags from the description
// 	$content_desc = trim($subscription->description);
// 	$content_desc = str_replace('\r\n', '', $content_desc);
// 	$content_desc = str_replace('\n', '', $content_desc);
// 	$content_desc = str_replace('\r', '', $content_desc);
// 	$content_desc = preg_replace('/[\s]+/','',$content_desc);
// 	$content_desc = preg_replace("/<[a-zA-Z ]+>|<\/[a-zA-Z]+>/",'',$content_desc);
// 	$content_desc = strip_tags($content_desc);

// 	if (strlen($content_desc) >= 30)
// 		$content_desc = substr($content_desc, 0, 30).'...';


// 	$subscription_button = elgg_view('input/button', array(
// 		'class'=> 'btn btn-default unsub-button',
// 		'id'=> $subscription->guid.'_unsub',
// 		'value'=> elgg_echo("cp_notify:unsubscribe"),
// 		'align' => 'right',
// 	));

// 	// form the url
// 	$entity_content = get_entity($subscription->guid);
// 	$url = $entity_content->getURL();

// 	$translated_subtype = cp_translate_subtype($subscription->subtype);

// 	$content .= "<div class='clearfix col-sm-12 list-break'>";
// 	$content .= "<div class='togglefield col-sm-10'> {$translated_subtype} : <a href='{$url}'><strong>{$content_title}</strong></a></div>";
// 	$content .= "<div class=' col-sm-2'> {$subscription_button} </div>";
// 	$content .= "</div>";

// 	$cp_count++;
// }

// if ($cp_count <= 0)
// 	$content .= elgg_echo('cp_notify:no_subscription')."<br/>";

if (strcmp(elgg_get_plugin_setting('cp_notifications_sidebar','cp_notifications'), 'yes') == 0)
	echo elgg_extend_view('page/elements/sidebar','cp_notifications/sidebar');

echo elgg_view_module('info', $title, $content);



?>



<?php /// jquery and javascripts to render the usersettings page for notifications ?>
<script>

	/// jquery to limit the functionality
	$(document).ready( function () {
		$('input[name="params[cpn_set_digest]"]').click(function() {
			$("#more_digest_options").toggle(this.checked);
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
			var loading_text = elgg.echo('cp_notify:setting:loading');

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
						$('#group-content-' + grp_guid).append("<div class='clearfix col-sm-12 list-break'>" + "Nothing to show" + "<div>");

					// jquery - when the unsubscribe button is clicked, remove entry from the subscribed to content
				    $('.unsub-button').on('click', function() {
				        var this_thing = $(this);
				        var guid = parseInt($(this_thing).attr('id'));
				        
				        elgg.action('cp_notify/unsubscribe', {
			                data: {
			                	'guid':guid,
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
		$('#personal-content-' + entity_subtype).append("<div class='clearfix col-sm-12 list-break'>LOADING...<div>");

		elgg.action('cp_notify/retrieve_personal_content', {
			data: {
				user_guid: usr_guid,
				subtype: entity_subtype
			},
			success: function (sample_text) {

				// assuming this is doing what i think it is doing 
				$('#personal-content-' + entity_subtype).children().remove();
				// create a list of all the content in the group that you are subscribed to
				for (var item in sample_text.output.text3)
					$('#personal-content-' + entity_subtype).append("<div class='clearfix col-sm-12 list-break'>" + sample_text.output.text3[item] + "<div>");
				
				if (sample_text.output.text3.length == 0)
					$('#personal-content-' + entity_subtype).append("<div class='clearfix col-sm-12 list-break'>" + "Nothing to show" + "<div>");

				// jquery - when the unsubscribe button is clicked, remove entry from the subscribed to content
			    $('.unsub-button').on('click', function() {
			        var this_thing = $(this);
			        var guid = parseInt($(this_thing).attr('id'));
			        
			        elgg.action('cp_notify/unsubscribe', {
		                data: {
		                	'guid':guid
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


