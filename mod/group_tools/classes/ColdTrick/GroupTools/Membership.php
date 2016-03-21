<?php

namespace ColdTrick\GroupTools;

class Membership {
	
	/**
	 * Listen to the delete of a membership request
	 *
	 * @param stirng            $event        the name of the event
	 * @param stirng            $type         the type of the event
	 * @param \ElggRelationship $relationship the relationship
	 *
	 * @return void
	 */
	public static function deleteRequest($event, $type, $relationship) {
		
		if (!($relationship instanceof \ElggRelationship)) {
			return;
		}
		
		if ($relationship->relationship !== 'membership_request') {
			// not a membership request
			return;
		}
		
		$action_pattern = '/action\/groups\/killrequest/i';
		if (!preg_match($action_pattern, current_page_url())) {
			// not in the action, so do nothing
			return;
		}
		
		$group = get_entity($relationship->guid_two);
		$user = get_user($relationship->guid_one);
		
		if (empty($user) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		$reason = get_input('reason');
		if (empty($reason)) {
			$body = elgg_echo('group_tools:notify:membership:declined:message', array(
				$user->name,
				$group->name,
				$group->getURL(),
			));
		} else {
			$body = elgg_echo('group_tools:notify:membership:declined:message:reason', array(
				$user->name,
				$group->name,
				$reason,
				$group->getURL(),
			));
		}
		
		$subject = elgg_echo('group_tools:notify:membership:declined:subject', array(
			$group->name,
		));
		
		$params = array(
			'object' => $group,
			'action' => 'delete',
		);
		notify_user($user->getGUID(), $group->getGUID(), $subject, $body, $params);
	}
}
