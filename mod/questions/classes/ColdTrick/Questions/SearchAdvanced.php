<?php

namespace ColdTrick\Questions;

class SearchAdvanced {
	
	/**
	 * Change search params for combined search
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|mixed
	 */
	public static function combinedParams($hook, $type, $return_value, $params) {
		
		$combined_search_type = elgg_extract('combined', $params);
		if (empty($combined_search_type)) {
			return;
		}
		
		switch ($combined_search_type) {
			case 'objects':
				$subtypes = elgg_extract('subtype', $return_value);
				if (empty($subtypes)) {
					return;
				}
				
				if (in_array(\ElggQuestion::SUBTYPE, $subtypes)) {
					// add answers
					$subtypes[] = \ElggAnswer::SUBTYPE;
				}
				
				$return_value['subtype'] = $subtypes;
				break;
			case 'all':
				$type_subtype_pairs = elgg_extract('type_subtype_pairs', $return_value);
				if (empty($type_subtype_pairs) || empty($type_subtype_pairs['object'])) {
					return;
				}
				
				if (in_array(\ElggQuestion::SUBTYPE, $type_subtype_pairs['object'])) {
					// add answers
					$type_subtype_pairs['object'][] = \ElggAnswer::SUBTYPE;
				}
				
				$return_value['type_subtype_pairs'] = $type_subtype_pairs;
				
				break;
			default:
				return;
		}
		
		return $return_value;
	}
}
