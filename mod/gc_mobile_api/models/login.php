<?php
/*
 * Exposes API endpoints for logging in a user
 */

elgg_ws_expose_function(
	"login.user",
	"login_user",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"password" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Logs in a user based on user email',
	'POST',
	false,
	false
);

elgg_ws_expose_function(
	"login.sso",
	"login_sso",
	array(
		"email" => array('type' => 'string', 'required' => true),
		"sub" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Logs in a user based on user email for SSO',
	'POST',
	false,
	false
);

elgg_ws_expose_function(
	"login.userforchat",
	"login_user_for_chat",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Logs in a user based on user id for using chat',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"login.userfordocs",
	"login_user_for_docs",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Logs in a user based on user id for using Docs',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"login.userforurl",
	"login_user_for_url",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"url" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Logs in a user based on user id and url',
	'POST',
	true,
	false
);

function login_user($user, $password, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	$username = $user_entity->username;
	$access = elgg_authenticate($username, $password);

	if (true === $access) {
		return true;
	} else {
		return "Invalid user.";
	}
}

function login_sso($email, $sub, $lang)
{
	$db_prefix = elgg_get_config('dbprefix');
	$user = get_user_by_pleio_guid_or_email($sub, $email);
    $allow_registration = elgg_get_config("allow_registration");

    if (!$user && $allow_registration) {

        /*** Username Generation ***/
        $query = "SELECT count(*) as num FROM {$db_prefix}users_entity WHERE username = '". $username ."'";
        $result = get_data($query);

        // check if username exists and increment it
        if ( $result[0]->num > 0 ){
            $unamePostfix = 0;
            $usrnameQuery = $username;
            
            do {
                $unamePostfix++;
                $tmpUsrnameQuery = $usrnameQuery . $unamePostfix;
                
                $query1 = "SELECT count(*) as num FROM {$db_prefix}users_entity WHERE username = '". $tmpUsrnameQuery ."'";
                $tmpResult = get_data($query1);
                
                $uname = $tmpUsrnameQuery;
            } while ( $tmpResult[0]->num > 0);
        } else {
            $uname = $username;
        }
        $username = $uname;
        /*** End Username Generation ***/
        
        $guid = register_user(
            $username,
            generate_random_cleartext_password(),
            $name,
            $email
        );
        
        if ($guid) {
            update_data("UPDATE {$db_prefix}users_entity SET pleio_guid = {$sub} WHERE guid = {$guid}");
        }
        
        $user = get_user($guid);
    }

    if (!$user) {
        return "Invalid user.";
    }

    try {
        login($user);
        return true;
    } catch (\LoginException $e) {
        return "Invalid user.";
    }
}

function login_user_for_chat($user, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	forward('cometchat/cometchat_embedded.php');
}

function login_user_for_docs($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Doc was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, 'object', 'etherpad')) {
		return "Invalid Doc. Please try a different GUID";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$docObj = new ElggPad($guid);
	forward($docObj->getPadPath());
}

function login_user_for_url($user, $url, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}
	
	forward($url);
}
