<?php
/**
 * Show all group invitations based on the user's e-mail address
 */

$user = elgg_get_page_owner_entity();
if (!($user instanceof ElggUser) || !$user->canEdit()) {
	return;
}

if (elgg_get_plugin_setting('invite_email', 'group_tools') !== 'yes') {
	return;
}

$email_invitations = group_tools_get_invited_groups_by_email($user->email);
if (empty($email_invitations)) {
	return;
}

$params = [
	'limit' => false,
	'offset' => 0,
	'count' => count($email_invitations),
	'items' => $email_invitations,
	'item_view' => 'group_tools/format/emailinvitation',
];

echo elgg_view('page/components/list', $params);
