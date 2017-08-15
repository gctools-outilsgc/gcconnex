<?php
/**
 * Elgg groups plugin
 *
 * @package ElggGroups
 */

$comment = elgg_get_sticky_value('group_invite', 'comment');
elgg_clear_sticky_form('group_invite');

$group = elgg_extract('entity', $vars, elgg_get_page_owner_entity());
$invite_friends = elgg_extract('invite_friends', $vars, 'yes');
$invite_site_members = elgg_extract('invite', $vars, 'no');
$invite_email = elgg_extract('invite_email', $vars, 'no');
$invite_csv = elgg_extract('invite_csv', $vars, 'no');

// load js
elgg_require_js('group_tools/invite');

// show tabs
echo elgg_view('group_tools/invite/filter', $vars);

// invite friends
$class = [
	'group-tools-invite-form',
	'elgg-state-active',
];
if ($invite_friends !== 'no') {
	$friends_attr = [
		'id' => 'group-tools-invite-friends',
		'class' => $class,
	];
	echo elgg_format_element('div', $friends_attr, elgg_view('group_tools/invite/friends', $vars));
	
	$class[1] = 'hidden';
}

// invite site members
if ($invite_site_members === 'yes') {
	$site_members_attr = [
		'id' => 'group-tools-invite-users',
		'class' => $class,
	];
	echo elgg_format_element('div', $site_members_attr, elgg_view('group_tools/invite/users', $vars));
	
	$class[1] = 'hidden';
}

// invite email
if ($invite_email === 'yes') {
	$email_attr = [
		'id' => 'group-tools-invite-email',
		'class' => $class,
	];
	echo elgg_format_element('div', $email_attr, elgg_view('group_tools/invite/email', $vars));
	
	$class[1] = 'hidden';
}

// invite csv
if ($invite_csv === 'yes') {
	$csv_attr = [
		'id' => 'group-tools-invite-csv',
		'class' => $class,
	];
	echo elgg_format_element('div', $csv_attr, elgg_view('group_tools/invite/csv', $vars));
	
	$class[1] = 'hidden';
}

// optional text
echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('group_tools:group:invite:text'),
	'name' => 'comment',
	'value' => $comment,
]);

// renotify existing invites
if ($group->canEdit()) {
	echo elgg_view_field([
		'#type' => 'checkbox',
		'#label' => elgg_echo('group_tools:group:invite:resend'),
		'name' => 'resend',
		'value' => 'yes',
	]);
}

echo elgg_view('input/hidden', ['name' => 'group_guid', 'value' => $group->getGUID()]);


// show buttons
$footer_fields = [
	[
	'#type' => 'submit', 
	'name' => 'submit', 
	'value' => elgg_echo('invite'),
	],
];
if (elgg_is_admin_logged_in()) {
	$footer_fields[] = [
		'#type' => 'submit', 
		'name' => 'submit',
		'value' => elgg_echo('group_tools:add_users'),
		'onclick' => 'return confirm("' . elgg_echo('group_tools:group:invite:add:confirm') . '");',
	];
}
$footer = elgg_view('input/fieldset', [
	'fields' => $footer_fields,
	'align' => 'horizontal',
]);
elgg_set_form_footer($footer);
