<?php

namespace ColdTrick\BlogTools;

/**
 * Router handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class EntityMenu {
	
	/**
	 * Add some menu items to the entity menu
	 *
	 * @param string         $hook        'register'
	 * @param string         $entity_type 'menu:entity'
	 * @param ElggMenuItem[] $returnvalue the current menu items
	 * @param array          $params      supplied params
	 *
	 * @return void|ElggMenuItem[]
	 */
	public static function register($hook, $entity_type, $returnvalue, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggBlog)) {
			return;
		}
		
		// only published blogs
		if ($entity->status === 'draft') {
			return;
		}
		
		if (!elgg_in_context('widgets') && elgg_is_admin_logged_in()) {
			elgg_require_js('blog_tools/site');
			
			$returnvalue[] = \ElggMenuItem::factory([
				'name' => 'blog-feature',
				'text' => elgg_echo('blog_tools:toggle:feature'),
				'href' => "action/blog_tools/toggle_metadata?guid={$entity->getGUID()}&metadata=featured",
				'item_class' => empty($entity->featured) ? '' : 'hidden',
				'is_action' => true,
				'priority' => 175,
			]);
			$returnvalue[] = \ElggMenuItem::factory([
				'name' => 'blog-unfeature',
				'text' => elgg_echo('blog_tools:toggle:unfeature'),
				'href' => "action/blog_tools/toggle_metadata?guid={$entity->getGUID()}&metadata=featured",
				'item_class' => empty($entity->featured) ? 'hidden' : '',
				'is_action' => true,
				'priority' => 176,
			]);
		}
		
		if ($entity->canComment()) {
			$returnvalue[] = \ElggMenuItem::factory([
				'name' => 'comments',
				'text' => elgg_view_icon('speech-bubble'),
				'title' => elgg_echo('comment:this'),
				'href' => "{$entity->getURL()}#comments",
			]);
			
			$comment_count = $entity->countComments();
			if ($comment_count) {
				$returnvalue[] = \ElggMenuItem::factory([
					'name' => 'comments_count',
					'text' => $comment_count,
					'title' => elgg_echo('comments'),
					'href' => "{$entity->getURL()}#comments",
				]);
			}
		}
		
		return $returnvalue;
	}
}
