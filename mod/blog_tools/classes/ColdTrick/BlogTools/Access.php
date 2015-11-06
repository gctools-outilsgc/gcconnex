<?php

namespace ColdTrick\BlogTools;

class Access {
	
	/**
	 * Correct version of blog can comment
	 *
	 * @param string $hook        the name of the hook
	 * @param string $type        the type of the hook
	 * @param bool   $returnvalue current return value
	 * @param array  $params      supplied params
	 *
	 * @return bool
	 */
	public static function blogCanComment($hook, $type, $returnvalue, $params) {
		
		if (empty($params) || !is_array($params)) {
			return $returnvalue;
		}
		
		$entity = elgg_extract('entity', $params);
		if (empty($entity) || !elgg_instanceof($entity, 'object', 'blog')) {
			return $returnvalue;
		}
		
		$returnvalue = false;
		if ($entity->comments_on != 'Off' && $entity->status == 'published') {
			$returnvalue = true;
		}
		
		return $returnvalue;
	}
}
