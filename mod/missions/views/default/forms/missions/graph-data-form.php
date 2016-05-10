<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Form which allows users to add a department to the analytics graph.
 */
$state_array = array('Open');
if($vars['state_array']) {
	$state_array = $vars['state_array'];
}
$state_array = implode(',', $state_array);

if (elgg_is_sticky_form('graphdatafill')) {
	$temp_form = elgg_get_sticky_values('graphdatafill');
	$extracted_org = mo_get_last_input_node($temp_form);
	extract($temp_form);
	// elgg_clear_sticky_form('firstfill');
}

$input_department = elgg_view('page/elements/organization-input', array(
		'organization_string' => $extracted_org
));

echo elgg_view('input/hidden', array(
		'name' => 'hidden_state_array',
		'value' => $state_array
));

$current_count = count($_SESSION['mission_graph_data_array']);
?>

<div class="form-group">
	<label class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:add_this_department_to_graph') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_department; ?>
	</div>
</div>
<div> 
	<?php 
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:add_department'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'mission-graph-data-form-submission-button',
				'onclick' => 'mission_search_progressing()'
		));
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-graph-data-form-submission-button'));
	?>
</div>

<div class="spinner circles" id="mission-graph-spinner">
     <div></div>
     <div></div>
     <div></div>
     <div></div>
     <div></div>
     <div></div>
     <div></div>
     <div></div>
</div>

<script>
	function mission_search_progressing() {
		$('#mission-graph-spinner').show();
	}
</script>