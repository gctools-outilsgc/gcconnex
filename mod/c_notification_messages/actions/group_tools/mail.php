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
		$group_owner = $group->getOwnerEntity();
		if ($group->canEdit()) {
			set_time_limit(0);
			
			//$body .= PHP_EOL . PHP_EOL;
			
			$body_msg = elgg_echo("c_group_tools:mail:message:body", array(
				$body,
				$group->name,
				$group_owner->name,
				$group->name,
				
				$body,
				$group->name,
				$group_owner->name,
				$group->name,
			));
			//$body .= elgg_echo("group_tools:mail:message:from") . ": " . $group->name . " [" . $group->getURL() . "]";
			
			if ($subject == "") {
				$subj_line = c_validate_string(utf8_encode(html_entity_decode($group->name, ENT_QUOTES | ENT_HTML5 )));
				if (!is_array($subj_line))
				{
					$lang01 = $subj_line;
					$lang02 = $subj_line;
				} else {
					$lang01 = $subj_line[0];
					$lang02 = $subj_line[1];
				}
				$subject = "You received mail from the group ".$lang01." / Vous avez reçu le courrier du groupe ".$lang02;
			}
			
			foreach ($user_guids as $guid) {
				notify_user($guid, $group->getGUID(), $subject, $body_msg, NULL, "email");
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
