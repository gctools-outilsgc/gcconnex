<?php

/**
 * Group Tools
 *
 * Extend the registration form with the group invite code
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group_invitecode = get_input('group_invitecode');
if (empty($group_invitecode)) {
	return;
}

echo elgg_view('input/hidden', [
	'name' => 'group_invitecode',
	'value' => $group_invitecode,
]);
