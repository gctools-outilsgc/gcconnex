<?php


$urlmod = "?method=ical&filter={$vars['filter']}&date={$vars['date']}&interval={$vars['interval']}";

if ($vars['group_guid']) {
  $urlmod .= "&group_guid={$vars['group_guid']}";
}

if ($vars['region']) {
  $urlmod .= "&region={$vars['region']}";
}

echo elgg_view('navigation/tabs', array(
	'tabs' => array(
		array(
			'text' => elgg_echo('event_calendar_ical:export'),
			'href' => elgg_get_site_url() . 'event_calendar/ical/export' . $urlmod,
			'selected' => ($vars['filter_type'] == 'export')
		),
		array(
			'text' => elgg_echo('event_calendar_ical:import'),
			'href' => elgg_get_site_url() . 'event_calendar/ical/import' . $urlmod,
			'selected' => ($vars['filter_type'] == 'import')
		)
	)
));