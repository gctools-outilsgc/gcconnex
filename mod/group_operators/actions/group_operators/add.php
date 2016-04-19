<?php
/**
 * Elgg group operators adding action
 *
 * @package ElggGroupOperators
 */

action_gatekeeper("group_operators/add");
$mygroup = get_entity(get_input('mygroup'));
$who = get_entity(get_input('who'));
error_log('jdslkfjdlskfjldskfjlsdkLKDSJLFKSDJFLKDSJFLKSDJFLDKSJFL');
$success = false;
if ($mygroup instanceof ElggGroup && $who instanceof ElggUser && $mygroup->canEdit()) {
	if ($mygroup->isMember($who) && !check_entity_relationship($who->guid, 'operator', $mygroup->guid)) {
		add_entity_relationship($who->guid, 'operator', $mygroup->guid);
		system_message(elgg_echo('group_operators:added', array($who->name, $group->name)));

		// notify user that they have been added as group operator
		if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_msg_type' => 'cp_add_grp_operator',
				'cp_to_user' => $who,
				'cp_to_operator' => $who->name,
				'cp_who_made_operator' => elgg_get_logged_in_user_entity()->name
			);
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification','all',$message);
		}


	} else {
		register_error(elgg_echo('group_operators:add:error', array($who->name, $group->name)));
	}
} else {
	register_error(elgg_echo('groups:permissions:error'));
}

forward(REFERER);
?>
