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
	'selects' => [
		'SUBSTRING_INDEX(v.string, "|", -1) AS invited_email',
	],
	'annotation_name' => 'email_invitation',
	'annotation_owner_guid' => $group->getGUID(),
	'wheres' => [
		'(v.string LIKE "%|%")',
	],
	'offset' => $offset,
	'limit' => $limit,
	'count' => true,
	'order_by' => 'invited_email ASC',
];

$count = elgg_get_annotations($options);
unset($options['count']);
$emails = elgg_get_annotations($options);

$content = elgg_view('group_tools/membershipreq/email_invites', [
	'emails' => $emails,
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