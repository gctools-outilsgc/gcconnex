<?php

namespace ColdTrick\GroupTools;

use Elgg\Notifications\Event;
class GroupMail {
	
	/**
	 * Add a menu option to the page menu of groups
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function pageMenu($hook, $type, $return_value, $params) {
		
		if (!elgg_is_logged_in()) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		if (!($page_owner instanceof \ElggGroup) || !elgg_in_context('groups')) {
			return;
		}
		
		if (!group_tools_group_mail_enabled($page_owner) && !group_tools_group_mail_members_enabled($page_owner)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'mail',
			'text' => elgg_echo('group_tools:menu:mail'),
			'href' => "groups/mail/{$page_owner->getGUID()}",
		]);
		
		return $return_value;
	}
	
	/**
	 * Change the notification for a GroupMail
	 *
	 * @param string                           $hook         the name of the hook
	 * @param string                           $type         the type of the hook
	 * @param \Elgg\Notifications\Notification $return_value current return value
	 * @param array                            $params       supplied params
	 *
	 * @return void|\Elgg\Notifications\Notification
	 */
	public static function prepareNotification($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
		
		$object = $event->getObject();
		if (!($object instanceof \GroupMail)) {
			return;
		}
		
		$return_value->subject = $object->getSubject();
		$return_value->summary = $object->getSubject();
		$return_value->body = $object->getMessage();
		
		return $return_value;
	}
	
	/**
	 * Get the subscribers for the GroupMail
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function getSubscribers($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
		
		$object = $event->getObject();
		if (!($object instanceof \GroupMail)) {
			return;
		}
		
		// large group could have a lot of recipients, so increase php time limit
		set_time_limit(0);
		
		return $object->getRecipients();
	}
	
	/**
	 * Tasks todo after the notification has been send
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param void   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function cleanup($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
		
		$object = $event->getObject();
		if (!($object instanceof \GroupMail)) {
			return;
		}
		
		// need to check if the $event actor is a recipient, because Elgg skips that user
		$recipients = $object->getRecipients();
		if (!empty($recipients)) {
			foreach ($recipients as $user_guid => $methods) {
				if ($user_guid != $event->getActorGUID()) {
					continue;
				}
				
				notify_user($user_guid, $event->getActorGUID(), $object->getSubject(), $object->getMessage(), [], $methods);
				break;
			}
		}
		
		// remove the mail from the database
		$object->delete();
	}
}
