<?php
/*
 * Author: National Research Council Canada
* Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
*
* License: Creative Commons Attribution 3.0 Unported License
* Copyright: Her Majesty the Queen in Right of Canada, 2015
*/

/*
 * Function to store the final organization dropdown input as MOrg:{input}.
 * Given an array of input 'name' => 'value' (usually from a sticky form).
 */
function mo_get_last_input_node($input_array) {
	$container = array();
	$count = 0;
	
	foreach($input_array as $key => $value) {
		if(strpos($key, 'org-drop') !== false && $value != 0 && $value != 1) {
			$container[$count] = $value;
			$count++;
		}
	}
	
	if(!empty($container)) {
		$return_string = 'MOrg:' . array_pop($container);
		if($return_string == 'MOrg:0') {
			$return_string = 'MOrg:' . array_pop($container);
		}
		
		if($input_array['other_node']) {
			$return_string .= ':' . $input_array['other_node'];
		}
		
		return $return_string;
	}
	else if(empty($container) && !empty($input_array['other_node'])) {
		return 'MOrg:0:' . $input_array['other_node'];
	}
	else {
		return false;
	}
}

/*
 * Function to format the dropdown menu input.
 * If the input is not an entity then it returns false.
 */
function mo_format_input_node($input) {
	if(elgg_entity_exists($input)) {
		return 'MOrg:' . $input;
	}
	else {
		return false;
	}
}

/*
 * Function which gets all the ancestors of a stored organization department.
 */
function mo_get_all_ancestors($node_string, $write_log = true) {
	$x = true;
	$count = 1;
	$returner = array();
	
	if($write_log) {
		$my_log = fopen("mod/missions_organization/get_ancestors_log.txt", "w");
	}
	
	if($node_string == '') {
		return array();
	}
	
	$node_guid = mo_extract_node_guid($node_string);
	
	$returner[0] = $node_guid;
	$current_id = $node_guid;
	while($x) {
		$parent_relation = mo_node_immediate_parent($current_id);
        /*$options['type'] = 'object';
        $options['subtype'] = 'orgnode';
		$options['relationship'] = 'org-related';
		$options['relationship_guid'] = $current_id;
		$options['inverse_relationship'] = true;
		$options['limit'] = 0;
		$parent_relation = elgg_get_entities_from_relationship($options);*/
		//$parent_relation = get_entity_relationships($current_id, true);
		
		if($count > 10) {
			return array();
		}
		
		if(!empty($parent_relation)) {
			$parent_guid = $parent_relation[0]->guid;
			$returner[$count] = $parent_guid;
			
			if($write_log) {
				$to_file = $count . ": " . get_entity($current_id)->name . " (" . $current_id . ") --- " . get_entity($parent_guid)->name . " (" . $parent_guid . ")\n";
				$fval = fwrite($my_log, $to_file);
			}
			
			$count++;
			$current_id = $parent_guid;
		}
		else {
			$x = false;
		}
	}
	
	if($write_log) {
		fclose($my_log);
	}
	
	array_pop($returner);
	return array_reverse($returner);
}

/*
 * Function which gets all the ancestors and then creates a string out of their names.
 */
function mo_string_all_ancestors($node_string) {
	$ancestor_guids = mo_get_all_ancestors($node_string);
	$ancestor_names_english = array();
	$ancestor_names_french = array();
	$count = 0;
	
	foreach($ancestor_guids as $guid) {
		$ancestor = get_entity($guid);
		$ancestor_names_english[$count] = $ancestor->name;
		$ancestor_names_french[$count] = $ancestor->name_french;
		$count++;
	}
	
	$other_input = mo_extract_other_input($node_string);
	if($other_input) {
		$other_input = ' / ' . $other_input;
	}

	$returner['english_path'] = implode(' / ', $ancestor_names_english) . $other_input;
	$returner['french_path'] = implode(' / ', $ancestor_names_french) . $other_input;
	
	return $returner;
}

/*
 * Extracts node guid from the stored data.
 */
function mo_extract_node_guid($node_string) {
	$node_array = explode(':', $node_string);
	return $node_array[1];
}

/*
 * Extracts the other input from the stored data.
 */
function mo_extract_other_input($node_string) {
	$node_array = explode(':', $node_string);
	return $node_array[2];
}

/*
 * 
 */
function mo_array_node_and_all_children($node_string) {
	$node_guid = mo_extract_node_guid($node_string);
	$returner = array($node_string);
		
	$node_children_relations = get_entity_relationships($node_guid);
		
	foreach($node_children_relations as $relation) {
		$temp_node_string = mo_format_input_node($relation->guid_two);
		$temp_array = mo_array_node_and_all_children($temp_node_string);
		$returner = array_merge($returner, $temp_array);
	}
		
	return $returner;
}

/*
 * 
 */
function mo_node_immediate_children($node_guid) {
	$node_children_relations = get_entity_relationships($node_guid);
	$node_children_guid = array();
	$count = 0;
	
	foreach($node_children_relations as $relation) {
		$node_children_guid[$count] = $relation->guid_two;
		$count++;
	}
	
	return $node_children_guid;
}
/*
 * 
 */
function mo_node_immediate_parent($node_guid) {
	$options['type'] = 'object';
	$options['subtype'] = 'orgnode';
	$options['relationship'] = 'org-related';
	$options['relationship_guid'] = $node_guid;
	$options['inverse_relationship'] = true;
	$options['limit'] = 0;
	return elgg_get_entities_from_relationship($options);
}

/*
 * 
 */
function mo_get_tree_root() {
	$options['type'] = 'object';
	$options['subtype'] = 'orgnode';
	$options['metadata_name_value_pairs'] = array(
			array('name' => 'root', 'value' => true)
	);
	$entities_parent = elgg_get_entities_from_metadata($options);
	
	if(count($entities_parent) > 0) {
		return $entities_parent[0];
	}
	else {
		return false;
	}
}

/*
 * 
 */
function mo_get_department_next_to_root($name) {
	$options['type'] = 'object';
	$options['subtype'] = 'orgnode';
	$options['metadata_name_value_pairs'] = array(
			//array('name' => 'parent_guid', 'value' => mo_get_tree_root()->guid, 'operand' => '='),
			array('name' => 'name', 'value' => $name, 'operand' => '=', 'case_sensitive' => false)
	);
	$entities = elgg_get_entities_from_metadata($options);
	
	if(count($entities) == 1) {
		return $entities[0]->guid;
	}
	else {
		return false;
	}
}