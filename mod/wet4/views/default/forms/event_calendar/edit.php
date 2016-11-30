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
	$('#teleconference_radio').each(function(){
		if ($(this).is(':checked')) {
			$('#infoConference').css('display', 'block');
		} else {
			$('#infoConference').css('display', 'none');
		}
	});

	$('#teleconference_radio').live('change', function(){
	    if ( $(this).is(':checked') ) {
	         $('#infoConference').show("slow");
	    } else {
	         $('#infoConference').hide("hide");
	    }
	});

	$('#contact_checkbox').each(function(){
	    if ($(this).is(':checked')) {
	        $('#infoContact').css('display', 'block');
	    } else {
	        $('#infoContact').css('display', 'none');
	    }
	});

	$('#contact_checkbox').live('change', function(){
	    if ( $(this).is(':checked') ) {
	         $('#infoContact').show("slow");
	    } else {
	         $('#infoContact').hide("hide");
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

$language_options = array(
	elgg_echo('Français'),
	elgg_echo('English'),
	elgg_echo('Bilingue'),
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
	'long_description','long_description2', 'spots', 'personal_manage', 'teleconference_text', 'calendar_additional');

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
$language = $fd['language'];
$brief_description = $fd['description'];
$venue = $fd['venue'];
$teleconference_text = $fd['teleconference'];
$teleconference_radio = $fd['teleconference_radio'];
$calendar_additional = $fd['calendar_additional'];
$calendar_additional2 = $fd['calendar_additional2'];
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
$contact_phone = $fd['contact_phone'];
$contact_email = $fd['contact_email'];
$organiser = $fd['organiser'];
$event_tags = $fd['tags'];
$all_day = $fd['all_day'];
$schedule_type = $fd['schedule_type'];
$long_description = $fd['long_description'];
$long_description2 = $fd['long_description2'];
$room = $fd['room'];

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
$body .= elgg_view("input/text", array('name' => 'title', 'value' => $title, 'id' => 'calendar-title', 'class' => 'form-control'));
$body .= '</div>';
$body .= '<p class="wb-inv">'.$prefix['title'].elgg_echo('event_calendar:title_description').'</p>';
//French
$body .= '<div class="form-group fr"><label for="calendar-title2" class="required">'.elgg_echo("event_calendar:title_label2").'</label>';
$body .= elgg_view("input/text", array('name' => 'title2', 'value' => $title2, 'id' => 'calendar-title2', 'class' => 'form-control'));
$body .= '</div>';
$body .= '<p class="wb-inv">'.$prefix['title2'].elgg_echo('event_calendar:title_description').'</p>';

$body .= '<p><div style ="display: inline-block; margin-right: 5%;"><label for="calendar-venue" class="required">'.elgg_echo("event_calendar:venue_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'venue', 'id' => 'calendar-venue', 'value' => $venue));
$body .= '<p class="wb-inv">'.$prefix['venue'].elgg_echo('event_calendar:venue_description').'</p></div>';

$body .= '<div style ="display: inline-block;"><label for="calendar-room">'.elgg_echo("event_calendar:room_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'room', 'id' => 'calendar-room', 'value' => $room));
$body .= '<p class="wb-inv">'.$prefix['room'].elgg_echo('event_calendar:room_description').'</p></div></p>';


//brief description
/*$briefmaxlength = 350;					// Maximum length for brief description character count
$shortname = 'briefdescription';

	$line_break = ($valtype == "longtext") ? "" : "<br />";
	$label = elgg_echo("groups:{$shortname}");

					// Brief description with character limit, count

					// Brief description with character limit, count
		$label .= elgg_echo('groups:brief:charcount') . "0/" . $briefmaxlength;	// additional text for max length
		$input = elgg_view("input/text", array(
			'name' => 'description',
            'id' => 'calendar-description',
			'value' => $brief_description,
			'maxlength' => $briefmaxlength,
			'onkeyup' => "document.getElementById('briefdescr-lbl').innerHTML = '" . elgg_echo("groups:{$shortname}") . elgg_echo('groups:brief:charcount') . " ' + this.value.length + '/" . $briefmaxlength . "';"
		));


			// Brief description with character limit, count
        $body .= "<div><label id='briefdescr-lbl' for='calendar-description'>{$label}</label>{$line_break}{$input}</div>";
	*/

/*$body .= '<p><label for="calendar-description">'.elgg_echo("event_calendar:brief_description_label").'</label>';
$body .= elgg_view("input/text", array('name' => 'description', 'id' => 'calendar-description', 'value' => $brief_description));
$body .= '</p>';
$body .= '<p class="wb-inv">'.$prefix['brief_description'].elgg_echo('event_calendar:brief_description_description').'</p>';*/

$body .= '<div class="event-calendar-edit-form-block">';
$body .= '<h2>'.elgg_echo('event_calendar:schedule:header').'</h2>';
$body .= '<ul class="elgg-input-radios elgg-vertical event-calendar-edit-schedule-type list-unstyled">';




foreach($schedule_options as $label => $key) {
  if ($key == $schedule_type) {
    $checked = "checked \"checked\"";
  } else {

    $checked = '';
  }


 /*  if ($key == 'all_day') {
   $body .= '<div class="event-calendar-edit-all-day-date-wrapper">';
    $body .= '</p><p id="event-calendar-to-time-wrapper"><label>'.elgg_echo('event_calendar:from_label').'</label>';
    $body .= elgg_view("event_calendar/input/date_local",array(
		'autocomplete' => 'off',
		'class' => 'event-calendar-compressed-date',
		'name' => 'start_date',
		'value' => $fd['start_date']));

		$body .= '<p><label>'.elgg_echo("event_calendar:end_date_label").'<br />';
		$body .= elgg_view("event_calendar/input/date_local",array('timestamp'=>TRUE,'autocomplete'=>'off','name' => 'end_date','value'=>$end_date));
		$body .= '</label></p>';
    $body .= '</div>';

  }*/


  $body .= '<input type="checkbox" name="schedule_type" id="all_day" class="elgg-input-radio " value="'.$key.'" '.$checked.' />';
$body .= '<label for="all_day" class="mrgn-lft-sm">'.$label.'</label>';

}
$vars['choix'] = $key;
$vars['prefix'] = $prefix;
//$body .= $key;
$body .= '<div style="float:left">';
$body .= elgg_view('event_calendar/schedule_section', $vars);
$body .= '</div></ul>';


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
		$body .= '<div class="en"><br><p><label for="long_description" style="float:left; width:225px;">'.elgg_echo("event_calendar:long_description_label").'</label>';
		$body .= '<textarea rows="10" cols="80" id="long_description" name="long_description">'.$long_description.'</textarea>';
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['long_description'].elgg_echo('event_calendar:long_description_description').'</p></div>';
	//French
		$body .= '<div class="fr"><br><p><label for="long_description2" style="float:left; width:225px;">'.elgg_echo("event_calendar:long_description_label2").'</label>';
		$body .= '<textarea rows="10" cols="80" id="long_description2" name="long_description2">'.$long_description2.'</textarea>';
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['long_description2'].elgg_echo('event_calendar:long_description_description').'</p></div>';
}

/*$teleconference_options = array(
	elgg_echo("option:no") => 'no',
	elgg_echo("option:yes") => 'yes',
);*/
$body .= '<p><label>'.elgg_echo("event_calendar:meeting").'</label><br/>';
	$body .= '<div class="event-calendar-edit-form-block event-calendar-edit-form-membership-block">';
	//$body .= elgg_view("input/radio", array('name' => 'teleconference_radio',  'value' => $teleconference_radio, 'options' => $teleconference_options));
	$body .= '<p>';
	if ($fd['teleconference_radio'] == 1) {
		$body .= elgg_view('input/checkbox', array('name' => 'teleconference_radio', 'id' => 'teleconference_radio', 'value' => 1, 'checked' => 'checked'));
	} else {
		$body .= elgg_view('input/checkbox', array('name' => 'teleconference_radio', 'id' => 'teleconference_radio', 'value' => 1));
	}
	$body .= '<label for="teleconference_radio">'.elgg_echo('event_calendar:web_conference_label').'</label>';
	$body .= '</p>';

	$body .= '</div>';

	$body .= '</p>';
	$body .= '<p class="wb-inv">'.$prefix['brief_description'].elgg_echo('event_calendar:brief_description_description').'</p>';

 $body .= '<p id="infoConference" class="list-unstyled" >';

 $body .= '<label for="teleconference_text">URL</label><br/>';
 $body .= elgg_view("input/text", array('name' => 'teleconference_text', 'id' => 'teleconference_text', 'class' => 'form-control', 'value' => $teleconference_text));

 //English
$body .='<span class="en">';
 $body .= '<label for="calendar-additional">'.elgg_echo('event_calendar:info').'</label><br/>';
 $body .= elgg_view("input/textarea", array('name' => 'calendar_additional', 'value' => $calendar_additional, 'id' => 'calendar_additional', 'class' => 'form-control'));
  $body .= '</span>';

//French
 $body .= '<span class="fr">';
 $body .= '<label for="calendar-additional2">'.elgg_echo('event_calendar:info2').'</label><br/>';
 $body .= elgg_view("input/textarea", array('name' => 'calendar_additional2', 'value' => $calendar_additional2, 'id' => 'calendar_additional2', 'class' => 'form-control'));
 $body .= '</span>';

$body .= '</p>';
if ($event_calendar_fewer_fields != 'yes') {
		$body .= '<p><label for="fees">'.elgg_echo("event_calendar:fees_label").'</label>';
		$body .= elgg_view("input/text", array('name' => 'fees', 'id'=>'fees', 'value' => $fees));
		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['fees'].elgg_echo('event_calendar:fees_description').'</p>';
}
$body .= '<p><label for="calendar-language">'.elgg_echo("event_calendar:language").'</label>';
$body .= elgg_view("input/select", array('name' => 'language', 'id'=>'calendar-language', 'value' => $language, 'options' => $language_options));
$body .='</p>';

$body .= '<p><label for="calendar-tags">'.elgg_echo("event_calendar:event_tags_label").'</label>';
$body .= elgg_view("input/tags", array('name' => 'tags', 'id' => 'calendar-tags', 'value' => $event_tags));
$body .= '</p>';
$body .= '<p class="wb-inv">'.$prefix['event_tags'].elgg_echo('event_calendar:event_tags_description').'</p>';
if ($event_calendar_fewer_fields != 'yes') {


		$body .= '<p><div class="event-calendar-edit-form-block event-calendar-edit-form-membership-block">';
		//$body .= elgg_view("input/radio", array('name' => 'teleconference_radio',  'value' => $teleconference_radio, 'options' => $teleconference_options));
		$body .= '<p>';
		if ($fd['contact_checkbox'] == 1) {
		$body .= elgg_view('input/checkbox', array('name' => 'contact_checkbox', 'id' => 'contact_checkbox', 'value' => 1, 'checked' => 'checked'));
		} else {
		$body .= elgg_view('input/checkbox', array('name' => 'contact_checkbox', 'id' => 'contact_checkbox', 'value' => 1));
		}
		$body .= '<label for="contact_checkbox">'.elgg_echo('Vous n\'êtes pas la personne contact?').'</lable>';
		$body .= '</p>';

		$body .= '</div><div id="infoContact" class="list-unstyled">';
		$body .= '<p><label for="contact">'.elgg_echo("event_calendar:contact_label").'</label>';

		if (empty($contact)){
			$body .= elgg_view("input/text", array('id' => 'contact','name' => 'contact','class' => 'event-calendar-medium-text', 'value' => $login_name));
		}else{

	$body .= elgg_view("input/text", array('id' => 'contact','name' => 'contact','class' => 'event-calendar-medium-text', 'value' => $contact));
}

		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['contact'].elgg_echo('event_calendar:contact_description').'</p>';

		$body .= '<p><label for="contact_email">'.elgg_echo("event_calendar:email").'</label>';

		if (empty($contact_email)){

	$body .= elgg_view("input/text", array('id' => 'contact_email', 'name' => 'contact_email', 'value' => $login_email));
}else{

	$body .= elgg_view("input/text", array('id' => 'contact_email', 'name' => 'contact_email', 'value' => $contact_email));
}

		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['organiser'].elgg_echo('event_calendar:organiser_description').'</p>';

		$body .= '<p><label for="contact_phone">'.elgg_echo("event_calendar:phone").'</label>';

if (empty($contact_phone)){

	$body .= elgg_view("input/text", array('id' => 'contact_phone', 'name' => 'contact_phone', 'value' => $login_phone));
}else{

	$body .= elgg_view("input/text", array('id' => 'contact_phone', 'name' => 'contact_phone', 'value' => $contact_phone));
}

		$body .= '</p>';
		$body .= '<p class="event-calendar-description">'.$prefix['organiser'].elgg_echo('event_calendar:organiser_description').'</p></div>';
}






//print_r($vars['group_guid']);
/*if ($event || !$vars['group_guid']) {
	$body .= '<p><label for="calendar-group">'.elgg_echo("event_calendar:calendar_label").'</label>';
	$body .= elgg_view('event_calendar/container', array('id' => 'calendar-group', 'name' => 'group_guid', 'container_guid' => $vars['group_guid'], 'value' => $fd['group_guid']));
	$body .= '</p>';
	$body .= '<p class="wb-inv">'.$prefix['calendar'].elgg_echo('event_calendar:calendar_description').'</p>';
} else {*/
	$body .= elgg_view('input/hidden', array('name' => 'group_guid', 'id' => 'calendar-group', 'value' => $vars['group_guid']));
//}

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
