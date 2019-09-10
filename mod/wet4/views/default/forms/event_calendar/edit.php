<?php
/*
* GC_MODIFICATION
* Description: Added accessible labels + content translation support
* Author: GCTools Team
*/
?>
<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>

<script>

$(document).ready(function () {
	$("input[name=submit]").click(function(){//if no title in english, copy the french one
	   	if( !$("input[name=title]").val() ){
			$("input[name=title]").val($("input[name=title2]").val());
	  	}
	});

});

</script>
<?php

$event = $vars['event'];
$fd = $vars['form_data'];

$schedule_options = array(
	elgg_echo('event_calendar:all_day_label') => 'all_day',
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
		'region', 'event_type','organiser',
		'event_tags', 'spots');
} else {
	$required_fields = array('title', 'venue', 'start_date');
}
$all_fields = array('title', 'venue', 'start_time', 'start_date', 'end_time', 'end_date',
	'region', 'event_type', 'organiser', 'event_tags',
	'description','description2', 'spots', 'personal_manage', 'calendar_additional');

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

	// cyu
	$new_entity = false;

} else {
	$event_action = 'add_event';
	$event_guid = 0;

	// cyu
	$new_entity = true;
}

$user = elgg_get_logged_in_user_entity();
$login_name = $user->name;
$login_email = $user->email;
$login_phone = $user->phone;


$title = $fd['title'];
$title2 = $fd['title2'];
$venue = $fd['venue'];
$teleconference_text = $fd['teleconference'];
$teleconference_radio = $fd['teleconference_radio'];
$calendar_additional = $fd['calendar_additional'];
$calendar_additional2 = $fd['calendar_additional2'];
if ($event_calendar_spots_display) {
	$spots = $fd['spots'];
}
if ($event_calendar_region_display) {
	$region = $fd['region'];
}
if ($event_calendar_type_display) {
	$event_type = $fd['event_type'];
}
$organiser = $fd['organiser'];
$event_tags = $fd['tags'];
$all_day = $fd['all_day'];
$schedule_type = $fd['schedule_type'];
$description = $fd['description'];
$description2 = $fd['description2'];



// decode json into English / French parts
$json_title = json_decode($fd['title']);
$json_desc = json_decode($fd['description']);
$json_add = json_decode($fd['calendar_additional']);


if ( $json_title ){
  $title2 = $json_title->fr;
  $title = $json_title->en;
}

if ( $json_desc ){
  $description2 = $json_desc->fr;
  $description = $json_desc->en;
}

if ( $json_add ){
  $calendar_additional2 = $json_add->fr;
  $calendar_additional = $json_add->en;
}


$body = '<div class="event-calendar-edit-form">';

$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';

$body .= $btn_language;

$body .= '<div class="tab-content tab-content-border">';

$body .= elgg_view('input/hidden', array('name' => 'event_action', 'value' => $event_action));
$body .= elgg_view('input/hidden', array('name' => 'event_guid', 'value' => $event_guid));

$body .= '<div class="event-calendar-edit-form-block">';
//English
$body .= '<div class="form-group en"><label for="calendar-title" class="required">'.elgg_echo("event_calendar:title_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'title', 'value' => $title, 'id' => 'calendar-title', 'class' => 'form-control', 'required' => 'required'));
$body .= '</div>';
$body .= '<p class="wb-inv">'.$prefix['title'].elgg_echo('event_calendar:title_description').'</p>';
//French
$body .= '<div class="form-group fr"><label for="calendar-title2" class="required">'.elgg_echo("event_calendar:title_label2").'</label>';
$body .= elgg_view("input/text", array('name' => 'title2', 'value' => $title2, 'id' => 'calendar-title2', 'class' => 'form-control', 'required' => 'required'));
$body .= '</div>';
$body .= '<p class="wb-inv">'.$prefix['title2'].elgg_echo('event_calendar:title_description').'</p>';

$body .= '<p><div style ="display: inline-block; margin-right: 5%;"><label for="calendar-venue" class="required">'.elgg_echo("event_calendar:venue_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'venue', 'id' => 'calendar-venue', 'value' => $venue, 'required' => 'required'));
$body .= '<p class="wb-inv">'.$prefix['venue'].elgg_echo('event_calendar:venue_description').'</p></div>';

$body .= '<div class="event-calendar-edit-form-block">';
$body .= '<h2>'.elgg_echo('event_calendar:schedule:header').'</h2>';
$body .= '<ul class="elgg-input-radios elgg-vertical event-calendar-edit-schedule-type list-unstyled">';


foreach($schedule_options as $label => $key) {
  if ($key == $schedule_type) {
    $checked = "checked \"checked\"";
  } else {

    $checked = '';
  }


$body .= '<input type="checkbox" name="schedule_type" id="all_day" class="elgg-input-radio " value="'.$key.'" '.$checked.' />';
$body .= '<label for="all_day" class="mrgn-lft-sm">'.$label.'</label>';

}
$vars['choix'] = $key;
$vars['prefix'] = $prefix;
//$body .= $key;
$body .= '<div style="float:left">';
$body .= elgg_view('event_calendar/schedule_section', $vars);
$body .= '</ul>';


if ($event_calendar_spots_display == 'yes') {
	$body .= '<br><p><label>'.elgg_echo("event_calendar:spots_label").'</label>';
	$body .= elgg_view("input/text", array('name' => 'spots', 'value' => $spots));
	$body .= '</p>';
	$body .= '<p class="event-calendar-description">'.$prefix['spots'].elgg_echo('event_calendar:spots_description').'</p>';
}

$body .= '<div class="event-calendar-edit-bottom"></div>';
$body .= '</div>';

	if ($event_calendar_fewer_fields != 'yes') {

		//English
		$body .= '<div class="en"><br><p><label for="long_description">'.elgg_echo("event_calendar:long_description_label").'</label>';
		$body .= elgg_view("input/longtext", array('name' => 'description', 'id' => 'description', 'value' => $description));
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['long_description'].elgg_echo('event_calendar:long_description_description').'</p></div>';

		//french
		$body .= '<div class="fr"><br><p><label for="long_description2">'.elgg_echo("event_calendar:long_description_label2").'</label>';
		$body .= elgg_view("input/longtext", array('name' => 'description2', 'id' => 'description2', 'value' => $description2));
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['description2'].elgg_echo('event_calendar:long_description_description2').'</p></div>';
}

$body .= '<p><label for="calendar-tags">'.elgg_echo("event_calendar:event_tags_label").'</label>';
$body .= elgg_view("input/tags", array('name' => 'tags', 'id' => 'calendar-tags', 'value' => $event_tags));
$body .= '</p>';

$body .= '<p class="wb-inv">'.$prefix['event_tags'].elgg_echo('event_calendar:event_tags_description').'</p>';
if ($event_calendar_fewer_fields != 'yes') {

		$body .= '<p><div class="event-calendar-edit-form-block event-calendar-edit-form-membership-block">';
		$body .= '<p class="event-calendar-description">'.$prefix['organiser'].elgg_echo('event_calendar:organiser_description').'</p></div>';
}

	$body .= elgg_view('input/hidden', array('name' => 'group_guid', 'id' => 'calendar-group', 'value' => $vars['group_guid']));


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



	$body .= '</div>';
}


if (elgg_is_active_plugin('cp_notifications') && !$new_entity) {
	// cyu - implement "minor edit" as per business requirements document
	$body .= '<div>';
	$body .= "<h2>".elgg_echo('cp_notify:minor_edit_header')."</h2>";
	$body .= elgg_view('input/checkboxes', array(
			'name' => 'chk_ec_minor_edit',
			'id' => 'chk_ec_minor_edit',
			'value' => 0,
			'options' => array(
					elgg_echo('cp_notify:minor_edit') => 1),
		));

	$body .= '</div>';
}


$body .= '<br>'.elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('event_calendar:submit'), 'class' => 'btn btn-primary'));

$body .= '</div></div>';

echo $body;


if(get_current_language() == 'fr'){
?>
	<script>
		jQuery('.fr').show();
	    jQuery('.en').hide();
	    jQuery('#btnfr').addClass('active');

	</script>
<?php
}else{
?>
	<script>
		jQuery('.en').show();
    	jQuery('.fr').hide();
    	jQuery('#btnen').addClass('active');
	</script>
<?php
}
?>
<script>
jQuery(function(){

	var selector = '.nav li';

	$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

		jQuery('#btnClickfr').click(function(){
               jQuery('.fr').show();
               jQuery('.en').hide();
        });

          jQuery('#btnClicken').click(function(){
               jQuery('.en').show();
               jQuery('.fr').hide();
        });
});
</script>
