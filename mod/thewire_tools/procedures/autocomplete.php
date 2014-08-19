<?php
/**
 * jQuery autocomplete procedure
 *
 */

if (elgg_is_logged_in()) {
	$q = get_input("q");
	$limit = (int) get_input("limit", 50);
	$page_owner_guid = (int) get_input("page_owner_guid");
	
	$result = array();
	
	if (!empty($q)) {
		if (substr($q, 0, 1) == "@") {
			$username = substr($q, 1);
			
			$options = array(
				"type" => "user",
				"limit" => $limit,
				"joins" => array("JOIN " . elgg_get_config("dbprefix") . "users_entity ue ON e.guid = ue.guid"),
				"wheres" => array("(ue.username LIKE '%" . sanitise_string($username) . "%' OR ue.name LIKE '%" . sanitise_string($username) . "%')"),
				"site_guids" => false,
				"order_by" => "ue.name ASC"
			);
			
			$group = get_entity($page_owner_guid);
			if (!empty($group) && ($group instanceof ElggGroup)) {
				$options["relationship"] = "member";
				$options["relationship_guid"] = $group->getGUID();
				$options["inverse_relationship"] = true;
			} else {
				$options["joins"][] = "JOIN " . elgg_get_config("dbprefix") . "entity_relationships r1 ON r1.guid_one = e.guid";
				$options["joins"][] = "JOIN " . elgg_get_config("dbprefix") . "entity_relationships r2 ON r2.guid_two = e.guid";
				$options["joins"][] = "JOIN " . elgg_get_config("dbprefix") . "entity_relationships r3 ON r3.guid_one = e.guid";
				
				$options["wheres"][] = "(
					((r1.relationship = 'friend' AND r1.guid_two = " . elgg_get_logged_in_user_guid() . ")
					OR
					(r2.relationship = 'friend' AND r2.guid_one = " . elgg_get_logged_in_user_guid() . "))
					AND
					(r3.relationship = 'member_of_site' AND r3.guid_two = " . elgg_get_site_entity()->getGUID() . ")
				)";
			}
			
			$users = elgg_get_entities_from_relationship($options);
			if (!empty($users)) {
				foreach ($users as $user) {
					$result[] = array(
						"type" => "user",
						"username" => $user->username,
						"name" => $user->name,
						"icon" => $user->getIconURL("tiny")
					);
				}
			}
		} elseif (substr($q, 0, 1) == "#") {
			$tag = substr($q, 1);
			
			$tags_id = get_metastring_id("tags");
			$thewire_id = get_subtype_id("object", "thewire");
			
			$query = "SELECT DISTINCT *";
			$query .= " FROM (SELECT ms1.string as value";
			$query .= " FROM " . elgg_get_config("dbprefix") . "entities e";
			$query .= " JOIN " . elgg_get_config("dbprefix") . "metadata m ON e.guid = m.entity_guid";
			$query .= " JOIN " . elgg_get_config("dbprefix") . "metastrings ms1 ON m.value_id = ms1.id";
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
				$metadata = array();
				
				foreach ($rows as $row) {
					if (!empty($row->value) || ($row->value == 0)) {
						$metadata[] = $row->value;
					}
				}
				
				natcasesort($metadata);
				foreach ($metadata as $md) {
					$result[] = array("type" => "hashtag", "value" => $md);
				}
			}
		}
	}
	
	header("Content-Type: application/json");
	echo json_encode(array_values($result));
	exit();
}
