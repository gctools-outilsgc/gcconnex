<?php

namespace AU\ActivityTabs;

$user = elgg_get_page_owner_entity();

// grab collections for this user
$collections = get_user_access_collections($user->guid);

// grab groups this user is a member of
// 0 = no limit
$dbprefix = elgg_get_config('dbprefix');
$groups = elgg_get_entities_from_relationship(array(
	'selects' => array(
		"ge.name as name"
	),
	'type' => 'group',
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'joins' => array(
		"JOIN {$dbprefix}groups_entity ge ON ge.guid = e.guid"
	),
	'callback' => false, // scalability, no need to get full entities
	'limit' => false
		));

if ($collections) {
	echo "<p>" . elgg_echo('activity_tabs:description') . "<p>";

	echo "<div class='admin_statistics'>";
	echo "<h3>" . elgg_echo('activity_tabs:collections') . "</h3>";
	echo "<table border='1' cellpadding='5px' class='activity_tabs_table'>";
	echo "<tr class='even'><td class='column_one'>" . elgg_echo('activity_tabs:name') . "</td>";
	echo "<td>" . elgg_echo('activity_tabs:enabled') . "</td>";
	echo "<td>" . elgg_echo('activity_tabs:priority') . "</td></tr>";

	$even = false;
	foreach ($collections as $collection) {
		$name = $collection->name;
		if (substr($name, 0, 7) == 'Group: ') {
			continue;
		}

		$id = $collection->id;
		$collectionid = "collection_" . $id;

		if ($even) {
			echo "<tr class='even'><td class='column_one'>$name</td>";
		} else {
			echo "<tr class='odd'><td class='column_one'>$name</td>";
		}
		echo "<td>";

		$value = elgg_get_plugin_user_setting($collectionid, $user->guid, 'mt_activity_tabs');
		$options = array(
			'name' => "params[{$collectionid}]",
			'value' => $value ? $value : 'no',
			'options_values' => array(
				'yes' => elgg_echo('option:yes'),
				'no' => elgg_echo('option:no')
			),
		);

		echo elgg_view('input/dropdown', $options);

		$value = elgg_get_plugin_user_setting($collectionid . '_priority', $user->guid, 'mt_activity_tabs');
		$options = array(
			'name' => "params[{$collectionid}_priority]",
			'value' => $value ? $value : 0,
			'options_values' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
		);

		echo "</td><td>" . elgg_view('input/dropdown', $options);

		echo "</td></tr>";


		// toggle even flag
		if ($even) {
			$even = false;
		} else {
			$even = true;
		}
	}


	echo "</table>";

	echo "<br><br>";
}

if ($groups) {
	echo "<h3>" . elgg_echo('activity_tabs:groups') . "</h3>";
	echo "<table border='1' cellpadding='5' class='activity_tabs_table'>";
	echo "<tr class='even'><td class='column_one'>" . elgg_echo('activity_tabs:name') . "</td>";
	echo "<td>" . elgg_echo('activity_tabs:enabled') . "</td>";
	echo "<td>" . elgg_echo('activity_tabs:priority') . "</td>";
	echo "<td>" . elgg_echo('activity_tabs:group:display') . "</td></tr>";

// even flag
	$even = false;
	foreach ($groups as $group) {
		$name = $group->name;

		$id = $group->guid;
		$groupid = "group_" . $id;

		if ($even) {
			echo "<tr class='even'><td class='column_one'>$name</td>";
		} else {
			echo "<tr class='odd'><td class='column_one'>$name</td>";
		}
		echo "<td>";

		$value = elgg_get_plugin_user_setting($groupid, elgg_get_logged_in_user_guid(), 'mt_activity_tabs');
		$options = array(
			'name' => "params[{$groupid}]",
			'value' => $value ? $value : 'no',
			'options_values' => array(
				'yes' => elgg_echo('option:yes'),
				'no' => elgg_echo('option:no')
			)
		);

		echo elgg_view('input/dropdown', $options);

		$value = elgg_get_plugin_user_setting($groupid . '_priority', $user->guid, 'mt_activity_tabs');
		$options = array(
			'name' => "params[{$groupid}_priority]",
			'value' => $value ? $value : 0,
			'options_values' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
		);

		echo "</td><td>" . elgg_view('input/dropdown', $options);

		// show activity only inside the group, or by all members of the group?
		// default to all members
		$value = elgg_get_plugin_user_setting($groupid . '_display', $user->guid, 'mt_activity_tabs');

		$options = array(
			'name' => "params[{$groupid}_display]",
			'value' => $value ? $value : 'global',
			'options_values' => array(
				'global' => elgg_echo('activity_tabs:option:group_display:global'),
				'group' => elgg_echo('activity_tabs:option:group_display:group')
			),
		);

		echo "</td><td>" . elgg_view('input/dropdown', $options);

		echo "</td></tr>";

		// toggle even flag
		if ($even) {
			$even = false;
		} else {
			$even = true;
		}
	}

	echo "</table>";
}

echo "</div>";
