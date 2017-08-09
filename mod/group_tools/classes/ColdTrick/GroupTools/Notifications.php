<?php

namespace ColdTrick\GroupTools;

class Notifications {
	
	/**
	 * Get the subscribers for a new group which needs admin approval
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function adminApprovalSubs($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
		
		$group = $event->getObject();
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		$action = $event->getAction();
		if ($action !== 'admin_approval') {
			return;
		}
		
		// get all admins
		$dbprefix = elgg_get_config('dbprefix');
		$batch = new \ElggBatch('elgg_get_entities', [
			'type' => 'user',
			'joins' => [
				"JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid",
			],
			'wheres' => [
				'ue.admin = "yes"',
			],
		]);
		/* @var $user \ElggUser */
		foreach ($batch as $user) {
			$notification_settings = get_user_notification_settings($user->getGUID());
			if (empty($notification_settings)) {
				continue;
			}
			
			$return_value[$user->getGUID()] = [];
			foreach ($notification_settings as $method => $active) {
				if (!$active) {
					continue;
				}
				$return_value[$user->getGUID()][] = $method;
			}
		}
		
		return $return_value;
	}
	
	/**
	 * Get the subscribers for a new group which needs admin approval
	 *
	 * @param string                           $hook         the name of the hook
	 * @param string                           $type         the type of the hook
	 * @param \Elgg\Notifications\Notification $return_value current return value
	 * @param array                            $params       supplied params
	 *
	 * @return void|\Elgg\Notifications\Notification
	 */
	public static function prepareAdminApprovalMessage($hook, $type, $return_value, $params) {
		
		if (!($return_value instanceof \Elgg\Notifications\Notification)) {
			return;
		}
		
		$actor = $return_value->getSender();
		$recipient = $return_value->getRecipient();
		
		$language = elgg_extract('language', $params);
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
		
		$group = $event->getObject();
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		$return_value->subject = elgg_echo('group_tools:group:admin_approve:admin:subject', [$group->name], $language);
		$return_value->summary = elgg_echo('group_tools:group:admin_approve:admin:summary', [$group->name], $language);
		$return_value->body = elgg_echo('group_tools:group:admin_approve:admin:message', [
			$recipient->name,
			$actor->name,
			$group->name,
			$group->getURL(),
			elgg_normalize_url('admin/groups/admin_approval'),
		], $language);
		
		return $return_value;
	}
}
