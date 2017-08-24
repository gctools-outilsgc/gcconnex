<?php
/**
 * Edit idea page
 *
 * @package ideas
 */
$lang = get_current_language();
$idea_guid = get_input('guid');
$idea = get_entity($idea_guid);

if (!elgg_instanceof($idea, 'object', 'idea') || !$idea->canEdit()) {
	register_error(elgg_echo('ideas:unknown_idea'));
	forward(REFERRER);
}


	elgg_push_breadcrumb(gc_explode_translation($idea->title,$lang), $idea->getURL());

elgg_push_breadcrumb(elgg_echo('ideas:edit'));

$vars = ideas_prepare_form_vars($idea);

$content = elgg_view_form('ideas/editidea', array(), $vars);

$title = elgg_echo('ideas:idea:edit');

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);