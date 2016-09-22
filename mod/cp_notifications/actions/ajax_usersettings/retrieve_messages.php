<?php

/*
 * Retrieve site messages
 */

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}


$limit = (int)get_input('limit');
$page_number = (int)get_input('page_number');
$offset = (int)$page_number*$limit;

$list = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'messages',
	'metadata_name' => 'toId',
	'metadata_value' => elgg_get_page_owner_guid(),
	'owner_guid' => elgg_get_page_owner_guid(),
	'full_view' => false,
	'limit' => $limit,
    'pagination' => true,
	'preload_owners' => true,
	'bulk_actions' => true,
	'offset' => $offset,
	//'wetcustom:messages' => false
));


$body_vars = array(
	'folder' => 'inbox',
	'list' => $list,
);
$content = elgg_view_form('messages/process', array(), $body_vars);

$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => elgg_echo('messages:inbox'),
	'filter' => '',
));


echo json_encode([
	'text1' => $list,
]);
