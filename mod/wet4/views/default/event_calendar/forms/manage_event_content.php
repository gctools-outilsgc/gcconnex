<?php
$event = $vars['event'];
$event_id = $vars['event_id'];
$event_calendar_times = get_plugin_setting('times', 'event_calendar');
$event_calendar_region_display = get_plugin_setting('region_display', 'event_calendar');
$event_calendar_type_display = get_plugin_setting('type_display', 'event_calendar');
$event_calendar_spots_display = get_plugin_setting('spots_display', 'event_calendar');
$event_calendar_add_users = get_plugin_setting('add_users', 'event_calendar');
$event_calendar_hide_access = get_plugin_setting('hide_access', 'event_calendar');
$event_calendar_hide_end = get_plugin_setting('hide_end', 'event_calendar');
$event_calendar_more_required = get_plugin_setting('more_required', 'event_calendar');

if ($event_calendar_more_required == 'yes') {
	$required_fields = array('title','venue','start_date','start_time',
		'brief_description','region','event_type','fees','contact','organiser',
		'event_tags','spots');
} else {
	$required_fields = array('title','venue','start_date');
}
$all_fields = array('title','venue','start_time','start_date','end_time','end_date',
	'brief_description','region','event_type','fees','contact','organiser','event_tags',
	'long_description','spots');
$prefix = array();
foreach ($all_fields as $fn) {
	if (in_array($fn,$required_fields)) {
		$prefix[$fn] = elgg_echo('event_calendar:required').' ';
	} else {
		$prefix[$fn] = elgg_echo('event_calendar:optional').' ';
	}
}

if ($event) {
	$title = $event->title;
	$brief_description = $event->description;
	$venue = $event->venue;
	if ($event->form_data) {
		// this is a form redisplay, so take the values as submitted
		$start_date = $event->start_date;
		$end_date = $event->end_date;
	} else {
		// the values are from the database,
		// so convert
		$start_date = date("l, F j, Y",$event->start_date);
		if ($event->end_date) {
			$end_date = date("l, F j, Y",$event->end_date);
		} else {
			$end_date = '';
		}
	}
	
	if ($event_calendar_region_display) {
		$region = $event->region;
		if (!$region) {
			$region = '-';
		}
	}
	
	if ($event_calendar_spots_display) {
		$spots = trim($event->spots);
	}
	if ($event_calendar_type_display) {
		$event_type = $event->event_type;
		if (!$event_type) {
			$event_type = '-';
		}
	}
	$fees = $event->fees;
	$contact = $event->contact;
	$organiser = $event->organiser;
	$event_tags = $event->event_tags;
	$long_description = $event->long_description;
	$access = $event->access_id;
	if ($event_calendar_times == 'yes') {
		$start_time = $event->start_time;
		$end_time = $event->end_time;
	}
	$event_action = 'manage_event';
} else {
	$event_id = 0;
	$title = '';
	$brief_description = '';
	$venue = '';
	$start_date = '';
	$end_date = '';
	$fees = '';
	if ($event_calendar_spots_display) {
		$spots = '';
	}
	if ($event_calendar_region_display) {
		$region = '-';
	}
	if ($event_calendar_type_display) {
		$event_type = '-';
	}
	$contact = '';
	$organiser = '';
	$event_tags = '';
	$long_description = '';
	$access = get_default_access();
	if ($event_calendar_times == 'yes') {
		$start_time = '';
		$end_time = '';
	}
	$event_action = 'add_event';
}
$body = '';

$body .= elgg_view('input/hidden',array('internalname'=>'event_action', 'value'=>$event_action));
$body .= elgg_view('input/hidden',array('internalname'=>'event_id', 'value'=>$event_id));
$body .= elgg_view('input/hidden',array('internalname'=>'group_guid', 'value'=>$vars['group_guid']));

$body .= '<p><label>'.elgg_echo("event_calendar:title_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'title','value'=>$title));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['title'].elgg_echo('event_calendar:title_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:venue_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'venue','value'=>$venue));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['venue'].elgg_echo('event_calendar:venue_description').'</p>';

if ($event_calendar_times != 'no') {
	$body .= '<p><label>'.elgg_echo("event_calendar:start_time_label").'</label><br />';
	$body .= elgg_view("input/timepicker",array('internalname' => 'start_time','value'=>$start_time));
	$body .= '</p>';
	$body .= '<p class="description">'.$prefix['start_time'].elgg_echo('event_calendar:start_time_description').'</p>';
}

$body .= '<p><label>'.elgg_echo("event_calendar:start_date_label").'<br />';
$body .= elgg_view("input/datepicker_popup",array('internalname' => 'start_date','value'=>$start_date));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['start_date'].elgg_echo('event_calendar:start_date_description').'</p>';

if ($event_calendar_hide_end != 'yes') {
	if ($event_calendar_times != 'no') {
		$body .= '<p><label>'.elgg_echo("event_calendar:end_time_label").'</label><br />';
		$body .= elgg_view("input/timepicker",array('internalname' => 'end_time','value'=>$end_time));
		$body .= '</p>';
		$body .= '<p class="description">'.$prefix['end_time'].elgg_echo('event_calendar:end_time_description').'</p>';
	}
	
	$body .= '<p><label>'.elgg_echo("event_calendar:end_date_label").'<br />';
	$body .= elgg_view("input/datepicker_popup",array('internalname' => 'end_date','value'=>$end_date));
	$body .= '</label></p>';
	$body .= '<p class="description">'.$prefix['end_date'].elgg_echo('event_calendar:end_date_description').'</p>';
}

if ($event_calendar_spots_display == 'yes') {
	$body .= '<p><label>'.elgg_echo("event_calendar:spots_label").'<br />';
	$body .= elgg_view("input/text",array('internalname' => 'spots','value'=>$spots));
	$body .= '</label></p>';
	$body .= '<p class="description">'.$prefix['spots'].elgg_echo('event_calendar:spots_description').'</p>';
}

if ($event_calendar_add_users == 'yes') {
	$body .= '<p><label>'.elgg_echo("event_calendar:add_user_label").'<br />';
	$body .= elgg_view("input/adduser",array('internalname' => 'adduser','internalid' => 'do_adduser','width'=> 200, 'minChars'=>2));
	$body .= '</label></p><br /><br />';
	$body .= '<p class="description">'.elgg_echo('event_calendar:add_user_description').'</p>';
}

$body .= '<p><label>'.elgg_echo("event_calendar:brief_description_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'brief_description','value'=>$brief_description));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['brief_description'].elgg_echo('event_calendar:brief_description_description').'</p>';

if ($event_calendar_region_display == 'yes') {
	$region_list = trim(elgg_get_plugin_setting('region_list', 'event_calendar'));
	$region_list_handles = elgg_get_plugin_setting('region_list_handles', 'event_calendar');
	// make sure that we are using Unix line endings
	$region_list = str_replace("\r\n","\n",$region_list);
	$region_list = str_replace("\r","\n",$region_list);
	if ($region_list) {
		$options = array();
		$options[] = '-';
		foreach(explode("\n",$region_list) as $region_item) {
			$region_item = trim($region_item);
			if ($region_list_handles == 'yes') {
				$options[$region_item] = elgg_echo('event_calendar:region:'.$region_item);
			} else {
				$options[$region_item] = $region_item;
			}
		}
		$body .= '<p><label>'.elgg_echo("event_calendar:region_label").'<br />';
		$body .= elgg_view("input/dropdown",array('internalname' => 'region','value'=>$region,'options_values'=>$options));
		$body .= '</label></p>';
		$body .= '<p class="description">'.$prefix['region'].elgg_echo('event_calendar:region_description').'</p>';
	}
}

if ($event_calendar_type_display == 'yes') {
	$type_list = trim(elgg_get_plugin_setting('type_list', 'event_calendar'));
	$type_list_handles = elgg_get_plugin_setting('type_list_handles', 'event_calendar');
	// make sure that we are using Unix line endings
	$type_list = str_replace("\r\n","\n",$type_list);
	$type_list = str_replace("\r","\n",$type_list);
	if ($type_list) {
		$options = array();
		$options[] = '-';
		foreach(explode("\n",$type_list) as $type_item) {
			$type_item = trim($type_item);
			if ($type_list_handles == 'yes') {
				$options[$type_item] = elgg_echo('event_calendar:type:'.$type_item);
			} else {
				$options[$type_item] = $type_item;
			}			
		}
		$body .= '<p><label>'.elgg_echo("event_calendar:type_label").'<br />';
		$body .= elgg_view("input/dropdown",array('internalname' => 'event_type','value'=>$event_type,'options_values'=>$options));
		$body .= '</label></p>';
		$body .= '<p class="description">'.$prefix['event_type'].elgg_echo('event_calendar:type_description').'</p>';
	}
}

$body .= '<p><label>'.elgg_echo("event_calendar:fees_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'fees','value'=>$fees));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['fees'].elgg_echo('event_calendar:fees_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:contact_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'contact','value'=>$contact));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['contact'].elgg_echo('event_calendar:contact_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:organiser_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'organiser','value'=>$organiser));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['organiser'].elgg_echo('event_calendar:organiser_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:event_tags_label").'<br />';
$body .= elgg_view("input/tags",array('internalname' => 'event_tags','value'=>$event_tags));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['event_tags'].elgg_echo('event_calendar:event_tags_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:long_description_label").'<br />';
$body .= elgg_view("input/longtext",array('internalname' => 'long_description','value'=>$long_description));
$body .= '</label></p>';
$body .= '<p class="description">'.$prefix['long_description'].elgg_echo('event_calendar:long_description_description').'</p>';

if($event_calendar_hide_access == 'yes') {
	$event_calendar_default_access = get_plugin_setting('default_access', 'event_calendar');
	if($event_calendar_default_access) {
		$body .= elgg_view("input/hidden",array('internalname' => 'access','value'=>$event_calendar_default_access));
	} else {
		$body .= elgg_view("input/hidden",array('internalname' => 'access','value'=>ACCESS_PRIVATE));
	}
} else {
	$body .= '<p><label>'.elgg_echo("access").'<br />';
	$body .= elgg_view("input/access",array('internalname' => 'access','value'=>$access));
	$body .= '</label></p>';
}

print $body;
?>