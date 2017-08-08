<?php
/**
 * jQuery autocomplete procedure
 *
 */
gatekeeper();

$q = get_input('q');
$limit = (int) get_input('limit', 50);
$page_owner_guid = (int) get_input('page_owner_guid');

$site = elgg_get_site_entity();
$result = [];

header('Content-Type: application/json');

if (empty($q)) {
	echo json_encode(array_values($result));
	return;
}

$dbprefix = elgg_get_config('dbprefix');

if (substr($q, 0, 1) == '@') {
	$username = substr($q, 1);
	
	$options = [
		'type' => 'user',
		'limit' => $limit,
		'joins' => ["JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid"],
		'wheres' => ["(ue.username LIKE '%" . sanitise_string($username) . "%' OR ue.name LIKE '%" . sanitise_string($username) . "%')"],
		'site_guids' => false,
		'order_by' => 'ue.name ASC',
		'inverse_relationship' => true,
	];
	
	$group = get_entity($page_owner_guid);
	if (elgg_instanceof($group, 'group')) {
		$options['relationship'] = 'member';
		$options['relationship_guid'] = $group->getGUID();
	} else {
		$options['relationship'] = 'member_of_site';
		$options['relationship_guid'] = $site->getGUID();
	}
	
	$users = elgg_get_entities_from_relationship($options);
	if (!empty($users)) {
		foreach ($users as $user) {
			$result[] = [
				'type' => 'user',
				'username' => $user->username,
				'name' => $user->name,
				'icon' => $user->getIconURL('tiny'),
			];
		}
	}
} elseif (substr($q, 0, 1) == '#') {
	$tag = substr($q, 1);
	
	$tags_id = elgg_get_metastring_id('tags');
	$thewire_id = get_subtype_id('object', 'thewire');
	
	$query = "SELECT DISTINCT *";
	$query .= " FROM (SELECT ms1.string as value";
	$query .= " FROM {$dbprefix}entities e";
	$query .= " JOIN {$dbprefix}metadata m ON e.guid = m.entity_guid";
	$query .= " JOIN {$dbprefix}metastrings ms1 ON m.value_id = ms1.id";
	$query .= " WHERE (e.type = 'object' AND e.subtype = " . $thewire_id . ")";
	$query .= " AND (e.owner_guid = " . elgg_get_logged_in_user_guid() . ")";
	$query .= " AND (m.name_id = " . $tags_id . ")";
	$query .= " AND (ms1.string LIKE '%" . sanitise_string($tag) . "%')";
	$query .= " AND " . get_access_sql_suffix("e");
	$query .= " AND " . get_access_sql_suffix("m");
	$query .= " ORDER BY m.time_created DESC) a";
	$query .= " LIMIT 0, " . $limit;
	
	$rows = get_data($query);
	if (!empty($rows)) {
		$metadata = [];
		
		foreach ($rows as $row) {
			if (!empty($row->value) || ($row->value == 0)) {
				$metadata[] = $row->value;
			}
		}
		
		natcasesort($metadata);
		foreach ($metadata as $md) {
			$result[] = ['type' => 'hashtag', 'value' => $md];
		}
	}
}
	
echo json_encode(array_values($result));
exit();
