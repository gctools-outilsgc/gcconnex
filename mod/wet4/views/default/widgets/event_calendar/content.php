<?php

/**
 * Elgg event calendar widget
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

// Load event calendar model
elgg_load_library('elgg:event_calendar');

//the number of events to display
$num = (int) $vars['entity']->num_display;
if (!$num) {
	$num = 4;
}
/*
// Get the events
$events = event_calendar_get_personal_events_for_user(elgg_get_page_owner_guid(), $num);
*/
/*$options = array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'relationship' => 'personal_event',
		'relationship_guid' => $user_guid,
		//'limit' => 6,
		'count' => $vars['count'],
		'pagination' => true,
);
$events = elgg_list_entities($options);*/

// If there are any events to view, view them
/*if (is_array($events) && sizeof($events) > 0) {
	echo "<div id=\"widget_calendar\">";
	foreach($events as $event) {
		echo elgg_view("object/event_calendar", array('entity' => $event));
	}
	echo "</div>";

	$event_url = "event_calendar/owner/" . elgg_get_page_owner_entity()->username;
	$viewall_link = elgg_view('output/url', array(
		'href' => $event_url,
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$viewall_link</span>";
} else {
	echo elgg_echo('event_calendar:no_events_found');
}*/

/*
$options = array(
	'type' => 'object',
	'subtype' => 'event_calendar',
	'relationship' => 'personal_event',
	'relationship_guid' => $user_guid,
	'limit' => 5,
	'full_view' => false,
	'pagination' => false,
	
);
$content = elgg_list_entities($options);
echo $content;


if ($content) {
	$event_url = "event_calendar/owner/" . elgg_get_page_owner_entity()->username;
	$viewall_link = elgg_view('output/url', array(
		'href' => $event_url,
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$viewall_link</span>";
} else {
	echo elgg_echo('event_calendar:no_events_found');
}*/

 
   
       $events = event_calendar_get_personal_events_for_user(elgg_get_page_owner_guid(), $num);
    

    if(!$events){
        echo '<div class="mrgn-lft-sm mrgn-bttm-md">' . elgg_echo('event_calendar:no_events_found') . '</div>';
    }
    
    foreach($events as $event) {
		echo elgg_view("object/event_calendar", array('entity' => $event));
        echo '</div>';
	}
    
    $date = date('Y-m-d'/*, strtotime("-1 days")*/);
    $event_url = "event_calendar/owner/". elgg_get_page_owner_entity()->username;
	$viewall_link = elgg_view('output/url', array(
		'href' => $event_url,
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	));

	echo "<span class=\"elgg-widget-more\">$viewall_link</span>";

