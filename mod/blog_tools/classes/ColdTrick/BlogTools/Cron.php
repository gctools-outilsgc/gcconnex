<?php

namespace ColdTrick\BlogTools;

/**
 * Cron handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class Cron {
	
	/**
	 * Publish blogs based on advanced publication options
	 *
	 * @param string $hook         'cron'
	 * @param string $type         'daily'
	 * @param string $return_value optional stdout text
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function daily($hook, $type, $return_value, $params) {
		
		// only do if this is configured
		if (!blog_tools_use_advanced_publication_options()) {
			return;
		}
		
		$time = (int) elgg_extract('time', $params, time());
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		self::publishBlogs($time);
		self::unpublishBlogs();
		
		// reset access
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Publish blogs based on advanced publication settings
	 *
	 * @param int $time the timestamp the entity was published
	 *
	 * @return void
	 */
	protected static function publishBlogs($time) {
		
		$dbprefix = elgg_get_config('dbprefix');
		$publication_id = elgg_get_metastring_id('publication_date');
		
		$publish_options = [
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => false,
			'joins' => [
				"JOIN {$dbprefix}metadata mdtime ON e.guid = mdtime.entity_guid",
				"JOIN {$dbprefix}metastrings mstime ON mdtime.value_id = mstime.id",
			],
			'metadata_name_value_pairs' => [
				[
					'name' => 'status',
					'value' => 'draft',
				],
			],
			'wheres' => [
				"((mdtime.name_id = {$publication_id}) AND (DATE(mstime.string) = DATE(NOW())))",
			],
		];
		
		// get unpublished blogs that need to be published
		$entities = new \ElggBatch('elgg_get_entities_from_metadata', $publish_options);
		foreach ($entities as $entity) {
			// add river item
			elgg_create_river_item([
				'view' => 'river/object/blog/create',
				'action_type' => 'create',
				'subject_guid' => $entity->getOwnerGUID(),
				'object_guid' => $entity->getGUID(),
			]);
				
			// set correct time created
			$entity->time_created = $time;
				
			// publish blog
			$entity->status = 'published';
				
			// revert access
			$entity->access_id = $entity->future_access;
			unset($entity->future_access);
				
			// send notifications when post published
			elgg_trigger_event('publish', 'object', $entity);
				
			// notify owner
			notify_user($entity->getOwnerGUID(),
				$entity->site_guid,
				elgg_echo('blog_tools:notify:publish:subject'),
				elgg_echo('blog_tools:notify:publish:message', [
					$entity->title,
					$entity->getURL(),
				])
			);
				
			// save everything
			$entity->save();
		}
	}
	
	/**
	 * Unpublish blogs based on advanced publication settings
	 *
	 * @return void
	 */
	protected static function unpublishBlogs() {
		
		$dbprefix = elgg_get_config('dbprefix');
		$expiration_id = elgg_get_metastring_id('expiration_date');
		
		$unpublish_options = [
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => false,
			'joins' => [
				"JOIN {$dbprefix}metadata mdtime ON e.guid = mdtime.entity_guid",
				"JOIN {$dbprefix}metastrings mstime ON mdtime.value_id = mstime.id",
			],
			'metadata_name_values_pairs' => [
				[
					'name' => 'status',
					'value' => 'published',
				],
			],
			'wheres' => [
				"((mdtime.name_id = {$expiration_id}) AND (DATE(mstime.string) = DATE(NOW())))",
			],
		];
		
		// get published blogs that need to be unpublished
		$entities = new \ElggBatch('elgg_get_entities_from_metadata', $unpublish_options);
		foreach ($entities as $entity) {
			// remove river item
			elgg_delete_river([
				'object_guid' => $entity->getGUID(),
				'action_type' => 'create',
			]);
			
			// unpublish blog
			$entity->status = 'draft';
			
			// notify owner
			notify_user($entity->getOwnerGUID(),
				$entity->site_guid,
				elgg_echo('blog_tools:notify:expire:subject'),
				elgg_echo('blog_tools:notify:expire:message', [
					$entity->title,
					$entity->getURL(),
				])
			);
			
			// save everything
			$entity->save();
		}
	}
}
