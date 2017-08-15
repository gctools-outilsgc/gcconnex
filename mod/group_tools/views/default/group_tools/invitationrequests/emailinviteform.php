<?php
/**
 * Show a form where the user can enter an invitation code from their e-mail
 * (auto-fill if provided by url param)
 */

$user = elgg_get_logged_in_user_entity();
if (!($user instanceof ElggUser)) {
	return;
}

if (elgg_get_page_owner_guid() !== $user->getGUID()) {
	// only show this form on the current user's page (only applies to admins)
	return;
}

if (elgg_get_plugin_setting('invite_email', 'group_tools') !== 'yes') {
	return;
}

$form = elgg_view_form('group_tools/email_invitation');

echo elgg_view_module('info', elgg_echo('group_tools:groups:invitation:code:title'), $form);
