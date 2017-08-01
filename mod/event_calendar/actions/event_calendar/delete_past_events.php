<?php
/**
 * Deletion of past event calendar entities
 *
 * Called through ajax, but registered as an Elgg action.
 *
 */

set_time_limit(0);

$delete_upper_limit = get_input('delete_upper_limit');

if (!$delete_upper_limit) {
	$response = array('success' => false, 'message' => elgg_echo('event_calendar:administer:error_no_interval'));
	echo json_encode($response);
	exit;
}

$delete_repeating_events = get_input('delete_repeating_events');
$delete_repeating_events = ($delete_repeating_events === 'true');

$ia = elgg_set_ignore_access(true);
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$now = time();
$upper_limit = false;
switch ($delete_upper_limit) {
	case 'one_year':
		$upper_limit = $now - 60*60*24*367;
		break;
	case 'half_year':
		$upper_limit = $now - 60*60*24*181;
		break;
	case 'three_months':
		$upper_limit = $now - 60*60*24*91;
		break;
	case 'four_weeks':
		$upper_limit = $now - 60*60*24*29;
		break;
	case 'two_weeks':
		$upper_limit = $now - 60*60*24*15;
		break;
}

if ($upper_limit && ($upper_limit > 0)) {

	// Fetching events with start_date < $upper_limit here because repeating events have no meaningful real_end_time metadata value
	// Non-scheduled event poll events are not retrieved here because they don't have any fixed start_date metadata value yet
	$options = array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'limit' => false,
		'metadata_name_value_pairs' => array(
			array(
				'name' => 'start_date',
				'value' => $upper_limit,
				'operand' => '<'
		)),
	);
	$past_events = new ElggBatch('elgg_get_entities_from_metadata', $options);
	$past_events->setIncrementOffset(false);

	$success_count = 0;
	$error_count = 0;
	foreach($past_events as $past_event) {
		// do we delete also repeating events?
		if ($past_event->repeats == 'yes') {
			if ($delete_repeating_events) {
				if ($past_event->delete()) {
					$success_count++;
				} else {
					$error_count++;
				}
			}
		} else if ($past_event->repeats != 'yes') {
			// Non-repeating events have a real_end_time metadata value, so let's check if real_end_time < $upper_limit, too, before deletion
			if ($past_event->real_end_time < $upper_limit) {
				if ($past_event->delete()) {
					$success_count++;
				} else {
					$error_count++;
				}
			}
		}
	}

	$response = array('success' => true, 'message' => elgg_echo('event_calendar:administer:delete_past_events_result', array($success_count, $error_count)));
} else {
	$response = array('success' => false, 'message' => elgg_echo('event_calendar:administer:error_invalid_interval'));
}

elgg_set_ignore_access($ia);
access_show_hidden_entities($access_status);

echo json_encode($response);
exit();
