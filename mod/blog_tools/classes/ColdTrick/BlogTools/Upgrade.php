<?php

namespace ColdTrick\BlogTools;

class Upgrade {
	
	/**
	 * Register an upgrade class to move the blog icons
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied object/params
	 *
	 * @return void
	 */
	public static function moveBlogIcons($event, $type, $object) {
		
		$ia = elgg_set_ignore_access(true);
		
		$path = 'admin/upgrades/blog_tools_move_icons';
		
		$upgrade = new \ElggUpgrade();
		if (!$upgrade->getUpgradeFromPath($path)) {
			$upgrade->setPath($path);
			$upgrade->title = elgg_echo('admin:upgrades:blog_tools_move_icons');
			$upgrade->description = elgg_echo('admin:upgrades:blog_tools_move_icons:description');
			
			$upgrade->save();
			
			// check for blog with icons
			// eg. if non found, no upgrade needed
			$count = elgg_get_entities_from_metadata([
				'type' => 'object',
				'subtype' => 'blog',
				'metadata_name' => 'icontime',
				'count' => true,
			]);
			if (empty($count)) {
				$upgrade->setCompleted();
			}
		}
		
		// restore access
		elgg_set_ignore_access($ia);
	}
}
