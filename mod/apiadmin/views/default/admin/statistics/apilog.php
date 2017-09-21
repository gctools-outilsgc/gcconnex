<?php
/**
 * API Admin usage log browser admin page
 *
 * @note The ElggObject this creates for each entry is temporary
 *
 * @package APIAdmin
 */

if ( !elgg_is_active_plugin('version_check') ) {
    register_error(elgg_echo('apiadmin:no_version_check'));
}

$limit = get_input('limit', 20);
$offset = get_input('offset');

/*
 * filter implementation

$search_username = get_input('search_username');
if ($search_username) {
    $user = get_user_by_username($search_username);
    if ($user) {
        $user_guid = $user->guid;
    } else {
        $user_guid = null;
    }
} else {
    $user_guid = get_input('user_guid', null);
    if ($user_guid) {
        $user_guid = (int) $user_guid;
        $user = get_entity($user_guid);
        if ($user) {
            $search_username = $user->username;
        }
    } else {
        $user_guid = null;
    }
}

$timelower = get_input('timelower');
if ($timelower) {
    $timelower = strtotime($timelower);
}

$timeupper = get_input('timeupper');
if ($timeupper) {
    $timeupper = strtotime($timeupper);
}

$ip_address = get_input('ip_address');

$refine = elgg_view('apiadmin/refine', array(
    'timeupper' => $timeupper,
    'timelower' => $timelower,
    'ip_address' => $ip_address,
    'username' => $search_username,
));

 */

// Get log entries
$log = apiadmin_get_usage_log('','','','','',$limit,$offset,false,0,0,0);
$count = apiadmin_get_usage_log('','','','','',$limit,$offset,true,0,0,0);

// if user does not exist, we have no results
if ($search_username && is_null($user_guid)) {
    $log = false;
    $count = 0;
}

$table = elgg_view('apiadmin/table', array('log_entries' => $log));

$nav = elgg_view('navigation/pagination',array(
    'offset' => $offset,
    'count' => $count,
    'limit' => $limit,
));

// display admin body
$body = <<<__HTML
$refine
$nav
$table
$nav
__HTML;

echo $body;
