<?php

require_once($CONFIG->pluginspath.'event_calendar/models/model.php');


$event_list = elgg_get_entities_from_metadata(array(
	'subtype' => 'event_calendar',
	'type' => 'object',
	'metadata_name_value_pair' => array('name' => 'start_date', 'value' => time(),  'operand' => '>='),
	'order_by_metadata' => array('name' => 'start_date', 'direction' => 'asc')
));

$today = date("F j, Y, g:i a");

echo "<div style='overflow-y:auto; height:200px;'>";
echo '<h4 class="mtm">'.elgg_echo('index_widget:event:today',array($today)).'</h4>';

foreach ($event_list as $event) {

	$start_date = date('Y-m-d', $event->start_date);
	$end_date = date('Y-m-d', $event->end_date);

	$start_date = event_calendar_format_time($start_date, $event->start_time);
	$end_date = event_calendar_format_time($end_date, $event->end_time);

	$lang = get_current_language();
	$title = gc_explode_translation($event->title,$lang);

echo "<div class='pbm'>
			<div id='event_title'><strong><a href='{$event->getURL()}'>{$title}</a></strong></div>
			<div id='event_date'>{$start_date} - {$end_date} EST</div>
			<div id='event_location'>{$event->venue}</div>
		</div>";
}
echo "</div>";

?>
