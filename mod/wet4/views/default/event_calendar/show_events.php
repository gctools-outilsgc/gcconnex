<?php

/**
 * Elgg show events view
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

elgg_load_library('elgg:event_calendar');

$listing_format = $vars['listing_format'];

if ($vars['events']) {
	if ($listing_format == 'agenda') {
		$vars['events'] = event_calendar_flatten_event_structure($vars['events']);
		$event_list = elgg_view('event_calendar/agenda_view', $vars);
	} else if ($listing_format == 'paged') {
		$vars['events'] = event_calendar_flatten_event_structure($vars['events']);
		$event_list = elgg_view('event_calendar/paged_view', $vars);
	} else if ($listing_format == 'full') {
		$event_list = elgg_view('event_calendar/full_calendar_view', $vars);
	} else {
		$vars['events'] = event_calendar_flatten_event_structure($vars['events']);
		$options = array(
			'list_class' => 'elgg-list-entity',
			'full_view' => false,
			'pagination' => true,
			'list_type' => 'listing',
			'list_type_toggle' => false,
			'offset' => $vars['offset'],
			'limit' => $vars['limit'],
			'count' => $vars['count'],
		);
		$event_list = elgg_view_entity_list($vars['events'], $options);
	}
} else {
	if ($listing_format == 'full') {
		// show the empty calendar
		$event_list = elgg_view('event_calendar/full_calendar_view', $vars);
	} else {
		$event_list = '<p>'.elgg_echo('event_calendar:no_events_found').'</p>';
	}
}
if ($listing_format == 'paged' || $listing_format == 'full') {
	$vars['events'] = event_calendar_flatten_event_structure($vars['events']);
		$options = array(
			'list_class' => 'elgg-list-entity',
			'full_view' => false,
			'pagination' => true,
			'list_type' => 'listing',
			'list_type_toggle' => false,
			'offset' => $vars['offset'],
			'limit' => $vars['limit'],
			'count' => $vars['count'],

	);
	$event_list = elgg_view_entity_list($vars['events'], $options);

	$owner = elgg_get_page_owner_entity();
	if(elgg_instanceof($owner, 'group')) { // add guid to the link if it a group

		$new_link = elgg_view('output/url', array(
        'href' => "event_calendar/add/$owner->guid",
        'text' => elgg_echo('event_calendar:new'),
        'class' => 'btn btn-primary pull-right',
    	));
	}else{
		$new_link = elgg_view('output/url', array(
        'href' => "event_calendar/add",
        'text' => elgg_echo('event_calendar:new1'),
        'class' => 'btn btn-primary pull-right',
    	));
	}
	

		 echo'<h3>'.elgg_echo('event_calendar:comming').'</h3>';
		 echo $new_link;
	if (empty($event_list)) {
		// show the empty calendar
		$event_list = '<p>'.elgg_echo('event_calendar:no_events_found').'</p>';
		echo $event_list;
	} else {
		//show the list of event
		echo $event_list;
		
	}

	


	
} else {
?>
	<div style="width:100%">
		<div id="event_list" style="float:left;">
			<?php
			echo $event_list;
			?>
		</div>
		<div style="float:right;">
			<!-- see the calendar -->
			<?php
			echo elgg_view('event_calendar/calendar', $vars);
			?>
		</div>
	</div>
<?php
}
