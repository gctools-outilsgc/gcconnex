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
$root = mo_get_tree_root();

// The organization tree must exist to create this field.
if($root) {
	$org_path = mo_get_all_ancestors($org_string);
	
	// If an organization string was passed to this field.
	if(!empty($org_path)) {
		$count = 1;
		$previous_org = $root->guid;
		
		// Create a dropdown for each tree level found in the organization string.
		foreach($org_path as $org) {
			// Disable all but the last element.
			/*$is_disabled = true;
			if($count == count($org_path)) {
				$is_disabled = false;
			}*/
			
			$initial_input .= elgg_view('missions_organization/org-dropdown', array(
					'given_value' => $org,
					'target' => $previous_org,
					'is_disabled' => $is_disabled,
					'disable_other' => $vars['disable_other'],
					'passed_onchange_function' => $vars['passed_onchange_function']
			));
			
			$previous_org = $org;
			$count++;
		}
		
		// Last dropdown which is not part of the hierarchy
		$last_given = 0;
		if($extracted_other_value) {
			$last_given = 1;
		}
		
		$initial_input .= elgg_view('missions_organization/org-dropdown', array(
				'given_value' => $last_given,
				'target' => $previous_org,
				'disable_other' => $vars['disable_other'],
				'passed_onchange_function' => $vars['passed_onchange_function']
		));
		
		$display_less_button = 'display:block;';
	}
	else {
		// Create a single initial dropdown element for the root of the organization tree.
		$initial_input = elgg_view('missions_organization/org-dropdown', array(
				'target' => $root->guid,
				'disable_other' => $vars['disable_other'],
				'passed_onchange_function' => $vars['passed_onchange_function']
		));
	}
	
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
else {
	$initial_input = elgg_view('input/text', array(
		    'name' => 'department',
		    'value' => elgg_get_logged_in_user_entity()->department,
		    'id' => 'org-no-tree-exists-text-input'
	));
}
 
$numerator = $_SESSION['organization_dropdown_input_count'];

$hidden_disable_other = elgg_view('input/hidden', array(
		'name' => 'hidden_disable_other',
		'value' => $vars['disable_other'],
		'id' => 'missions-is-other-disabled-hidden-value'
));

$hidden_passed_onchange = elgg_view('input/hidden', array(
		'name' => 'hidden_passed_onchange',
		'value' => $vars['passed_onchange_function'],
		'id' => 'missions-passed-onchange-function-hidden-value'
));
?>

<?php echo $hidden_disable_other; ?>
<?php echo $hidden_passed_onchange; ?>
<div>
	<div id="org-dropdown-set">
		<?php echo $initial_input; ?>
	</div>
	<div id="org-other-input-field" style="<?php echo $initial_other_display; ?>">
		<label style="display:inline-block;"><?php echo elgg_echo('missions_organization:other') . ':'; ?></label>
		<?php echo $other_text_input; ?>
	</div>
</div>

<script>
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

			if(count > 10) {
				break;
			}	
			
			if(last_element[0].id == caller.id) {
				x = false;
			}
			else {
				last_container.remove();
			}
			count++;
		}

		var value = caller.value;
		var disabling = document.getElementById('missions-is-other-disabled-hidden-value').value;
		var passed_onchange = document.getElementById('missions-passed-onchange-function-hidden-value').value;
		if(value != 0 && value != 1) {
			elgg.get('ajax/view/missions_organization/org-dropdown', {
				data: {
					target: value,
					disable_other: disabling,
					passed_onchange_function: passed_onchange
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