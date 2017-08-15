<?php
/**
 * List all invited user for the group
 */

elgg_gatekeeper();

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'group');
$group = get_entity($guid);
if (!$group->canEdit()) {
	register_error(elgg_echo('groups:noaccess'));
	forward(REFERER);
}

elgg_set_page_owner_guid($guid);

$title = elgg_echo('group_tools:menu:invitations');

elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb($title);

// additional title menu item
elgg_register_menu_item('title', [
	'name' => 'groups:invite',
	'href' => "groups/invite/{$group->getGUID()}",
	'text' => elgg_echo('groups:invite'),
	'link_class' => 'elgg-button elgg-button-action',
]);

$offset = (int) get_input('offset', 0);
$limit = (int) get_input('limit', 25);

$dbprefix = elgg_get_config('dbprefix');

// get invited users
$options = [
	'joins' => [
		"JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid",
	],
	'type' => 'user',
	'relationship' => 'invited',
	'relationship_guid' => $guid,
	'offset' => $offset,
	'limit' => $limit,
	'count' => true,
	'order_by' => 'ue.name ASC',
];

$count = elgg_get_entities_from_relationship($options);
unset($options['count']);
$invitations = elgg_get_entities_from_relationship($options);

$content = elgg_view('group_tools/membershipreq/invites', [
	'invitations' => $invitations,
	'entity' => $group,
	'offset' => $offset,
	'limit' => $limit,
	'count' => $count,
]);

$tabs = elgg_view_menu('group:membershiprequests', [
	'entity' => $group,
	'sort_by' => 'priority',
	'class' => 'elgg-tabs',
]);

$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => $tabs,
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);