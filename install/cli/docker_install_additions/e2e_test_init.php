<?php
/**
 * E2E test init module for Docker CLI installer script.
 *
 * @access private
 */

function e2e_init(){
    echo "do init stuff... \n";
    create_test_user("Haibun", "Haibun", "Haibun");
}


function create_test_user( $username, $name, $password){
    $user = new ElggUser();
	$user->username = $username;
	$user->name = $name;
	$user->access_id = ACCESS_PUBLIC;
	$user->setPassword($password);
	$user->owner_guid = 0;
	$user->container_guid = 0;

	if (!$user->save()) {
		echo "error creating user $username"
	}

    return $user;
}