<?php
/**
 * Mail all the members of a group
 */

$group_guid = (int) get_input("group_guid", 0);
$user_guids = get_input("user_guids");
$subject = get_input("title");
$body = get_input("description");

$forward_url = REFERER;
$user_guids = group_tools_verify_group_members($group_guid, $user_guids);

if (!empty($group_guid) && !empty($body) && !empty($user_guids)) {
	$group = get_entity($group_guid);
	
	if (!empty($group) && ($group instanceof ElggGroup)) {
		if ($group->canEdit()) {
			set_time_limit(0);
			
			$body .= PHP_EOL . PHP_EOL;
			$body .= elgg_echo("group_tools:mail:message:from") . ": " . $group->name . " [" . $group->getURL() . "]";
			
			// cyu - 03/07/2016: we need to use the cp_notifications module to handle the improved notifications
			if (elgg_is_active_plugin('cp_notifications')) {

				$message = array(
					'cp_group' => $group,
					'cp_group_subject' => $subject,
					'cp_group_message' => get_input("description") . "<br/>" . elgg_echo("group_tools:mail:message:from") . ": " . $group->name . " [" . $group->getURL() . "]",
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
