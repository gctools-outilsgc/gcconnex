<?php

/**
 * set_no_notifications
 *
 * @author Gustavo Bellino
 * @link http://community.elgg.org/pg/profile/gushbellino
 * @copyright (c) Keetup 2010
 * @link http://www.keetup.com/
 * @license GNU General Public License (GPL) version 2
 *
 * updated and modified for Elgg 1.8 and newer by iionly
 * (c) iionly
 */

// Initialise set_no_notifications
elgg_register_event_handler('init','system','set_no_notifications_init');

function set_no_notifications_init() {
	//Event to act!
	elgg_register_event_handler('login:after', 'user', 'set_no_notifications_clear_user_meta');
}

/**
 * This function checks and if necessary sets the email notifications to disabled the first time a user logs in
 * @param String $event
 * @param String $object_type
 * @param Object $object
 */
function set_no_notifications_clear_user_meta($event, $object_type, $object) {
	// check if the user should be considered
	if (elgg_get_plugin_setting('setNoNotif_time', 'set_no_notifications') < $object->time_created) {
		if($event == 'login:after' && $object_type=='user' && $object instanceof ElggUser) {

			$time = elgg_get_plugin_setting('setNoNotif_time','set_no_notifications');
			if (!$object->set_no_notifications && $object->time_created > $time) {
				$method = array('email'=>'no');
				$result = false;
				foreach ($method as $k => $v) {
					$result = set_user_notification_setting($object['user']->guid, $k, ($v == 'yes') ? true : false);

					if (!$result) {
						$object->set_no_notifications = false;
					} else {
						$object->set_no_notifications = true;
					}
				}
			}
		}
	}

	return true;
}
