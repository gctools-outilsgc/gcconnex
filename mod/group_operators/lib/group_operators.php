<?php
/**
 * Group operators helper functions
 *
 * @package ElggGroupOperators
 */


/**
 * Gives the list of the operators of a group
 *
 * @param ElggGroup $group
 * @return array
 */
function get_group_operators($group){
	if($group instanceof ElggGroup){
		$operators = elgg_get_entities_from_relationship(
			array('types'=>'user', 'limit'=>0, 'relationship_guid'=>$group->guid, 'relationship'=>'operator', 'inverse_relationship'=>true));
		$group_owner = get_entity($group->getOwnerGUID());

		if(!in_array($group_owner, $operators)){
			$operators[$group_owner->guid] = $group_owner;
		}
		return $operators;
	}
	else {
		return null;
	}
}

function elgg_view_group_operators_list($group){
	$operators = get_group_operators($group);
	$html = '<ul class="elgg-list">';
	foreach($operators as $operator){
		$html .= '<li class="elgg-item">';
		$html .= elgg_view('group_operators/display', array(
			'entity' => $operator,
			'group' => $group
		));
		$html .= '</li>';
	}
	$html .= '</ul>';
	return $html;
}

/**
 * Prepare the manage form variables
 *
 * @param ElggGroup $group
 * @return array
 */
function group_operators_prepare_form_vars($group) {

	$members = $group->getMembers(0);
	$operators = get_group_operators($group);
	$no_operators = array_obj_diff($members, $operators);

	// input names => defaults
	$values = array(
		'entity' => $group,
		'candidates' => $no_operators
	);

	return $values;
}

/**
 * Prepare the manage form variables
 *
 * @param array $candidates Candidate entities
 * @return array guids => 'name - username'
 */
function group_operators_prepare_combo_vars($candidates) {
	$values = array('' => elgg_echo('group_operators:selectone'));
	foreach($candidates as $candidate){
		$values[$candidate->guid] = $candidate->name." - ".$candidate->username;
	}
	return $values;
}

/**
 * array_diff doesn't work with arrays of objects because it compares the
 * string-represantation of the arguments (which is always "Object" for an object).
 */
function array_obj_diff ($array1, $array2) {
   
    foreach ($array1 as $key => $value) {
        $array1[$key] = serialize ($value);
    }

    foreach ($array2 as $key => $value) {
        $array2[$key] = serialize ($value);
    }
   
    $array_diff = array_diff ($array1, $array2);
   
    foreach ($array_diff as $key => $value) {
        $array_diff[$key] = unserialize ($value);
    }
   
    return $array_diff;
}
