<?php
/**
 * Elgg ideas plugin friends page
 *
 * @package ideas
 */
$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	forward('ideas/all');
}

elgg_push_breadcrumb($page_owner->name, "ideas/owner/$page_owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

$friends = get_user_friends($page_owner->guid, "", 999999, 0);
$friendguids = array();
foreach ($friends as $friend) {
	$friendguids[] = $friend->getGUID();
}

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'idea',
	'owner_guids' => $friendguids,
	'limit' => 10,
	'pagination' => true,
	'full_view' => 'no_vote',
	'list_class' => 'ideas-list',
	'item_class' => 'elgg-item-idea'
));

if (!$content) {
	$content = elgg_echo('ideas:none');
}

$title = elgg_echo('ideas:friends');

$vars = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
	//'sidebar' => elgg_view('ideas/sidebar'),
);

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);