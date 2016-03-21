<?php

/**
 * Check the current plugin release and load $plugin_id/lib/upgrade.php script if the release is newer
 *
 * @param str		$plugin_id		Plugin Name
 * @param str		$release		Release timestamp
 */
function hj_framework_check_release($plugin_id, $release) {

	if (!elgg_is_admin_logged_in()) {
		return false;
	}

	$old_release = elgg_get_plugin_setting('release', $plugin_id);

	if ($release > $old_release) {

		$shortcuts = hj_framework_path_shortcuts($plugin_id);
		$lib = "{$shortcuts['lib']}upgrade.php";

		elgg_register_library("hj:{$plugin_id}:upgrade", $lib);
		elgg_load_library("hj:{$plugin_id}:upgrade");

		elgg_set_plugin_setting('release', $release, $plugin_id);
	}

	return true;
}

/**
 * Get plugin tree shortcut urls
 *
 * @param string  $plugin     Plugin name string
 * @return array
 */
function hj_framework_path_shortcuts($plugin) {
	$path = elgg_get_plugins_path();
	$plugin_path = $path . $plugin . '/';

	return $structure = array(
		"actions" => "{$plugin_path}actions/",
		"classes" => "{$plugin_path}classes/",
		"graphics" => "{$plugin_path}graphics/",
		"languages" => "{$plugin_path}languages/",
		"lib" => "{$plugin_path}lib/",
		"pages" => "{$plugin_path}pages/",
		"vendors" => "{$plugin_path}vendors/"
	);
}

/**
 * Helper functions to manipulate entities
 *
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category Framework Entities Library
 */

/**
 * Set priority of an element in a list
 *
 * @see ElggEntity::$priority
 *
 * @param ElggEntity $entity
 * @return bool
 */
function hj_framework_set_entity_priority($entity, $priority = null) {

	if ($priority) {
		$entity->priority = $priority;
		return true;
	}

	$count = elgg_get_entities(array(
		'type' => $entity->getType(),
		'subtype' => $entity->getSubtype(),
		'owner_guid' => $entity->owner_guid,
		'container_guid' => $entity->container_guid,
		'count' => true
			));

	if (!$entity->priority)
		$entity->priority = $count + 1;

	return true;
}

/**
 * Get a list of entities sorted by priority
 *
 * @param string $type
 * @param string $subtype
 * @param int $owner_guid
 * @param int $container_guid
 * @param int $limit
 * @return array An array of ElggEntity
 */
function hj_framework_get_entities_by_priority($options = array()) {

	if (!is_array($options) || empty($options)) {
		return false;
	}
	
	$defaults = array(
		'order_by_metadata' => array(
			'name' => 'priority', 'value' => 'ASC'
		)
	);

	$options = array_merge($defaults, $options);

	return elgg_get_entities_from_relationship($options);
}

function hj_framework_get_entities_from_metadata_by_priority($type = 'object', $subtype = null, $owner_guid = NULL, $container_guid = null, $metadata_name_value_pairs = null, $limit = 0, $offset = 0, $count = false) {
	if (is_array($metadata_name_value_pairs)) {
		$db_prefix = elgg_get_config('dbprefix');
		$entities = elgg_get_entities_from_metadata(array(
			'type' => $type,
			'subtype' => $subtype,
			'owner_guid' => $owner_guid,
			'container_guid' => $container_guid,
			'metadata_name_value_pairs' => $metadata_name_value_pairs,
			'limit' => $limit,
			'offset' => $offset,
			'count' => $count,
			'joins' => array("JOIN {$db_prefix}metadata as mt on e.guid = mt.entity_guid
                      JOIN {$db_prefix}metastrings as msn on mt.name_id = msn.id
                      JOIN {$db_prefix}metastrings as msv on mt.value_id = msv.id"
			),
			'wheres' => array("((msn.string = 'priority'))"),
			'order_by' => "CAST(msv.string AS SIGNED) ASC"
				));
	} else {
		$entities = hj_framework_get_entities_by_priority(array(
			'type' => $type,
			'subtype' => $subtype,
			'owner_guid' => $owner_guid,
			'container_guid' => $container_guid,
			'limit' => $limit
				));
	}
	return $entities;
}

/**
 * Unset values from vars
 * @param array $vars
 * @return array
 */
function hj_framework_clean_vars($vars) {
	if (!is_array($vars)) {
		return $vars;
	}
	$vars = elgg_clean_vars($vars);
	$clean = array(
		'entity_guid',
		'subject_guid',
		'container_guid',
		'owner_guid',
		'form_guid',
		'widget_guid',
		'subtype',
		'context',
		'handler',
		'event',
		'form_name'
	);
	foreach ($clean as $key) {
		unset($vars[$key]);
	}
	return $vars;
}

/**
 * Replacement for Elgg'd native function which returns a malformatted url
 */
function hj_framework_http_remove_url_query_element($url, $element) {
	$url_array = parse_url($url);

	if (isset($url_array['query'])) {
		$query = elgg_parse_str($url_array['query']);
	} else {
		// nothing to remove. Return original URL.
		return $url;
	}

	if (array_key_exists($element, $query)) {
		unset($query[$element]);
	}

	$url_array['query'] = http_build_query($query);
	$string = elgg_http_build_url($url_array, false);
	return $string;
}