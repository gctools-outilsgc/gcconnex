<?php

namespace ColdTrick\Analytics;

class Tracker {
	
	/**
	 * Track certain events on ElggEntity's
	 *
	 * @param string      $event  the event
	 * @param string      $type   the type of the ElggEntity
	 * @param \ElggEntity $object the entity for the event
	 *
	 * @return void
	 */
	public static function events($event, $type, $object) {
		
		if (!($object instanceof \ElggEntity)) {
			return;
		}
		
		if (!analytics_google_track_events_enabled()) {
			return;
		}
		
		switch ($object->getType()) {
			case 'object':
				analytics_track_event($object->getSubtype(), $event, $object->title);
				break;
			case 'group':
			case 'user':
				analytics_track_event($object->getType(), $event, $object->name);
				break;
		}
		
	}
	
	/**
	 * Track Elgg actions
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function actions($hook, $type, $return_value, $params) {
		
		if (!analytics_google_track_actions_enabled()) {
			return;
		}
		
		$_SESSION['analytics']['tracking_action'] = $type;
		
		elgg_register_event_handler('shutdown', 'system', '\ColdTrick\Analytics\Tracker::shutdownAction');
	}
	
	/**
	 * In the shutdown event, check if an action was successfull or has errors
	 *
	 * @param string      $event  the event
	 * @param string      $type   the type of the ElggEntity
	 * @param \ElggEntity $object the entity for the event
	 *
	 * @return void
	 */
	public static function shutdownAction($event, $type, $object) {
		
		if (empty($_SESSION['analytics']['tracking_action'])) {
			return;
		}
		
		analytics_track_action($_SESSION['analytics']['tracking_action']);
		unset($_SESSION['analytics']['tracking_action']);
	}
}
