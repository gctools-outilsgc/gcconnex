<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * View which displays 4 dropdown fields for start hour and minute and duration hour and minute.
 * Values in the dropdown fields are extracted from the hour_string and minute_string found in settings.
 */
//$hourarray = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
//$minarray = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
//$durationarray = explode(',', elgg_get_plugin_setting('duration_string', 'missions'));

$day = $vars['day'];
$start = $vars['start'];
$duration = $vars['duration'];

if (elgg_is_sticky_form('tddropfill')) {
    extract(elgg_get_sticky_values('tddropfill'));
    // elgg_clear_sticky_form('thirdfill');
}

$input_start = elgg_view('input/text', array(
		'name' => $day . '_start',
		'value' => $start,
		'style' => 'width:100px;',
		'id' => 'time-' . $day . '-start-text-input',
		'placeholder' => 'HH:mm',
		'class' => 'timepicker'
));

$input_duration = elgg_view('input/text', array(
		'name' => $day . '_duration',
		'value' => $duration,
		'style' => 'width:100px;',
		'id' => 'time-' . $day . '-duration-text-input',
		'placeholder' => 'HH:mm',
		'class' => 'timepicker'//,
		//'pattern' => '[0-9]:[0-5][0-9]'
));
?>

<div style="display:inline-block;">
	<div style="text-align:center;">
		<h4> <?php echo elgg_echo('missions:' . $day); ?> </h4>
	</div>
	<div>
		<?php echo $input_start; ?>
	</div>
	<div>
		<?php echo $input_duration; ?>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.timepicker').keydown(function(event) {
			if(event.which != 8 && event.which != 46) {
				var input = $(this).val();
				var length = input.length;
				switch(length) {
					case 0:
						if((event.which > 50 || event.which < 48) && (event.which > 98 || event.which < 96)) {
							event.preventDefault();
						}
						break;
					case 1:
						if(input == 2 && (event.which > 51 || event.which < 48) && (event.which > 99 || event.which < 96)) {
							event.preventDefault();
						}
						else if((event.which > 57 || event.which < 48) && (event.which > 105 || event.which < 96))  {
							event.preventDefault();
						}
						break;
					case 2:
						if(event.which != 58 && !event.shiftKey) {
							event.preventDefault();
						}
						break;
					case 3:
						if((event.which > 53 || event.which < 48) && (event.which > 101 || event.which < 96)) {
							event.preventDefault();
						}
						break;
					case 4:
						if((event.which > 57 || event.which < 48) && (event.which > 105 || event.which < 96)) {
							event.preventDefault();
						}
						break;
					default:
						event.preventDefault();
				}
			}
		});
	});
</script>