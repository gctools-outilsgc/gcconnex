<?php

elgg_register_event_handler('init', 'system', 'mindbreeze_test_init');

function mindbreeze_test_init() {

    elgg_register_plugin_hook_handler('route', 'all', 'mindbreeze_route_all', 10);

}

/**
 * Handles incoming HTTP Request from the GSA, this acts as the security layer for the GSA only
 * @param $hook
 * @param $type
 * @param $info
 * @return False to stop processing the response, True will let elgg handle the response
 */
function mindbreeze_route_all($hook, $type, $info) {

    // Incoming request from the GSA
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $set_agent = strtolower(elgg_get_plugin_setting('elgg_mb_agentstring', 'mindbreeze_test'));

    if (strpos($agent, $set_agent) !== false) {
  
  		$set_username = strtolower(elgg_get_plugin_setting('elgg_mb_username','mindbreeze_test'));
  		$set_password = strtolower(elgg_get_plugin_setting('elgg_mb_password','mindbreeze_test'));

        // Handles a request coming from the Crawler
        $username = $set_username;
        $password = $set_password;
        if (!empty($username) && !empty($password)) {
            $persistent = false;
            // check if logging in with email address
            if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
                $username = $users[0]->username;
            }

            $result = elgg_authenticate($username, $password);
            if ($result !== true) {
                header('WWW-Authenticate: Basic realm="Elgg Authentication"');
                header('HTTP/1.0 401 Unauthorized');
                return false;
            }

            $user = get_user_by_username($username);
            if (!$user) {
                header('WWW-Authenticate: Basic realm="Elgg Authentication"');
                header('HTTP/1.0 401 Unauthorized');
                return false;
            }

            try {
                login($user, $persistent);
                return $info;
            }
			catch (LoginException $e) {
                header('WWW-Authenticate: Basic realm="Elgg Authentication"');
                header('HTTP/1.0 401 Unauthorized');
                return false;
            }

        } else {
            $user = elgg_get_logged_in_user_entity();
            if ($user) {
                return $info;
            } else {
                header('WWW-Authenticate: Basic realm="Elgg Authentication"');
                header('HTTP/1.0 401 Unauthorized');
                exit();
            }

        }
    }

    return;
}