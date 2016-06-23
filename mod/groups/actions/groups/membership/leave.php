<?php
/**
 * Leave a group action.
 *
 * @package ElggGroups
 */

$user_guid = get_input('user_guid');
$group_guid = get_input('group_guid');

$user = NULL;
if (!$user_guid) {
	$user = elgg_get_logged_in_user_entity();
} else {
	$user = get_user($user_guid);
}

$group = get_entity($group_guid);

elgg_set_page_owner_guid($group->guid);

if ($user && ($group instanceof ElggGroup)) {
	if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
		if ($group->leave($user)) {

			// cyu - remove all the relationships when a user leaves a group
			if (elgg_is_active_plugin('cp_notifications')) {

				$group_content_arr = array('blog','bookmark','groupforumtopic','event_calendar','file',/*'hjforumtopic','hjforum',*/'photo','album','task','page','page_top','task_top','idea');
				$dbprefix = elgg_get_config('dbprefix');

				$query = "SELECT o.guid as content_id, o.title FROM {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o, {$dbprefix}entities e, {$dbprefix}entity_subtypes es WHERE r.guid_one = {$user->getGUID()} AND r.guid_two = o.guid AND o.title <> '' AND o.guid = e.guid AND e.container_guid = {$group_guid} AND es.id = e.subtype AND ( es.subtype = 'poll'";
				foreach ($group_content_arr as $grp_content_subtype)
					$query .= " OR es.subtype = '{$grp_content_subtype}'";
				$query .= " )";
				
				$group_contents = get_data($query);

				// unsubscribe to the group
				remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_guid);
				remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group_guid);
				// unsubscribe to group content if not already
				foreach ($group_contents as $group_content) {
					remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_content->content_id);
					remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group_content->content_id);
				}

			}

			system_message(elgg_echo("groups:left"));
		} else {
			register_error(elgg_echo("groups:cantleave"));
		}
	} else {
		register_error(elgg_echo("groups:cantleave"));
	}
} else {
	register_error(elgg_echo("groups:cantleave"));
}

forward(REFERER);
