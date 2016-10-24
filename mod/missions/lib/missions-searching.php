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
function mm_search_database_for_missions($query_array, $query_operand, $limit)
{
    $options = array();
    $mission_count = '';
    $missions = '';

    $filtered_array = array_filter($query_array);
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

        // split the search into separate queries to prevent slowdown from 10+ join queries using 'OR'
        $all_missions = array();
        foreach ($filtered_array as $array) {
            $options['metadata_name_value_pairs'] = array($array);
            $some_missions = elgg_get_entities_from_metadata($options);
            $all_missions = array_merge( $all_missions, $some_missions );
        }
        
        $missions = array();
        foreach ($all_missions as $mission) {
            $missions[$mission->guid] = $mission;
        }
        // remove the closed, completed, etc. opportunities
        foreach($missions as $key => $mission) {
            if($mission->state != 'posted') {
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
    $returner = array();

    switch(trim($array['selection_' . $place])) {
        // Returns an empty array if
        case '':
            break;

        case elgg_echo('missions:user_department'):
            if (trim($array['selection_' . $place . '_element']) != '') {
            	$returner['name'] = 'department';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;
        
        case elgg_echo('missions:opt_in'):
        	if(trim($array['selection_' . $place . '_element']) != '') {
        		$name_option = '';
	        	switch($array['selection_' . $place . '_element']) {
                    case elgg_echo('gcconnex_profile:opt:micro_missionseek'):
                        $name_option = 'opt_in_missions';
                        break;
	        		case elgg_echo('gcconnex_profile:opt:micro_mission'):
	        			$name_option = 'opt_in_missionCreate';
	        			break;
	        		case elgg_echo('gcconnex_profile:opt:job_swap'):
	        			$name_option = 'opt_in_swap';
	        			break;
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
	        		case elgg_echo('gcconnex_profile:opt:peer_coached'):
	        			$name_option = 'opt_in_peer_coached';
	        			break;
	        		case elgg_echo('gcconnex_profile:opt:peer_coaching'):
	        			$name_option = 'opt_in_peer_coaching';
	        			break;
					case elgg_echo('gcconnex_profile:opt:skill_sharing'):
	        			$name_option = 'opt_in_skill_sharing';
	        			break;
	        		case elgg_echo('gcconnex_profile:opt:job_sharing'):
	        			$name_option = 'opt_in_job_sharing';
	        			break;
	        	}
	        	$returner['name'] = $name_option;
                $returner['operand'] = '=';
	        	$returner['value'] = 'gcconnex_profile:opt:yes';
        	}
        	break;
            
        case elgg_echo('missions:portfolio'):
            if(trim($array['selection_' . $place . '_element_value']) != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                switch($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:publication_date'):
                        $name_option = 'pubdate';
                        $operand_option = $array['selection_' . $place . '_element_operand'];
                        $value_option = $array['selection_' . $place . '_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'portfolio';
            }
            break;

        case elgg_echo('missions:skill'):
            if(trim($array['selection_' . $place . '_element']) != '') {
                $returner['name'] = 'title';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
                $returner['extra_option'] = 'MySkill';
            }
            break;

        case elgg_echo('missions:experience'):
            if(trim($array['selection_' . $place . '_element_value']) != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                switch($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:organization'):
                        $name_option = 'organization';
                        break;
                    case elgg_echo('missions:end_year'):
                        $name_option = 'endyear';
                        $operand_option = $array['selection_' . $place . '_element_operand'];
                        $value_option = $array['selection_' . $place . '_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'experience';
            }
            break;

        case elgg_echo('missions:education'):
            if(trim($array['selection_' . $place . '_element_value']) != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                switch($array['selection_' . $place . '_element']) {
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
                        $operand_option = $array['selection_' . $place . '_element_operand'];
                        $value_option = $array['selection_' . $place . '_element_value'];
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
            if (trim($array['selection_' . $place . '_element'])) {
                $name_option = '';
                // Selects which day will be searched.
                switch ($array['selection_' . $place . '_element_day']) {
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
                
                if($array['selection_' . $place] == elgg_echo('missions:start_time')) {
                	$name_option .= '_start';
                }
                if($array['selection_' . $place] == elgg_echo('missions:duration')) {
                	 $name_option .= '_duration';
                }
                
                $operand_option = $array['selection_' . $place . '_operand'];
                // Packs the input hour and time for comparison with the packed elements in the database.
                $returner['name'] = $name_option;
                $returner['operand'] = $array['selection_' . $place . '_operand'];
                $returner['value'] = $array['selection_' . $place . '_element'];
            }
            break;
        
        case elgg_echo('missions:period'):
        	if(trim($array['selection_' . $place . '_element']) != '') {
	        	$returner['name'] = 'time_interval';
	        	$returner['operand'] = '=';
	        	$returner['value'] = $array['selection_' . $place . '_element'];
        	}
          	break;
            
        case elgg_echo('missions:time'):
            if (trim($array['selection_' . $place . '_element']) != '') {
	        	$returner['name'] = 'time_commitment';
	        	$returner['operand'] = $array['selection_' . $place . '_operand'];
	        	$returner['value'] = $array['selection_' . $place . '_element'];
            }
        	break;

        // Selects language element which requires packing.
        case elgg_echo('missions:language'):
            if (trim($array['selection_' . $place . '_element_lwc']) != '' || trim($array['selection_' . $place . '_element_lwe']) != '' || trim($array['selection_' . $place . '_element_lop']) != '') {
                $name_option = '';
                // Selects which language will be searched
                switch ($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:english'):
                        $name_option = 'english';
                        break;
                    case elgg_echo('missions:french'):
                        $name_option = 'french';
                        break;
                }
                
                $option_value = $name_option;
                $language_requirement_array = array($array['selection_' . $place . '_element_lwc'], $array['selection_' . $place . '_element_lwe'], $array['selection_' . $place . '_element_lop']);
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
                //$option_value = mm_pack_language($array['selection_' . $place . '_element_lwc'], $array['selection_' . $place . '_element_lwe'], $array['selection_' . $place . '_element_lop'], $name_option);
                $returner['name'] = $name_option;
                $returner['operand'] = 'REGEXP';
                $returner['value'] = $option_value;
            }
            break;

        // The next 3 are select elements that require a MySQL LIKE comparison.
        case elgg_echo('missions:key_skills'):
            if (trim($array['selection_' . $place . '_element']) != '') {
                $returner['name'] = 'key_skills';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;

        case elgg_echo('missions:location'):
            if (trim($array['selection_' . $place . '_element']) != '') {
                $returner['name'] = 'location';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;

        case elgg_echo('missions:type'):
            if (trim($array['selection_' . $place . '_element']) != '') {
                $returner['name'] = 'job_type';
                $returner['operand'] = '=';
                $returner['value'] = $array['selection_' . $place . '_element'];
            }
            break;

        // The next 5 are selects elements that require a direct equivalence comparison.
        case elgg_echo('missions:title'):
            if (trim($array['selection_' . $place . '_element']) != '') {
                $returner['name'] = 'job_title';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;

        case elgg_echo('missions:security_clearance'):
            if (trim($array['selection_' . $place . '_element']) != '') {
                $returner['name'] = 'security';
                $returner['operand'] = '=';
                $returner['value'] = $array['selection_' . $place . '_element'];
            }
            break;

        case elgg_echo('missions:department'):
            if (trim($array['selection_' . $place . '_element']) != '') {
            	if(get_current_language() == 'fr') {
            		$returner['name'] = 'department_path_french';
            	}
            	else {
            		$returner['name'] = 'department_path_english';
            	}
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;

        case elgg_echo('missions:work_remotely'):
            $returner['name'] = 'remotely';
            $returner['operand'] = '=';
            if($array['selection_' . $place . '_element']) {
            	$returner['value'] = 1;
            }
            else {
            	$returner['value'] = 0;
            }
            break;

        case elgg_echo('missions:program_area'):
            $returner['name'] = 'program_area';
            $returner['operand'] = '=';
            $returner['value'] = $array['selection_' . $place . '_element'];
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
    if (trim($array['selection_' . $place]) != '') {
        // Base operand and value.
        $operand_option = '=';
        $value_option = $array['backup_' . $place];
        // Modifies name, operand and/or value depending on which selection element was chosen.
        switch ($array['selection_' . $place]) {
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
                $value_option = '%' . $array['selection_' . $place . '_element'] . '%';
                $extra_option = 'MySkill';
                break;

            case elgg_echo('missions:experience'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                $extra_option = 'experience';
                break;

            case elgg_echo('missions:education'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                $extra_option = 'education';
                break;
                
            case elgg_echo('missions:portfolio'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
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
function mm_simple_search_database_for_candidates($query_array, $query_operand, $limit)
{
    $options = array();

    $filtered_array = array_filter($query_array);
    if (empty($filtered_array)) {
        register_error(elgg_echo('missions:error:no_search_values'));
        return false;
    }
    
    $value_array = array();
    foreach($filtered_array as $key => $array) {
    	$value_array[$key] = str_replace('%', '', $array['value']);
    }

    // Setting options with which the query will be built.
    $options['type'] = 'object';
    $options['subtypes'] = array('education', 'experience', 'MySkill', 'portfolio');
    $options['attribute_name_value_pairs'] = $filtered_array;
    $options['attribute_name_value_pairs_operator'] = $query_operand;
    $entities = elgg_get_entities_from_attributes($options);

    $entity_owners = array();
    $search_feedback = array();
    $count = 0;
    foreach($entities as $entity) {
        $entity_owners[$count] = $entity->owner_guid;
        // Section for generating feedback which tells the user which search criteria the returned users met.
        if($entity->getSubtype() == 'education') {
            $identifier_string = elgg_echo('missions:school_name');
        }
        if($entity->getSubtype() == 'experience') {
            $identifier_string = elgg_echo('missions:job_title');
        }
        if($entity->getSubtype() == 'MySkill') {
            $identifier_string = elgg_echo('missions:skill');
        }
        if($entity->getSubtype() == 'portfolio') {
            $identifier_string = elgg_echo('missions:portfolio');
        }
        $search_feedback[$entity->owner_guid] .= $identifier_string . ': ' . $entity->title . ',';
        $count++;
    }

    $filtered_array_name = $filtered_array;
    $filtered_array_email = $filtered_array;
    foreach($filtered_array as $key => $value) {
    	$filtered_array_name[$key]['name'] = 'name';
    	$filtered_array_email[$key]['name'] = 'email';
    }
    $filtered_array_total = array_merge($filtered_array_name, $filtered_array_email);
    
    // Searches user names for the given string. 
    $options_second['type'] = 'user';
    $options_second['limit'] = $limit;
    $options_second['attribute_name_value_pairs'] = $filtered_array_total;
    $options_second['attribute_name_value_pairs_operator'] = $query_operand;
    $users = elgg_get_entities_from_attributes($options_second);
    
    // Turns the user list into a list of GUIDs and sets the search feedback for search by name.
    foreach($users as $key => $user) {
    	$users[$key] = $user->guid;
    	foreach($value_array as $value) {
    		if(strpos(strtolower($user->name), $value) !== false) {
    			$search_feedback[$user->guid] .= elgg_echo('missions:name') . ': ' . $user->name . ',';
    		}
    		if(strpos(strtolower($user->email), $value) !== false) {
    			$search_feedback[$user->guid] .= elgg_echo('missions:email') . ': ' . $user->email . ',';
    		}
    	}
    	$count++;
    }
    
    $entity_owners = array_merge($entity_owners, $users);
    
    $unique_owners_entity = mm_guids_to_entities_with_opt(array_unique($entity_owners));
    $candidate_count = count($unique_owners_entity);

    if ($candidate_count == 0) {
        register_error(elgg_echo('missions:error:candidate_does_not_exist'));
        return false;
    } else {
        $_SESSION['candidate_count'] = $candidate_count;
        $_SESSION['candidate_search_set'] = $unique_owners_entity;
        $_SESSION['candidate_search_set_timestamp'] = time();
        $_SESSION['candidate_search_feedback'] = $search_feedback;
        $_SESSION['candidate_search_feedback_timestamp'] = time();

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