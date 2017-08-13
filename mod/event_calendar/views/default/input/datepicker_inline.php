<?php

/**
 * JQuery data picker(inline version)
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

elgg_require_js('event_calendar/datepicker_inline');

if ($vars['group_guid']) {
	$link_bit = elgg_get_site_url()."event_calendar/group/{$vars['group_guid']}/%s/{$vars['mode']}";
} else {
	$link_bit = elgg_get_site_url()."event_calendar/list/%s/{$vars['mode']}/{$vars['filter']}";
}

if ($vars['mode'] == 'week') {
	$selected_week = date('W', strtotime($vars['start_date'].' UTC'))+1;
} else {
	$selected_week = '';
}

if ($vars['mode']) {
	$wrapper_class = "event-calendar-datepicker-inline event-calendar-filter-period-".$vars['mode'];
} else {
	$wrapper_class = "event-calendar-datepicker-inline event-calendar-filter-period-month";
}

echo '<div class="' . $wrapper_class . '" id="' . $vars['name'] . '" style="position:relative;" data-name="' . $vars['name'] . '" data-selectedweek="'. $selected_week .'" data-linkbit="' . $link_bit . '" data-startdate="' . $vars['start_date'] . '" data-enddate="' . $vars['end_date'] . '" data-mode="' . $vars['mode'] . '"></div>';
echo '<p style="clear: both;"></p>';
