<?php
/**
 * E2E test init module for Docker CLI installer script.
 *
 * @access private
 */

function e2e_init(){
    echo "do init stuff... \n";
    $user_guid = create_test_user("Haibun", "Haibun", "Haibun");
    create_test_group("Haibun", $user_guid);
}


function create_test_user($username, $name, $password){
    $user = new ElggUser();
	$user->username = $username;
	$user->name = $name;
	$user->access_id = ACCESS_PUBLIC;
	$user->setPassword($password);
	$user->owner_guid = 0;
	$user->container_guid = 0;

	// user type and organization
	$user->user_type = 'academic';
	$user->institution = 'university';
	$user->university = 'Haibun';

	$user_guid = $user->save();
	if (!$user_guid) {
		echo "error creating user $username";
	}

    return $user_guid;
}

function create_test_group($name, $owner_guid){

    $group = new ElggGroup();
    $group->name = $name;
	$group->membership = ACCESS_PUBLIC;
	$group->access_id = ACCESS_PUBLIC;

	$group_guid = $group->save();
	if (!$group_guid) {
		echo "error creating group $name for user $owner_guid \n";
	}

	$group = get_entity($group_guid);
	$group->join(get_user($owner_guid));

	// elgg refuses to update owner_guid and container_guid any other way here, so went with a direct update query
	$db_prefix = elgg_get_config('dbprefix');
	update_data("UPDATE {$db_prefix}entities SET owner_guid = '$owner_guid', container_guid = '$owner_guid' where guid = '$group_guid'");

    return $group;
}