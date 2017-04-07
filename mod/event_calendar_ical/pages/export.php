<?php
gatekeeper();

$action_type = get_input('action_type', 'export');
$filter = get_input('filter', 'mine');
$group_guid = get_input('group_guid', false);
$date = get_input('date', date('Y-n-j'));
$interval = get_input('interval', 'month');
$region = get_input('region');

elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

if ($group_guid) {
  $group = get_entity($group_guid);
  // make sure group exists, has calendars enabled, and global group calendars are enabled
  if (!elgg_instanceof($group, 'group')
		  || $group->event_calendar_enable == 'no'
		  || elgg_get_plugin_setting('group_calendar', 'event_calendar') == 'no'
		  ) {
	forward('', '404');
  }
  
  elgg_set_page_owner_guid($group->getGUID());
  
  elgg_push_breadcrumb($group->name, $group->getURL());
  elgg_push_breadcrumb(elgg_echo('item:object:event_calendar'), elgg_get_site_url() . 'event_calendar/group/' . $group->getGUID());
}
else {
  elgg_push_breadcrumb(elgg_echo('item:object:event_calendar'), elgg_get_site_url() . "event_calendar/list/{$date}/{$interval}/{$filter}");
}

elgg_push_breadcrumb(elgg_echo('event_calendar_ical:' . $action_type));

$title = elgg_echo('event_calendar_ical:title:' . $action_type);

$form_vars = array();
if ($action_type == 'import') {
  $form_vars['enctype'] = 'multipart/form-data';
}

$content = elgg_view_form('event_calendar_ical/' . $action_type, $form_vars, array(
	'filter' => $filter,
	'group_guid' => $group_guid,
	'date' => $date,
	'interval' => $interval,
	'region' => $region
));

$layout = elgg_view_layout('content', array(
	'title' => $title,
	'filter' => elgg_view('event_calendar_ical/tabs', array(
		'filter_type' => $action_type,
		'filter' => $filter,
		'group_guid' => $group_guid,
		'date' => $date,
		'interval' => $interval,
		'region' => $region
		)),
	'content' => $content
));

echo elgg_view_page($title, $layout);