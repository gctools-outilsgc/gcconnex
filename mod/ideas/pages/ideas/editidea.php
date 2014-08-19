<?php
/**
 * Edit idea page
 *
 * @package ideas
 */
 
$idea_guid = get_input('guid');
$idea = get_entity($idea_guid);

if (!elgg_instanceof($idea, 'object', 'idea') || !$idea->canEdit()) {
	register_error(elgg_echo('ideas:unknown_idea'));
	forward(REFERRER);
}

elgg_push_breadcrumb(elgg_echo('ideas:edit'));
elgg_push_breadcrumb($idea->title, $idea->getURL());

$vars = ideas_prepare_form_vars($idea);

$content = elgg_view_form('ideas/editidea', array(), $vars);

$title = elgg_echo('ideas:idea:edit');

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);