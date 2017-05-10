<?php

namespace ColdTrick\Questions;

class Elasticsearch {
	
	/**
	 * Add answers to the exported types for Elasticsearch
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function indexTypes($hook, $type, $return_value, $params) {
		
		$objects = elgg_extract('object', $return_value);
		if (empty($objects)) {
			return;
		}
		
		if (!in_array(\ElggQuestion::SUBTYPE, $objects)) {
			return;
		}
		
		$objects[] = \ElggAnswer::SUBTYPE;
		$return_value['object'] = $objects;
		
		return $return_value;
	}
}
