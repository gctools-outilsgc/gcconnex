<?php

$fd = $vars['form_data'];
$event_calendar_personal_manage = elgg_get_plugin_setting('personal_manage', 'event_calendar');
$body = '';

if ($event_calendar_personal_manage == 'by_event') {
	$personal_manage_options = array(
		'open' => elgg_echo('event_calendar:personal_manage:by_event:open'),
		'closed' => elgg_echo('event_calendar:personal_manage:by_event:closed'),
		'private' => elgg_echo('event_calendar:personal_manage:by_event:private'),
	);
	$body .= '<div class="event-calendar-edit-form-block event-calendar-edit-form-membership-block">';
	$body .= '<h2>'.elgg_echo('event_calendar:personal_manage:label').'</h2>';
	$body .= elgg_view("input/select", array('name' => 'personal_manage', 'value' => $fd['personal_manage'], 'options_values' => $personal_manage_options, 'class' => 'list-unstyled'));
	$body .= '<br clear="both" />';
	$body .= '</div>';
}

echo $body;
