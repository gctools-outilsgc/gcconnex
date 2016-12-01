<?php
/**
 * Elgg messages inbox page
 *
 * @package ElggMessages
*/
/*
* GC_MODIFICATION
* Description: Modified to increase load times and split messages from notifications
* Author: GCTools Team
*/
elgg_gatekeeper();

$offset = get_input('offset', 0);

$page_owner = elgg_get_page_owner_entity();

if (!$page_owner || !$page_owner->canEdit()) {
	$guid = 0;
	if($page_owner){
		$guid = $page_owner->getGUID();
	}
	register_error(elgg_echo("pageownerunavailable", array($guid)));
	forward();
}

elgg_push_breadcrumb(elgg_echo('messages:notifications'));

elgg_register_title_button();

$title = elgg_echo('messages:user_notifications', array($page_owner->name));

//$list = elgg_echo('messages:displayposts', array('<a href="?num=10">10</a> | <a href="?num=25">25</a> | <a href="?num=100">100</a>'));
$display_num_post = $_GET['num'];
if (!isset($display_num_post)) $display_num_post = 10;

$count = messages_count_unread_notifications(elgg_get_page_owner_guid());
$limit = 1000;
$dbprefix = elgg_get_config('dbprefix');
$list .= elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'messages',
	'metadata_name' => 'toId',
	'metadata_value' => elgg_get_page_owner_guid(),
	'owner_guid' => elgg_get_page_owner_guid(),
	'full_view' => false,
	'limit' => $limit,
    'pagination' => false,
	'preload_owners' => true,
	'bulk_actions' => true,
	'wetcustom:messages' => true,
	'joins' => "LEFT JOIN {$dbprefix}metadata mdfrom ON e.guid = mdfrom.entity_guid
	LEFT JOIN {$dbprefix}metastrings msnfrom ON mdfrom.name_id = msnfrom.id
	LEFT JOIN {$dbprefix}metastrings msvfrom ON mdfrom.value_id = msvfrom.id
	LEFT JOIN {$dbprefix}entities efrom ON msvfrom.string = efrom.guid",
	'wheres' => "msnfrom.string = 'fromId' AND (efrom.type <> 'user' OR efrom.type IS NULL)"
));

$body_vars = array(
	'folder' => 'notifications',
	'list' => $list,
);
$content = elgg_view_form('messages/process', array(), $body_vars);

if ( $count - $offset > $limit ){
	$offset = $offset + $limit;
	// add a "Show All button"
	$moreButton = elgg_view('output/url', array(
		'href' => $site_url ."messages/notifications/".elgg_get_page_owner_entity()->username."/?offset={$offset}",
		'text' => elgg_echo('wet:inboxmore'),
		'class' => 'btn btn-primary newsfeed-button',
		'is_trusted' => true,
	));
	$content .= $moreButton;
}

$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => elgg_echo('messages:notifications'),
	'filter' => '',
));

echo elgg_view_page($title, $body);
