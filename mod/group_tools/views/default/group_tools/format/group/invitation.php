<?php
/**
 * Show an invitation to the group admin
 *
 * @uses $vars['entity'] the ElggUser being invited
 */

$page_owner = elgg_get_page_owner_entity();
if (!($page_owner instanceof ElggGroup) || !$page_owner->canEdit()) {
	return;
}

$user = elgg_extract('entity', $vars);
if (!($user instanceof ElggUser)) {
	return;
}

$icon = elgg_view_entity_icon($user, 'small');
$menu = elgg_view_menu('group:invitation', [
	'entity' => $user,
	'group' => $page_owner,
	'order_by' => 'priority',
	'class' => 'elgg-menu-hz float-alt',
]);

$summary = elgg_view('user/elements/summary', [
	'entity' => $user,
	'subtitle' => $user->briefdescription,
	'metadata' => $menu,
]);

echo elgg_view_image_block($icon, $summary);
