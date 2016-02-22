<?php 
	$q = sanitize_string(get_input("q"));
	$current_groups = sanitize_string(get_input("groups_guids"));
	$limit = (int) get_input("limit", 50);
	$result = array();
	$user = elgg_get_logged_in_user_entity();
	
	if(!empty($q)){
		$db_prefix = elgg_get_config('dbprefix');
		$params['type'] = 'group';
		$params['limit'] = $limit;
		if (strlen($q) <=3) {
			$params['query'] = $q;
		} else {
			$params['query'] = '*'.$q.'*';
		}
		$join = "JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid";
		$params['joins'] = array($join);
		$fields = array('name', 'description');
		$where = search_get_where_sql('ge', $fields, $params,FALSE);
		$params['wheres'] = array($where);
		// override subtype -- All groups should be returned regardless of subtype.
		$params['subtype'] = ELGG_ENTITIES_ANY_VALUE;
		//$params['count'] = TRUE;
		$groups = elgg_get_entities($params);
		foreach($groups as $group){
			//if (! $group->isMember($user)) {
				if (! $group->isPublicMembership()) {
					$result[] = array("type" => "group", "value" => $group->getGUID(),"label" => $group->name,"content" => "<a class=' text-unstyled ' href='".$group->getURL()."'><img class='mrgn-rght-sm' src='" . $group->getIconURL("small") . "' /><span>" . $group->name . "</span></a>", "name" => $group->name);
				} else {
					$result[] = array("type" => "group", "value" => $group->getGUID(),"label" => $group->name,"content" => "<a class=' text-unstyled ' href='".$group->getURL()."'><img class='mrgn-rght-sm' src='" . $group->getIconURL("small") . "' /><span>" . $group->name."</span></a>", "name" => $group->name);
				}
			//}
		}
	}
	header("Content-Type: application/json");
	echo json_encode(array_values($result));
	exit();
