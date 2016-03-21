<?php

// Custom order by clauses
elgg_register_plugin_hook_handler('order_by_clause', 'framework:lists', 'hj_forum_order_by_clauses');

// Custom search clause
elgg_register_plugin_hook_handler('custom_sql_clause', 'framework:lists', 'hj_forum_filter_forum_list');

// Allow users to use forums as container entities
elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'hj_forum_container_permissions_check');

// Override commenting on forums
elgg_register_plugin_hook_handler('permissions_check:comment', 'object', 'hj_forum_disable_comments');

/**
 * Custom clauses for forum ordering
 */
function hj_forum_order_by_clauses($hook, $type, $options, $params) {

	$order_by = $params['order_by'];
	$direction = $params['direction'];

	list($prefix, $column) = explode('.', $order_by);

	if (!$prefix || !$column) {
		return $options;
	}

	if ($prefix !== 'forum') {
		return $options;
	}

	$prefix = sanitize_string($prefix);
	$column = sanitize_string($column);
	$direction = sanitize_string($direction);

	$dbprefix = elgg_get_config('dbprefix');

	$order_by_prev = elgg_extract('order_by', $options, false);

	switch ($column) {

		case 'topics' :
			$options = hj_framework_get_order_by_descendant_count_clauses(array('hjforum', 'hjforumtopic'), $direction, $options);

			break;

		case 'posts' :
			$options = hj_framework_get_order_by_descendant_count_clauses(array('hjforumpost'), $direction, $options);
			break;

		case 'author' :
			$options['joins'][] = "JOIN {$dbprefix}users_entity ue ON ue.guid = e.owner_guid";
			$options['order_by'] = "ue.name $direction";
			break;

		case 'sticky' :
			$subtype_ids = implode(',', array(
				get_subtype_id('object', 'hjforum'),
				get_subtype_id('object', 'hjforumtopic')
					));
			$options['selects'][] = "SUM(stickymsv.string) stickyval";
			$options['joins'][] = "JOIN {$dbprefix}metadata stickymd ON e.guid = stickymd.entity_guid";
			$options['joins'][] = "JOIN {$dbprefix}metastrings stickymsn ON (stickymsn.string = 'sticky')";
			$options['joins'][] = "LEFT JOIN {$dbprefix}metastrings stickymsv ON (stickymd.name_id = stickymsn.id AND stickymd.value_id = stickymsv.id)";
			$options['group_by'] = 'e.guid';
			$options['order_by'] = "FIELD(e.subtype, $subtype_ids), ISNULL(SUM(stickymsv.string)), SUM(stickymsv.string) = 0, SUM(stickymsv.string) $direction, e.time_created DESC";
			break;
	}

	if ($order_by_prev) {
		$options['order_by'] = "$order_by_prev, {$options['order_by']}";
	}

	return $options;
}

/**
 * Custom clauses for forum keyword search
 */
function hj_forum_filter_forum_list($hook, $type, $options, $params) {

	if (!is_array($options['subtypes'])) {
		if (isset($options['subtype'])) {
			$options['subtypes'] = array($options['subtype']);
			unset($options['subtype']);
		} elseif (isset($options['subtypes'])) {
			$options['subtypes'] = array($options['subtypes']);
		} else {
			return $options;
		}
	}

	if (!in_array('hjforum', $options['subtypes'])
			&& !in_array('hjforumtopic', $options['subtypes'])) {
		return $options;
	}

	$query = get_input("__q", false);

	if (!$query || empty($query)) {
		return $options;
	}

	$query = sanitise_string(urldecode($query));

	$dbprefix = elgg_get_config('dbprefix');
	$options['joins'][] = "JOIN {$dbprefix}objects_entity oe_q ON e.guid = oe_q.guid";
	$options['wheres'][] = "MATCH(oe_q.title, oe_q.description) AGAINST ('$query')";

	return $options;
}

/**
 * Bypass default permission to allow users to add posts and topics to forums
 */
function hj_forum_container_permissions_check($hook, $type, $return, $params) {

	$container = elgg_extract('container', $params, false);
	$user = elgg_extract('user', $params, false);
	$subtype = elgg_extract('subtype', $params, false);

	if (!$container || !$user || !$subtype)
		return $return;

	switch ($container->getSubtype()) {

		default :
			return $return;
			break;

		case 'hjforum' :

			switch ($subtype) {

				default :
					return $return;
					break;

				case 'hjforum' : // Adding sub-forum
					return $return;
					break;

				case 'hjforumtopic' : // Adding new topics
					return ($container->isOpenFor($subtype));
					break;
			}
			break;

		case 'hjforumtopic' :
			switch ($subtype) {

				default :
					return $return;
					break;

				case 'hjforumpost' :
					return ($container->isOpenFor($subtype));
					break;
			}
			break;
	}
}

function hj_forum_disable_comments($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	switch($entity->getSubtype()) {
		case 'hjforum' :
		case 'hjforumtopic' :
		case 'hjforumcategory' :
		case 'hjforumpost' :
			return false;
			break;

		default :
			return $return;
			break;
	}
}