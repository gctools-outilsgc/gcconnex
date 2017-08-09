<?php

$guid = (int) elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'group');

$group = get_entity($guid);

elgg_set_page_owner_guid($guid);

elgg_group_gatekeeper();

elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb(elgg_echo('groups:members'));

$options = [
	'relationship' => 'member',
	'relationship_guid' => $group->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'limit' => (int) get_input('limit', max(20, elgg_get_config('default_limit')), false),
	'no_results' => elgg_format_element('div', ['class' => 'elgg-list'], elgg_echo('notfound')),
];

$sort = elgg_extract('sort', $vars);
switch ($sort) {
	case 'newest':
		$options['order_by'] = 'r.time_created DESC';
		break;
	default:
		$db_prefix = elgg_get_config('dbprefix');
		
		$options['joins'] = array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid");
		$options['order_by'] = 'u.name ASC';
		break;
}

// user search
$members_search = sanitise_string(get_input('members_search'));
if (!empty($members_search)) {
	$options['base_url'] = "groups/members/{$guid}/{$sort}?members_search={$members_search}";
	$options['joins'][] = "JOIN {$db_prefix}users_entity ms ON e.guid = ms.guid";
	$options['wheres'][] = "(ms.name LIKE '%{$members_search}%' OR ms.username LIKE '%{$members_search}%')";
}

$title = elgg_echo('groups:members:title', array($group->name));

$tabs = elgg_view_menu('groups_members', [
	'entity' => $group,
	'sort_by' => 'priority',
	'class' => 'elgg-tabs'
]);

$user_list = elgg_list_entities_from_relationship($options);

if (elgg_is_xhr()) {
	// ajax pagination
	echo $user_list;
	return;
}

$content = elgg_view_form('group_tools/members_search', [
	'action' => "groups/members/{$guid}/{$sort}",
	'disable_security' => true,
]);
$content .= $user_list;

$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => $tabs,
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
