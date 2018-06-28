<?php
/**
 * group_operator/add.php
 *
 * Elgg group operators adding action
 *
 * @package ElggGroupOperators
 * @author Lorea
 */

action_gatekeeper("group_operators/add");
$mygroup = get_entity(get_input('mygroup'));
$who = get_entity(get_input('who'));
$backup_test = get_input('groups-owner-guid');

//added additional checks to find user
if (!($who instanceof ElggUser)){

	//test if username has been given
	$user_by_username = get_user_by_username($backup_test);
	if($user_by_username){
		$who = $user_by_username;
	} else {

		//now check if they used display name
		$db_prefix = elgg_get_config('dbprefix');
		$display_name_check = get_data("SELECT * FROM {$db_prefix}users_entity WHERE name = '{$backup_test}'");
		foreach($display_name_check as $user){
			$member = get_entity($user->guid);

			if($mygroup->isMember($member)){
				$who = $member;
			}
		}

		//final check to see if we found the target user after checking username/display name
		if (!($who instanceof ElggUser)){
			register_error(elgg_echo('group_operator:find:user:error'));
			forward(REFERER);
		}
	}
}

if ($mygroup instanceof ElggGroup && $mygroup->canEdit()) {
	if ($mygroup->isMember($who) && !check_entity_relationship($who->guid, 'operator', $mygroup->guid)) {
		add_entity_relationship($who->guid, 'operator', $mygroup->guid);
		system_message(elgg_echo('group_operators:added', array($who->name, $group->name)));

		// notify user that they have been added as group operator
		if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_msg_type' => 'cp_add_grp_operator',
				'cp_to_user' => $who,
				'cp_to_operator' => $who->name,
				'cp_who_made_operator' => elgg_get_logged_in_user_entity()->name,
				'cp_group_name' => $mygroup->name,
				'cp_group_url' => $mygroup->getURL(),
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
