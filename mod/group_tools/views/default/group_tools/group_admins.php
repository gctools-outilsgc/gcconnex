<?php

/**
 * Group Tools
 *
 * show all group admins
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

if (!group_tools_multiple_admin_enabled()) {
	return;
}

$options = [
	'relationship' => 'group_admin',
	'relationship_guid' => $group->getGUID(),
	'inverse_relationship' => true,
	'type' => 'user',
	'limit' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
	'wheres' => [
		"e.guid <> {$group->getOwnerGUID()}",
	],
];

$users = elgg_get_entities_from_relationship($options);
if (empty($users)) {
	return;
}

// add owner to the beginning of the list
array_unshift($users, $group->getOwnerEntity());

$body = elgg_view_entity_list($users, $options);
echo elgg_view_module('aside', elgg_echo('group_tools:multiple_admin:group_admins'), $body);
