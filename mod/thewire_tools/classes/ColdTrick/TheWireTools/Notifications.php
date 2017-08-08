<?php

namespace ColdTrick\TheWireTools;

class Notifications {
	
	/**
	 * This functions performs actions when a wire post is created
	 *
	 * @param string     $event  'create'
	 * @param string     $type   'object'
	 * @param \ElggObject $object the ElggObject created
	 *
	 * @return void
	 */
	public static function triggerMentionNotificationEvent($event, $type, \ElggObject $object) {
		
		if (!elgg_instanceof($object, 'object', 'thewire')) {
			return;
		}
		
		// @todo replace with decent Elgg 2.0 notification event handling
	
		//send out notification to users mentioned in a wire post
		$usernames = [];
		preg_match_all("/\@([A-Za-z0-9\_\.\-]+)/i", $object->description, $usernames);
	
		if (empty($usernames)) {
			return;
		}
	
		$usernames = array_unique($usernames[0]);
		$params = [
			'object' => $object,
			'action' => 'mention',
		];
	
		foreach ($usernames as $username) {
			$username = str_ireplace('@', '', $username);
			$user = get_user_by_username($username);
	
			if (empty($user) || ($user->getGUID() == $object->getOwnerGUID())) {
				continue;
			}
				
			$setting = thewire_tools_get_notification_settings($user->getGUID());
			if (empty($setting)) {
				continue;
			}
	
			$subject = elgg_echo('thewire_tools:notify:mention:subject');
			$message = elgg_echo('thewire_tools:notify:mention:message', [
				$user->name,
				$object->getOwnerEntity()->name,
				elgg_normalize_url("thewire/search/@{$user->username}"),
			]);
	
			notify_user($user->getGUID(), $object->getOwnerGUID(), $subject, $message, $params, $setting);
		}
	}
	
	/**
	 * Save the wire_tools preferences for the user
	 *
	 * @param string $hook         the name of the hook
	 * @param stirng $type         the type of the hook
	 * @param array  $return_value the current return value
	 * @param array  $params       supplied values
	 *
	 * @return void
	 */
	public static function saveUserNotificationsSettings($hook, $type, $return_value, $params) {
	
		$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();
		if (empty($NOTIFICATION_HANDLERS) || !is_array($NOTIFICATION_HANDLERS)) {
			return;
		}
	
		$user_guid = (int) get_input('guid');
		if (empty($user_guid)) {
			return;
		}
	
		$user = get_user($user_guid);
		if (empty($user) || !$user->canEdit()) {
			return;
		}
	
		$methods = [];
	
		foreach ($NOTIFICATION_HANDLERS as $method) {
			$setting = get_input("thewire_tools_{$method}");
	
			if (!empty($setting)) {
				$methods[] = $method;
			}
		}
	
		if (!empty($methods)) {
			elgg_set_plugin_user_setting('notification_settings', implode(',', $methods), $user->getGUID(), 'thewire_tools');
		} else {
			elgg_unset_plugin_user_setting('notification_settings', $user->getGUID(), 'thewire_tools');
		}
	
		// set flag for correct fallback behaviour
		elgg_set_plugin_user_setting('notification_settings_saved', '1', $user->getGUID(), 'thewire_tools');
	
	}
}