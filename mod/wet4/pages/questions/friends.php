<?php
/**
 * Elgg questions plugin everyone page
 *
 * @package ElggQuestions
 */

elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

elgg_register_title_button();

elgg_push_breadcrumb(elgg_echo('questions:friends'));

$owner = elgg_get_page_owner_entity();

// build content
$title = elgg_echo('questions:friends');

$content .= elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => 'question',
	'full_view' => false,
	'relationship' => 'friend',
	'relationship_guid' => $owner->guid,
	'relationship_join_on' => 'owner_guid',
	'preload_owners' => true,
  'no_results' => elgg_echo('questions:none'),
));

// build page
$body = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
  'filter_context' => 'friend',
]);

// draw page
echo elgg_view_page($title, $body);
