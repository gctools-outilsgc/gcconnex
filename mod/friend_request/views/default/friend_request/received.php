<?php

$user = elgg_get_page_owner_entity();

$options = [
	'type' => 'user',
	'relationship' => 'friendrequest',
	'relationship_guid' => $user->guid,
	'inverse_relationship' => true,
	'offset_key' => 'offset_received',
	'no_results' => elgg_echo('friend_request:received:none'),
	'item_view' => 'friend_request/item',
];

$content = elgg_list_entities_from_relationship($options);

echo elgg_view_module('info', elgg_echo('friend_request:received:title'), $content, ['class' => 'mbm']);
