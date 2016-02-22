<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Field of dropdown elements which traverse the organization tree.
 */
 
 // Session variable to help distinguish the multiple dropdown elements from on another.
$_SESSION['organization_dropdown_input_count'] = 0;

$org_string = $vars['organization_string'];
$extracted_other_value = mo_extract_other_input($org_string);

$display_less_button = 'display:none;';

// Finds the root of the organization tree.
$options['type'] = 'object';
$options['subtype'] = 'orgnode';
$options['metadata_name_value_pairs'] = array(
		array('name' => 'root', 'value' => true)
);
$options['metadata_case_sensitive'] = false;
$entities_parent = elgg_get_entities_from_metadata($options);

// The organization tree must exist to create this field.
if($entities_parent[0]) {
	$org_path = mo_get_all_ancestors($org_string);
	
	// If an organization string was passed to this field.
	if(!empty($org_path)) {
		$count = 1;
		$previous_org = $entities_parent[0]->guid;
		
		// Create a dropdown for each tree level found in the organization string.
		foreach($org_path as $org) {
			// Disable all but the last element.
			/*$is_disabled = true;
			if($count == count($org_path)) {
				$is_disabled = false;
			}*/
			
			$initial_dropdown .= elgg_view('missions_organization/org-dropdown', array(
					'given_value' => $org,
					'target' => $previous_org,
					'is_disabled' => $is_disabled
			));
			
			$previous_org = $org;
			$count++;
		}
		
		// Last dropdown which is not part of the hierarchy
		$last_given = 0;
		if($extracted_other_value) {
			$last_given = 1;
		}
		
		$initial_dropdown .= elgg_view('missions_organization/org-dropdown', array(
				'given_value' => $last_given,
				'target' => $previous_org
		));
		
		$display_less_button = 'display:block;';
	}
	else {
		// Create a single initial dropdown element for the root of the organization tree.
		$initial_dropdown = elgg_view('missions_organization/org-dropdown', array('target' => $entities_parent[0]->guid));
	}
	
	// Button to create a dropdown element for the node in the previous dropdown element.
	/*$more_org_button = elgg_view('output/url', array(
			'text' => elgg_echo('missions_organization:drill_down'),
			'class' => 'elgg-button btn btn-default',
			'id' => 'more-org-button',
			'onclick' => 'more_org()'
	));
	
	// Button to delete the last dropdown element. Not displayed if there is only one dropdown element.
	$less_org_button = elgg_view('output/url', array(
			'text' => elgg_echo('missions_organization:less'),
			'class' => 'elgg-button btn btn-default',
			'id' => 'less-org-button',
			'onclick' => 'less_org()',
			'style' => $display_less_button
	));*/
	
	$initial_other_display = 'display:none;';
	$initial_other_disabled = true;
	if($extracted_other_value) {
		$initial_other_display = 'display:block;';
		$initial_other_disabled = false;
	}
	
	$other_text_input = elgg_view('input/text', array(
		    'name' => 'other_node',
		    'value' => $extracted_other_value,
		    'id' => 'org-other-node-text-input',
			'style' => 'display:inline-block;',
			'disabled' => $initial_other_disabled
	));
}
 
$numerator = $_SESSION['organization_dropdown_input_count'];
?>

<div>
	<div id="org-dropdown-set">
		<?php echo $initial_dropdown; ?>
	</div>
	<!-- <div>
		<div style="display:inline-block;">
			<?php //echo $more_org_button; ?>
		</div>
		<div style="display:inline-block;">
			<?php //echo $less_org_button; ?>
		</div>
	</div> -->
	<div id="org-other-input-field" style="<?php echo $initial_other_display; ?>">
		<label style="display:inline-block;"><?php echo elgg_echo('missions_organization:other') . ':'; ?></label>
		<?php echo $other_text_input; ?>
	</div>
</div>

<script>
	function more_org() {
		// Gets all dropdown elements and how many there are.
		var children = document.getElementById('org-dropdown-set').children;
		var children_length = children.length;

		// Gets the dropdown input, its value and the hidden element.
		var last_dropdown = children[children_length - 1].getElementsByTagName('select');
		var value = last_dropdown[0].value;
		//var last_hidden = children[children_length - 1].getElementsByTagName('input');
		
		if(value != '') {
			elgg.get('ajax/view/missions_organization/org-dropdown', {
				data: {
					target: value
				},
				success: function(result, success, xhr) {
					if($.trim(result)) {
						// Appends the new element to the set.
						$("#org-dropdown-set").append(result);
						// Disables the previous element and sets the hidden input's value to its value.
						//last_hidden[0].value = value;
						last_dropdown[0].disabled = true;
					}
					else {
						// Error message if the new dropdown element has no values to populate it.
						elgg.system_message(elgg.echo('missions_organization:group_has_no_children'));
					}
				}
			});

			// Displays the less button if it's not already displayed.
			var less_button = document.getElementById('less-org-button');
			if(less_button.style.display == 'none') {
				less_button.style.display = 'block';
			}
		}
	}

	function less_org() {
		// Gets all dropdown elements and how many there are.
		var children = document.getElementById('org-dropdown-set').children;
		var children_length = children.length;

		
		if(children_length > 1) {
			// Selects the element before the last element and re-enables it.
			var second_last_dropdown = children[children_length - 2].getElementsByTagName('select');
			var second_last_hidden = children[children_length - 2].getElementsByTagName('input');
			//second_last_hidden[0].value = '';
			second_last_dropdown[0].disabled = false;

			// Delete the last element.
			children[children_length - 1].remove();

			// If there are only 2 elements when the less button is pressed.
			if(children_length == 2) {
				// Then do not display the less button.
				document.getElementById('less-org-button').style.display = 'none';
			}
		}
		else {
			// Error message when the user tries to remove the last input.
			elgg.system_message(elgg.echo('missions_organization:cannot_remove_last_input'));
		}	
	}

	function dynamicDrop(caller) {
		// The other input starts out hidden and disabled.
		document.getElementById('org-other-input-field').style.display = 'none';
		document.getElementById('org-other-node-text-input').disabled = true;

		// Creates an array of element ids found in org-dropdown-set
		var children_collection = document.getElementById('org-dropdown-set').children;
		var temp_array = [];
		for(var i = 0; i < children_collection.length; i++) {
			temp_array[i] = children_collection[i].id;
		}

		temp_array.sort(function(a, b){
			var a_temp = a.split('-');
			var b_temp = b.split('-');
			var a_comp = parseInt(a_temp.pop());
			var b_comp = parseInt(b_temp.pop());
			return a_comp - b_comp;
		});

		var x = true;
		var count = 1;
		
		while(x) {
			var last_container = document.getElementById(temp_array[temp_array.length - count]);
			var last_element = last_container.getElementsByTagName('select');
			if(last_element[0].id == caller.id) {
				x = false;
			}
			else {
				last_container.remove();
			}
			count++;
		}

		var value = caller.value;
		if(value != 0 && value != 1) {
			elgg.get('ajax/view/missions_organization/org-dropdown', {
				data: {
					target: value
				},
				success: function(result, success, xhr) {
					if($.trim(result)) {
						// Appends the new element to the set.
						$("#org-dropdown-set").append(result);
					}
					//else {
					//	document.getElementById('org-other-input-field').style.display = 'block';
					//}
				}
			});
		}
		else if(value == 1) {
			document.getElementById('org-other-input-field').style.display = 'block';
			document.getElementById('org-other-node-text-input').disabled = false;
		}
	}
</script>