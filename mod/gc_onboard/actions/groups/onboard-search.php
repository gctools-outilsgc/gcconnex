<?php
/*
* onboard-search.php
* action file that searches for groups by ajax call
*/
$db_prefix = elgg_get_config("dbprefix");
$query = sanitise_string(get_input("tag"));

$title = elgg_echo("groups:search:title", array($query));
$content = false;

//dont search if the user has not entered anything
if($query == 'search' || $query == 'chercher'){
    $query = '';
}

if (!empty($query)) {
	$params = array(
		"type" => "group",
		"full_view" => FALSE,
        'order_by' => 'time_created asc',
	);

	// search all profile fields
	$profile_fields = array_keys(elgg_get_config("group"));
	if (!empty($profile_fields)) {
		$params["joins"] = array(
			"JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid",
			"JOIN {$db_prefix}metadata md on e.guid = md.entity_guid",
			"JOIN {$db_prefix}metastrings msv ON md.value_id = msv.id"
		);
	} else {
		$params["joins"] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
	}

	$where = "ge.name LIKE '%$query%' OR ge.description LIKE '%$query%'";

	if (!empty($profile_fields)) {

		$tag_name_ids = array();
		foreach ($profile_fields as $field) {
			$tag_name_ids[] = elgg_get_metastring_id($field);
		}

		$md_where = "((md.name_id IN (" . implode(",", $tag_name_ids) . ")) AND (msv.string LIKE '%$query%'))";
		$params["wheres"] = array("(($where) OR ($md_where))");
	} else {
		$params["wheres"] = array($where);
	}

	$groups = elgg_get_entities($params);

    if(!empty($groups)){
        $count = 0;
        foreach($groups as $group){

            if($count<6){
                $join_url = "action/groups/join?group_guid={$group->getGUID()}";

                if ($group->isPublicMembership() || $group->canEdit()) {
                    $join_text = elgg_echo("groups:join");
                    $disabled = '';
                } else {
                    // request membership
                    $join_text = elgg_echo("groups:joinrequest");
                    $disabled = 'disabled="true"';
                }

                $content .= '<div class="col-xs-12">';
                $content .=  elgg_view('group/default', array('entity' => $group));
                //echo "<div class='text-center'>" . elgg_view("output/url", array("text" => $join_text, "href" => $join_url, "is_action" => true, "class" => "elgg-button elgg-button-action btn btn-primary mrgn-bttm-sm")) . "</div>";
                $content .=  '<div class="text-center"><a id="search-'.$group->guid.'" '.$disabled.' class="btn btn-primary mrgn-bttm-sm" href="#search" onclick="joinGroup(\'search\', '.$group->guid.')">'.$join_text.'</a></div>';
                $content .=  '</div>';

                $count = $count+1;
            }
        }
    }

    if (empty($content)) {
        $content = elgg_echo("groups:search:none");
    }

    //return groups
    echo json_encode([
                      'groups' => $content,
]);
}
