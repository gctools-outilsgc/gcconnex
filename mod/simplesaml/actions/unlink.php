<?php

$source = get_input("source");
$user_guid = (int) get_input("user_guid");

if (!empty($source) && !empty($user_guid)) {
	$user = get_user($user_guid);
	if (!empty($user) && $user->canEdit()) {
		$label = simplesaml_get_source_label($source);
		
		if (simplesaml_is_enabled_source($source)) {
			if (simplesaml_unlink_user($user, $source)) {
				system_message(elgg_echo("simplesaml:action:unlink:success", array($label)));
			} else {
				register_error(elgg_echo("simplesaml:action:unlink:error", array($label)));
			}
		} else {
			register_error(elgg_echo("simplesaml:error:source_not_enabled", array($label)));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward(REFERER);
