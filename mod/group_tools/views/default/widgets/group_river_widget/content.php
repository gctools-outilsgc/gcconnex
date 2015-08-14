<?php
/**
 * content for the group river/activity widget
 */

$widget = $vars["entity"];

// which group
if ($widget->context == "groups") {
	$group_guid = array($widget->getOwnerGUID());
} else {
	$group_guid = $widget->group_guid;
	if (!empty($group_guid)) {
		if (!is_array($group_guid)) {
			$group_guid = array($group_guid);
		}
	}
}

if (!empty($group_guid)) {
	$group_guid = array_map("sanitise_int", $group_guid);
	$key = array_search(0, $group_guid);
	if ($key !== false) {
		unset($group_guid[$key]);
	}
}

if (!empty($group_guid)) {
	// get activity filter
	$activity_filter = $widget->activity_filter;
	
	//get the number of items to display
	$dbprefix = elgg_get_config("dbprefix");
	$offset = 0;
	$limit = (int) $widget->num_display;
	if ($limit < 1) {
		$limit = 10;
	}
	
	$sql = "SELECT {$dbprefix}river.*";
	$sql .= " FROM {$dbprefix}river";
	$sql .= " INNER JOIN {$dbprefix}entities AS entities1 ON {$dbprefix}river.object_guid = entities1.guid";
	$sql .= " WHERE (entities1.container_guid in (" . implode(",", $group_guid) . ")";
	$sql .= " OR {$dbprefix}river.object_guid IN (" . implode(",", $group_guid) . "))";
	
	if (!empty($activity_filter) && is_string($activity_filter)) {
		list($type, $subtype) = explode(",", $activity_filter);
		
		if (!empty($type)) {
			$filter_where = " ({$dbprefix}river.type = '" . sanitise_string($type) . "'";
			
			if (!empty($subtype)) {
				$filter_where .= " AND {$dbprefix}river.subtype = '" . sanitise_string($subtype) . "'";
			}
			
			$filter_where .= ")";
			$sql .= " AND " . $filter_where;
		}
	}
	
	$sql .= " AND " . get_access_sql_suffix("entities1");
	$sql .= " ORDER BY {$dbprefix}river.posted DESC";
	$sql .= " LIMIT {$offset},{$limit}";

	$items = get_data($sql, "elgg_row_to_elgg_river_item");

	// cyu - tasks are not of a river item
	if (sanitise_string($subtype) === 'task') {
		elgg_push_context('widgets');
		$options = array(
			'type' => 'object',
			'subtype' => 'task',
			'container_guid' => elgg_get_page_owner_guid(),
			'limit' => $limit,
			'full_view' => false,
			'pagination' => false,
		);
		$content = elgg_list_entities($options);
		elgg_pop_context();

		if (!$content) {
			$content = '<p>'.elgg_echo('widgets:group_river_widget:view:noactivity').'</p>';
		}

		echo elgg_view('groups/profile/module', array(
			'content' => $content,
			'all_link' => $all_link,
		));
	} else if (sanitise_string($subtype) === 'task_top') {
		elgg_push_context('widgets');
		$options = array(
			'type' => 'object',
			'subtype' => 'task_top',
			'container_guid' => elgg_get_page_owner_guid(),
			'limit' => $limit,
			'full_view' => false,
			'pagination' => false,
		);
		$content = elgg_list_entities($options);
		elgg_pop_context();

		if (!$content) {
			$content = '<p>'.elgg_echo('widgets:group_river_widget:view:noactivity').'</p>';
		}

		echo elgg_view('groups/profile/module', array(
			'content' => $content,
			'all_link' => $all_link,
		));
	} else {

		if (!empty($items)) {

			$options = array(
				"pagination" => false,
				"count" => count($items),
				"items" => $items,
				"list_class" => "elgg-list-river elgg-river",
				"limit" => $limit,
				"offset" => $offset
			);
			
			$river_items = elgg_view("page/components/list", $options);
		} else {
			$river_items = elgg_echo("widgets:group_river_widget:view:noactivity");
		}
			// display
			echo $river_items;
	}
} else 
		{
			echo elgg_echo("widgets:group_river_widget:view:not_configured");
		}
		