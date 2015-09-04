<?php
/**
 * Enable or disable group notifications for all members
 */
$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();

$toggle = get_input("toggle");
$guid = (int) get_input("guid");

$forward_url = REFERER;

if (!empty($guid) && !empty($toggle)) {
	$group = get_entity($guid);
	if (!empty($group) && elgg_instanceof($group, "group")) {
		// get group members
		$members = $group->getMembers(array("count" => true));
		if (!empty($members)) {
			$options = array(
				"type" => "user",
				"relationship" => "member",
				"relationship_guid" => $group->getGUID(),
				"inverse_relationship" => true,
				"limit" => false,
			);
			$members = new ElggBatch("elgg_get_entities_from_relationship", $options);
			
			if ($toggle == "enable") {
				// fix notifications settings for site amd email
				$auto_notification_handlers = array(
					"site",
					"email"
				);
				
				// enable notification for everyone
				foreach ($members as $member) {
					foreach ($NOTIFICATION_HANDLERS as $method => $dummy) {
						if (in_array($method, $auto_notification_handlers)) {
							add_entity_relationship($member->getGUID(), "notify" . $method, $group->getGUID());
						}
					}
				}
				
				system_message(elgg_echo("group_tools:action:notifications:success:enable"));
				$forward_url = $group->getURL();
			} elseif ($toggle == "disable") {
				// disable notification for everyone
				foreach ($members as $member) {
					foreach ($NOTIFICATION_HANDLERS as $method => $dummy) {
						remove_entity_relationship($member->getGUID(), "notify" . $method, $group->getGUID());
					}
				}
				
				system_message(elgg_echo("group_tools:action:notifications:success:disable"));
				$forward_url = $group->getURL();
			} else {
				register_error(elgg_echo("group_tools:action:notifications:error:toggle"));
			}
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:entity"));
	}
} else {
	register_error(elgg_echo("group_tools:action:error:input"));
}

forward($forward_url);
