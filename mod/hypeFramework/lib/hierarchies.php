<?php

/**
 * Retrieve ancestry relationships / update if they have changed
 *
 * @param int $guid
 * @param mixed $subtypes
 * @return boolean|array
 */
function hj_framework_set_ancestry($guid) {

	$entity = get_entity($guid);

	if (!$entity) {
		return false;
	}

	$ia = elgg_set_ignore_access(true);

	// Build an hierarchy from [0]highest to [X]lowest
	$ancestry = array();
	$ancestry_guids = array();
	$container = $entity->getContainerEntity();
	while (elgg_instanceof($container)) {
		array_unshift($ancestry, $container);
		array_unshift($ancestry_guids, $container->guid);
		$container = $container->getContainerEntity();
	}

	// Store as a hash so we don't unnecessarily update the hierarchy every time save() is calleed
	if (!isset($entity->hierarchy_hash) || $entity->hierarchy_hash != sha1(serialize($ancestry_guids))) {

		remove_entity_relationships($entity->guid, 'descendant', false);

		foreach ($ancestry as $ancestor) {
			if (elgg_instanceof($ancestor, 'object')) {
				update_entity_last_action($ancestor->guid, $entity->time_created);
			}
			if (!check_entity_relationship($entity->guid, 'descendant', $ancestor->guid))
				add_entity_relationship($entity->guid, 'descendant', $ancestor->guid);
		}

		$entity->hierarchy_hash = sha1(serialize($ancestry_guids));
	}

	elgg_set_ignore_access($ia);

	return $ancestry;
}

/**
 * Get object's ancestors
 *
 * @param int $guid
 *
 */
function hj_framework_get_ancestry($guid) {

	$entity = get_entity($guid);

	if (!$entity) {
		return false;
	}

	// Build an hierarchy from [0]highest to [X]lowest
	$ancestry = array();
	$container = $entity->getContainerEntity();
	while (elgg_instanceof($container)) {
		array_unshift($ancestry, $container);
		$container = $container->getContainerEntity();
	}

	return $ancestry;
}

/**
 * Add sql clauses to order entities by descendants count
 *
 * @param array $subtypes	Array of descendant subtypes
 * @param str $direction	Order by direction
 * @param array $options	Original options array
 */
function hj_framework_get_order_by_descendant_count_clauses($subtypes, $direction, $options) {

	foreach ($subtypes as $st) {
		if ($id = get_subtype_id('object', $st)) {
			$subtype_ids[] = $id;
		}
	}

	$subtype_ids_str = implode(',', $subtype_ids);

	if (empty($subtype_ids_str))
		return $options;

	$dbprefix = elgg_get_config('dbprefix');

	$options['selects'][] = "COUNT(r_descendant.guid_one)";

	$options['joins'][] = "JOIN {$dbprefix}entities e_descendant ON (e_descendant.subtype IN ($subtype_ids_str))";
	$options['joins'][] = "LEFT JOIN {$dbprefix}entity_relationships r_descendant ON (e.guid = r_descendant.guid_two AND r_descendant.relationship = 'descendant' AND r_descendant.guid_one = e_descendant.guid)";

	$options['wheres'][] = get_access_sql_suffix('e_descendant');

	$options['group_by'] = 'e.guid';
	$options['order_by'] = "count(r_descendant.guid_one) $direction, e.time_created DESC";

	return $options;
}

function hj_framework_get_descendant_offset($descendant_guid, $options) {

	$dbprefix = elgg_get_config('dbprefix');

	$options['count'] = true;

	if ($options['order_by'] == 'e.time_created ASC') {
		$options['wheres'][] = "(e.guid < $descendant_guid)";
	} else if ($options['order_by'] == 'e.time_created DESC') {
		$options['wheres'][] = "(e.guid > $descendant_guid)";
	}

	return elgg_get_entities($options);
}