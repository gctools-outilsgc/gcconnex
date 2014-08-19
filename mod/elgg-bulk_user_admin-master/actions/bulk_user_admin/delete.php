<?php
/**
 * Bulk delete users
 */

$guids = get_input('bulk_user_admin_guids');
$errors = array();

foreach ($guids as $guid) {
	$user = get_entity($guid);

	if (!$user instanceof ElggUser) {
		$errors[] = "$guid is not a user.";
		continue;
	}

	if (!$user->delete()) {
		$errors[] = "Could not delete $user->name ($user->username).";
	}
}

if ($errors) {
	foreach ($errors as $error) {
		register_error($error);
	}
} else {
	system_message("Users deleted.");
}

forward(REFERER);
