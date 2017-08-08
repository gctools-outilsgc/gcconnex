<?php

$source = get_input('source');
$user_guid = (int) get_input('user_guid');

if (empty($source) || empty($user_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$user = get_user($user_guid);
if (empty($user) || !$user->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$label = simplesaml_get_source_label($source);

if (!simplesaml_is_enabled_source($source)) {
	register_error(elgg_echo('simplesaml:error:source_not_enabled', [$label]));
	forward(REFERER);
}

if (simplesaml_unlink_user($user, $source)) {
	system_message(elgg_echo('simplesaml:action:unlink:success', [$label]));
} else {
	register_error(elgg_echo('simplesaml:action:unlink:error', [$label]));
}

forward(REFERER);
