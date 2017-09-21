<?php
/**
 * List all docs
 *
 * @package ElggPad
 */

$title = elgg_echo('etherpad:all');

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('etherpad'));

elgg_register_title_button();

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => array('etherpad', 'subpad'),
	'full_view' => false,
));
if (!$content) {
	$content = '<p>' . elgg_echo('etherpad:none') . '</p>';
}

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('etherpad/sidebar'),
));

echo elgg_view_page($title, $body);
