<?php

/**
 * Group Tools
 *
 * group owner tranfser form
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group = elgg_extract('entity', $vars);
$user = elgg_get_logged_in_user_entity();

if (!($group instanceof ElggGroup)) {
	return;
}

if (!($user instanceof ElggUser)) {
	return;
}

if (($group->getOwnerGUID() !== $user->getGUID()) && !$user->isAdmin()) {
	return;
}
	
$dbprefix = elgg_get_config('dbprefix');

$friends_options = [
	'type' => 'user',
	'relationship' => 'friend',
	'relationship_guid' => $user->getGUID(),
	'limit' => false,
	'count' => true,
	'joins' => [
		"JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid",
	],
	'wheres' => [
		"(e.guid <> {$group->getOwnerGUID()})",
	],
	'order_by' => 'ue.name',
	'selects' => ['ue.name'],
];

$member_options = [
	'type' => 'user',
	'relationship' => 'member',
	'relationship_guid' => $group->getGUID(),
	'inverse_relationship' => true,
	'limit' => false,
	'count' => true,
	'joins' => [
		"JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid",
	],
	'wheres' => [
		"(e.guid NOT IN ({$group->getOwnerGUID()}, {$user->getGUID()}))",
	],
	'order_by' => 'ue.name',
	'selects' => ['ue.name'],
];

$friends = elgg_get_entities_from_relationship($friends_options);
$members = elgg_get_entities_from_relationship($member_options);

if (empty($friends) && empty($members)) {
	return;
}

$show_selector = false;

$add_myself = false;
$add_friends = false;
$add_members = false;


$options = [];
// add current group owner
$options[] = elgg_format_element('option', ['value' => $group->getOwnerGUID()], elgg_echo('group_tools:admin_transfer:current', [$group->getOwnerEntity()->name]));

// add current user
if ($group->getOwnerGUID() !== $user->getGUID()) {
	$show_selector = true;
	$options[] = elgg_format_element('option', ['value' => $user->getGUID()], elgg_echo('group_tools:admin_transfer:myself'));
}

if (!empty($friends)) {
	$show_selector = true;
	$friends_optgroup = [];
	
	unset($friends_options['count']);
	$friends_options['callback'] = 'group_tool_admin_transfer_callback';
	
	$friends = new ElggBatch('elgg_get_entities_from_relationship', $friends_options);
	foreach ($friends as $friend) {
		$friends_optgroup[] = elgg_format_element('option', ['value' => $friend['guid']], $friend['name']);
	}
	
	// add friends to the select
	$options[] = elgg_format_element('optgroup', ['label' => elgg_echo('friends')], implode('', $friends_optgroup));
}

if (!empty($members)) {
	$show_selector = true;
	$members_optgroup = [];
	
	unset($member_options['count']);
	$member_options['callback'] = 'group_tool_admin_transfer_callback';
	
	$members = new ElggBatch('elgg_get_entities_from_relationship', $member_options);
	foreach ($members as $member) {
		$members_optgroup[] = elgg_format_element('option', ['value' => $member['guid']], $member['name']);
	}
	
	// add group members to the select
	$options[] = elgg_format_element('optgroup', ['label' => elgg_echo('groups:members')], implode('', $members_optgroup));
}

if (!$show_selector) {
	return;
}

echo '<div>';
echo elgg_format_element('label', ['for' => 'groups-owner-guid'], elgg_echo('groups:owner'));
echo '<br />';
echo elgg_format_element('select', [
	'name' => 'owner_guid',
	'id' => 'groups-owner-guid',
], implode('', $options));

if ($group->getOwnerGUID() == $user->getGUID()) {
	echo '<br />';
	echo elgg_format_element('span', ['class' => 'elgg-text-help'], elgg_echo('groups:owner:warning'));
}

echo '</div>';
