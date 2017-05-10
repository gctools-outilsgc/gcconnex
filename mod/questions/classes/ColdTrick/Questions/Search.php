<?php

namespace ColdTrick\Questions;

class Search {
	
	/**
	 * Handle search hook, to include answers in the same set as questions
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|mixed
	 */
	public static function handleQuestionsSearch($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		unset($params['subtype']);
		$params['subtypes'] = [
			\ElggAnswer::SUBTYPE,
			\ElggQuestion::SUBTYPE,
		];
		
		return elgg_trigger_plugin_hook('search', 'object', $params, $return_value);
	}
}
