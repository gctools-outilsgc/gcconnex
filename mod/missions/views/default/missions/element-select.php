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

 $obj = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => 'dept_list',
            'owner_guid' => 0
        ));

$provinces = array();
if (get_current_language()=='en'){

    $departments = $obj[0]->deptsEn;
    $provinces['pov-alb'] = 'Government of Alberta';
    $provinces['pov-bc'] = 'Government of British Columbia';
    $provinces['pov-man'] = 'Government of Manitoba';
    $provinces['pov-nb'] = 'Government of New Brunswick';
    $provinces['pov-nfl'] = 'Government of Newfoundland and Labrador';
    $provinces['pov-ns'] = 'Government of Nova Scotia';
    $provinces['pov-nwt'] = 'Government of Northwest Territories';
    $provinces['pov-nun'] = 'Government of Nunavut';
    $provinces['pov-ont'] = 'Government of Ontario';
    $provinces['pov-pei'] = 'Government of Prince Edward Island';
    $provinces['pov-que'] = 'Government of Quebec';
    $provinces['pov-sask'] = 'Government of Saskatchewan';
    $provinces['pov-yuk'] = 'Government of Yukon';
}else{
    $departments = $obj[0]->deptsFr;
    $provinces['pov-alb'] = "Gouvernement de l'Alberta";
    $provinces['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
    $provinces['pov-man'] = 'Gouvernement du Manitoba';
    $provinces['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
    $provinces['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
    $provinces['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
    $provinces['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
    $provinces['pov-nun'] = 'Gouvernement du Nunavut';
    $provinces['pov-ont'] = "Gouvernement de l'Ontario";
    $provinces['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
    $provinces['pov-que'] = 'Gouvernement du Québec';
    $provinces['pov-sask'] = 'Gouvernement de Saskatchewan';
    $provinces['pov-yuk'] = 'Gouvernement du Yukon';
}
$departments = json_decode($departments, true);

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

        case elgg_echo('missions:opt_in'):
            $content .= elgg_view('input/dropdown', array(
                    'name' => $dropdown_name . '_element',
                    'value' => '',
                    'options' => array(
                            '',
                            elgg_echo("gcconnex_profile:opt:micro_missionseek"),
                            elgg_echo('gcconnex_profile:opt:micro_mission'),
                            elgg_echo('gcconnex_profile:opt:mentored'),
                            elgg_echo('gcconnex_profile:opt:mentoring'),
                            elgg_echo('gcconnex_profile:opt:job_swap'),
                            elgg_echo('gcconnex_profile:opt:shadowed'),
                            elgg_echo('gcconnex_profile:opt:shadowing'),
                            elgg_echo('gcconnex_profile:opt:assignment_deployment_seek'),
                            elgg_echo('gcconnex_profile:opt:assignment_deployment_create'),
                            elgg_echo('gcconnex_profile:opt:deployment_seek'),
                            elgg_echo('gcconnex_profile:opt:deployment_create'),
                            elgg_echo('gcconnex_profile:opt:job_rotate'),
                            elgg_echo('gcconnex_profile:opt:skill_sharing'),
                            elgg_echo('gcconnex_profile:opt:skill_sharing_create'),
                            elgg_echo('gcconnex_profile:opt:peer_coached'),
                            elgg_echo('gcconnex_profile:opt:peer_coaching'),
                            elgg_echo('gcconnex_profile:opt:job_sharing'),
                    )
            ));
            break;
        
        case elgg_echo('missions:department'):

             $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'id' => 'department',
                'value' => '',
                'class' => 'department_test form-control',
                'options' => array_merge($departments,$provinces),
            ));
        	break;
        
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