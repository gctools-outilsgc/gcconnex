<?php

/**
 *
 * User setting for Notification options. Displays different options for subscription settings, how to be notified and who or what to subscribe
 * @author Christine Yu <internalfire5@live.com>
 *
 */


$action_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
	$action_url = str_replace("http:", "https:", $action_url);
}
$action_url .= 'action/cp_notifications/usersettings/save';

echo elgg_view_form('notifications/usersettings', array(
	'class' => 'elgg-form-alt',
	'action' => $action_url,
));

