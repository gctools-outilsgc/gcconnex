<?php
/**
 * Add featured groups to the sidebar of a group
 */

if (!elgg_in_context('group_profile')) {
	return;
}

$group = elgg_get_page_owner_entity();
if (!($group instanceof ElggGroup)) {
	return;
}

$prefix = \ColdTrick\GroupTools\Cleanup::SETTING_PREFIX;

// show featured groups in the sidebar
$featured = $group->getPrivateSetting("{$prefix}featured"); // contains 'no' or number
if (!empty($featured) && ($featured != 'no')) {
	$featured_sorting = $group->getPrivateSetting("{$prefix}featured_sorting");
	$featured = sanitise_int($featured, false);
	
	echo elgg_view('groups/sidebar/featured', [
		'limit' => $featured,
		'sort' => $featured_sorting,
	]);
}
