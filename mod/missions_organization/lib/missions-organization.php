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
		if(strpos($key, 'org-drop') !== false && $value != 1) {
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
function mo_get_all_ancestors($node_string) {
	$x = true;
	$count = 1;
	$returner = array();
	
	$node_array = explode(':', $node_string);
	$node_guid = $node_array[1];
	
	$returner[0] = $node_guid;
	$current_id = $node_guid;
	while($x) {
		$parent_relation = get_entity_relationships($current_id, true);
		
		if($parent_relation[0]) {
			$parent_guid = $parent_relation[0]->guid_one;
			
			$returner[$count] = $parent_guid;
			$count++;
			$current_id = $parent_guid;
		}
		else {
			$x = false;
		}
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
		$other_input = ', ' . $other_input;
	}

	$returner['english_path'] = implode(', ', $ancestor_names_english) . $other_input;
	$returner['french_path'] = implode(', ', $ancestor_names_french) . $other_input;
	
	return $returner;
}

/*
 * Extracts the other input from the stored data.
 */
function mo_extract_other_input($node_string) {
	$node_array = explode(':', $node_string);
	return $node_array[2];
}