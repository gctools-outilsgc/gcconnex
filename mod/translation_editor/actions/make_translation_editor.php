<?php
/**
 * give a user the right to modify the translations
 */

$user_guid = (int) get_input("user");
$role = "translation_editor";

$user = get_user($user_guid);
if (empty($user)) {
	register_error(elgg_echo("translation_editor:action:make_translation_editor:error"));
	forward(REFERER);
}

if (create_metadata($user->getGUID(), $role, true, "integer", $user->getGUID(), ACCESS_PUBLIC)) {
	system_message(elgg_echo("translation_editor:action:make_translation_editor:success"));
} else {
	register_error(elgg_echo("translation_editor:action:make_translation_editor:error"));
}

forward(REFERER);
