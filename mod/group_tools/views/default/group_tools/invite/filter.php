<?php
/**
 * Filter menu (tabs) on the group invite form
 *
 * used in /forms/groups/invite
 */

$invite_friends = elgg_extract('invite_friends', $vars, 'yes');
$invite_site_members = elgg_extract('invite', $vars, 'no');
$invite_email = elgg_extract('invite_email', $vars, 'no');
$invite_csv = elgg_extract('invite_csv', $vars, 'no');

$tabs = [];
$selected = true;
if ($invite_friends !== 'no') {
	$tabs['friends'] = [
		'text' => elgg_echo('friends'),
		'href' => '#group-tools-invite-friends',
		'priority' => 200,
		'selected' => $selected,
	];
	$selected = false;
}

if ($invite_site_members == 'yes') {
	$tabs['users'] = [
		'text' => elgg_echo('group_tools:group:invite:users'),
		'href' => '#group-tools-invite-users',
		'priority' => 300,
		'selected' => $selected,
	];
	$selected = false;
}

if ($invite_email == 'yes') {
	$tabs['email'] = [
		'text' => elgg_echo('group_tools:group:invite:email'),
		'href' => '#group-tools-invite-email',
		'priority' => 400,
		'selected' => $selected,
	];
	$selected = false;
}

if ($invite_csv == 'yes') {
	$tabs['csv'] = [
		'text' => elgg_echo('group_tools:group:invite:csv'),
		'href' => '#group-tools-invite-csv',
		'priority' => 500,
		'selected' => $selected,
	];
	$selected = false;
}

// register tabs if more than 1
if (count($tabs) > 1) {
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}
}

// show tabs
echo elgg_view_menu('filter', [
	'handler' => 'group_tools',
	'item_class' => 'group-tools-invite-tab',
	'class' => 'group-tools-invite-filter',
	'sort_by' => 'priority',
	'params' => [
		'invite_friends' => $invite_friends,
		'invite' => $invite_site_members,
		'invite_email' => $invite_email,
		'invite_csv' => $invite_csv,
	],
]);
