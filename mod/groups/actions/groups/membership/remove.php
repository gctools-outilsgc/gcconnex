<?php
/**
 * Remove a user from a group
 *
 * @package ElggGroups
 */

$user_guid = get_input('user_guid');
$group_guid = get_input('group_guid');

$user = get_user($user_guid);
$group = get_entity($group_guid);

elgg_set_page_owner_guid($group->guid);

if ($user && ($group instanceof ElggGroup) && $group->canEdit()) {
	// Don't allow removing group owner
	if ($group->getOwnerGUID() != $user->getGUID()) {
		if ($group->leave($user)) {

			// cyu - remove all the relationships when a user is being removed from a group
			if (elgg_is_active_plugin('cp_notifications')) {
				$dbprefix = elgg_get_config('dbprefix');

				/// removes all the content (excludes the forums)
				$group_content_arr = array('blog','bookmark','groupforumtopic','event_calendar','file','photo','album','task','page','page_top','task_top','idea');
				$query = "SELECT o.guid as content_id, o.title FROM {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o, {$dbprefix}entities e, {$dbprefix}entity_subtypes es WHERE r.guid_one = {$user->getGUID()} AND r.guid_two = o.guid AND o.title <> '' AND o.guid = e.guid AND e.container_guid = {$group_guid} AND es.id = e.subtype AND ( es.subtype = 'poll'";
				foreach ($group_content_arr as $grp_content_subtype) {
					$query .= " OR es.subtype = '{$grp_content_subtype}'";
				}
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

				/// remove forum related subscriptions
				$query = "SELECT r.guid_one, r.guid_two as content_id
				FROM {$dbprefix}entities e, {$dbprefix}entity_subtypes es, {$dbprefix}entity_relationships r
				WHERE e.guid = r.guid_two AND e.subtype = es.id AND r.guid_one = '{$user->getGUID()}' AND es.subtype LIKE 'hj%'";
				$forum_contents = get_data($query);

				// unsubscribe to group forums (& topic) if not already
				foreach ($forum_contents as $forum_content) {
					remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $forum_content->content_id);
					remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $forum_content->content_id);	
				}
			}


			system_message(elgg_echo("groups:removed", array($user->name)));
		} else {
			register_error(elgg_echo("groups:cantremove"));
		}
	} else {
		register_error(elgg_echo("groups:cantremove"));
	}
} else {
	register_error(elgg_echo("groups:cantremove"));
}

forward(REFERER);
