<?php
/**
 * Save the domains for domain based joining of a group
 */

$group_guid = (int) get_input("group_guid");
$domains = get_input("domains");

$forward_url = REFERER;

if (!empty($group_guid)) {
	$group = get_entity($group_guid);
	
	if (!empty($group) && elgg_instanceof($group, "group")) {
		if ($group->canEdit()) {
			
			if (!empty($domains)) {
				$domains = string_to_tag_array($domains);
				$domains = "|" . implode("|", $domains) . "|";
				
				$group->setPrivateSetting("domain_based", $domains);
			} else {
				$group->removePrivateSetting("domain_based");
			}
			
			system_message(elgg_echo("group_tools:action:domain_based:success"));
			$forward_url = $group->getURL();
		} else {
			register_error(elgg_echo("groups:cantedit"));
		}
	} else {
		register_error(elgg_echo("groups:notfound:details"));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward($forward_url);