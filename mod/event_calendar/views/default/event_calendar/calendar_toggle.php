<?php

$event_guid = get_input('guid');
$event = get_entity($event_guid);
$container = get_entity($event->container_guid);

$user = $vars['entity'];

if ($container->canEdit()) {
	$has_event = event_calendar_has_personal_event($event->guid, $user->guid);

	$class_add = $has_event ? 'hidden' : '';
	$class_remove = $has_event ? '' : 'hidden';

	echo elgg_view('input/button', array(
		'class' => "elgg-button-delete event-calendar-personal-calendar-toggle $class_remove",
		'value' => elgg_echo('event_calendar:remove_from_the_calendar_button'),
		'data-event-guid' => $event->guid,
		'data-user-guid' => $user->guid,
	));
	echo elgg_view('input/button', array(
		'class' => "elgg-button-submit event-calendar-personal-calendar-toggle $class_add",
		'value' => elgg_echo('event_calendar:add_to_the_calendar'),
		'data-event-guid' => $event->guid,
		'data-user-guid' => $user->guid,
	));
}
