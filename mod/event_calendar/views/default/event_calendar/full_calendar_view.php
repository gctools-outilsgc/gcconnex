<?php

elgg_require_js('event_calendar/fullcalendar');
elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_require_js('event_calendar/event_calendar_fullcalendar');

$timeformat = elgg_get_plugin_setting('timeformat', 'event_calendar') == 24 ? 'H(:mm)' : 'h(:mm)t';
$startdate = date('n', strtotime($vars['start_date'])) - 1;
$filter = $vars['filter'];
$groupguid = $vars['group_guid'];
$region = $vars['region'];

echo "<div id='calendar' data-timeformat='" . $timeformat . "' data-startdate='" . $startdate . "' data-filter='" . $filter . "' data-groupguid='" . $groupguid . "' data-region='" . $region . "'></div>";
echo elgg_view('input/hidden', array('id' => 'event-calendar-selected-date'));