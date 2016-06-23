<?php

gatekeeper();

$current_user = elgg_get_logged_in_user_entity();
$dbprefix = elgg_get_config('dbprefix');

$subscription = get_input('sub');


$query = "SELECT g.guid AS grp_id FROM  {$dbprefix}entity_relationships r, {$dbprefix}groups_entity g WHERE r.guid_one = {$current_user->getGUID()} AND r.relationship = 'member' AND g.guid = r.guid_two";

$groups = get_data($query);
$group_content_arr = array('blog','bookmark','groupforumtopic','event_calendar','file',/*'hjforumtopic','hjforum',*/'photo','album','task','page','page_top','task_top','idea');



foreach ($groups as $group) {

	if (strcmp($subscription,'sub') == 0) {
		// subscribe to the group if not already
		add_entity_relationship($current_user->guid, 'cp_subscribed_to_email', $group->grp_id);
		add_entity_relationship($current_user->guid, 'cp_subscribed_to_site_mail', $group->grp_id);
	} else {
		remove_entity_relationship($current_user->guid, 'cp_subscribed_to_email', $group->grp_id);
		remove_entity_relationship($current_user->guid, 'cp_subscribed_to_site_mail', $group->grp_id);
	}

	$query = "SELECT o.guid as content_id, o.title FROM {$dbprefix}objects_entity o, {$dbprefix}entities e, {$dbprefix}entity_subtypes es WHERE o.title <> '' AND o.guid = e.guid AND e.container_guid = {$group->grp_id} AND es.id = e.subtype AND ( es.subtype = 'poll'";
	foreach ($group_content_arr as $grp_content_subtype)
		$query .= " OR es.subtype = '{$grp_content_subtype}'";
	$query .= " )";

	$group_contents = get_data($query);

	// subscribe to group content if not already
	foreach ($group_contents as $group_content) {
		if (strcmp($subscription,'sub') == 0) {
			add_entity_relationship($current_user->guid, 'cp_subscribed_to_email', $group_content->content_id);
			add_entity_relationship($current_user->guid, 'cp_subscribed_to_site_mail', $group_content->content_id);
		} else {
			remove_entity_relationship($current_user->guid, 'cp_subscribed_to_email', $group_content->content_id);
			remove_entity_relationship($current_user->guid, 'cp_subscribed_to_site_mail', $group_content->content_id);
		}
	}
}

// forum topics and forums are a little bit different
$query = "SELECT e.guid, o.title
FROM {$dbprefix}entities e, {$dbprefix}objects_entity o, {$dbprefix}entity_subtypes es
WHERE e.guid = o.guid AND es.id = e.subtype AND e.owner_guid = {$current_user->getGUID()} AND ( es.subtype = 'hjforumtopic' OR es.subtype = 'hjforum' )";

