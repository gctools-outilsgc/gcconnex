<?php

namespace ColdTrick\Questions;

class ContentSubscriptions {
	
	/**
	 * Add questions to Content Subscriptions supported types
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function getEntityTypes($hook, $type, $return_value, $params) {
		
		if (!is_array($return_value)) {
			// someone blocked all
			return;
		}
		
		$return_value['object'][] = \ElggQuestion::SUBTYPE;
		
		return $return_value;
	}
	
	/**
	 * Subscribe to a question when you create an answer
	 *
	 * @param string      $event
	 * @param string      $type
	 * @param \ElggObject $object
	 *
	 * @return void
	 */
	public static function createAnswer($event, $type, \ElggObject $object) {
		
		if (!elgg_is_active_plugin('content_subscriptions')) {
			return;
		}
		
		if (!($object instanceof \ElggAnswer)) {
			return;
		}
		
		$owner = $object->getOwnerEntity();
		$question = $object->getContainerEntity();
		
		if (!content_subscriptions_can_subscribe($question, $owner->getGUID())) {
			return;
		}
		
		// subscribe to the question
		content_subscriptions_autosubscribe($question->getGUID(), $owner->getGUID());
	}
	
	/**
	 * Subscribe to a question when you create a comment on an answer
	 *
	 * @param string      $event
	 * @param string      $type
	 * @param \ElggObject $object
	 *
	 * @return void
	 */
	public static function createCommentOnAnswer($event, $type, \ElggObject $object) {
		
		if (!elgg_is_active_plugin('content_subscriptions')) {
			return;
		}
		
		if (!($object instanceof \ElggComment)) {
			return;
		}
		
		$answer = $object->getContainerEntity();
		if (!($answer instanceof \ElggAnswer)) {
			return;
		}
		
		$owner = $object->getOwnerEntity();
		$question = $answer->getContainerEntity();
		if (!content_subscriptions_can_subscribe($question, $owner->getGUID())) {
			return;
		}
		
		// subscribe to the question
		content_subscriptions_autosubscribe($question->getGUID(), $owner->getGUID());
	}
}
