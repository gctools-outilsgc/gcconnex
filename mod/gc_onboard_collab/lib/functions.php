<?php
/*
 * user_skill_match
 *
 * Uses logged-in user's skills to prepare query for the skill search function
 *
 * @author Ethan Wallace <your.name@example.com>
 * @return [ARRAY] [< User entities>]
 *
 */
function user_skill_match(){

  $array = array();

  $user = elgg_get_logged_in_user_entity();
  //if user has skills
    if($user->gc_skills){
      $skill_guids = $user->gc_skills;
      //check if user has more then one skill entered
      if(is_array($skill_guids)){

        //combine skill titles into a string
        foreach ($skill_guids as $skill_guid) {
          if ($skill = get_entity($skill_guid)) {
            $skill_class = $skill->title;
            $skill_array .= $skill_class . ',';
          }
        }
      } else {
        //if only one skill, make title a string
        $skill_array = get_entity($user->gc_skills)->title.',';
      }

      //remove weird spacing with commas and convert string into an array
      $skill_array = str_replace(' ,', ',', $skill_array);
      $string_to_array = explode(',', str_replace(', ', ',', $skill_array));

      array_pop($string_to_array);

      foreach($string_to_array as $key => $value) {
        $array[$key] = array(
                'name' => 'title',
                'operand' => 'LIKE',
                'value' => '%' . $value . '%',
              'case_sensitive' => false
          );
      }

      //run query through array
      $returned = skill_search($array, 'OR', 12);

      return $returned;
    } else {
      return;
    }
}

/*
 * skill_search
 *
 * Modified version of mm_simple_search_database_for_candidates.
 * Finds user entities with similiar skills to the logged-in user
 *
 * @author Ethan wallace <>
 * @param [ARRAY] [$query_array] [<Assembled query from user_skill_match function>]
 * @param [STRING] [$query_operand] [<Operand used for the function>]
 * @param [INT] [$limit] [<Limit the amount of returned users>]
 * @return [ARRAY] [<ARRAY of user entities>]
 *
 */
function skill_search($query_array, $query_operand, $limit)
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
    $options['subtypes'] = array('MySkill');
    $options['attribute_name_value_pairs'] = $filtered_array;
    $options['attribute_name_value_pairs_operator'] = $query_operand;
    $entities = elgg_get_entities_from_attributes($options);

    $entity_owners = array();
    $search_feedback = array();
    $count = 0;
    foreach($entities as $entity) {
        $entity_owners[$count] = $entity->owner_guid;
        // Section for generating feedback which tells the user which search criteria the returned users met.
        if($entity->getSubtype() == 'MySkill') {
            $identifier_string = elgg_echo('onboard:skill');
        }

        //test to see if list already created
        //add other matching skills to list
        if(isset($search_feedback[$entity->owner_guid])){
            $search_feedback[$entity->owner_guid] .= ', '.$entity->title;
        } else {
            $search_feedback[$entity->owner_guid] .= $identifier_string . ': ' . $entity->title;
        }

        $count++;
    }

    $unique_owners_entity = guids_to_entities_with_opt(array_unique($entity_owners));
    $candidate_count = count($unique_owners_entity);

    if ($candidate_count == 0) {
        register_error(elgg_echo('missions:error:candidate_does_not_exist'));
        return false;
    } else {
        $_SESSION['candidate_search_set'] = $unique_owners_entity;
        $_SESSION['candidate_search_feedback'] = $search_feedback;

        return $unique_owners_entity;
    }
}

/*
 * guids_to_entities_with_opt
 *
 * Modified version of mm_guids_to_entities_with_opt.
 * Converts guids to entities
 *
 * @author Ethan wallace <>
 * @param [ARRAY] [$candidates] [<Array of guids>]
 * @return [ARRAY] [<ARRAY of user entities>]
 *
 */
function guids_to_entities_with_opt($candidates) {
	$count_c = 0;
	$count_p = 0;
	$candidates_users = array();
	$potentials_users = array();
	foreach($candidates as $candidate) {
		$user_temp = get_user($candidate);
		$potentials_users[$count_p] = $user_temp;
		$count_p++;
	}

	return array_merge($candidates_users, $potentials_users);
}

 ?>
