<?php

$event = $vars['event'];
$fd = $vars['form_data'];

$schedule_options = array(
	elgg_echo('event_calendar:all_day_label') => 'all_day',
	elgg_echo('event_calendar:schedule_type:fixed') => 'fixed',
);

if (elgg_is_active_plugin('event_poll')) {
	$schedule_options = array_merge(array(elgg_echo('event_calendar:schedule_type:poll') => 'poll'), $schedule_options);
}

$event_calendar_fewer_fields = elgg_get_plugin_setting('fewer_fields', 'event_calendar');
$event_calendar_repeating_events = elgg_get_plugin_setting('repeating_events', 'event_calendar');

$event_calendar_region_display = elgg_get_plugin_setting('region_display', 'event_calendar');
$event_calendar_type_display = elgg_get_plugin_setting('type_display', 'event_calendar');
$event_calendar_spots_display = elgg_get_plugin_setting('spots_display', 'event_calendar');

$event_calendar_more_required = elgg_get_plugin_setting('more_required', 'event_calendar');
$event_calendar_bbb_server_url = elgg_get_plugin_setting('bbb_server_url', 'event_calendar');

if ($event_calendar_more_required == 'yes') {
	$required_fields = array('title', 'venue', 'start_date', 'start_time',
		'brief_description', 'region', 'event_type', 'fees', 'contact','organiser',
		'event_tags', 'spots');
} else {
	$required_fields = array('title', 'venue', 'start_date');
}
$all_fields = array('title', 'venue', 'start_time', 'start_date', 'end_time', 'end_date',
	'brief_description', 'region', 'event_type', 'fees', 'contact', 'organiser', 'event_tags',
	'long_description', 'spots', 'personal_manage');

$prefix = array();
foreach ($all_fields as $fn) {
	if (in_array($fn, $required_fields)) {
		$prefix[$fn] = elgg_echo('event_calendar:required').' ';
	} else {
		$prefix[$fn] = elgg_echo('event_calendar:optional').' ';
	}
}

if ($event) {
	$event_action = 'manage_event';
	$event_guid = $event->guid;
} else {
	$event_action = 'add_event';
	$event_guid = 0;
}

$title = $fd['title'];
$brief_description = $fd['description'];
$venue = $fd['venue'];

$fees = $fd['fees'];
if ($event_calendar_spots_display) {
	$spots = $fd['spots'];
}
if ($event_calendar_region_display) {
	$region = $fd['region'];
}
if ($event_calendar_type_display) {
	$event_type = $fd['event_type'];
}
$contact = $fd['contact'];
$organiser = $fd['organiser'];
$event_tags = $fd['tags'];
$all_day = $fd['all_day'];
$schedule_type = $fd['schedule_type'];
$long_description = $fd['long_description'];

$body = '<div class="event-calendar-edit-form">';

$body .= elgg_view('input/hidden', array('name' => 'event_action', 'value' => $event_action));
$body .= elgg_view('input/hidden', array('name' => 'event_guid', 'value' => $event_guid));

$body .= '<div class="event-calendar-edit-form-block">';

$body .= '<div class="form-group"><label for="calendar-title">'.elgg_echo("event_calendar:title_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'title', 'value' => $title, 'id' => 'calendar-title', 'class' => 'form-control'));
$body .= '</div>';
$body .= '<p class="event-calendar-description">'.$prefix['title'].elgg_echo('event_calendar:title_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:venue_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'venue', 'value' => $venue));
$body .= '</p>';
$body .= '<p class="event-calendar-description">'.$prefix['venue'].elgg_echo('event_calendar:venue_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:brief_description_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'description', 'value' => $brief_description));
$body .= '</p>';
$body .= '<p class="event-calendar-description">'.$prefix['brief_description'].elgg_echo('event_calendar:brief_description_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:event_tags_label").'</label>';
$body .= elgg_view("input/tags", array('name' => 'tags', 'value' => $event_tags));
$body .= '</p>';
$body .= '<p class="event-calendar-description">'.$prefix['event_tags'].elgg_echo('event_calendar:event_tags_description').'</p>';

if ($event || !$vars['group_guid']) {
	$body .= '<p><label>'.elgg_echo("event_calendar:calendar_label").'</label>';
	$body .= elgg_view('event_calendar/container', array('container_guid' => $vars['group_guid']));
	$body .= '</p>';
	$body .= '<p class="event-calendar-description">'.$prefix['calendar'].elgg_echo('event_calendar:calendar_description').'</p>';
} else {
	$body .= elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $vars['group_guid']));
}

if($event_calendar_bbb_server_url) {
	$body .= '<p>';
	if ($fd['web_conference']) {
		$body .= elgg_view('input/checkbox', array('name' => 'web_conference', 'value' => 1, 'checked' => 'checked'));
	} else {
		$body .= elgg_view('input/checkbox', array('name' => 'web_conference', 'value' => 1));
	}
	$body .= elgg_echo('event_calendar:web_conference_label');
	$body .= '</p>';
}

$body .= '</div>';

$body .= '<div class="event-calendar-edit-form-block">';
$body .= '<h2>'.elgg_echo('event_calendar:schedule:header').'</h2>';
$body .= '<ul class="elgg-input-radios elgg-vertical event-calendar-edit-schedule-type">';
foreach($schedule_options as $label => $key) {
  if ($key == $schedule_type) {
    $checked = "checked \"checked\"";
  } else {
    $checked = '';
  }
  $body .= '<li><label><input type="radio" name="schedule_type" class="elgg-input-radio" value="'.$key.'" '.$checked.' />';
  $body .= $label . '</label></li>';
  if ($key == 'all_day') {
    $body .= '<div class="event-calendar-edit-all-day-date-wrapper">';
    $body .= elgg_view("event_calendar/input/date_local",array(
		'autocomplete' => 'off',
		'class' => 'event-calendar-compressed-date',
		'name' => 'start_date_for_all_day',
		'value' => $fd['start_date']));
    $body .= '</div>';
  }
}
$body .= '</ul>';

$vars['prefix'] = $prefix;

$body .= elgg_view('event_calendar/schedule_section', $vars);

if ($event_calendar_spots_display == 'yes') {
	$body .= '<br><p><label>'.elgg_echo("event_calendar:spots_label").'</label>';
	$body .= elgg_view("input/text", array('name' => 'spots', 'value' => $spots));
	$body .= '</p>';
	$body .= '<p class="event-calendar-description">'.$prefix['spots'].elgg_echo('event_calendar:spots_description').'</p>';
}

$body .= '<div class="event-calendar-edit-bottom"></div>';
$body .= '</div>';

$body .= elgg_view('event_calendar/personal_manage_section', $vars);

$body .= elgg_view('event_calendar/share_section', $vars);

if ($event_calendar_region_display == 'yes' || $event_calendar_type_display == 'yes' || $event_calendar_fewer_fields != 'yes') {
	$body .= '<div class="event-calendar-edit-form-block event-calendar-edit-form-other-block">';

	if ($event_calendar_region_display == 'yes') {
		$region_list = trim(elgg_get_plugin_setting('region_list', 'event_calendar'));
		$region_list_handles = elgg_get_plugin_setting('region_list_handles', 'event_calendar');
		// make sure that we are using Unix line endings
		$region_list = str_replace("\r\n","\n", $region_list);
		$region_list = str_replace("\r","\n", $region_list);
		if ($region_list) {
			$options = array();
			$options[] = '-';
			foreach(explode("\n", $region_list) as $region_item) {
				$region_item = trim($region_item);
				if ($region_list_handles == 'yes') {
					$options[$region_item] = elgg_echo('event_calendar:region:'.$region_item);
				} else {
					$options[$region_item] = $region_item;
				}
			}
			$body .= '<p><label>'.elgg_echo("event_calendar:region_label").'</label>';
			$body .= elgg_view("input/dropdown", array('name' => 'region', 'value' => $region, 'options_values' => $options));
			$body .= '</p>';
			$body .= '<p class="event-calendar-description">'.$prefix['region'].elgg_echo('event_calendar:region_description').'</p>';
		}
	}

	if ($event_calendar_type_display == 'yes') {
		$type_list = trim(elgg_get_plugin_setting('type_list', 'event_calendar'));
		$type_list_handles = elgg_get_plugin_setting('type_list_handles', 'event_calendar');

		// make sure that we are using Unix line endings
		$type_list = str_replace("\r\n", "\n", $type_list);
		$type_list = str_replace("\r", "\n", $type_list);

		if ($type_list) {
			$options = array();
			$options[] = '-';

			foreach (explode("\n", $type_list) as $type_item) {
				$type_item = explode('|', $type_item);
				$type_name = trim($type_item[0]);

				if ($type_list_handles == 'yes') {
					// Use translation system to resolve the type names
					$options[$type_name] = elgg_echo("event_calendar:type:$type_name");
				} else {
					$options[$type_name] = $type_name;
				}
			}

			$body .= '<p><label>'.elgg_echo("event_calendar:type_label").'</label>';
			$body .= elgg_view("input/dropdown", array(
				'name' => 'event_type',
				'value' => $event_type,
				'options_values' => $options
			));
			$body .= '</p>';
			$body .= '<p class="event-calendar-description">'.$prefix['event_type'].elgg_echo('event_calendar:type_description').'</p>';
		}
	}

	if ($event_calendar_fewer_fields != 'yes') {

		$body .= '<p><label>'.elgg_echo("event_calendar:fees_label").'</label>';
		$body .= elgg_view("input/text", array('name' => 'fees', 'value' => $fees));
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['fees'].elgg_echo('event_calendar:fees_description').'</p>';

		$body .= '<p><label>'.elgg_echo("event_calendar:contact_label").'</label>';
		$body .= elgg_view("input/text", array('name' => 'contact','class' => 'event-calendar-medium-text', 'value' => $contact));
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['contact'].elgg_echo('event_calendar:contact_description').'</p>';

		$body .= '<p><label>'.elgg_echo("event_calendar:organiser_label").'</label>';
		$body .= elgg_view("input/text", array('name' => 'organiser', 'value' => $organiser));
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['organiser'].elgg_echo('event_calendar:organiser_description').'</p>';

		$body .= '<br><p><label style="float:left; width:200px;">'.elgg_echo("event_calendar:long_description_label").'</label>';
		$body .= elgg_view("input/longtext", array('name' => 'long_description', 'value' => $long_description));
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['long_description'].elgg_echo('event_calendar:long_description_description').'</p>';
	}

	$body .= '</div>';
}

$body .= '<br>'.elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('event_calendar:submit'), 'class' => 'btn btn-primary'));

$body .= '</div>';

echo $body;
