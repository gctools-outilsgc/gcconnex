<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

// WORK IN PROGRESS

/*$input_start_date = elgg_view('input/date', array(
		'name' => 'start_date',
		'value' => $start_date,
		'id' => 'data-analytics-start-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_end_date = elgg_view('input/date', array(
		'name' => 'end_date',
		'value' => $end_date,
		'id' => 'data-analytics-end-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_interval = elgg_view('input/dropdown', array(
		'name' => 'date_interval',
		'value' => $date_interval,
		'options_values' => array(
				'missions:year' => elgg_echo('missions:year'),
				'missions:fiscal_year' => elgg_echo('missions:fiscal_year'),
				'missions:quarter' => elgg_echo('missions:quarter'),
				'missions:month' => elgg_echo('missions:month'),
				'missions:week' => elgg_echo('missions:week'),
				'missions:day' => elgg_echo('missions:day')
		),
		'id' => 'data-analytics-interval-dropdown-input'
));

$input_department = elgg_view('page/elements/organization-input', array(
		'organization_string' => $extracted_org,
		'disable_other' => true
));

$graph_generate_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:generate'),
		'class' => 'elgg-button btn btn-success',
		'id' => 'data-analytics-generate-graph-button',
		'onclick' => 'generate_graph()'
));*/
?>

<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-start-date-input' class="col-sm-3" style="text-align:right;"">
		<?php echo elgg_echo('missions:start_date') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_start_date; ?>
	</div>
	<div class="fa fa-calendar fa-lg"></div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-end-date-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:end_date') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_end_date; ?>
	</div>
	<div class="fa fa-calendar fa-lg"></div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-interval-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:time_interval') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_interval; ?>
	</div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:department') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_department; ?>
	</div>
</div>
<div style="text-align:right;">
	<?php echo $graph_generate_button; ?>
</div>
<div id="generated-graph-container"></div>

<script>
	function generate_graph() {
		var graph_start_date = $('#data-analytics-start-date-input').val();
		var graph_end_date = $('#data-analytics-end-date-input').val();
		var graph_interval = $('#data-analytics-interval-dropdown-input').val();

		var array_of_department_values = $(".org-dropdown-input").map(function(index) {
			return $('#' + this.id).val();
		});
		var department_guid = array_of_department_values[array_of_department_values.length - 1];
		if(department_guid == 0 && array_of_department_values.length > 1) {
			department_guid = array_of_department_values[array_of_department_values.length - 2];
		}

		elgg.get('ajax/view/missions/analytics-generator', {
			data: {
				start_date: graph_start_date,
				end_date: graph_end_date,
				interval: graph_interval,
				department_guid: department_guid
			},
			success: function(result, success, xhr) {
				$('#generated-graph-container').html(result);
			}
		});
	}
</script>
