<?php
/**
 * Enhanced API Admin
 * A plugin to manage web services API keys directly from within the Elgg admin console
 *
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 * @author Federico Mestrone
 * @copyright Moodsdesign Ltd 2012
 * @link http://www.moodsdesign.com
 */

/*
 * Based upon:
 *
 * Elgg API Admin
 * Upgraded to Elgg 1.8 (tested on 1.8.8) and added rename and regenerate actions
 * 
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2011
 * @link http://www.elgg.org
*/

elgg_register_event_handler('init','system','apiadmin_init');

/**
 * Initialise the API Admin tool on init,system
 *
 * @param unknown_type $event
 * @param unknown_type $object_type
 * @param unknown_type $object
*/
function apiadmin_init($event, $object_type, $object = null) {
	// Add pages and menu items to the admin area
	elgg_register_admin_menu_item('administer', 'apiadmin', 'administer_utilities', 501);
    elgg_register_admin_menu_item('administer', 'apilog', 'statistics', 501);
    //elgg_register_admin_menu_item('administer', 'apistats', 'statistics', 501);

	// Hook into delete to revoke secret keys
	elgg_register_event_handler('delete', 'object', 'apiadmin_delete_key');

	// Register some actions
	$plugindir = dirname(__FILE__);
	elgg_register_action('apiadmin/revokekey', $plugindir . '/actions/apiadmin/revokekey.php', 'admin');
	elgg_register_action('apiadmin/generate', $plugindir . '/actions/apiadmin/generate.php', 'admin');
	elgg_register_action('apiadmin/renamekey', $plugindir . '/actions/apiadmin/renamekey.php', 'admin');
	elgg_register_action('apiadmin/regenerate', $plugindir . '/actions/apiadmin/regenerate.php', 'admin');

    if ( elgg_get_plugin_setting('enable_stats', 'apiadmin') == 'on' ) {
        // Register hook for 'api_key', 'use' for stats purposes
        elgg_register_plugin_hook_handler('api_key', 'use', 'apiadmin_apikey_use');
    }

    if ( elgg_is_active_plugin('version_check') ) {
        version_check_register_plugin('apiadmin');
    }
}

/**
 * Event handler for when an API key is deleted
 * 
 * @param unknown_type $event
 * @param unknown_type $object_type
 * @param unknown_type $object
 */
function apiadmin_delete_key($event, $object_type, $object = null) {
	global $CONFIG;

	if ( ($object) && ($object->subtype === get_subtype_id('object', 'api_key')) ) {
		// Delete secret key
		return remove_api_user($CONFIG->site_id, $object->public);
	}

	return true;
}

function apiadmin_apikey_use($hook, $type, $returnvalue, $params) {
    global $CONFIG;
    $handler = sanitise_string($_GET['handler']);
    $request = sanitise_string($_GET['request']);
    $method = sanitise_string($_GET['method']);
    $api_key = sanitise_string($params);
    $remote_address = sanitise_string($_SERVER['REMOTE_ADDR']);
    $user_agent = sanitise_string($_SERVER['HTTP_USER_AGENT']);
    // `id` bigint(20) `timestamp` int(11) `api_key` varchar(40) `handler` varchar(256) `request` varchar(256) `method` varchar(256)
    $sql = sprintf("INSERT INTO %s VALUES(NULL, %d, '%s', '%s', '%s', '%s', '%s', '%s')", $CONFIG->dbprefix . 'apiadmin_log',
                time(),
                $api_key,
                $handler,
                $request,
                $method,
                $remote_address,
                $user_agent
            );
    $result = insert_data($sql);
    if ( $result != 1 ) {
        error_log("Could not save stats for $api_key ($method)");
    }
    return $returnvalue;
}

/**
 * Retrieve the API Access log based on a number of parameters.
 *
 * @param int|array $by_key             The guid(s) of the key(s) to filter in
 * @param string    $handler            The event you are searching on.
 * @param string    $request            The class of object it effects.
 * @param string    $method             The type
 * @param string    $remote_address     The subtype.
 * @param int       $limit      Maximum number of responses to return.
 * @param int       $offset     Offset of where to start.
 * @param bool      $count      Return count or not
 * @param int       $timebefore Lower time limit
 * @param int       $timeafter  Upper time limit
 * @param int       $object_id  GUID of an object
 * @param str       $ip_address The IP address.
 * @return mixed
 */
function apiadmin_get_usage_log($by_key = '', $handler = '', $request = '', $method = '', $remote_address = '',
    $limit = 10, $offset = 0, $count = false, $timebefore = 0, $timeafter = 0, $object_id = 0
  ) {

    global $CONFIG;

    $limit = (int)$limit;
    $offset = (int)$offset;

    $where = array();

    /*
        $by_user_orig = $by_user;
        if (is_array($by_user) && sizeof($by_user) > 0) {
            foreach ($by_user as $key => $val) {
                $by_user[$key] = (int) $val;
            }
        } else {
            $by_user = (int)$by_user;
        }

        $event = sanitise_string($event);
        $class = sanitise_string($class);
        $type = sanitise_string($type);
        $subtype = sanitise_string($subtype);
        $ip_address = sanitise_string($ip_address);

        if ($by_user_orig !== "" && $by_user_orig !== false && $by_user_orig !== null) {
            if (is_int($by_user)) {
                $where[] = "performed_by_guid=$by_user";
            } else if (is_array($by_user)) {
                $where [] = "performed_by_guid in (" . implode(",", $by_user) . ")";
            }
        }
        if ($event != "") {
            $where[] = "event='$event'";
        }
        if ($class !== "") {
            $where[] = "object_class='$class'";
        }
        if ($type != "") {
            $where[] = "object_type='$type'";
        }
        if ($subtype !== "") {
            $where[] = "object_subtype='$subtype'";
        }

        if ($timebefore) {
            $where[] = "time_created < " . ((int) $timebefore);
        }
        if ($timeafter) {
            $where[] = "time_created > " . ((int) $timeafter);
        }
        if ($object_id) {
            $where[] = "object_id = " . ((int) $object_id);
        }
        if ($ip_address) {
            $where[] = "ip_address = '$ip_address'";
        }
    */

    $select = '*';
    if ( $count ) {
        $select = 'count(*) as count';
    }
    $query = "SELECT $select FROM {$CONFIG->dbprefix}apiadmin_log WHERE 1 ";
    foreach ( $where as $w ) {
        $query .= " AND $w";
    }

    if ( !$count ) {
        $query .= ' ORDER BY time_created DESC';
        $query .= " LIMIT $offset, $limit"; // Add order and limit
    }

    if ( $count ) {
        $numrows = get_data_row($query);
        if ( $numrows ) {
            return $numrows->count;
        }
    } else {
        return get_data($query);
    }

    return false;
}
