<?php

$event = $vars['event'];
$fd = $vars['form_data'];
echo '<div class="event-calendar-repeat-section">';
if ($fd['repeats'] == 'yes') {
	echo elgg_view('input/checkbox', array('name' => 'repeats', 'id' => 'repeats', 'value' => 'yes', 'checked' => 'checked'));
} else {
	echo elgg_view('input/checkbox', array('name' => 'repeats', 'id' => 'repeats', 'value' => 'yes'));
}
echo elgg_echo('event_calendar:add_recurrence');
echo '<div id="recurrence_event">';
echo elgg_echo('event_calendar:repeat_interval_label').' ';
echo elgg_view('input/dropdown', array('name' => 'repeat_interval','style'=>'width: auto; display:inline-block;', 'value' => $fd['repeat_interval'], 'options_values' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8')));
echo ' '.elgg_echo('event_calendar:repeat_weeks');
echo ' '.elgg_echo('event_calendar:on_these_days');

echo '<div class="event-calendar-repeating-wrapper">';

$days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');

foreach ($days as $day) {

	echo '<a id="event-calendar-repeating-'.$day.'" href="javascript:void(0);" class="event-calendar-repeating-unselected space_event">';
	echo elgg_echo("event_calendar:day_abbrev:$day"); 
	echo'</a>';
}

echo '</div>';

foreach ($days as $day) {

	echo '<input type="hidden" name="event-calendar-repeating-'.$day.'-value" value=" '.$fd['event-calendar-repeating-'.$day.'-value'].'">';
}

?>
<script>
 if ($('#repeats').is(':checked')){
	$('#recurrence_event').show();
	
}else{
	$('#recurrence_event').hide();
}


$('#repeats').change(function(){
    if($(this).is(":checked")) {
        $('#recurrence_event').show("slow");
    } else {
        $('#recurrence_event').hide("1000");
    }
});
</script>