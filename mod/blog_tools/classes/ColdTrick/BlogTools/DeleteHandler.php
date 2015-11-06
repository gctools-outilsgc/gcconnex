<?php

namespace ColdTrick\BlogTools;

/**
 * Listen to delete events
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class DeleteHandler {
	
	/**
	 * When a blog is removed also remove it's icons
	 *
	 * @param string     $event  'delete'
	 * @param string     $type   'object'
	 * @param ElggObject $object The ElggObject being removed
	 *
	 * @return void
	 */
	public static function cleanupBlogIcon($event, $type, $object) {
		
		if (!elgg_instanceof($object, "object", "blog", "ElggBlog")) {
			return;
		}
			
		blog_tools_remove_blog_icon($object);
	}
}