<?php
/**
 * Show a group the user is invited for by e-mail address
 *
 */

$user = elgg_extract('user', $vars, elgg_get_page_owner_entity());
if (!($user instanceof ElggUser) || !$user->canEdit()) {
	return;
}

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

$icon = elgg_view_entity_icon($group, 'small');
$menu = elgg_view_menu('emailinvitation', [
	'entity' => $group,
	'user' => $user,
	'order_by' => 'priority',
	'class' => 'elgg-menu-hz float-alt',
]);

$summary = elgg_view('group/elements/summary', [
	'entity' => $group,
	'subtitle' => $group->briefdescription,
	'metadata' => $menu,
]);

echo elgg_view_image_block($icon, $summary);
