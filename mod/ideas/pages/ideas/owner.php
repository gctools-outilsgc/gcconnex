<?php
/**
 * Elgg ideas plugin owner page
 *
 * @package ideas
 */
$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	forward('ideas/all');
}

elgg_push_breadcrumb($page_owner->name);

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'idea',
	'owner_guid' => $page_owner->guid,
	'limit' => 0,
	'pagination' => false,
	'full_view' => 'no_vote',
	'list_class' => 'ideas-list',
	'item_class' => 'elgg-item-idea'
));

if (!$content) {
	$content = elgg_echo('ideas:none');
}

$title = elgg_echo('ideas:owner', array($page_owner->name));

$filter_context = '';
if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$vars = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	//'sidebar' => elgg_view('ideas/sidebar'),
);

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);