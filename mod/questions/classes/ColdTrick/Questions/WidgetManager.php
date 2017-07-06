<?php

namespace ColdTrick\Questions;

class WidgetManager {
	
	/**
	 * Return the widget title url
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function widgetURL($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			// already set
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggWidget)) {
			return;
		}
		
		if ($entity->handler !== 'questions') {
			return;
		}
		
		$owner = $entity->getOwnerEntity();
		
		if ($owner instanceof \ElggUser) {
			// user
			$return_value = "questions/owner/{$owner->username}";
			if ($entity->context === 'dashboard') {
				switch ($entity->content_type) {
					case 'all':
						$return_value = 'questions/all';
						break;
					case 'todo':
						if (questions_is_expert()) {
							$return_value = 'questions/todo';
						}
						break;
				}
			}
		} elseif ($owner instanceof \ElggGroup) {
			// group
			$return_value = "questions/group/{$owner->getGUID()}/all";
		} elseif ($owner instanceof \ElggSite) {
			// site
			$return_value = 'questions/all';
		}
		
		return $return_value;
	}
}
