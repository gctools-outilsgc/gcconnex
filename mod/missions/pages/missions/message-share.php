<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page for messaging the manager of a mission, sharing a mission with a friend, sharing a mission with The Wire, or prompting users to opt in.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$entity_guid = array_pop($blast_radius);
$entity = get_entity($entity_guid);
$switch_segment = array_pop($blast_radius);

$highlight_one = false;
$highlight_two = false;

// Sharing a mission can done with another user or with The Wire
switch($switch_segment) {
	case 'wire':
		if($entity->type == 'user') {
			// Not in use at the moment.
		}
		else if($entity->type == 'object' && get_subtype_from_id($entity->subtype) == 'mission') {

            //Nick changing this to use the wire reshare view and added col class
			$main_content = elgg_view_form('missions/wire-post', array('class'=>'clearfix col-sm-8',), array('entity_subject' => $entity)) . '</section>';
			$title = elgg_echo('missions:share_with_colleague');
		}
		$highlight_two = true;
		break;
	default:
		$recipient_username = '';
		$message_subject = '';
		$message_body = '';
		// If the passed GUID corresponds to a user then it's a message to a user about opting in to Micro-Missions
		if($entity->type == 'user') {
			$recipient_username = $entity->username;
			//$title = elgg_echo('missions:email_manager');
			$message_body = elgg_echo('missions:check_micro_missions');
			$message_subject = elgg_echo('missions:invite_to_opt_in');
			$title = elgg_echo('missions:invite_to_opt_in');
		}
		// If the passed GUID corrseponds to a mission then a mission is being shared.
		else if($entity->type == 'object' && get_subtype_from_id($entity->subtype) == 'mission') {
			$message_body = elgg_echo('missions:check_this_mission', array(elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')), $entity->getURL()));
			$message_subject = elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')) . ' ' . elgg_echo('missions:micro_mission');
			$title = elgg_echo('missions:share_with_colleague');
		}
		
		$main_content = '<div>' . elgg_view_form('missions/message-user-form', array(
				'class' => 'form-horizontal'
		), array(
				'recipient_username' => $recipient_username,
				'subject' => $message_subject,
				'body' => $message_body
		)) . '</div>';
		$highlight_one = true;
}

$navigation_tabs = array(
		array(
				'text' => elgg_echo('missions:message_user'),
				'href' => elgg_get_site_url() . 'missions/message-share/' . $entity_guid,
				'selected' => $highlight_one,
				'id' => 'mission-message-share-user-message'
		)
);

// Only show The Wire sharing when The Wire plugin is active.
if(elgg_is_active_plugin('thewire')) {
	$navigation_tabs[1] = array(
			'text' => elgg_echo('missions:the_wire_post'),
			'href' => elgg_get_site_url() . 'missions/message-share/wire/' . $entity_guid,
			'selected' => $highlight_two,
			'id' => 'mission-message-share-the-wire-post'
	);
}

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
if($entity_guid != 0) {
	elgg_push_breadcrumb(elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')), $entity->getURL());
}
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs');

$content .= elgg_view('navigation/tabs', array(
		'class' => 'elgg-menu elgg-menu-filter list-inline mrgn-lft-sm elgg-menu-filter-default mission-tab',
		'tabs' => $navigation_tabs
));

$content .= $main_content;

echo elgg_view_page($title, $content);