<?php

elgg_gatekeeper();

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'group');

$group = get_entity($guid);
if (!$group->canEdit() && !group_tools_allow_members_invite($group)) {
	register_error(elgg_echo('groups:noaccess'));
	forward(REFERER);
}

elgg_set_page_owner_guid($guid);

// get plugin settings
$invite_friends = elgg_get_plugin_setting('invite_friends', 'group_tools', 'yes');
$invite = elgg_get_plugin_setting('invite', 'group_tools');
$invite_email = elgg_get_plugin_setting('invite_email', 'group_tools');
$invite_csv = elgg_get_plugin_setting('invite_csv', 'group_tools');

if (in_array('yes', [$invite, $invite_csv, $invite_email])) {
	$title = elgg_echo('group_tools:groups:invite:title');
	$breadcrumb = elgg_echo('group_tools:groups:invite');
} elseif ($invite_friends !== 'no') {
	$title = elgg_echo('groups:invite:title');
	$breadcrumb = elgg_echo('groups:invite');
} else {
	// no option is allowed
	register_error(elgg_echo('group_tools:groups:invite:error'));
	forward($group->getURL());
}

// breadcrumb
elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb($breadcrumb);

$content = elgg_view_form('groups/invite', array(
	'id' => 'invite_to_group',
	'class' => 'elgg-form-alt mtm',
	'enctype' => 'multipart/form-data', // to allow csv upload
), array(
	'entity' => $group,
	'invite_friends' => $invite_friends,
	'invite' => $invite,
	'invite_email' => $invite_email,
	'invite_csv' => $invite_csv,
));

// build page
$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

// draw page
echo elgg_view_page($title, $body);
