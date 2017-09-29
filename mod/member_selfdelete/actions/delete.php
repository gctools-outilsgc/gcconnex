<?php

namespace Beck24\MemberSelfDelete;

elgg_make_sticky_form('member_selfdelete');

if (elgg_is_admin_logged_in()) {
	register_error(elgg_echo('member_selfdelete:error:delete:admin'));
	forward(REFERER);
}

$confirmation = get_input('confirmation');
$reason = get_input('reason');

if (elgg_get_plugin_setting('method', PLUGIN_ID) == "choose") {
	$method = get_input('method', 'delete');
	if (!in_array($method, array('delete', 'ban', 'transfer'))) {
		$method = "delete"; // no valid method selected, somethings wrong, delete them for hacking! hehe
	}
} else {
	$method = elgg_get_plugin_setting('method', PLUGIN_ID);
}

// make sure they entered their password into the confirmation
if (elgg_authenticate(elgg_get_logged_in_user_entity()->username, $confirmation) !== true) {
	// not confirmed
	register_error(elgg_echo('member_selfdelete:invalid:confirmation'));
	forward(REFERER);
}


if (!empty($reason)) {
	// they gave some feedback - log it

	$prefix = "Username: " . elgg_get_logged_in_user_entity()->username . "<br> Reason for leaving: <br>";
	// annotate the site, set the owner_guid to -9999 
	create_annotation(elgg_get_logged_in_user_entity()->site_guid, 'selfdeletefeedback', $prefix . $reason, 'text', elgg_get_site_entity()->guid, ACCESS_PRIVATE);

	system_message(elgg_echo('member_selfdelete:feedback:thanks'));
}


$user = elgg_get_logged_in_user_entity();

switch ($method) {
	case "ban":
		// just bans the user
		ban_user($user->guid, elgg_echo('member_selfdelete:self:banned'));
		logout();
		
		session_regenerate_id(true);

		system_message(elgg_echo('member_selfdelete:action:banned'));
		break;
	case "anonymize":
		// rename display name to inactive
		$user->name = elgg_echo('member_selfdelete:inactive:user');

		// reset avatar to system default
		unset($user->icontime);

		// delete all metadata on the user - all profile fields etc.
		// includes anything set by any other plugins
		// essentially resets to clean user
		$metadata = elgg_get_metadata(array('guid' => $user->guid, 'limit' => false));
		if (is_array($metadata)) {
			foreach ($metadata as $data) {
				$data->delete();
			}
		}

		// delete all relationships in both directions
		$relationships1 = get_entity_relationships($user->guid, FALSE);
		$relationships2 = get_entity_relationships($user->guid, TRUE);
		$relationships = array_merge($relationships1, $relationships2);

		if (is_array($relationships)) {
			foreach ($relationships as $relationship) {
				if ($relationship->relationship == 'member_of_site') {
					continue;
				}
				$relationship->delete();
			}
		}

		// delete all annotations on the user
		$annotations = elgg_get_annotations(array('guids' => array($user->guid)));
		if (is_array($annotations)) {
			foreach ($annotations as $annotation) {
				$annotation->delete();
			}
		}

		// delete all access collections
		$collections = get_user_access_collections($user->guid);
		if (is_array($collections)) {
			foreach ($collections as $collection) {
				delete_access_collection($collection->id);
			}
		}

		// remove from access collections
		$access = get_access_array();
		foreach ($access as $id) {
			if (!in_array($id, array(ACCESS_PUBLIC, ACCESS_LOGGED_IN, ACCESS_FRIENDS, ACCESS_PRIVATE))) {
				remove_user_from_access_collection($user->guid, $id);
			}
		}

		// reset password to unusable password
		$user->password = '';
		$user->salt = '';
		$user->password_hash = '';
		$user->email = "anon{$user->guid}@" . get_site_domain();

		// set our single piece of metadata that tells us this user has been deleted
		$user->member_selfdelete = "anonymized";

		$user->save();
		logout();
		session_regenerate_id(true);

		system_message(elgg_echo('member_selfdelete:action:anonymized'));
		break;
	default:
		// default is to delete the user
		$user->delete();
		session_regenerate_id(true);

		system_message(elgg_echo('member_selfdelete:deleted'));
		break;
}

elgg_clear_sticky_form('member_selfdelete');

forward();
