<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Name and value of the dropdown box which called this view.
 * The dropdown name indicates which row is being modified.
 */
$dropdown_name = $vars['caller_name'];
$dropdown_value = $vars['caller_value'];
$second = $vars['caller_second'];
$all_values = $vars['all_values'];
$test_value = $all_values['value_answer'];
$reading = $vars['reading'];
$writing = $vars['writing'];
$oral = $vars['oral'];
$operand = htmlspecialchars_decode($vars['operand']);
$day = $vars['day'];

$content = '';
$array_sec = mm_echo_explode_setting_string(elgg_get_plugin_setting('security_string', 'missions'));
$array_lang = explode(',', elgg_get_plugin_setting('language_string', 'missions'));
$array_day = mm_echo_explode_setting_string(elgg_get_plugin_setting('day_string', 'missions'));
$array_hour = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
$array_min = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
$array_duration = explode(',', elgg_get_plugin_setting('duration_string', 'missions'));


// Builds input field content depending on what type the user selected.
// This handles input fields for mission and candidate searching.
if($second == 'true') {
	// This section handles second javascript type selection.
    switch ($dropdown_value) {
        case elgg_echo('missions:publication_date'):
        case elgg_echo('missions:end_year'):
            $content .= '<div>' . elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_operand',
                'value' => '=',
                'options' => array('=', '>=', '<=')
            )) . '</div>';
            
            $content .= '<div>' . elgg_view('input/date', array(
            		'name' => $dropdown_name . '_value',
            		'value' => ''
            )) . '</div>';
            break;
            
        default:
            $content .= elgg_view('input/text', array(
                'name' => $dropdown_name . '_value',
                'value' => ''
            ));
            break;
    }
}
else {
	// This section handles first javascript type selection.
    switch ($dropdown_value) {
        case '':
            break;
        
        /*case 'missions:user_department':
        	
        	break;*/
            
        case elgg_echo('missions:portfolio'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => '',
                'options' => array('', elgg_echo('missions:title'), /*elgg_echo('missions:publication_date')*/),
                'onchange' => 'element_switch(this)'
            ));
            break;
            
        case elgg_echo('missions:education'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => '',
                'options' => array('', elgg_echo('missions:title'), elgg_echo('missions:degree'), elgg_echo('missions:field'), elgg_echo('missions:end_year')),
                'onchange' => 'element_switch(this)'
            ));
            break;
            
        case elgg_echo('missions:experience'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => '',
                'options' => array('', elgg_echo('missions:title'), elgg_echo('missions:organization'), elgg_echo('missions:end_year')),
                'onchange' => 'element_switch(this)'
            ));
            break;
        
        case elgg_echo('missions:duration'):
        case elgg_echo('missions:start_time'):
        	$content .= elgg_view('input/dropdown', array(
        			'name' => $dropdown_name . '_operand',
        			'value' => htmlspecialchars_decode($all_values['operand']),
        			'options' => array('=', '>=', '<='),
        			'style' => 'display:inline-block'
        	));
        	
            $content .= elgg_view('input/text', array(
                	'name' => $dropdown_name . '_element',
                	'value' => $all_values['value_answer'],
                	'placeholder' => 'HH:mm',
        			'style' => 'display:inline-block'
            ));
            
            $content .= elgg_view('input/dropdown', array(
            		'name' => $dropdown_name . '_element_day',
            		'value' => $all_values['day'],
            		'options' => $array_day
            ));
            break;
            
        case elgg_echo('missions:time'):
        	$content .= elgg_view('input/dropdown', array(
        			'name' => $dropdown_name . '_operand',
        			'value' => htmlspecialchars_decode($all_values['operand']),
        			'options' => array('=', '>=', '<='),
        			'style' => 'display:inline-block'
        	));
        	 
        	$content .= elgg_view('input/text', array(
        			'name' => $dropdown_name . '_element',
        			'value' => $all_values['value_answer'],
        			'style' => 'display:inline-block'
        	));
        	break;
        	
        case elgg_echo('missions:period'):
        	$content .= elgg_view('input/dropdown', array(
        			'name' => $dropdown_name . '_element',
        			'value' => $all_values['value_answer'],
        			'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('time_rate_string', 'missions'))
        	));
        	break;
        
        case elgg_echo('missions:language'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => $all_values['value_answer'],
                'options' => array( elgg_echo('missions:english'),elgg_echo('missions:french'))
            ));
            $content .= '<br>';
            
            $content .= '<div class="col-sm-6">' . elgg_echo('missions:reading') . ':</div>';
            $content .= '<div class="col-sm-6">' . elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_lwc',
                'value' => $all_values['reading'],
                'options_values' => $array_lang
            )) . '</div>';
            
            $content .= '<div class="col-sm-6">' . elgg_echo('missions:writing') . ':</div>';
            $content .= '<div class="col-sm-6">' . elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_lwe',
                'value' => $all_values['writing'],
                'options_values' => $array_lang
            )) . '</div>';
            
            $content .= '<div class="col-sm-6">' . elgg_echo('missions:oral') . ':</div>';
            $content .= '<div class="col-sm-6">' . elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_lop',
                'value' => $all_values['oral'],
                'options_values' => $array_lang
            )) . '</div>';
            break;
        
        case elgg_echo('missions:security_clearance'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => $all_values['value_answer'],
                'options_values' => $array_sec
            ));
            break;
            
        case elgg_echo('missions:type'):
        	$content .= elgg_view('input/dropdown', array(
        			'name' => $dropdown_name . '_element',
        			'value' => '',
        			'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('opportunity_type_string', 'missions'))
        	));
        	break;
            
        case elgg_echo('missions:program_area'):
        	$content .= elgg_view('input/dropdown', array(
        			'name' => $dropdown_name . '_element',
        			'value' => $all_values['value_answer'],
        			'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('program_area_string', 'missions'))
        	));
        	break;
            
        case elgg_echo('missions:work_remotely'):
        if ($all_values['value_answer'] == 'on')
            $checked = 'checked';
        
        	$content .= elgg_view('input/checkbox', array(
        			'name' => $dropdown_name . '_element',
                    'checked' => $checked
        	));
        	break;
            
        case elgg_echo('missions:location'):
        	$content .= elgg_view('input/dropdown', array(
        			'name' => $dropdown_name . '_element',
				    'value' => $all_values['value_answer'],
				    'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('province_string', 'missions')),
        	));
        	break;
            
        case elgg_echo('missions:skill'):
        case elgg_echo('missions:key_skills'):
        	$content .= elgg_view('missions/add-skill', array(
        			'name_override' => $dropdown_name . '_element',
        			'no_delete' => true,
                    'value' => $all_values['value_answer'],
        	));
        	break;
        
        default:

            $content .= elgg_view('input/text', array(
                'name' => $dropdown_name . '_element',
                'value' => $all_values['value_answer'],
            ));
    }
}

echo $content;