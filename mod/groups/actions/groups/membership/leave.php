<?php
/**
 * Leave a group action.
 *
 * @package ElggGroups
 */
 /*
  * GC_MODIFICATION
  * Description: Tied action into cp_subscriptions. Also added removing operator rights to action.
  * Author: GCTools Team
  * Date: December 12th 2016 (Operator rights)
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

				$group_content_arr = array('blog','bookmark','groupforumtopic','event_calendar','file','photo','album','task','page','page_top','task_top','idea');
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

			//check if user is a group operator
			if(check_entity_relationship($user->getGUID(), 'operator', $group_guid)){
				//remove operator rights
				remove_entity_relationship($user->getGUID(), 'operator', $group_guid);
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
