<?php
/**
 * group_operator/change_owner.php
 *
 * Change owner
 *
 * @author Lorea
 */

	action_gatekeeper();
	$mygroup_guid = get_input('mygroup');
	$who_guid = get_input('who');
	$mygroup = get_entity($mygroup_guid);
	$who = get_entity($who_guid);
	$db_prefix = elgg_get_config('dbprefix');
	if ($mygroup instanceof ElggGroup && ($mygroup->owner_guid == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())) {

		// Owner is now a simple operator
		if (!check_entity_relationship($mygroup->owner_guid, 'operator', $mygroup_guid)) {
			add_entity_relationship($mygroup->owner_guid, 'operator', $mygroup_guid);
		}

		//transfer cover photo to new owner
		gc_group_layout_transfer_coverphoto($mygroup, $who);
		// transfer the group to the new owner
		group_tools_transfer_group_ownership($mygroup, $who);

		//Update metadata owner guid is case user creator is delete
		update_data("UPDATE {$db_prefix}metadata SET owner_guid = '$who_guid' where entity_guid = $mygroup_guid");

		if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_msg_type' => 'cp_grp_admin_transfer',
				'cp_group_name' => $mygroup->name,
				'cp_group_url' => $mygroup->getURL(),
				'cp_new_owner' => $who->name,
				'cp_appointer' => elgg_get_logged_in_user_entity()->name,
				'cp_new_owner_user' => $who,
			);
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification','all',$message);
		}

		system_message(elgg_echo('group_operators:owner_changed', array($who->name)));
	} else {
		register_error(elgg_echo('group_operators:change_owner:error'));
	}
	forward(REFERER);
