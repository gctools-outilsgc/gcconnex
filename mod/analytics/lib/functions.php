<?php
/**
 * All helper functions are bundled here
 */

/**
 * Track Elgg actions if the setting allows this
 *
 * @param string $action the name of the action
 *
 * @return void
 */
function analytics_track_action($action) {
	$action_result = true;
	
	if (!analytics_google_track_actions_enabled()) {
		// tracking is not enabled
		return;
	}
	
	$params = [
		'action' => $action,
	];
	if (!elgg_trigger_plugin_hook('track_action', 'analytics', $params, true)) {
		// don't track this action
		return;
	}
	
	// if an error occured log the action as failed
	if (count_messages('error') > 0) {
		$action_result = false;
	}
	
	if (!isset($_SESSION['analytics'])) {
		$_SESSION['analytics'] = [];
	}
	
	if (!isset($_SESSION['analytics']['actions'])) {
		$_SESSION['analytics']['actions'] = [];
	}
	
	$_SESSION['analytics']['actions'][$action] = $action_result;
}

/**
 * Track Elgg events if the settings allows this
 *
 * @param string $category category of the event
 * @param string $action   the action of the event
 * @param string $label    optional label for tracking
 *
 * @return void
 */
function analytics_track_event($category, $action, $label = '') {
	
	if (!analytics_google_track_events_enabled()) {
		// tracking is not enabled
		return;
	}
	
	if (empty($category) || empty($action)) {
		// invalid input
		return;
	}
	
	$params = [
		'category' => $category,
		'action' => $action,
		'label' => $label,
	];
	if (!elgg_trigger_plugin_hook('track_event', 'analytics', $params, true)) {
		// don't track this event
		return;
	}
	
	if (!isset($_SESSION['analytics'])) {
		$_SESSION['analytics'] = [];
	}
	
	if (!isset($_SESSION['analytics']['events'])) {
		$_SESSION['analytics']['events'] = [];
	}
	
	$t_event = [
		'category' => $category,
		'action' => $action,
	];
	
	if (!empty($label)) {
		$t_event['label'] = $label;
	}
	
	$_SESSION['analytics']['events'][] = $t_event;
}

/**
 * Check is tracking Events is enabled for Google Analytics
 *
 * @return bool
 */
function analytics_google_track_events_enabled() {
	static $cache;
	
	if (!isset($cache)) {
		$cache = false;
		
		$setting = elgg_get_plugin_setting('trackEvents', 'analytics');
		if ($setting === 'yes') {
			$cache = true;
		}
	}
	
	return $cache;
}

/**
 * Check is tracking Actions is enabled for Google Analytics
 *
 * @return bool
 */
function analytics_google_track_actions_enabled() {
	static $cache;
	
	if (!isset($cache)) {
		$cache = false;
		
		$setting = elgg_get_plugin_setting('trackActions', 'analytics');
		if ($setting === 'yes') {
			$cache = true;
		}
	}
	
	return $cache;
}

/**
 * Get all the tracked Events in a Google Analytics format
 *
 * @return string
 */
function analytics_google_get_tracked_events() {
	$output = '';
	
	if (!analytics_google_track_events_enabled()) {
		return $output;
	}
	
	if (empty($_SESSION['analytics']['events'])) {
		return $output;
	}
	
	foreach ($_SESSION['analytics']['events'] as $event) {
		
		$event_data = [
			'eventCategory' => $event['category'],
			'eventAction' => $event['action'],
		];
		if (!empty($event['label'])) {
			$event_data['eventLabel'] = $event['label'];
		}
		
		
		$output .= "ga('send', 'event', " . json_encode($event_data) . ");";
	}

	$_SESSION['analytics']['events'] = [];
	
	return $output;
}

/**
 * Get all the tracked Actions in a Google Analytics format
 *
 * @return string
 */
function analytics_google_get_tracked_actions() {
	$output = '';
	
	if (!analytics_google_track_actions_enabled()) {
		return $output;
	}
	
	if (empty($_SESSION['analytics']['actions'])) {
		return $output;
	}
	
	foreach ($_SESSION['analytics']['actions'] as $action => $result) {
		if ($result) {
			$output .= "ga('send', 'pageview', '/action/{$action}/succes');";
		} else {
			$output .= "ga('send', 'pageview', '/action/{$action}/error');";
		}
	}
	
	$_SESSION['analytics']['actions'] = [];
	
	return $output;
}
