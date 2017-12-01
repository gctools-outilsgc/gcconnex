<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Handles the call to the database using elgg_get_entities_from_metadata.
 * Sets the resulting array and count of the array to SESSION variables if the count is not 0.
 * Also handles intersecting with any array that currently exists within SESSION.
 */
function mm_search_database_for_missions($query_array, $query_operand, $limit, $mission_state_include_array = ['posted'])
{
    $options = array();
    $mission_count = '';
    $missions = '';
    $filtered_array = array_filter($query_array);
    $dbprefix = elgg_get_config("dbprefix");

    if(empty($filtered_array)) {
        register_error(elgg_echo('missions:error:no_search_values'));
        return false;
    }

    foreach($filtered_array as $key => $array) {
        $filtered_array[$key]['operand'] = htmlspecialchars_decode($array['operand']);
    }

    if ( strcasecmp( $query_operand, 'OR' ) === 0 ){
        $options['type'] = 'object';
        $options['subtype'] = 'mission';
        $options['metadata_name_value_pairs_operator'] = $query_operand;
        $options['metadata_case_sensitive'] = false;
        $options['limit'] = $limit;
        $options['wheres'][] = 'e.owner_guid IN (SELECT guid FROM '.$dbprefix.'users_entity user WHERE user.name LIKE "' . mysql_escape_string($filtered_array[0]['value']) . '")';

        $all_missions = elgg_get_entities_from_metadata($options);
        array_pop($options['wheres']);

        // split the search into separate queries to prevent slowdown from 10+ join queries using 'OR'
        foreach ($filtered_array as $array) {
            $options['metadata_name_value_pairs'] = array($array);
            $some_missions = elgg_get_entities_from_metadata($options);
            $all_missions = array_merge( $all_missions, $some_missions );
        }

        $missions = array();
        foreach ($all_missions as $mission) {
            $missions[$mission->guid] = $mission;
        }
        // Filter opportunities based on their state.  Inclusive.
        // WHY: We may only want to search for archived or open opportunities which have different states.
        foreach($missions as $key => $mission) {
            $include_opportunity = false;
            foreach ($mission_state_include_array as $include_state) {
                if ($mission->state == $include_state) {
                    $include_opportunity = true;
                    last;
                }
            }
            if ($include_opportunity == false) {
                unset($missions[$key]);
            }
        }
    }
    else {
        // Setting options with which the query will be built.
        $options['type'] = 'object';
        $options['subtype'] = 'mission';
        $options['metadata_name_value_pairs'] = $filtered_array;
        $options['metadata_name_value_pairs_operator'] = $query_operand;
        $options['metadata_case_sensitive'] = false;
        $options['limit'] = $limit;
        $missions = elgg_get_entities_from_metadata($options);

        foreach($missions as $key => $mission) {
            if($mission->state != 'posted') {
                unset($missions[$key]);
            }
        }
    }

    $mission_count = count($missions);
    if ($mission_count == 0) {
        register_error(elgg_echo('missions:error:entity_does_not_exist'));
        return false;
    } else {
        $_SESSION['mission_count'] = $mission_count;
        $_SESSION['mission_search_set'] = $missions;
        $_SESSION['mission_search_set_timestamp'] = time();

        return true;
    }
}

/*
 * Small function to compare missions according to their guid.
 */
function mm_compare_guid($a, $b)
{
    if ($a->guid == $b->guid) {
        return 0;
    }
    if ($a->guid > $b->guid) {
        return 1;
    }
    return - 1;
}

/*
 * Analyzes the selection values and selection element values in order to construct a WHERE statement.
 * This is for when Javascript is enabled.
 */
function mm_analyze_advanced_search_element($place, $array)
{
    $form_name = $_SESSION['mission_search_switch'];
    $returner = array();

    switch(trim($array[$form_name.'_'.$place])) {
        // Returns an empty array if
        case '':
            break;

        case elgg_echo('missions:user_department'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'department';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array[$form_name.'_'.$place.'_element'].'%';
            }
            break;

        case elgg_echo('missions:opt_in'):
            if(trim($array[$form_name.'_'.$place.'_element']) != '') {
                $name_option = '';
                switch($array[$form_name.'_'.$place.'_element']) {
                    case elgg_echo('gcconnex_profile:opt:micro_missionseek'):
                        $name_option = 'opt_in_missions';
                        break;
                    case elgg_echo('gcconnex_profile:opt:micro_mission'):
                        $name_option = 'opt_in_missionCreate';
                        break;
                    case elgg_echo('gcconnex_profile:opt:assignment_deployment_seek'):
                        $name_option = 'opt_in_assignSeek';
                        break;
                    case elgg_echo('gcconnex_profile:opt:assignment_deployment_create'):
                        $name_option = 'opt_in_assignCreate';
                        break;
                    case elgg_echo('gcconnex_profile:opt:deployment_seek'):
                        $name_option = 'opt_in_deploySeek';
                        break;
                    case elgg_echo('gcconnex_profile:opt:deployment_create'):
                        $name_option = 'opt_in_deployCreate';
                        break;
                    case elgg_echo('gcconnex_profile:opt:job_swap'):
                        $name_option = 'opt_in_swap';
                        break;
                    case elgg_echo('gcconnex_profile:opt:job_rotate'):
                        $name_option = 'opt_in_rotation';
                        break;

                    // Development
                    case elgg_echo('gcconnex_profile:opt:mentored'):
                        $name_option = 'opt_in_mentored';
                        break;
                    case elgg_echo('gcconnex_profile:opt:mentoring'):
                        $name_option = 'opt_in_mentoring';
                        break;
                    case elgg_echo('gcconnex_profile:opt:shadowed'):
                        $name_option = 'opt_in_shadowed';
                        break;
                    case elgg_echo('gcconnex_profile:opt:shadowing'):
                        $name_option = 'opt_in_shadowing';
                        break;
                    case elgg_echo('gcconnex_profile:opt:job_sharing'):
                        $name_option = 'opt_in_jobshare';
                        break;
                    case elgg_echo('gcconnex_profile:opt:peer_coached'):
                        $name_option = 'opt_in_pcSeek';
                        break;
                    case elgg_echo('gcconnex_profile:opt:peer_coaching'):
                        $name_option = 'opt_in_pcCreate';
                        break;
                    case elgg_echo('gcconnex_profile:opt:skill_sharing'):
                        $name_option = 'opt_in_ssSeek';
                        break;
                    case elgg_echo('gcconnex_profile:opt:skill_sharing_create'):
                        $name_option = 'opt_in_ssCreate';
                        break;

                    /* MW - Added for GCcollab */
                    case elgg_echo('gcconnex_profile:opt:casual_seek'):
                        $name_option = 'opt_in_casual_seek';
                        break;
                    case elgg_echo('gcconnex_profile:opt:casual_create'):
                        $name_option = 'opt_in_casual_create';
                        break;
                    case elgg_echo('gcconnex_profile:opt:student_seek'):
                        $name_option = 'opt_in_student_seek';
                        break;
                    case elgg_echo('gcconnex_profile:opt:student_create'):
                        $name_option = 'opt_in_student_create';
                        break;
                    case elgg_echo('gcconnex_profile:opt:collaboration_seek'):
                        $name_option = 'opt_in_collaboration_seek';
                        break;
                    case elgg_echo('gcconnex_profile:opt:collaboration_create'):
                        $name_option = 'opt_in_collaboration_create';
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = '=';
                $returner['value'] = 'gcconnex_profile:opt:yes';
            }
            break;

        case elgg_echo('missions:portfolio'):
            if(trim($array[$form_name.'_'.$place.'_element_value']) != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array[$form_name.'_'.$place.'_element_value'].'%';
                switch($array[$form_name.'_'.$place.'_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:publication_date'):
                        $name_option = 'pubdate';
                        $operand_option = $array[$form_name.'_'.$place.'_element_operand'];
                        $value_option = $array[$form_name.'_'.$place.'_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'portfolio';
            }
            break;

        case elgg_echo('missions:skill'):
            if(trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'title';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array[$form_name.'_'.$place.'_element'].'%';
                $returner['extra_option'] = 'MySkill';
            }
            break;

        case elgg_echo('missions:experience'):
            if(trim($array[$form_name.'_'.$place.'_element_value']) != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array[$form_name.'_'.$place.'_element_value'].'%';
                switch($array[$form_name.'_'.$place.'_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:organization'):
                        $name_option = 'organization';
                        break;
                    case elgg_echo('missions:end_year'):
                        $name_option = 'endyear';
                        $operand_option = $array[$form_name.'_'.$place.'_element_operand'];
                        $value_option = $array[$form_name.'_'.$place.'_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'experience';
            }
            break;

        case elgg_echo('missions:education'):
            if(trim($array[$form_name.'_'.$place.'_element_value']) != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array[$form_name.'_'.$place.'_element_value'].'%';
                switch($array[$form_name.'_'.$place.'_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:degree'):
                        $name_option = 'degree';
                        break;
                    case elgg_echo('missions:field'):
                        $name_option = 'field';
                        break;
                    case elgg_echo('missions:end_year'):
                        $name_option = 'endyear';
                        $operand_option = $array[$form_name.'_'.$place.'_element_operand'];
                        $value_option = $array[$form_name.'_'.$place.'_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'education';
            }
            break;

        //
        case elgg_echo('missions:start_time'):
        case elgg_echo('missions:duration'):
            if (trim($array[$form_name.'_'.$place.'_element'])) {
                $name_option = '';
                // Selects which day will be searched.
                switch ($array[$form_name.'_'.$place.'_element_day']) {
                    case elgg_echo('missions:mon'):
                        $name_option = 'mon';
                        break;
                    case elgg_echo('missions:tue'):
                        $name_option = 'tue';
                        break;
                    case elgg_echo('missions:wed'):
                        $name_option = 'wed';
                        break;
                    case elgg_echo('missions:thu'):
                        $name_option = 'thu';
                        break;
                    case elgg_echo('missions:fri'):
                        $name_option = 'fri';
                        break;
                    case elgg_echo('missions:sat'):
                        $name_option = 'sat';
                        break;
                    case elgg_echo('missions:sun'):
                        $name_option = 'sun';
                        break;
                }

                if($array[$form_name.'_'.$place] == elgg_echo('missions:start_time')) {
                    $name_option .= '_start';
                }
                if($array[$form_name.'_'.$place] == elgg_echo('missions:duration')) {
                     $name_option .= '_duration';
                }

                $operand_option = $array[$form_name.'_'.$place.'_operand'];
                // Packs the input hour and time for comparison with the packed elements in the database.
                $returner['name'] = $name_option;
                $returner['operand'] = $array[$form_name.'_'.$place.'_operand'];
                $returner['value'] = $array[$form_name.'_'.$place.'_element'];
            }
            break;

        case elgg_echo('missions:period'):
            if(trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'time_interval';
                $returner['operand'] = '=';
                $returner['value'] = $array[$form_name.'_'.$place.'_element'];
            }
              break;

        case elgg_echo('missions:time'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'time_commitment';
                $returner['operand'] = $array[$form_name.'_'.$place.'_operand'];
                $returner['value'] = $array[$form_name.'_'.$place.'_element'];
            }
            break;

        // Selects language element which requires packing.
        case elgg_echo('missions:language'):
            if (trim($array[$form_name.'_'.$place.'_element_lwc']) != '' || trim($array[$form_name.'_'.$place.'_element_lwe']) != '' || trim($array[$form_name.'_'.$place.'_element_lop']) != '') {
                $name_option = '';
                // Selects which language will be searched
                switch ($array[$form_name.'_'.$place.'_element']) {
                    case elgg_echo('missions:english'):
                        $name_option = 'english';
                        break;
                    case elgg_echo('missions:french'):
                        $name_option = 'french';
                        break;
                }

                $option_value = $name_option;
                $language_requirement_array = array($array[$form_name.'_'.$place.'_element_lwc'], $array[$form_name.'_'.$place.'_element_lwe'], $array[$form_name.'_'.$place.'_element_lop']);
                foreach($language_requirement_array as $value) {
                    switch($value) {
                        case 'A':
                            $option_value .= '[Aa-]';
                            break;
                        case 'B':
                            $option_value .= '[ABab-]';
                            break;
                        case 'C':
                            $option_value .= '[ABCabc-]';
                            break;
                        default:
                            $option_value .= '[-]';
                    }
                }

                // Packs the input written comprehension, written expression and oral proficiency for comparison with the packed elements in the database.
                //$option_value = mm_pack_language($array[$form_name.'_' . $place . '_element_lwc'], $array[$form_name.'_' . $place . '_element_lwe'], $array[$form_name.'_' . $place . '_element_lop'], $name_option);
                $returner['name'] = $name_option;
                $returner['operand'] = 'REGEXP';
                $returner['value'] = $option_value;
            }
            break;

        // The next 3 are select elements that require a MySQL LIKE comparison.
        case elgg_echo('missions:key_skills'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'key_skills';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array[$form_name.'_'.$place.'_element'] . '%';
            }
            break;

        case elgg_echo('missions:location'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'location';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array[$form_name.'_'.$place.'_element'] . '%';
            }
            break;

        case elgg_echo('missions:type'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'job_type';
                $returner['operand'] = '=';
                $returner['value'] = $array[$form_name.'_'.$place.'_element'];
            }
            break;

        // The next 5 are selects elements that require a direct equivalence comparison.
        case elgg_echo('missions:title'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'job_title';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array[$form_name.'_'.$place.'_element'] . '%';
            }
            break;

        case elgg_echo('missions:security_clearance'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                $returner['name'] = 'security';
                $returner['operand'] = '=';
                $returner['value'] = $array[$form_name.'_'.$place.'_element'];
            }
            break;

        case elgg_echo('missions:department'):
            if (trim($array[$form_name.'_'.$place.'_element']) != '') {
                if(get_current_language() == 'fr') {
                    $returner['name'] = 'department_path_french';
                }
                else {
                    $returner['name'] = 'department_path_english';
                }
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array[$form_name.'_'.$place.'_element'] . '%';
            }
            break;

        case elgg_echo('missions:work_remotely'):
            $returner['name'] = 'remotely';
            $returner['operand'] = '=';
            if($array[$form_name.'_'.$place.'_element']) {
                $returner['value'] = 'on';
            }
            else {
                $returner['value'] = 0;
            }
            break;

        case elgg_echo('missions:program_area'):
            $returner['name'] = 'program_area';
            $returner['operand'] = '=';
            $returner['value'] = $array[$form_name.'_'.$place.'_element'];
            break;
    }

    return $returner;
}

/*
 * Analyzes the selection values and selection element values in order to construct a WHERE statement.
 * This is for when Javascript is disabled.
 */
function mm_analyze_backup($place, $array)
{
    $returner = array();

    $name_option = '';
    $operand_option = '';
    $value_option = '';
    $extra_option = '';

    // If the selection element has been chosen.
    if (trim($array[$form_name.'_'.$place]) != '') {
        // Base operand and value.
        $operand_option = '=';
        $value_option = $array['backup_' . $place];
        // Modifies name, operand and/or value depending on which selection element was chosen.
        switch ($array[$form_name.'_'.$place]) {
            case elgg_echo('missions:title'):
                $name_option = 'job_title';
                break;

            case elgg_echo('missions:type'):
                $name_option = 'job_type';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['backup_' . $place] . '%';
                break;

            case elgg_echo('missions:department'):
                $name_option = 'department';
                break;

            case elgg_echo('missions:location'):
                $name_option = 'location';
                break;

            case elgg_echo('missions:key_skills'):
                $name_option = 'key_skills';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['backup_' . $place] . '%';
                break;

            case elgg_echo('missions:security_clearance'):
                $name_option = 'security';
                break;

            // In the language case, the value needs to have the format {language}{LWC}{LWE}{LOP}
            case elgg_echo('missions:language'):
                switch ($array['backup_' . $place]) {
                    case (strpos($array['backup_' . $place], 'english') !== false):
                        $name_option = 'english';
                        break;
                    case (strpos($array['backup_' . $place], 'french') !== false):
                        $name_option = 'french';
                        break;
                    default:
                        return array();
                }
                $operand_option = '=';
                break;

            // In the time case, the value needs to have the format {day}_{start/end}{hour}:{min}
            case elgg_echo('missions:duration'):
            case elgg_echo('missions:start_time'):
                switch ($array['backup_' . $place]) {
                    case (strpos($array['backup_' . $place], 'mon_start') !== false):
                        $name_option = 'mon_start';
                        break;
                    case (strpos($array['backup_' . $place], 'mon_duration') !== false):
                        $name_option = 'mon_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'tue_start') !== false):
                        $name_option = 'tue_start';
                        break;
                    case (strpos($array['backup_' . $place], 'tue_duration') !== false):
                        $name_option = 'tue_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'wed_start') !== false):
                        $name_option = 'wed_start';
                        break;
                    case (strpos($array['backup_' . $place], 'wed_duration') !== false):
                        $name_option = 'wed_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'thu_start') !== false):
                        $name_option = 'thu_start';
                        break;
                    case (strpos($array['backup_' . $place], 'thu_duration') !== false):
                        $name_option = 'thu_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'fri_start') !== false):
                        $name_option = 'fri_start';
                        break;
                    case (strpos($array['backup_' . $place], 'fri_duration') !== false):
                        $name_option = 'fri_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'sat_start') !== false):
                        $name_option = 'sat_start';
                        break;
                    case (strpos($array['backup_' . $place], 'sat_duration') !== false):
                        $name_option = 'sat_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'sun_start') !== false):
                        $name_option = 'sun_start';
                        break;
                    case (strpos($array['backup_' . $place], 'sun_duration') !== false):
                        $name_option = 'sun_duration';
                        break;
                    default:
                        return array();
                }
                $operand_option = '=';
                break;

            case elgg_echo('missions:skill'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array[$form_name.'_'.$place.'_element'] . '%';
                $extra_option = 'MySkill';
                break;

            case elgg_echo('missions:experience'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array[$form_name.'_'.$place.'_element_value'] . '%';
                $extra_option = 'experience';
                break;

            case elgg_echo('missions:education'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array[$form_name.'_'.$place.'_element_value'] . '%';
                $extra_option = 'education';
                break;

            case elgg_echo('missions:portfolio'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array[$form_name.'_'.$place.'_element_value'] . '%';
                $extra_option = 'portfolio';
                break;

            case elgg_echo('missions:work_remotely'):
                $name_option = 'remotely';
                break;

            case elgg_echo('missions:program_area'):
                $name_option = 'program_area';
                break;
        }
        $returner['name'] = $name_option;
        $returner['operand'] = $operand_option;
        $returner['value'] = $value_option;
        $returner['extra_option'] = $extra_option;
    }

    return $returner;
}

/*
 * Basic search functionality for candidate searching.
 * Checks education, experience and skill attributes from user profiles.
 */
function mm_simple_search_database_for_candidates($query_array, $limit, $offset=0)
{

    $filtered_array = array_filter($query_array);
    if (empty($filtered_array)) {
        register_error(elgg_echo('missions:error:no_search_values'));
        return false;
    }

    if (function_exists('\NRC\EUS\get') && \NRC\EUS\ready()) {
      $MemberSearch = \NRC\EUS\get();
      $term = '';
      foreach ($query_array as $t) {
        $term .= "{$t}* ";
      }
      $term = trim($term);
      $results = $MemberSearch->search($term, $limit, $offset);

      $candidate_count = $results['total'];


      $search_feedback = array();
      $pairs = array();
      foreach ($results['users'] as $user) {

        $pairs[] = array(
            'name' => 'guid',
            'value' => $user['user_guid'],
            'operand' => '='
        );

        if (!isset($search_feedback[$user['user_guid']])) {
            $search_feedback[$user['user_guid']] = '';
        }
        if ($user['matched_using']['education'] == 1) {
          $search_feedback[$user['user_guid']] .= elgg_echo('missions:school_name') . ': ' . $user['education'] . ',';
        }
        if ($user['matched_using']['experience'] == 1) {
            $search_feedback[$user['user_guid']] .= elgg_echo('missions:job_title') . ': ' . $user['experience'] . ',';
        }
        if ($user['matched_using']['gc_skills'] == 1) {
            $search_feedback[$user['user_guid']] .= elgg_echo('missions:skill') . ': ' . $user['gc_skills'] . ',';
        }
        if ($user['matched_using']['portfolio'] == 1) {
            $search_feedback[$user['user_guid']] .= elgg_echo('missions:portfolio') . ': ' . $user['portfolio'] . ',';
        }
        if ($user['matched_using']['name'] == 1) {
            $search_feedback[$user['user_guid']] .= elgg_echo('missions:name') . ': ' . $user['name'] . ',';
        }
        if ($user['matched_using']['contactemail'] == 1) {
            $search_feedback[$user['user_guid']] .= elgg_echo('missions:email') . ': ' . $user['contactemail'] . ',';
        }
      }

      if ($candidate_count > 0) {
        $unique_owners_entity = elgg_get_entities_from_attributes(array(
            'type' => 'user', 'limit' => 0,
            'attribute_name_value_pairs' => $pairs,
            'attribute_name_value_pairs_operator' => 'OR'
        ));

        // SORT ORDER LOST, resort results based on initial query.
        $sorted = array();
        foreach ($unique_owners_entity as $owner) {
            $sorted[] = array_search($owner->guid, array_keys($search_feedback));
        }

        array_multisort($sorted, $unique_owners_entity);
      }
    } else {

      $dbprefix = elgg_get_config("dbprefix");
      $only_opt_in = false; // Only include members who have opted-in to the platform
      $opt_in_sql = '';

      // TODO: Later versions of ELGG support parameterized queries... DO THAT.
      $ms_search = array(); $s_search = array(); $u_search = array();
      foreach ($query_array as $term) {
          $t = mysql_escape_string(trim($term)) . '*';
          $ms_search[] = "(MATCH(a.string) AGAINST(\"$t\" IN BOOLEAN MODE))";
          $s_search[] = "(MATCH(eoe.title) AGAINST(\"$t\" IN BOOLEAN MODE))";
          $u_search[] = "(MATCH(a.name) AGAINST(\"$t\" IN BOOLEAN MODE))";
      }

      $metadata_search = implode(' AND ', $ms_search);
      $metadata_relevance = implode(' + ', $ms_search) . ' + 0';
      $skill_search = implode(' AND ', $s_search);
      $skill_relevance = implode(' + ', $s_search) . ' + 0';
      $user_search = implode(' AND ', $u_search);
      $user_relevance = implode(' + ', $u_search) . ' + 0';

      $search_query_metadata = "
          SELECT
              c.guid AS user_guid,
              CONCAT(d.string, ':::::', a.string) AS field,
              ($metadata_relevance) as relevance
          FROM
              {$dbprefix}metastrings a
              LEFT JOIN {$dbprefix}metadata b ON a.id = b.value_id
              LEFT JOIN {$dbprefix}users_entity c ON c.guid = b.owner_guid
              LEFT JOIN {$dbprefix}metastrings d ON b.name_id = d.id
          WHERE
              c.guid IS NOT null
              AND d.string IN ('contactemail')
              AND ($metadata_search)
      ";
      $search_user_name = "
          SELECT
              a.guid as user_guid,
              CONCAT('name:::::', a.name) as field,
              ($user_relevance) as relevance
          FROM
              {$dbprefix}users_entity a
          WHERE
              ($user_search)
      ";
      $search_query_subtypes = "
          SELECT
              eue.guid as user_guid,
              CONCAT(es.subtype, ':::::', eoe.title) as field,
              ($skill_search) as relevance
              $opt_in_select
          FROM
              {$dbprefix}metastrings ems
              LEFT JOIN {$dbprefix}metadata em ON ems.id = em.value_id
              LEFT JOIN {$dbprefix}users_entity eue ON eue.guid = em.owner_guid
              LEFT JOIN {$dbprefix}entities ee ON CAST(ee.guid as char(10)) = ems.string
              LEFT JOIN {$dbprefix}entity_subtypes es ON es.id = ee.subtype
              LEFT JOIN {$dbprefix}objects_entity eoe ON ee.guid = eoe.guid
          WHERE
              eue.guid IS NOT NULL
              AND ee.subtype IN (SELECT id FROM {$dbprefix}entity_subtypes WHERE subtype IN ('MySkill', 'education', 'experience', 'portfolio'))
              AND ($skill_search)
      ";

      $search_wrapper = "
      SELECT SQL_CALC_FOUND_ROWS
          user_guid,
          GROUP_CONCAT(DISTINCT field SEPARATOR '!!!!!') as reason,
          SUM(relevance) as relevance
      FROM (";
      $search_wrapper .= $search_user_name;
      $search_wrapper .= "\nUNION\n" . $search_query_metadata;
      $search_wrapper .= "\nUNION\n" . $search_query_subtypes;
      $search_wrapper .= "\n) matches\n";
      if ($only_opt_in) {
          $search_wrapper .= "
              LEFT JOIN {$dbprefix}metadata b ON b.owner_guid = user_guid
              LEFT JOIN {$dbprefix}metastrings a ON a.id = b.name_id
              LEFT JOIN {$dbprefix}metastrings c ON c.id = b.value_id
          WHERE
              match(a.string) against ('opt_in_*' IN BOOLEAN MODE)
              AND c.string = 'gcconnex_profile:opt:yes'
          ";
      }
      $search_wrapper .= "GROUP BY user_guid ORDER BY relevance DESC, reason LIMIT $offset, $limit;";
      $results = get_data($search_wrapper);
      $total_users = get_data('SELECT FOUND_ROWS() as total_users;')[0]->total_users;

      $candidate_count = min(elgg_get_plugin_setting('search_limit', 'missions'), $total_users);

      if (count($results) > 0) {
          $search_feedback = array();
          foreach($results as $result) {
              $reasons = array();
              $reason_values = array();
              $reasons_tmp = explode('!!!!!', $result->reason);
              foreach ($reasons_tmp as $rt) {
                  $sp = explode(':::::', $rt);
                  $reasons[] = $sp[0];
                  $reason_values[$sp[0]] = $sp[1];
              }
              if (!isset($search_feedback[$result->user_guid])) {
                  $search_feedback[$result->user_guid] = '';
              }
              if (in_array('education', $reasons)) {
                  $search_feedback[$result->user_guid] .= elgg_echo('missions:school_name') . ': ' . $reason_values['education'] . ',';
              }
              if (in_array('experience', $reasons)) {
                  $search_feedback[$result->user_guid] .= elgg_echo('missions:job_title') . ': ' . $reason_values['experience'] . ',';
              }
              if (in_array('MySkill', $reasons)) {
                  $search_feedback[$result->user_guid] .= elgg_echo('missions:skill') . ': ' . $reason_values['MySkill'] . ',';
              }
              if (in_array('portfolio', $reasons)) {
                  $search_feedback[$result->user_guid] .= elgg_echo('missions:portfolio') . ': ' . $reason_values['portfolio'] . ',';
              }
              if (in_array('name', $reasons)) {
                  $search_feedback[$result->user_guid] .= elgg_echo('missions:name') . ': ' . $reason_values['name'] . ',';
              }
              if (in_array('contactemail', $reasons)) {
                  $search_feedback[$result->user_guid] .= elgg_echo('missions:email') . ': ' . $reason_values['contactemail'] . ',';
              }
          }

          $pairs = array();
          foreach(array_keys($search_feedback) as $guid) {
              $pairs[] = array(
                  'name' => 'guid',
                  'value' => $guid,
                  'operand' => '='
              );
          }
          $unique_owners_entity = elgg_get_entities_from_attributes(array(
              'type' => 'user', 'limit' => 0,
              'attribute_name_value_pairs' => $pairs,
              'attribute_name_value_pairs_operator' => 'OR'
          ));

          // SORT ORDER LOST, resort results based on initial query.
          $sorted = array();
          foreach ($unique_owners_entity as $owner) {
              $sorted[] = array_search($owner->guid, array_keys($search_feedback));
          }

          array_multisort($sorted, $unique_owners_entity);
      }
    }

    if ($candidate_count == 0) {
        register_error(elgg_echo('missions:error:candidate_does_not_exist'));
        return false;
    } else {
        $_SESSION['candidate_count'] = $candidate_count;
        $_SESSION['candidate_search_set'] = $unique_owners_entity;
        $_SESSION['candidate_search_set_timestamp'] = time();
        $_SESSION['candidate_search_feedback'] = $search_feedback;
        $_SESSION['candidate_search_feedback_timestamp'] = time();
        $_SESSION['candidate_search_query_array'] = $query_array;

        return true;
    }
}

/*
 * Advanced search functionality for candidate searching.
 * Checks education, experience and skill attributes and metadata from user profiles.
 */
function mm_advanced_search_database_for_candidates($query_array, $query_operand, $limit) {
    $users_returned_by_attribute = array();
    $users_returned_by_metadata = array();
    $is_attribute_searched = false;
    $is_metadata_searched = false;
    $candidates = array();

    $filtered_array = array_filter($query_array);
    if (empty($filtered_array)) {
        register_error(elgg_echo('missions:error:no_search_values'));
        return false;
    }

    // Handles each query individually.
    foreach($filtered_array as $array) {
        // Sets up an education and experience array search for title (not metadata).
        if($array['name'] == 'title') {
            $options_attribute['type'] = 'object';
            $options_attribute['subtypes'] = $array['extra_option'];
            $options_attribute['joins'] = array('INNER JOIN ' . elgg_get_config('dbprefix') . 'objects_entity g ON (g.guid = e.guid)');
            $options_attribute['wheres'] = array("g." . $array['name'] . " " . $array['operand'] . " '" . $array['value'] . "'");
            $options_attribute['limit'] = $limit;
            $entities = elgg_get_entities($options_attribute);

            $entity_owners = array();
            $count = 0;
            foreach($entities as $entity) {
                $entity_owners[$count] = $entity->owner_guid;
                $count++;
            }

            // Adds the results of the query to a pool of results.
            if(empty($users_returned_by_attribute)) {
                $users_returned_by_attribute = array_unique($entity_owners);
            }
            else {
                $users_returned_by_attribute = array_unique(array_intersect($users_returned_by_attribute, $entity_owners));
            }
            // Notes that attributes have been searched during this function call.
            $is_attribute_searched = true;
        }

        else if(strpos($array['name'], 'opt_in') !== false || strpos($array['name'], 'department') !== false) {
            $options_attribute['type'] = 'user';
            $options_metadata['metadata_name_value_pairs'] = array(array('name' => $array['name'], 'operand' => $array['operand'], 'value' => $array['value']));
            $options_metadata['limit'] = $limit;
            $options_metadata['metadata_case_sensitive'] = false;
            $entities = elgg_get_entities_from_metadata($options_metadata);

            $entity_owners = array();
            $count = 0;
            foreach($entities as $entity) {
                $entity_owners[$count] = $entity->guid;
                $count++;
            }

            // Adds the results of the query to a pool of results.
            if(empty($users_returned_by_metadata)) {
                $users_returned_by_metadata = array_unique($entity_owners);
            }
            else {
                $users_returned_by_metadata = array_unique(array_intersect($users_returned_by_metadata, $entity_owners));
            }
            // Notes that metadata have been searched during this function call.
            $is_metadata_searched = true;
        }

        // Sets up metadata serach.
        else {
            $operand_temp = htmlspecialchars_decode($array['operand']);

            $options_metadata['type'] = 'object';
            $options_metadata['subtypes'] = $array['extra_option'];
            $options_metadata['metadata_name_value_pairs'] = array(array('name' => $array['name'], 'operand' => $operand_temp, 'value' => $array['value']));
            $options_metadata['limit'] = $limit;
            $options_metadata['metadata_case_sensitive'] = false;
            $entities = elgg_get_entities_from_metadata($options_metadata);

            $entity_owners = array();
            $count = 0;
            foreach($entities as $entity) {
                $entity_owners[$count] = $entity->owner_guid;
                $count++;
            }

            // Adds the results of the query to a pool of results.
            if(empty($users_returned_by_metadata)) {
                $users_returned_by_metadata = array_unique($entity_owners);
            }
            else {
                $users_returned_by_metadata = array_unique(array_intersect($users_returned_by_metadata, $entity_owners));
            }
            // Notes that metadata have been searched during this function call.
            $is_metadata_searched = true;
        }
    }

    // Intersects the results into a single pool.
    if($is_attribute_searched && $is_metadata_searched) {
        $candidates = array_intersect($users_returned_by_attribute, $users_returned_by_metadata);
    }
    // If only metadata or only attributes have been searched then intersection is unecessary.
    if($is_attribute_searched && !$is_metadata_searched) {
        $candidates = $users_returned_by_attribute;
    }
    if(!$is_attribute_searched && $is_metadata_searched) {
        $candidates = $users_returned_by_metadata;
    }

    $final_users = mm_guids_to_entities_with_opt(array_slice($candidates, 0, $limit));
    $final_count = count($final_users);

    if ($final_count == 0) {
        register_error(elgg_echo('missions:error:candidate_does_not_exist'));
        return false;
    } else {
        $_SESSION['candidate_count'] = $final_count;
        $_SESSION['candidate_search_set'] = $final_users;
        $_SESSION['candidate_search_set_timestamp'] = time();
        unset($_SESSION['candidate_search_feedback']);

        return true;
    }
}

/*
 * Turns an array of guids into an array of entities.
 */
function mm_guids_to_entities_with_opt($candidates) {
    $count_c = 0;
    $count_p = 0;
    $candidates_users = array();
    $potentials_users = array();
    foreach($candidates as $candidate) {
        $user_temp = get_user($candidate);
        if(check_if_opted_in($user_temp)) {
            $candidates_users[$count_c] = $user_temp;
            $count_c++;
        }
        else {
            $potentials_users[$count_p] = $user_temp;
            $count_p++;
        }
    }

    return array_merge($candidates_users, $potentials_users);
}
