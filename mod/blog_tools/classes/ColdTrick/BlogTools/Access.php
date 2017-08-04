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
	 * @return void|bool
	 */
	public static function blogCanComment($hook, $type, $returnvalue, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggBlog)) {
			return;
		}
		
		$returnvalue = false;
		if ($entity->comments_on !== 'Off' && $entity->status === 'published') {
			$returnvalue = true;
		}
		
		return $returnvalue;
	}
}
