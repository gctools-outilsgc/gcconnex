<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page for messaging the manager of a mission or sharing it with a friend.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$entity_guid = array_pop($blast_radius);
$entity = get_entity($entity_guid);
$switch_segment = array_pop($blast_radius);

$highlight_one = false;
$highlight_two = false;

switch($switch_segment) {
	case 'wire':
		if($entity->type == 'user') {
			
		}
		else if($entity->type == 'object' && get_subtype_from_id($entity->subtype) == 'mission') {
			$main_content = elgg_view_form('missions/wire-post', array(), array('entity_subject' => $entity)) . '</section>';
			$title = elgg_echo('missions:share_with_colleague');
		}
		$highlight_two = true;
		break;
	default:
		$recipient_username = '';
		$message_subject = '';
		$message_body = '';
		// If the passed guid corresponds to a user then the manager is being emailed.
		if($entity->type == 'user') {
			$recipient_username = $entity->username;
			$title = elgg_echo('missions:email_manager');
		}
		// If the passed guid corrseponds to a mission then a mission is being shared.
		else if($entity->type == 'object' && get_subtype_from_id($entity->subtype) == 'mission') {
			$message_body = elgg_echo('missions:check_this_mission', array($entity->job_title, $entity->getURL()));
			$message_subject = $entity->job_title;
			$title = elgg_echo('missions:share_with_colleague');
		}
		
		$main_content = '<div class="col-sm-8">' . elgg_view_form('messages/send', array(), array(
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

if(elgg_is_active_plugin('thewire')) {
	$navigation_tabs[1] = array(
			'text' => elgg_echo('missions:the_wire_post'),
			'href' => elgg_get_site_url() . 'missions/message-share/wire/' . $entity_guid,
			'selected' => $highlight_two,
			'id' => 'mission-message-share-the-wire-post'
	);
}

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($entity->job_title, $entity->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('navigation/tabs', array(
		'class' => 'elgg-menu elgg-menu-filter list-inline mrgn-lft-sm elgg-menu-filter-default mission-tab',
		'tabs' => $navigation_tabs
));

$content .= $main_content;

echo elgg_view_page($title, $content);