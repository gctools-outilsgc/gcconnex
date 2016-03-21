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
$entity = get_entity(array_pop($blast_radius));

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
	$message_body = elgg_echo('missions:check_this_mission') . ': ';
	$message_body .= $entity->getURL();
	$message_subject = $entity->job_title;
	$title = elgg_echo('missions:share_with_colleague');
}

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($entity->job_title, $entity->getURL());
elgg_push_breadcrumb($title);

$content = '<section class="col-md-8">' .  elgg_view_title($title);

// Uses the message plugin.
$content .= elgg_view_form('messages/send', array(), array(
		'recipient_username' => $recipient_username,
		'subject' => $message_subject,
		'body' => $message_body
)) . '</section>';

echo elgg_view_page($title, $content);