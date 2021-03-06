<?php
/**
 * Layout of the groups profile page
 *
 * @uses $vars['entity']
 */

/* @var ElggGroup $group */
$group = elgg_extract('entity', $vars);

if (elgg_group_gatekeeper(false)) {
	if (!$group->isPublicMembership() && !$group->isMember()) {
		echo elgg_view('groups/profile/closed_membership');
	}

	echo elgg_view('groups/profile/activity_module', $vars);
} else {
	if ($group->isPublicMembership()) {
		echo elgg_view('groups/profile/membersonly_open');
	} else {
		echo elgg_view('groups/profile/membersonly_closed');
	}
}

//for metadata
echo elgg_view('wet4_theme/track_page_entity', array('entity' => $group));