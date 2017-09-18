<?php

/**
* Group Tools
* Mail all the members of a group
* 
* @author ColdTrick IT Solutions
* Modified by Christine Yu
**/	

$group_guid = (int) get_input("group_guid", 0);
$user_guids = get_input("user_guids");
$subject = get_input("title"); 
$body = get_input("description");

$forward_url = REFERER;

$user_guids = group_tools_retrieve_members($group_guid, $user_guids);

if (!empty($group_guid) && !empty($body) && !empty($user_guids)) {
	$group = get_entity($group_guid);
	
	if (!empty($group) && ($group instanceof ElggGroup)) {
		if ($group->canEdit()) {
			set_time_limit(0);
			
			$body .= PHP_EOL . PHP_EOL;
			$body .= elgg_echo("group_tools:mail:message:from") . ": {$group->name} [{$group->getURL()}]";
			
			// cyu - 03/07/2016: we need to use the cp_notifications module to handle the improved notifications
			if (elgg_is_active_plugin('cp_notifications')) {

				$message = array(
					'cp_group' => $group,
					'cp_group_subject' => $subject,
					'cp_group_message' => "<p>".get_input('description')."</p>",
					'cp_group_mail_users' => $user_guids,
					'cp_msg_type' => 'cp_group_mail',
				);
				$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);

			} else {

				// send notification...
				foreach ($user_guids as $guid) {
					notify_user($guid, $group->getGUID(), $subject, $body, NULL, "email");
				}
			}
			
			system_message(elgg_echo("group_tools:action:mail:success"));
			
			$forward_url = $group->getURL();
		} else {
			register_error(elgg_echo("group_tools:action:error:edit"));
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:entity"));
	}
} else {
	register_error(elgg_echo("group_tools:action:error:input"));
}

forward($forward_url);



/**
 * helper function to retrieve all the members (and members who are selected to receive the group mail)
 * @param int $group_id - group guid
 * @param array $user_guids - array of user guids
 */
function group_tools_retrieve_members($group_id, $user_guids) {

	$query = "SELECT guid_one FROM elggentity_relationships WHERE relationship = 'member' AND guid_two = '{$group_id}'";
	$group_members = json_decode(json_encode(get_data($query)),true);
	$group_members = array_flatten($group_members, array());

	$recipients = array();
	foreach ($user_guids as $user_id_key => $user_id) {
		if (in_array($user_id, $group_members)) {
			// make sure that this list does not contain any duplicates
			$recipients[$user_id] = $user_id;
		}
	}
	return $recipients;
}

/**
 * recursively flatten the array, get_data returns stdClass Object
 * @param array $array - array of user guids
 * @param array $return - array of recipients
 */
function array_flatten($array, $return) {
	for ($x = 0; $x <= count($array); $x++) {

		if (is_array($array[$x]['guid_one'])) {
			$return = array_flatten($array[$x], $return);
		
		} else if (isset($array[$x]['guid_one'])) {
			$return[] = $array[$x]['guid_one'];
		}
					
	}
	return $return;
}