<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Single dropdown element for the organization-input element.
 */
$target_guid = $vars['target']; // The guid of the node whose children make up the dropdown options.
$given_value = $vars['given_value']; // The guid of the initial dropdown value.
$disabled = $vars['is_disabled']; // Boolean which determines if the dropdown starts off disabled.

// Gets all the names of the children of the targeted node in order to populate the dropdown.
$node_children[0] = '';
if($target_guid) {
	unset($options);
	$options['relationship'] = 'org-related';
	$options['relationship_guid'] = $target_guid;
	$options['limit'] = 0;
	$temp_node_children = array_reverse(elgg_get_entities_from_relationship($options));

	foreach($temp_node_children as $key => $value) {
		$node_children[$value->guid] = $value->name;
		if(get_current_language() == 'fr') {
			$node_children[$value->guid] = $value->name_french;
		}
	}
}

$node_children[1] = elgg_echo('missions_organization:other_cap');

// Only creates a dropdown if the dropdown options are not empty.
if(!empty($node_children) && $node_children != array(0 => '', 1 => elgg_echo('missions_organization:other_cap'))) {
	// Updates the session variable which helps make the dropdowns unique.
	$numerator = $_SESSION['organization_dropdown_input_count'] + 1;
	$_SESSION['organization_dropdown_input_count'] = $numerator;
	
	echo '<div id="org-dropdown-container-' . $_SESSION['organization_dropdown_input_count'] . '">';
	echo elgg_view('input/dropdown', array(
			'name' => 'org-drop-' . $numerator,
			'value' => $given_value,
			'options_values' => $node_children,
			'id' => 'org-dropdown-input-' . $numerator,
			'disabled' => $disabled,
			'onchange' => 'dynamicDrop(this)'
	));
	
	if($disabled) {
		$temp_value = $given_value;
	}
	
	// Hidden value which passes along data when the dropdown is disabled.
	/*echo elgg_view('input/hidden', array(
			'name' => 'org-drop-' . $numerator . '-hidden',
			'value' => $temp_value
	));*/
	echo '</div>';
}