<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
elgg_load_js('missions_flot');
elgg_load_js('missions_flot_stack_patched');
elgg_load_js('missions_flot_selection');
elgg_load_js('missions_flot_navigation');
elgg_load_js('missions_flot_time');

$input_graph_type = elgg_view('input/dropdown', array(
		'name' => 'graph_type',
		'value' => $graph_type,
		'options_values' => array(
				'' => '',
				'missions:stacked_graph' => elgg_echo('missions:stacked_graph'),
				'missions:histogram' => elgg_echo('missions:histogram'),
				'missions:top_skills'	=>	elgg_echo('missions:skills'),
		),
		'id' => 'data-analytics-graph-type-dropdown-input',
		'onchange' => 'generate_inputs(this); wipe_away_graph();'
));

$input_department = elgg_view('page/elements/organization-input', array(
		'organization_string' => $extracted_org,
		'disable_other' => true,
		'passed_onchange_function' => 'wipe_away_graph();'
));

$input_role = elgg_view('input/dropdown', array(
	    'name' => 'job_role',
	    'value' => '',
		'options_values' => array('' => '') + mm_echo_explode_setting_string(elgg_get_plugin_setting('opportunity_role_string', 'missions')),
	    'id' => 'data-analytics-role-dropdown-input'
));

$input_type = elgg_view('input/dropdown', array(
	    'name' => 'job_type',
	    'value' => '',
		'options_values' => array('' => '') + mm_echo_explode_setting_string(elgg_get_plugin_setting('opportunity_type_string', 'missions')),
	    'id' => 'data-analytics-type-dropdown-input'
));

$input_status = elgg_view('input/dropdown', array(
	    'name' => 'status',
	    'value' => '',
		'options_values' => array('' => '') + mm_echo_explode_setting_string(elgg_get_plugin_setting('opportunity_status_string', 'missions')),
	    'id' => 'data-analytics-status-dropdown-input'
));

$graph_generate_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:generate'),
		'class' => 'elgg-button btn btn-success',
		'id' => 'data-analytics-generate-graph-button',
		'onclick' => 'generate_graph()'
));

$chart_controls = elgg_view('output/url', array(
		'title' => elgg_echo('missions:zoomcenter'),
		'class' => 'elgg-button btn btn-default glyphicon glyphicon-repeat',
		'id' => 'data-analytics-zoom-reset-btn',
));

$chart_controls .= elgg_view('output/url', array(
		'title' => elgg_echo('missions:zoomin'),
		'class' => 'elgg-button btn btn-default glyphicon glyphicon-zoom-in',
		'id' => 'data-analytics-zoom-in-btn',
));

$chart_controls .= elgg_view('output/url', array(
		'title' => elgg_echo('missions:zoomout'),
		'class' => 'elgg-button btn btn-default glyphicon glyphicon-zoom-out',
		'id' => 'data-analytics-zoom-out-btn',
));

$chart_controls .= elgg_view('output/url', array(
		'title' => elgg_echo('missions:panleft'),
		'class' => 'elgg-button btn btn-default glyphicon glyphicon-circle-arrow-left',
		'id' => 'data-analytics-pan-left-btn',
));

$chart_controls .= elgg_view('output/url', array(
		'title' => elgg_echo('missions:panright'),
		'class' => 'elgg-button btn btn-default glyphicon glyphicon-circle-arrow-right',
		'id' => 'data-analytics-pan-right-btn',
));

$graph_show_table_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:show_data_table'),
		'id' => 'data-analytics-show-table-graph-button',
		'style' => 'display:none;',
		'onclick' => 'show_graph_table()'
));

$graph_hide_table_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:hide_data_table'),
		'id' => 'data-analytics-hide-table-graph-button',
		'style' => 'display:none;',
		'onclick' => 'hide_graph_table()'
));
?>

<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-graph-type-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:graph_type') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_graph_type; ?>
	</div>
</div>
<div id="graph-type-inputs"></div>
<div class="col-sm-12" style="margin:4px;" id="department-input-row">
	<label class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:department') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_department; ?>
	</div>
</div>
<div class="col-sm-12" style="margin:4px;" id="role-input-row">
	<label class="col-sm-3 text-right">
		<?php echo elgg_echo('missions:opportunity_role') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_role; ?>
	</div>
</div>
<div class="col-sm-12" style="margin:4px;" id="type-input-row">
	<label class="col-sm-3 text-right">
		<?php echo elgg_echo('missions:opportunity_type') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_type; ?>
	</div>
</div>
<div class="col-sm-12" style="margin:4px;" id="status-input-row">
	<label class="col-sm-3 text-right">
		<?php echo elgg_echo('missions:opportunity_status') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_status; ?>
	</div>
</div>

<div class="col-sm-6">
	<div id="zoom_controls_container" style="display: none;">
		<?php echo $chart_controls; ?>
	</div>
</div>
<div class="col-sm-6 text-right">
	<?php echo $graph_generate_button; ?>
</div>
<div id="generated-graph-parent" class="col-sm-12" style="overflow-x:auto;">
	<div id="generated-graph-container"></div>
</div>
<div>
	<?php echo $graph_show_table_button . $graph_hide_table_button; ?>
</div>
<div hidden id="hidden-percentages-for-hover"></div>
<div id="hidden-graph-table-parent" class="col-sm-12" style="overflow-x:auto;margin-bottom:64px;">
	<div id="hidden-graph-table-container" style="display:none;"></div>
</div>

<script>
	// Function which makes an AJAX call to get the inputs needed for Stacked graph or Histogram.
	function generate_inputs(control) {
		var type = control.value;
		elgg.get('ajax/view/missions/analytics-inputs', {
			data: { graph_type: type },
			success: function(result, success, xhr) {
				$('#graph-type-inputs').html(result);
				if (type == 'missions:top_skills') {
					$('#department-input-row').hide();
					$('#role-input-row').hide();
					$('#type-input-row').hide();
					$('#status-input-row').hide();
				} else {
					disable_target_date();
				}
			}
		});
	}

	function wipe_away_graph() {
		$("#zoom_controls_container").css('display', 'none');
		$('#generated-graph-container').html("");
		$('#generated-graph-container').css("height", "");
		$('#generated-graph-container').css("width", "");
		$('#hidden-graph-table-container').html("");
		$('#hidden-graph-table-container').css("width", "");
		$('#data-analytics-hide-table-graph-button').css('display', 'none');
		$('#data-analytics-show-table-graph-button').css('display', 'none');
		$(".elgg-state-error").fadeOut(500);
	}

	window.onload = generate_inputs(document.getElementById("data-analytics-graph-type-dropdown-input"));

	// Function which displays a pop up when one of the graph bars is moused over.
	function showTooltip(x, y, content) {
		$('<div id="graph_tooltip">' + content + '</div>').css({
			position: 'absolute',
	        display: 'none',
	        top: y - 40,
	        left: x - 120,
	        border: '4px solid',
	        color: '#fff',
	        padding: '6px',
	        'font-size': '14px',
	        'border-radius': '12px',
	        'background-color': '#047177',
	        opacity: 0.9
		}).appendTo('body').fadeIn(200);
	}

	// Function which creates a table corresponding to the graph.
	function create_graph_table(dataset, ticks, caption) {
		var graph_graph_type = $('#data-analytics-graph-type-dropdown-input').val();
		var content = '<table class="wb-charts table" id="hidden-graph-table">';
		content += '<caption>' + caption + '</caption>';

		content += '<tr><td></td>';
		if(graph_graph_type == 'missions:stacked_graph') {
			for(var i=0; i < ticks.length; i++) {
				content += '<th style="text-align:center;white-space:nowrap;padding:10px;">' + ticks[i][1] + '</th>';
			}
		}
		else {
			for(var i=0; i < (ticks.length - 1); i++) {
				var first_number = ticks[i][1].substr(0,ticks[i][1].indexOf(' '));
				var second_number = ticks[i+1][1].substr(0,ticks[i+1][1].indexOf(' '));
				var unit = ticks[i][1].substr(ticks[i][1].indexOf(' '));

				content += '<th style="text-align:center;">' + first_number + '-' + second_number + unit + '</th>';
			}
		}
		content += '</tr>';

		for(var i=0;i<dataset.length;i++) {
			content += '<tr>';
			content += '<th>' + dataset[i].label + '</th>';
			for(var j=0;j<dataset[i].data.length;j++) {
				content += '<td style="text-align:center;">' + dataset[i].data[j][1] + '</td>';
			}
			content += '</tr>';
		}

		content += '</table>';
		$('#hidden-graph-table-container').append(content);
	}

	// Large function which creates the graph according to the previous input.
	function generate_graph() {
		wipe_away_graph();

		// Grabs the values of any of the inputs that are on the page.
		var graph_graph_type = $('#data-analytics-graph-type-dropdown-input').val();

		var graph_start_date = $('#data-analytics-start-date-input').val();
		var graph_end_date = $('#data-analytics-end-date-input').val();
		var graph_interval = $('#data-analytics-interval-dropdown-input').val();
		var graph_target_date = $('#data-analytics-target-mission-date-dropdown-input').val();
		var graph_separator = $('#data-analytics-separator-dropdown-input').val();

		var graph_bin_number = $('#data-analytics-bin-number-input').val();
		var graph_target_value = $('#data-analytics-target-value-dropdown-input').val();

		var array_of_department_values = $(".org-dropdown-input").map(function(index) {
			return $('#' + this.id).val();
		});
		var department_guid = array_of_department_values[array_of_department_values.length - 1];
		if(department_guid == 0 && array_of_department_values.length > 1) {
			department_guid = array_of_department_values[array_of_department_values.length - 2];
		}

		var array_of_role_type_values = $("#data-analytics-role-dropdown-input").map(function(index) {
			return $('#' + this.id).val();
		});
		var role_type = array_of_role_type_values[array_of_role_type_values.length - 1];
		if(role_type == 0 && array_of_role_type_values.length > 1) {
			role_type = array_of_role_type_values[array_of_role_type_values.length - 2];
		}

		var array_of_job_type_values = $("#data-analytics-type-dropdown-input").map(function(index) {
			return $('#' + this.id).val();
		});
		var job_type = array_of_job_type_values[array_of_job_type_values.length - 1];
		if(job_type == 0 && array_of_job_type_values.length > 1) {
			job_type = array_of_job_type_values[array_of_job_type_values.length - 2];
		}

		var array_of_status_values = $("#data-analytics-status-dropdown-input").map(function(index) {
			return $('#' + this.id).val();
		});
		var status = array_of_status_values[array_of_status_values.length - 1];
		if(status == 0 && array_of_status_values.length > 1) {
			status = array_of_status_values[array_of_status_values.length - 2];
		}

		// AJAX call which generates the data set for the graph as well as sets some supporting data and options.
		elgg.getJSON('ajax/view/missions/analytics-generator', {
			data: {
				graph_type: graph_graph_type,
				start_date: graph_start_date,
				end_date: graph_end_date,
				interval: graph_interval,
				target_mission_date: graph_target_date,
				department_guid: department_guid,
				role_type: role_type,
				job_type: job_type,
				status: status,
				separator: graph_separator,
				bin_number: graph_bin_number,
				target_value: graph_target_value
			},
			success: function(result, success, xhr) {
				if(result != '') {
					if(result.error_returned == '') {
						//$("#generated-graph-parent").css("overflow-x", "scroll");
						$("#generated-graph-container").css("height", "600px");
						if($("#data-analytics-hide-table-graph-button").css("display") == "none") {
							$("#data-analytics-show-table-graph-button").css("display", "block");
						}
						$("#hidden-graph-table-container").html('');

						var dataset = result.data;

						// Creates the graph table according to the set of data and the x-axis labels.
						create_graph_table(dataset, result.ticks, '');

						// Each bar tracks what percentage of the bar each data group takes up (mostly relevant for stacked graphs).
						// This stores these percentages as a hidden element for later retrieval by another function.
						$('#hidden-percentages-for-hover').html(JSON.stringify(result.percentages));

						// Determines the width of the graph based on how many intervals exist in the x-axis. The minimum length is 1140px.
						function set_graph_size() {
							var graph_length = $('h1', $('#generated-graph-container').parent()).width();
							$("#generated-graph-container").css("width", graph_length + "px");
							$("#hidden-graph-table-container").css("width", graph_length + "px");
						}
						set_graph_size();

						var options = result.options;

						function generate_chart() {
							plot = $.plot("#generated-graph-container", dataset, options);

							if (options.zoom) {
								$("#zoom_controls_container").css('display', '');

								$('#data-analytics-zoom-reset-btn')
									.click(function (event) {
										event.preventDefault();
										generate_chart();
									});

								$('#data-analytics-zoom-in-btn')
									.click(function (event) {
										event.preventDefault();
										plot.zoom();
									});

								$('#data-analytics-zoom-out-btn')
									.click(function (event) {
										event.preventDefault();
										plot.zoomOut();
									});

								$('#data-analytics-pan-left-btn')
									.click(function (e) {
										e.preventDefault();
										plot.pan({ left: -100 });
									});

									$('#data-analytics-pan-right-btn')
										.click(function (e) {
											e.preventDefault();
											plot.pan({ left: 100 });
										});

							}
						}

						generate_chart();

						$(window).resize(function() {
							set_graph_size();
							generate_chart();
						});

						// Function which handles the user mousing over a bar in the graph.
						var previous_hover = [0,0,0];
						$('#generated-graph-container')
						.bind('plothover', function(event, pos, item) {
							if(item) {
								if(previous_hover[0] != item.datapoint[0] || previous_hover[1] != item.datapoint[1] || previous_hover[2] != item.datapoint[2]) {
									previous_hover = item.datapoint;

									$('#graph_tooltip').remove();
									var x = item.datapoint[0];
									var y = item.datapoint[1] - item.datapoint[2];
									var label = item.series.label;

									var perc_set = JSON.parse($('#hidden-percentages-for-hover').html());
									var total = perc_set[label][x][0];
									var perc = perc_set[label][x][1];

									// Displays the y value of the bar.
									var tool_string = label + ': ' + y;
									// If that value is not 100% of the bar then the total y value and percentage is displayed.
									if(perc < 100) {
										tool_string = tool_string + '/' + total + ' (' + perc + '%)';
									}

									showTooltip(item.pageX, item.pageY, tool_string);
								}
							}
							else {
								$('#graph_tooltip').remove();
								previous_hover = [0,0,0];
							}
		      	});
					} else {
						elgg.register_error(result.error_returned);
						setTimeout(function () {
							$(".elgg-state-error").fadeOut(500);
						}, 180000);
					}
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}

	// Small function which displays the graph table.
	function show_graph_table() {
		$('#data-analytics-hide-table-graph-button').css('display', 'block');
		$('#data-analytics-show-table-graph-button').css('display', 'none');
		$('#hidden-graph-table-container').css('display', 'block');
	}

	// Small function which hides the graph table.
	function hide_graph_table() {
		$('#data-analytics-hide-table-graph-button').css('display', 'none');
		$('#data-analytics-show-table-graph-button').css('display', 'block');
		$('#hidden-graph-table-container').css('display', 'none');
	}

	function disable_target_date() {
		if($('#data-analytics-separator-dropdown-input').val() == 'missions:reason_to_decline' || $('#data-analytics-separator-dropdown-input').val() == 'missions:average_number_of_applicants') {
			$('#data-analytics-target-mission-date-dropdown-input').val('missions:date_posted');
			$('#data-analytics-target-mission-date-dropdown-input').prop('disabled', true);
			if($('#data-analytics-separator-dropdown-input').val() == 'missions:reason_to_decline') {
				$('#department-input-row').hide();
				$('#role-input-row').hide();
				$('#type-input-row').hide();
				$('#status-input-row').hide();
			}
		}
		else {
			$('#data-analytics-target-mission-date-dropdown-input').prop('disabled', false);
			$('#department-input-row').show();
			$('#role-input-row').show();
			$('#type-input-row').show();
			$('#status-input-row').show();
		}
	}
</script>
