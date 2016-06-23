<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

// WORK IN PROGRESS

$start_date = $vars['start_date'];
$end_date = $vars['end_date'];
$interval = $vars['interval'];
$department_guid = $vars['department_guid'];
if(elgg_entity_exists($department_guid)) {
	$department_identifier = 'MOrg:' . $department_guid;
}

$timescale_array = mm_generate_time_scale_timestamps($start_date, $end_date, $interval);

$timescale_labels = $timescale_array;
array_pop($timescale_labels);
foreach($timescale_labels as $key => $time) {
	//system_message($key . ': ' . date('Y-m-d', $time));
	if($interval == 'missions:year') {
		$timescale_labels[$key] = date('Y', $time);
	}
	else if($interval == 'missions:fiscal_year') {
		$timescale_labels[$key] = 'FY: ' . date('Y', $time);
	}
	else if($interval == 'missions:quarter') {
		$timescale_labels[$key] = 'Q' . ceil(intval(date('m', $time)) / 3) . ', ' . date('Y', $time);
	}
	else if($interval == 'missions:month') {
		$timescale_labels[$key] = date('M, Y', $time);
	}
	else if($interval == 'missions:week') {
		$timescale_labels[$key] = 'W' . date('W, Y', $time); 
	}
	else if($interval == 'missions:day') {
		$timescale_labels[$key] = date('Y-m-d', $time);
	}
}

$content .= '<caption>' . '</caption>';

$content .= '<thead><tr><th style="min-width:50px;"></th>';
foreach($timescale_labels as $label) {
	$content .= '<th style="min-width:100px;">' . $label . '</th>';
}
$content .= '</tr></thead>';
?>

<div class="col-sm-12" style="overflow-x:scroll;">
	<table class="wb-charts wb-charts-bar table">
		<?php echo $content; ?>
	</table>
</div>