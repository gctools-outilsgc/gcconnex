<?php
/**
 * Elgg ideas plugin all page
 *
 * @package ideas
 */

elgg_push_breadcrumb(elgg_echo('ideas:all'));

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'idea',
	'limit' => 10,
	'pagination' => true,
	'full_view' => 'no_vote',
	'show_group' => true,
	'list_class' => 'ideas-list',
	'item_class' => 'elgg-item-idea'
));

if (!$content) {
	$content = elgg_echo('ideas:none');
}

$title = elgg_echo('ideas:all');

$vars = array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	//'sidebar' => elgg_view('ideas/sidebar'),
);

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);
