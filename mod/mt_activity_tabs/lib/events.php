<?php

namespace AU\ActivityTabs;

/**
 * Pagesetup
 * 
 * @return type
 */
function pagesetup() {
	if (!elgg_is_logged_in()) {
		return;
	}

	if (!elgg_in_context('activity') && !elgg_in_context('activity_tabs')) {
		return;
	}

	$dbprefix = elgg_get_config('dbprefix');
	$priority = 500;

	$user = elgg_get_logged_in_user_entity();
	$filter_context = get_input('filter_context', false);
    
	$plugin = elgg_get_plugin_from_id(PLUGIN_ID);
	if (!$plugin) {
		// dunno how this could be possible
		return true;
	}
	$all_settings = $plugin->getAllUserSettings($user->guid);

	$tabs = array(
		'group' => array(),
		'collection' => array(),
	);

	if (!empty($all_settings)) {
		foreach ($all_settings as $name => $value) {
			list($type, $id, $opt) = explode('_', $name);
			if ($type !== 'group' && $type !== 'collection') {
				continue;
			}
			if (!$opt) {
				$opt = 'enabled';
			}
			$tabs[$type][$id][$opt] = $value;
		}
	}

	$collection_ids = array();
	foreach ($tabs['collection'] as $id => $opts) {
		$enabled = elgg_extract('enabled', $opts);
		if ($enabled == 'yes') {
			$collection_ids[] = (int) $id;
		}
	}

	$group_ids = array();
	foreach ($tabs['group'] as $id => $opts) {
		$enabled = elgg_extract('enabled', $opts);
		if ($enabled == 'yes') {
			$group_ids[] = (int) $id;
		}
	}

	if (!empty($collection_ids)) {
		$collection_ids_in = implode(',', $collection_ids);
		$query = "SELECT * FROM {$dbprefix}access_collections
			WHERE owner_guid = {$user->guid} AND id IN ($collection_ids_in) AND name NOT LIKE 'Group:%'";
		$collections = get_data($query);
	}

	if (!empty($collections)) {

		// iterate through collections and add tabs as necessary
		foreach ($collections as $collection) {
			// we need to create a tab
			$tab = array(
				'name' => "collection:$collection->id",
				'text' => $collection->name,
				'href' => "activity_tabs/collection/{$collection->id}/" . elgg_get_friendly_title($collection->name),
				'selected' => $filter_context == 'collection_' . $collection->id,
				'priority' => $priority + (int) $tabs['collection']["$collection->id"]['priority'],
			);
			elgg_register_menu_item('filter', $tab);
		}
	}

	if (!empty($group_ids)) {
		$group_ids_in = implode(',', $group_ids);
		$query = "SELECT * FROM {$dbprefix}groups_entity ge
			JOIN {$dbprefix}entity_relationships er ON er.guid_two = ge.guid
			WHERE er.guid_one = {$user->guid} AND ge.guid IN ($group_ids_in)";
		$groups = get_data($query);
	}

	if (!empty($groups)) {
		foreach ($groups as $group) {
			$tab = array(
				'name' => "group:$group->guid",
				'text' => $group->name,
				'href' => "activity_tabs/group/{$group->guid}/" . elgg_get_friendly_title($group->name),
				'selected' => $filter_context == 'group_' . $group->guid,
				'priority' => $priority + (int) $tabs['group']["$group->guid"]['priority'],
			);
		}
		elgg_register_menu_item('filter', $tab);
	}

	$tab = array(
		'name' => "mydept:$user->department",
		'text' => elgg_echo('activity_tabs:mydepartment'),
		'href' => "activity_tabs/mydept/",
		'selected' => $filter_context == 'mydept_',
		'priority' => $priority + (int) $tabs['dept']["$user->department"]['priority'],
	);
	elgg_register_menu_item('filter', $tab);

	$tab = array(
		'name' => "otherdept:$user->department",
		'text' => elgg_echo('activity_tabs:otherdepartments'),
		'href' => "activity_tabs/otherdept/",
		'selected' => $filter_context == 'otherdept_',
		'priority' => $priority + (int) $tabs['otherdept']["$user->department"]['priority'],
	);
	elgg_register_menu_item('filter', $tab);

	// register menu item for configuring tabs
	$link = array(
		'name' => 'configure_activity_tabs',
		'text' => elgg_echo('activity_tabs:configure'),
		'href' => 'settings/plugins/' . $user->username,
	);

	elgg_register_menu_item('page', $link);
}

/**
 * Run-once upgrades
 * @return boolean
 */
function upgrades() {
	if (!elgg_is_admin_logged_in()) {
		return true;
	}

	require_once __DIR__ . '/upgrades.php';
	run_function_once(__NAMESPACE__ . '\\upgrade20151017');
}
